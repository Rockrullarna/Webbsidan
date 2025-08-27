<?php
// En enkel proxy + cache för att hämta aktiviteter från dans.se
// För att undvika CORS/iframe och kunna styla eget markup.

header('Content-Type: text/html; charset=utf-8');

// Konfiguration
$SOURCE_URL = 'https://dans.se/view/schedule/?org=rockrullarna&days=60&showEndTime=1';
$CACHE_DIR = __DIR__ . '/../cache';
$CACHE_FILE = $CACHE_DIR . '/aktiviteter.json';
$CACHE_TTL = 15 * 60; // 15 minuter

if (!is_dir($CACHE_DIR)) {
    @mkdir($CACHE_DIR, 0775, true);
}

function fetch_remote($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 8,
        CURLOPT_TIMEOUT => 12,
        CURLOPT_USERAGENT => 'RR-Webb/1.0 (+https://rockrullarna.se)'
    ]);
    $data = curl_exec($ch);
    $err = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($data === false || $status >= 400) {
        throw new RuntimeException('Remote fetch failed: ' . ($err ?: 'HTTP ' . $status));
    }
    return $data;
}

function extract_events($html) {
    // Mycket enkel extraktion; riktiga sidan kanske behöver mer robust parser
    // För demo söker vi rader med event-rader. Justera selectors senare.
    $events = [];
    if (preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $html, $rows)) {
        foreach ($rows[1] as $rowHtml) {
            // Leta efter datum och titel heuristiskt
            if (preg_match('/(\d{4}-\d{2}-\d{2})/u', $rowHtml, $dMatch)) {
                $date = $dMatch[1];
            } else {
                $date = null;
            }
            if (preg_match('/<a[^>]*>(.*?)<\/a>/u', $rowHtml, $tMatch)) {
                $title = strip_tags($tMatch[1]);
            } else {
                $title = trim(strip_tags($rowHtml));
            }
            $clean = trim(preg_replace('/\s+/', ' ', strip_tags($rowHtml)));
            if ($title || $date) {
                $events[] = [
                    'date' => $date,
                    'title' => $title,
                    'raw' => $clean
                ];
            }
        }
    }
    return $events;
}

function read_cache($file, $ttl) {
    if (is_file($file) && (time() - filemtime($file) < $ttl)) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        if (is_array($data)) return $data;
    }
    return null;
}

function write_cache($file, $data) {
    file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

$cached = read_cache($CACHE_FILE, $CACHE_TTL);
if ($cached === null) {
    try {
        $html = fetch_remote($SOURCE_URL);
        $events = extract_events($html);
        $payload = [
            'fetched' => gmdate('c'),
            'events' => $events
        ];
        write_cache($CACHE_FILE, $payload);
        $cached = $payload;
    } catch (Throwable $e) {
        if ($cached === null) {
            http_response_code(502);
            echo '<div class="alert alert-warning">Kunde inte hämta aktiviteter just nu.</div>';
            exit;
        }
    }
}

// Rendera enkel lista
if (!$cached || empty($cached['events'])) {
    echo '<div class="text-muted">Inga kommande aktiviteter hittades.</div>';
    exit;
}

$events = $cached['events'];

usort($events, function($a,$b){
    return strcmp($a['date'] ?? '', $b['date'] ?? '');
});

$max = 12; // visa max 12
$count = 0;

echo '<ul class="list-group list-group-flush text-start">';
foreach ($events as $ev) {
    if ($count++ >= $max) break;
    $date = $ev['date'] ? htmlspecialchars($ev['date']) : '';
    $title = htmlspecialchars($ev['title']);
    echo '<li class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">';
    echo '<span class="fw-semibold">' . ($title ?: 'Aktivitet') . '</span>';
    if ($date) {
        echo '<time class="text-muted small" datetime="' . $date . '">' . $date . '</time>';
    }
    echo '</li>';
}

echo '</ul>';

echo '<p class="mt-3 mb-0"><a class="btn btn-sm btn-outline-secondary" href="/aktivitetskalender" title="Fullständig aktivitetskalender">Alla aktiviteter</a></p>';
