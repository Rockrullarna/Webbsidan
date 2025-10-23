<?php
// proxy-events.php
// Purpose: Fetch events XML from dans.se and serve it from your origin to avoid CORS problems.
// Includes a small on-disk cache to reduce load and improve performance.

declare(strict_types=1);

$upstream = 'https://dans.se/xml/?type=events&org=rockrullarna';
$cacheTtlSeconds = 300; // cache for 5 minutes
$cacheFile = sys_get_temp_dir() . '/rockrullarna-events.xml';

header('Content-Type: application/xml; charset=UTF-8');
// If you want to allow other origins to read your proxy, uncomment and set accordingly:
// header('Access-Control-Allow-Origin: https://rockrullarna.se');

function fetchUpstream(string $url): array {
  // Prefer cURL if available for better control/timeouts; fall back to file_get_contents.
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CONNECTTIMEOUT => 8,
      CURLOPT_TIMEOUT => 12,
      CURLOPT_HTTPHEADER => [
        'User-Agent: rockrullarna-proxy',
        'Accept: application/xml',
      ],
    ]);
    $body = curl_exec($ch);
    $err  = curl_error($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $ctype = curl_getinfo($ch, CURLINFO_CONTENT_TYPE) ?: 'application/xml; charset=UTF-8';
    curl_close($ch);

    return [$code, $ctype, $body, $err ?: null];
  }

  $ctx = stream_context_create([
    'http' => [
      'method' => 'GET',
      'header' =>
        "User-Agent: rockrullarna-proxy\r\n" .
        "Accept: application/xml\r\n",
      'timeout' => 12,
      'ignore_errors' => true,
    ]
  ]);
  $body = @file_get_contents($url, false, $ctx);
  // Extract HTTP code from $http_response_header if available
  $code = 0;
  $ctype = 'application/xml; charset=UTF-8';
  if (isset($http_response_header) && is_array($http_response_header)) {
    foreach ($http_response_header as $hdr) {
      if (stripos($hdr, 'HTTP/') === 0 && preg_match('/\s(\d{3})\s/', $hdr, $m)) {
        $code = (int)$m[1];
      } elseif (stripos($hdr, 'Content-Type:') === 0) {
        $ctype = trim(substr($hdr, strlen('Content-Type:')));
      }
    }
  }
  return [$code ?: 200, $ctype, $body, null];
}

// Serve cached if fresh
if (is_file($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtlSeconds)) {
  http_response_code(200);
  // Note: content type header already set above.
  readfile($cacheFile);
  exit;
}

// Fetch fresh
[$code, $ctype, $body, $err] = fetchUpstream($upstream);

// Pass-through status (but avoid caching failures for too long)
if ($code >= 200 && $code < 300 && $body !== false && $body !== null) {
  // Save to cache
  @file_put_contents($cacheFile, $body);
  header('Content-Type: ' . $ctype);
  http_response_code(200);
  echo $body;
  exit;
}

// On error: if we have a stale cache, serve it as a fallback
if (is_file($cacheFile)) {
  header('Content-Type: application/xml; charset=UTF-8');
  header('X-Proxy-Warning: upstream_error_fallback_cache');
  http_response_code(200);
  readfile($cacheFile);
  exit;
}

// No cache and upstream failed: return minimal XML error
http_response_code($code ?: 502);
header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?><error>Upstream fetch failed</error>';

// end of file
