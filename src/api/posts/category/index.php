<?php
declare(strict_types=1);

$requestPath = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?? '');
if (preg_match('#/api/posts/category(?:/index\.php)?/(.+)$#u', $requestPath, $matches) === 1) {
    $_GET['category'] = urldecode($matches[1]);
}

require_once dirname(__DIR__, 2) . '/posts.php';
