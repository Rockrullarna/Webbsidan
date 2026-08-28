<?php
declare(strict_types=1);

const RR_POSTS_CACHE_TTL_SECONDS = 300;

function rrPostsGetAll(): array
{
    $source = rrPostsLoadSourcePayload();
    $sourceHash = md5($source['raw']);
    $cacheFile = rrPostsGetCacheFile();

    $cached = rrPostsReadCache($cacheFile, RR_POSTS_CACHE_TTL_SECONDS, $sourceHash);
    if ($cached !== null) {
        return $cached;
    }

    $normalized = [];
    foreach ($source['posts'] as $post) {
        if (!is_array($post)) {
            continue;
        }

        $entry = rrPostsNormalizePost($post);
        if ($entry !== null) {
            $normalized[] = $entry;
        }
    }

    usort($normalized, static fn (array $a, array $b): int => strcmp($b['published_at'], $a['published_at']));
    rrPostsWriteCache($cacheFile, $sourceHash, $normalized);

    return $normalized;
}

function rrPostsGetCategories(array $posts): array
{
    $categories = [];
    foreach ($posts as $post) {
        $category = trim((string) ($post['category'] ?? ''));
        if ($category !== '') {
            $categories[] = $category;
        }
    }

    $categories = array_values(array_unique($categories));
    sort($categories, SORT_NATURAL | SORT_FLAG_CASE);
    return $categories;
}

function rrPostsFilter(array $posts, ?string $category = null, string $search = '', bool $featuredOnly = false): array
{
    $searchNeedle = mb_strtolower(trim($search), 'UTF-8');
    $categoryNeedle = mb_strtolower(trim((string) $category), 'UTF-8');

    return array_values(array_filter($posts, static function (array $post) use ($featuredOnly, $searchNeedle, $categoryNeedle): bool {
        if ($featuredOnly && empty($post['is_featured'])) {
            return false;
        }

        if ($categoryNeedle !== '' && mb_strtolower((string) ($post['category'] ?? ''), 'UTF-8') !== $categoryNeedle) {
            return false;
        }

        if ($searchNeedle === '') {
            return true;
        }

        $searchable = mb_strtolower(
            implode(' ', [
                (string) ($post['title'] ?? ''),
                (string) ($post['excerpt'] ?? ''),
                (string) ($post['content_markdown'] ?? ''),
                (string) ($post['author'] ?? ''),
                implode(' ', $post['categories'] ?? []),
            ]),
            'UTF-8'
        );

        return str_contains($searchable, $searchNeedle);
    }));
}

function rrPostsPaginate(array $posts, int $page, int $perPage): array
{
    $safePerPage = max(1, min(20, $perPage));
    $safePage = max(1, $page);
    $totalItems = count($posts);
    $totalPages = max(1, (int) ceil($totalItems / $safePerPage));

    if ($safePage > $totalPages) {
        $safePage = $totalPages;
    }

    $offset = ($safePage - 1) * $safePerPage;
    $items = array_slice($posts, $offset, $safePerPage);

    return [
        'items' => $items,
        'page' => $safePage,
        'per_page' => $safePerPage,
        'total_items' => $totalItems,
        'total_pages' => $totalPages,
    ];
}

function rrPostsFindByIdOrSlug(array $posts, string $idOrSlug): ?array
{
    $needle = trim($idOrSlug);
    if ($needle === '') {
        return null;
    }

    foreach ($posts as $post) {
        if ((string) ($post['id'] ?? '') === $needle || (string) ($post['slug'] ?? '') === $needle) {
            return $post;
        }
    }

    return null;
}

function rrPostsGetRelated(array $posts, array $currentPost, int $limit = 3): array
{
    $category = (string) ($currentPost['category'] ?? '');
    $related = [];

    foreach ($posts as $post) {
        if (($post['id'] ?? null) === ($currentPost['id'] ?? null)) {
            continue;
        }

        if ($category !== '' && (string) ($post['category'] ?? '') !== $category) {
            continue;
        }

        $related[] = $post;
        if (count($related) >= $limit) {
            break;
        }
    }

    return $related;
}

function rrPostsFormatDate(string $date): string
{
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return $date;
    }

    $months = [
        1 => 'januari',
        2 => 'februari',
        3 => 'mars',
        4 => 'april',
        5 => 'maj',
        6 => 'juni',
        7 => 'juli',
        8 => 'augusti',
        9 => 'september',
        10 => 'oktober',
        11 => 'november',
        12 => 'december',
    ];

    $month = $months[(int) date('n', $timestamp)] ?? date('m', $timestamp);
    return date('j', $timestamp) . ' ' . $month . ' ' . date('Y', $timestamp);
}

