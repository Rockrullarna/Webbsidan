<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$username = 'rockrullarna';
$limit = 4;
$cacheTtlSeconds = 15 * 60;
$cacheSchemaVersion = 2;
$debug = filter_input(INPUT_GET, 'debug', FILTER_VALIDATE_BOOLEAN) ?? false;
$forceRefresh = filter_input(INPUT_GET, 'refresh', FILTER_VALIDATE_BOOLEAN) ?? false;
$cacheDir = __DIR__ . DIRECTORY_SEPARATOR . 'cache';
$cacheFile = $cacheDir . DIRECTORY_SEPARATOR . 'instagram-' . $username . '.json';

function log_instagram_feed_issue(string $message): void
{
    error_log('[sociala-media/data] ' . $message);
}

function get_instagram_config_value(string $key, string $default = ''): string
{
    $value = getenv($key);

    if ($value === false || $value === null) {
        return $default;
    }

    $value = trim((string) $value);
    return $value === '' ? $default : $value;
}

function ensure_social_cache_directory(string $cacheDir): void
{
    if (is_dir($cacheDir)) {
        return;
    }

    if (!@mkdir($cacheDir, 0775, true) && !is_dir($cacheDir)) {
        throw new RuntimeException('Kunde inte skapa cache-katalogen för Instagram-flödet.');
    }
}

function fetch_instagram_json(string $endpoint, array $headers, string $requestLabel): ?array
{
    $response = false;
    $status = 0;

    if (function_exists('curl_init')) {
        $curlHandle = curl_init($endpoint);

        curl_setopt_array($curlHandle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 8,
        ]);

        $response = curl_exec($curlHandle);
        $status = (int) curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);
        curl_close($curlHandle);

        if ($status !== 200 || $response === false) {
            log_instagram_feed_issue($requestLabel . ' failed with status ' . (string) $status . '.');
            return null;
        }
    } else {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'timeout' => 8,
            ],
        ]);

        $response = @file_get_contents($endpoint, false, $context);

        if ($response === false) {
            log_instagram_feed_issue($requestLabel . ' failed when using file_get_contents.');
            return null;
        }
    }

    $payload = json_decode((string) $response, true);

    if (!is_array($payload)) {
        log_instagram_feed_issue($requestLabel . ' could not be decoded as JSON.');
        return null;
    }

    if (!empty($payload['error']['message'])) {
        log_instagram_feed_issue($requestLabel . ' returned an error: ' . $payload['error']['message']);
        return null;
    }

    return $payload;
}

function fetch_graph_instagram_payload(string $accessToken, int $limit): ?array
{
    $endpoint = 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp&limit=' . rawurlencode((string) $limit) . '&access_token=' . rawurlencode($accessToken);
    $headers = [
        'Accept: application/json',
        'User-Agent: RockrullarnaWeb/1.0 (+https://rockrullarna.se/)',
    ];

    return fetch_instagram_json($endpoint, $headers, 'Instagram Graph API request');
}

function fetch_legacy_instagram_payload(string $username): ?array
{
    $endpoint = 'https://i.instagram.com/api/v1/users/web_profile_info/?username=' . rawurlencode($username);
    $headers = [
        'Accept: */*',
        'Accept-Language: sv-SE,sv;q=0.9,en-US;q=0.8,en;q=0.7',
        'Referer: https://www.instagram.com/' . rawurlencode($username) . '/',
        'User-Agent: Instagram 276.0.0.26.129 Android (33/13; 420dpi; 1080x2220; Google/google; Pixel 7; panther; qcom; sv_SE; 456970516)',
        'X-IG-App-ID: 936619743392459',
    ];

    return fetch_instagram_json($endpoint, $headers, 'Instagram legacy profile request');
}

function normalize_instagram_posts(array $mediaItems, int $limit): array
{
    $posts = [];

    foreach (array_slice($mediaItems, 0, $limit) as $item) {
        $permalink = trim((string) ($item['permalink'] ?? ''));
        $mediaUrl = trim((string) ($item['media_url'] ?? ''));
        $thumbnailUrl = trim((string) ($item['thumbnail_url'] ?? ''));
        $mediaType = trim((string) ($item['media_type'] ?? ''));

        if ($permalink === '') {
            continue;
        }

        $caption = trim((string) ($item['caption'] ?? ''));
        if ($caption === '') {
            $caption = 'Se senaste uppdateringen från Rockrullarna på Instagram.';
        }

        $imageUrl = $mediaUrl;

        if ($mediaType === 'VIDEO' && $thumbnailUrl !== '') {
            $imageUrl = $thumbnailUrl;
        }

        if ($mediaType === 'CAROUSEL_ALBUM' && $imageUrl === '' && $thumbnailUrl !== '') {
            $imageUrl = $thumbnailUrl;
        }

        $posts[] = [
            'url' => $permalink,
            'image' => $imageUrl,
            'alt' => $caption !== '' ? $caption : 'Instagram-inlägg från Rockrullarna',
            'caption' => $caption,
            'timestamp' => trim((string) ($item['timestamp'] ?? '')),
            'mediaType' => $mediaType,
        ];
    }

    return $posts;
}

