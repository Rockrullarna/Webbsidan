<?php
declare(strict_types=1);

$remoteUrl = trim((string) filter_input(INPUT_GET, 'url', FILTER_UNSAFE_RAW));

if ($remoteUrl === '') {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Missing image url.';
    exit;
}

$parsedUrl = parse_url($remoteUrl);
$host = strtolower((string) ($parsedUrl['host'] ?? ''));
$allowedHosts = [
    'scontent-arn2-1.cdninstagram.com',
    'scontent.cdninstagram.com',
    'lookaside.instagram.com',
    'instagram.farn1-2.fna.fbcdn.net',
    'scontent-fra3-1.cdninstagram.com',
];

$isAllowedHost = false;

foreach ($allowedHosts as $allowedHost) {
    if ($host === $allowedHost || str_ends_with($host, '.cdninstagram.com') || str_ends_with($host, '.fbcdn.net')) {
        $isAllowedHost = true;
        break;
    }
}

if (!$isAllowedHost) {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Unsupported image host.';
    exit;
}

$headers = [
    'Accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
    'Accept-Language: sv-SE,sv;q=0.9,en-US;q=0.8,en;q=0.7',
    'Referer: https://www.instagram.com/',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36',
];

$binary = false;
$contentType = 'image/jpeg';
$statusCode = 0;

if (function_exists('curl_init')) {
    $curlHandle = curl_init($remoteUrl);

    curl_setopt_array($curlHandle, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 12,
        CURLOPT_HEADER => true,
    ]);

    $response = curl_exec($curlHandle);
    $statusCode = (int) curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);
    $headerSize = (int) curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE);
    $detectedContentType = (string) curl_getinfo($curlHandle, CURLINFO_CONTENT_TYPE);
    curl_close($curlHandle);

    if ($response !== false && $statusCode >= 200 && $statusCode < 300) {
        $binary = substr($response, $headerSize);

        if ($detectedContentType !== '') {
            $contentType = $detectedContentType;
        }
    }
} else {
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => implode("\r\n", $headers),
            'timeout' => 12,
        ],
    ]);

    $binary = @file_get_contents($remoteUrl, false, $context);

    if ($binary !== false && isset($http_response_header) && is_array($http_response_header)) {
        foreach ($http_response_header as $responseHeader) {
            if (stripos($responseHeader, 'Content-Type:') === 0) {
                $contentType = trim(substr($responseHeader, strlen('Content-Type:')));
            }
        }
    }
}

if ($binary === false || $binary === '') {
    http_response_code(502);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Could not load Instagram image.';
    exit;
}

header('Content-Type: ' . $contentType);
header('Cache-Control: public, max-age=900');
echo $binary;