function rrPostsRenderBody(array $post): string
{
    $markdown = trim((string) ($post['content_markdown'] ?? ''));
    if ($markdown !== '') {
        return rrPostsMarkdownToHtml($markdown);
    }

    $html = trim((string) ($post['content_html'] ?? ''));
    if ($html !== '') {
        return strip_tags($html, '<p><br><strong><em><ul><ol><li><h2><h3><blockquote><a>');
    }

    $plain = trim((string) ($post['content'] ?? ''));
    return '<p>' . nl2br(htmlspecialchars($plain, ENT_QUOTES, 'UTF-8')) . '</p>';
}

function rrPostsLoadSourcePayload(): array
{
    $sourceFile = rrPostsLocateSourceFile();
    if ($sourceFile !== null) {
        $raw = (string) file_get_contents($sourceFile);
        $decoded = json_decode($raw, true);

        if (is_array($decoded)) {
            $posts = $decoded['posts'] ?? $decoded;
            if (is_array($posts)) {
                return [
                    'raw' => $raw,
                    'posts' => $posts,
                ];
            }
        }
    }

    $fallback = rrPostsFallbackData();
    $raw = json_encode($fallback, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '[]';

    return [
        'raw' => $raw,
        'posts' => $fallback,
    ];
}

function rrPostsLocateSourceFile(): ?string
{
    $candidates = [];
    $envPath = getenv('RR_POSTS_JSON_PATH');
    if (is_string($envPath) && trim($envPath) !== '') {
        $candidates[] = $envPath;
    }

    $candidates[] = __DIR__ . '/posts-data.json';
    $candidates[] = dirname(__DIR__) . '/nyheter/posts-data.json';
    $candidates[] = dirname(__DIR__) . '/nyheter/cache/posts-data.json';

    foreach ($candidates as $candidate) {
        if (is_file($candidate) && is_readable($candidate)) {
            return $candidate;
        }
    }

    return null;
}

function rrPostsGetCacheFile(): string
{
    $cacheDir = __DIR__ . '/cache';
    if (!is_dir($cacheDir)) {
        @mkdir($cacheDir, 0775, true);
    }

    return $cacheDir . '/posts-cache.json';
}

function rrPostsReadCache(string $cacheFile, int $ttl, string $sourceHash): ?array
{
    if (!is_file($cacheFile)) {
        return null;
    }

    $modifiedTime = @filemtime($cacheFile);
    if ($modifiedTime === false || (time() - $modifiedTime) > $ttl) {
        return null;
    }

    $raw = @file_get_contents($cacheFile);
    if ($raw === false) {
        return null;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return null;
    }

    if (($decoded['source_hash'] ?? '') !== $sourceHash) {
        return null;
    }

    $posts = $decoded['posts'] ?? null;
    return is_array($posts) ? $posts : null;
}

function rrPostsWriteCache(string $cacheFile, string $sourceHash, array $posts): void
{
    $payload = json_encode([
        'source_hash' => $sourceHash,
        'posts' => $posts,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    if ($payload !== false) {
        @file_put_contents($cacheFile, $payload, LOCK_EX);
    }
}

function rrPostsNormalizePost(array $post): ?array
{
    $id = trim((string) ($post['id'] ?? $post['post_id'] ?? ''));
    if ($id === '') {
        return null;
    }

    $isPublished = rrPostsReadBool($post['is_published'] ?? null, true);
    $status = mb_strtolower(trim((string) ($post['status'] ?? '')), 'UTF-8');
    if ($status !== '' && $status !== 'published' && $status !== 'publish') {
        $isPublished = false;
    }

    if (!$isPublished) {
        return null;
    }

    $title = trim((string) ($post['title'] ?? 'Untitled'));
    $slug = trim((string) ($post['slug'] ?? ''));
    if ($slug === '') {
        $slug = rrPostsSlugify($title !== '' ? $title : $id);
    }

    $categories = rrPostsNormalizeCategories($post['categories'] ?? $post['category'] ?? []);
    $category = $categories[0] ?? '';

    $publishedAt = rrPostsNormalizeDate((string) ($post['published_at'] ?? $post['date'] ?? ''));
    $contentMarkdown = trim((string) ($post['content_markdown'] ?? $post['markdown'] ?? ''));
    $contentHtml = trim((string) ($post['content_html'] ?? ''));
    $content = trim((string) ($post['content'] ?? $post['body'] ?? ''));

    $excerpt = trim((string) ($post['excerpt'] ?? $post['summary'] ?? ''));
    if ($excerpt === '') {
        $excerptBase = $contentMarkdown !== '' ? $contentMarkdown : ($content !== '' ? $content : strip_tags($contentHtml));
        $excerpt = rrPostsCreateExcerpt($excerptBase);
    }

    return [
        'id' => $id,
        'slug' => $slug,
        'title' => $title,
        'excerpt' => $excerpt,
        'author' => trim((string) ($post['author'] ?? 'Rockrullarna')),
        'category' => $category,
        'categories' => $categories,
        'thumbnail' => rrPostsNullableString($post['thumbnail'] ?? $post['thumbnail_url'] ?? $post['image'] ?? null),
        'featured_image' => rrPostsNullableString($post['featured_image'] ?? $post['image'] ?? $post['thumbnail'] ?? null),
        'published_at' => $publishedAt,
        'is_featured' => rrPostsReadBool($post['is_featured'] ?? $post['featured'] ?? null, false),
        'content_markdown' => $contentMarkdown,
        'content_html' => $contentHtml,
        'content' => $content,
    ];
}

function rrPostsNormalizeCategories($input): array
{
    if (is_string($input)) {
        $input = preg_split('/\s*,\s*/u', $input) ?: [];
    }

    if (!is_array($input)) {
        return [];
    }

    $categories = [];
    foreach ($input as $value) {
        $item = trim((string) $value);
        if ($item !== '') {
            $categories[] = $item;
        }
    }

    return array_values(array_unique($categories));
}

function rrPostsNormalizeDate(string $date): string
{
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return date('Y-m-d H:i:s');
    }

    return date('Y-m-d H:i:s', $timestamp);
}

function rrPostsReadBool($value, bool $default): bool
{
    if ($value === null) {
        return $default;
    }

    if (is_bool($value)) {
        return $value;
    }

    if (is_numeric($value)) {
        return (int) $value === 1;
    }

    $normalized = mb_strtolower(trim((string) $value), 'UTF-8');
    if ($normalized === '') {
        return false;
    }

    return in_array($normalized, ['1', 'true', 'yes', 'ja', 'published', 'publish'], true);
}

function rrPostsNullableString($value): ?string
{
    $result = trim((string) $value);
    return $result === '' ? null : $result;
}

function rrPostsSlugify(string $value): string
{
    $value = mb_strtolower(trim($value), 'UTF-8');
    $value = strtr($value, ['å' => 'a', 'ä' => 'a', 'ö' => 'o']);
    $value = preg_replace('/[^a-z0-9]+/u', '-', $value) ?? $value;
    $value = trim($value, '-');
    return $value !== '' ? $value : 'post';
}

function rrPostsCreateExcerpt(string $text): string
{
    $clean = trim(preg_replace('/\s+/u', ' ', strip_tags($text)) ?? strip_tags($text));
    if (mb_strlen($clean, 'UTF-8') <= 180) {
        return $clean;
    }

    return rtrim(mb_substr($clean, 0, 177, 'UTF-8')) . '...';
}

function rrPostsMarkdownToHtml(string $markdown): string
{
    $text = htmlspecialchars($markdown, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/\[(.+?)\]\((https?:\/\/[^\s)]+)\)/u', '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>', $text) ?? $text;
    $text = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $text) ?? $text;
    $text = preg_replace('/\*(.+?)\*/u', '<em>$1</em>', $text) ?? $text;

    $blocks = preg_split("/\R{2,}/u", $text) ?: [$text];
    $htmlBlocks = [];

    foreach ($blocks as $block) {
        $line = trim($block);
        if ($line === '') {
            continue;
        }

        if (preg_match('/^###\s+(.+)/u', $line, $matches)) {
            $htmlBlocks[] = '<h3>' . $matches[1] . '</h3>';
            continue;
        }

        if (preg_match('/^##\s+(.+)/u', $line, $matches)) {
            $htmlBlocks[] = '<h2>' . $matches[1] . '</h2>';
            continue;
        }

        $listLines = preg_split('/\R/u', $line) ?: [];
        $isList = true;
        foreach ($listLines as $listLine) {
            if (!preg_match('/^\s*[-*]\s+.+/u', $listLine)) {
                $isList = false;
                break;
            }
        }

        if ($isList && $listLines !== []) {
            $items = [];
            foreach ($listLines as $listLine) {
                $items[] = '<li>' . preg_replace('/^\s*[-*]\s+/u', '', trim($listLine)) . '</li>';
            }
            $htmlBlocks[] = '<ul>' . implode('', $items) . '</ul>';
            continue;
        }

        $htmlBlocks[] = '<p>' . nl2br($line) . '</p>';
    }

    return implode("\n", $htmlBlocks);
}

function rrPostsFallbackData(): array
{
    return [
        [
            'id' => '2026-nyhet-kursstart-host',
            'slug' => 'kursstart-hosttermin',
            'title' => 'Kursstart i september – anmälan öppen',
            'excerpt' => 'Nu öppnar vi anmälan för höstens kurser i Bugg, Fox och West Coast Swing.',
            'author' => 'Rockrullarna',
            'category' => 'Kursstart',
            'categories' => ['Kursstart', 'Nyheter'],
            'thumbnail' => '/filer/bilder/webb/bugg/socialdans.jpg',
            'featured_image' => '/filer/bilder/webb/bugg/socialdans.jpg',
            'published_at' => '2026-08-20 09:00:00',
            'is_featured' => true,
            'content_markdown' => "## Höstterminen närmar sig\nAnmälan till våra kurser är nu öppen. Vi erbjuder flera nivåer och dansstilar.\n\n- Bugg\n- Fox\n- West Coast Swing\n\n[Läs mer om anmälan](/danskurser/anmalan-danskurser)",
        ],
        [
            'id' => '2026-nyhet-socialdans-sept',
            'slug' => 'socialdans-i-september',
            'title' => 'Socialdans varje torsdag i september',
            'excerpt' => 'Kom och dansa med oss under fyra torsdagskvällar i september.',
            'author' => 'Aktivitetsgruppen',
            'category' => 'Evenemang',
            'categories' => ['Evenemang'],
            'thumbnail' => '/filer/bilder/webb/fox/socialdans-oland-stranddans.jpg',
            'featured_image' => '/filer/bilder/webb/fox/socialdans-oland-stranddans.jpg',
            'published_at' => '2026-08-15 12:30:00',
            'is_featured' => false,
            'content_markdown' => "Välkommen till socialdans i vår lokal på Vaktelvägen 2.\n\nTa gärna med en vän!",
        ],
        [
            'id' => '2026-nyhet-arsmote',
            'slug' => 'arsmote-2027-information',
            'title' => 'Förhandsinfo: årsmöte 2027',
            'excerpt' => 'Spara datumet för kommande årsmöte med verksamhetsgenomgång och valberedningens förslag.',
            'author' => 'Styrelsen',
            'category' => 'Årsmöte',
            'categories' => ['Årsmöte'],
            'thumbnail' => '/filer/bilder/webb/lokalen/entre.jpg',
            'featured_image' => '/filer/bilder/webb/lokalen/entre.jpg',
            'published_at' => '2026-08-10 18:00:00',
            'is_featured' => true,
            'content_markdown' => "Mer information publiceras när handlingarna är klara.",
        ],
        [
            'id' => '2026-nyhet-workshop-fox',
            'slug' => 'fox-workshop-oktober',
            'title' => 'Fox-workshop i oktober',
            'excerpt' => 'En kväll med fokus på musikalitet och följteknik i Fox.',
            'author' => 'Kursgruppen',
            'category' => 'Evenemang',
            'categories' => ['Evenemang'],
            'thumbnail' => '/filer/bilder/webb/fox/workshop.jpg',
            'featured_image' => '/filer/bilder/webb/fox/workshop.jpg',
            'published_at' => '2026-08-05 08:00:00',
            'is_featured' => false,
            'content_markdown' => "Workshopen riktar sig till dansare med grundkunskaper i Fox.",
        ],
        [
            'id' => '2026-nyhet-trivselkvall',
            'slug' => 'trivselkvall-september',
            'title' => 'Trivselkväll med prova-på',
            'excerpt' => 'Ta med en vän och testa flera dansstilar under samma kväll.',
            'author' => 'Rockrullarna',
            'category' => 'Nyheter',
            'categories' => ['Nyheter'],
            'thumbnail' => '/filer/bilder/webb/wcs/socialdans-2.jpg',
            'featured_image' => '/filer/bilder/webb/wcs/socialdans-2.jpg',
            'published_at' => '2026-08-01 20:00:00',
            'is_featured' => false,
            'content_markdown' => "Vi bjuder in till trivselkväll med prova-på för både nya och befintliga medlemmar.",
        ],
    ];
}