function normalize_legacy_instagram_posts(array $payload, int $limit): array
{
    $edges = $payload['data']['user']['edge_owner_to_timeline_media']['edges']
        ?? $payload['graphql']['user']['edge_owner_to_timeline_media']['edges']
        ?? [];

    if (!is_array($edges) || empty($edges)) {
        log_instagram_feed_issue('Instagram legacy profile response did not contain any posts.');
        return [];
    }

    $posts = [];

    foreach (array_slice($edges, 0, $limit) as $edge) {
        $node = is_array($edge['node'] ?? null) ? $edge['node'] : [];
        $shortcode = trim((string) ($node['shortcode'] ?? ''));

        if ($shortcode === '') {
            continue;
        }

        $captionEdges = $node['edge_media_to_caption']['edges'] ?? [];
        $caption = '';

        if (!empty($captionEdges[0]['node']['text'])) {
            $caption = trim((string) $captionEdges[0]['node']['text']);
        }

        if ($caption === '' && !empty($node['accessibility_caption'])) {
            $caption = trim((string) $node['accessibility_caption']);
        }

        if ($caption === '') {
            $caption = 'Se senaste uppdateringen från Rockrullarna på Instagram.';
        }

        $posts[] = [
            'url' => 'https://www.instagram.com/p/' . rawurlencode($shortcode) . '/',
            'image' => trim((string) ($node['thumbnail_src'] ?? $node['display_url'] ?? '')),
            'alt' => trim((string) ($node['accessibility_caption'] ?? 'Instagram-inlägg från Rockrullarna')),
            'caption' => $caption,
            'timestamp' => trim((string) ($node['taken_at_timestamp'] ?? '')) !== ''
                ? gmdate('c', (int) $node['taken_at_timestamp'])
                : '',
            'mediaType' => !empty($node['is_video']) ? 'VIDEO' : 'IMAGE',
        ];
    }

    return $posts;
}

function build_instagram_payload(array $posts, int $cacheSchemaVersion, string $cacheStatus, bool $debug, ?string $errorMessage = null, string $source = 'cache'): array
{
    $payload = [
        'meta' => [
            'schemaVersion' => $cacheSchemaVersion,
            'generatedAt' => gmdate('c'),
            'cacheStatus' => $cacheStatus,
            'count' => count($posts),
            'source' => $source,
        ],
        'posts' => $posts,
    ];

    if ($debug && $errorMessage !== null) {
        $payload['meta']['error'] = $errorMessage;
    }

    return $payload;
}

function encode_instagram_payload(array $payload): string
{
    $encoded = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($encoded === false) {
        throw new RuntimeException('Kunde inte skapa JSON för Instagram-flödet.');
    }

    return $encoded;
}

function read_instagram_cache(string $cacheFile): ?array
{
    if (!is_file($cacheFile)) {
        return null;
    }

    $cachedContent = @file_get_contents($cacheFile);

    if ($cachedContent === false || $cachedContent === '') {
        return null;
    }

    $decoded = json_decode($cachedContent, true);

    return is_array($decoded) ? $decoded : null;
}

function is_instagram_cache_fresh(string $cacheFile, int $ttlSeconds, int $cacheSchemaVersion): bool
{
    if (!is_file($cacheFile)) {
        return false;
    }

    $modifiedTime = @filemtime($cacheFile);
    if ($modifiedTime === false || ($modifiedTime + $ttlSeconds) < time()) {
        return false;
    }

    $cachedPayload = read_instagram_cache($cacheFile);

    if (!is_array($cachedPayload)) {
        return false;
    }

    return (int) ($cachedPayload['meta']['schemaVersion'] ?? 0) === $cacheSchemaVersion;
}

function write_instagram_cache(string $cacheDir, string $cacheFile, string $payload): void
{
    ensure_social_cache_directory($cacheDir);
    @file_put_contents($cacheFile, $payload, LOCK_EX);
}

function respond_with_json(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo encode_instagram_payload($payload);
    exit;
}

if (!$forceRefresh && is_instagram_cache_fresh($cacheFile, $cacheTtlSeconds, $cacheSchemaVersion)) {
    $cachedPayload = read_instagram_cache($cacheFile);

    if (is_array($cachedPayload)) {
        respond_with_json($cachedPayload);
    }
}

$accessToken = get_instagram_config_value('RR_INSTAGRAM_ACCESS_TOKEN');

$posts = [];
$cacheStatus = 'error';
$source = 'none';
$errorMessage = null;

if ($accessToken !== '') {
    $remotePayload = fetch_graph_instagram_payload($accessToken, $limit);

    if (is_array($remotePayload) && is_array($remotePayload['data'] ?? null)) {
        $posts = normalize_instagram_posts($remotePayload['data'], $limit);

        if (!empty($posts)) {
            $cacheStatus = 'fresh';
            $source = 'graph';
        }
    }
}

if (empty($posts)) {
    $legacyPayload = fetch_legacy_instagram_payload($username);

    if (is_array($legacyPayload)) {
        $posts = normalize_legacy_instagram_posts($legacyPayload, $limit);

        if (!empty($posts)) {
            $cacheStatus = $accessToken === '' ? 'fresh-fallback' : 'fresh-fallback';
            $source = 'legacy';
        }
    }
}

if (empty($posts)) {
    $stalePayload = read_instagram_cache($cacheFile);

    if (is_array($stalePayload)) {
        $stalePayload['meta']['cacheStatus'] = 'stale';
        respond_with_json($stalePayload);
    }

    if ($accessToken === '') {
        $errorMessage = 'RR_INSTAGRAM_ACCESS_TOKEN saknas och legacy-hamtningen gav ingen data.';
        $cacheStatus = 'missing-config';
    } else {
        $errorMessage = 'Kunde inte hämta data från Instagram Graph API eller legacy-hämtaren.';
    }

    respond_with_json(
        build_instagram_payload([], $cacheSchemaVersion, $cacheStatus, $debug, $errorMessage, $source),
        $accessToken === '' ? 503 : 502
    );
}

$payload = build_instagram_payload($posts, $cacheSchemaVersion, $cacheStatus, $debug, null, $source);
$encodedPayload = encode_instagram_payload($payload);
write_instagram_cache($cacheDir, $cacheFile, $encodedPayload);

http_response_code(200);
echo $encodedPayload;