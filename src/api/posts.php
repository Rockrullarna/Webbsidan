<?php
declare(strict_types=1);

require_once __DIR__ . '/posts-cache.php';

header('Content-Type: application/json; charset=utf-8');

$posts = rrPostsGetAll();
$requestPath = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?? '');
$route = trim((string) preg_replace('#^/api/posts(?:\.php|/index\.php)?#', '', $requestPath), '/');

$queryId = trim((string) ($_GET['id'] ?? $_GET['slug'] ?? ''));
$queryCategory = trim((string) ($_GET['category'] ?? ''));
$querySearch = trim((string) ($_GET['q'] ?? ''));
$queryFeatured = filter_var($_GET['featured'] ?? false, FILTER_VALIDATE_BOOLEAN);
$queryPage = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);
$queryPerPage = filter_var($_GET['per_page'] ?? 10, FILTER_VALIDATE_INT, ['options' => ['default' => 10, 'min_range' => 10, 'max_range' => 20]]);

if ($queryId !== '') {
    $singlePost = rrPostsFindByIdOrSlug($posts, $queryId);
    if ($singlePost === null) {
        rrPostsApiRespondError(404, 'POST_NOT_FOUND', 'Posten kunde inte hittas.');
    }

    rrPostsApiRespond([
        'post' => $singlePost,
    ]);
}

if ($queryCategory !== '') {
    $filteredPosts = rrPostsFilter($posts, $queryCategory, $querySearch, $queryFeatured);
    $pagination = rrPostsPaginate($filteredPosts, $queryPage, $queryPerPage);

    rrPostsApiRespond([
        'posts' => $pagination['items'],
        'pagination' => rrPostsApiPagination($pagination),
        'filters' => [
            'category' => $queryCategory,
            'q' => $querySearch,
            'featured' => $queryFeatured,
        ],
    ]);
}

if ($route !== '') {
    if (preg_match('#^category/(.+)$#u', $route, $matches) === 1) {
        $routeCategory = trim(urldecode($matches[1]));
        if ($routeCategory === '') {
            rrPostsApiRespondError(400, 'INVALID_CATEGORY', 'Kategori saknas.');
        }

        $filteredPosts = rrPostsFilter($posts, $routeCategory, $querySearch, $queryFeatured);
        $pagination = rrPostsPaginate($filteredPosts, $queryPage, $queryPerPage);

        rrPostsApiRespond([
            'posts' => $pagination['items'],
            'pagination' => rrPostsApiPagination($pagination),
            'filters' => [
                'category' => $routeCategory,
                'q' => $querySearch,
                'featured' => $queryFeatured,
            ],
        ]);
    }

    $singlePost = rrPostsFindByIdOrSlug($posts, urldecode($route));
    if ($singlePost === null) {
        rrPostsApiRespondError(404, 'POST_NOT_FOUND', 'Posten kunde inte hittas.');
    }

    rrPostsApiRespond([
        'post' => $singlePost,
    ]);
}

$filteredPosts = rrPostsFilter($posts, $queryCategory !== '' ? $queryCategory : null, $querySearch, $queryFeatured);
$pagination = rrPostsPaginate($filteredPosts, $queryPage, $queryPerPage);

rrPostsApiRespond([
    'posts' => $pagination['items'],
    'pagination' => rrPostsApiPagination($pagination),
    'filters' => [
        'category' => $queryCategory,
        'q' => $querySearch,
        'featured' => $queryFeatured,
    ],
    'categories' => rrPostsGetCategories($posts),
]);

function rrPostsApiPagination(array $pagination): array
{
    return [
        'page' => $pagination['page'],
        'per_page' => $pagination['per_page'],
        'total_items' => $pagination['total_items'],
        'total_pages' => $pagination['total_pages'],
    ];
}

function rrPostsApiRespond(array $payload): void
{
    $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    if ($encoded === false) {
        rrPostsApiRespondError(500, 'JSON_ENCODE_ERROR', 'Kunde inte skapa JSON-svar.');
    }

    echo $encoded;
    exit;
}

function rrPostsApiRespondError(int $statusCode, string $code, string $message): void
{
    http_response_code($statusCode);
    rrPostsApiRespond([
        'error' => [
            'code' => $code,
            'message' => $message,
        ],
    ]);
}
