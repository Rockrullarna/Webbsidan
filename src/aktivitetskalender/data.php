<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// #region Config
$cacheTtlSeconds = 15 * 60;
$debug = filter_input(INPUT_GET, 'debug', FILTER_VALIDATE_BOOLEAN) ?? false;
$org = 'rockrullarna';
$days = filter_input(
    INPUT_GET,
    'days',
    FILTER_VALIDATE_INT,
    ['options' => ['default' => 180, 'min_range' => 1, 'max_range' => 365]]
);

$scheduleUrl = 'https://dans.se/view/schedule/?org=' . rawurlencode($org) . '&days=' . $days . '&showEndTime=1';
$eventsUrl = 'https://dans.se/api/public/events/?org=' . rawurlencode($org) . '&limit=500';
$cacheDir = __DIR__ . DIRECTORY_SEPARATOR . 'cache';
$cacheFile = $cacheDir . DIRECTORY_SEPARATOR . 'calendar-' . $org . '-' . $days . '.json';
// #endregion

// #region Cache And Remote Fetch
function fetch_remote_text(string $url): string
{
    $context = stream_context_create([
        'http' => [
            'timeout' => 20,
            'user_agent' => 'RR-Webbsidan aktivitetskalender'
        ]
    ]);

    $content = @file_get_contents($url, false, $context);
    if ($content !== false) {
        return $content;
    }

    if (function_exists('curl_init')) {
        $curlHandle = curl_init($url);
        curl_setopt_array($curlHandle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'RR-Webbsidan aktivitetskalender'
        ]);

        $content = curl_exec($curlHandle);
        $statusCode = (int) curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);
        curl_close($curlHandle);

        if ($content !== false && $statusCode >= 200 && $statusCode < 300) {
            return $content;
        }
    }

    throw new RuntimeException('Kunde inte hämta fjärrdata.');
}

function ensure_cache_directory(string $cacheDir): void
{
    if (is_dir($cacheDir)) {
        return;
    }

    if (!@mkdir($cacheDir, 0775, true) && !is_dir($cacheDir)) {
        throw new RuntimeException('Kunde inte skapa cache-katalogen.');
    }
}

function read_cache_if_fresh(string $cacheFile, int $ttlSeconds): ?string
{
    if (!is_file($cacheFile)) {
        return null;
    }

    $modifiedTime = @filemtime($cacheFile);
    if ($modifiedTime === false || (time() - $modifiedTime) > $ttlSeconds) {
        return null;
    }

    $contents = @file_get_contents($cacheFile);
    return $contents === false ? null : $contents;
}

function read_stale_cache(string $cacheFile): ?string
{
    if (!is_file($cacheFile)) {
        return null;
    }

    $contents = @file_get_contents($cacheFile);
    return $contents === false ? null : $contents;
}

function write_cache(string $cacheDir, string $cacheFile, string $payload): void
{
    ensure_cache_directory($cacheDir);
    @file_put_contents($cacheFile, $payload, LOCK_EX);
}
// #endregion

// #region Response Payloads
function decode_cache_payload(string $payload): ?array
{
    $decoded = json_decode($payload, true);

    if (is_array($decoded) && isset($decoded['events']) && is_array($decoded['events'])) {
        return [
            'events' => $decoded['events'],
            'meta' => is_array($decoded['meta'] ?? null) ? $decoded['meta'] : []
        ];
    }

    if (is_array($decoded) && array_is_list($decoded)) {
        return [
            'events' => $decoded,
            'meta' => []
        ];
    }

    return null;
}

function encode_cache_payload(array $events, array $meta): string
{
    $payload = json_encode([
        'events' => $events,
        'meta' => $meta
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($payload === false) {
        throw new RuntimeException('Kunde inte skapa cache-payload.');
    }

    return $payload;
}

function build_response_payload(array $events, array $meta, bool $debug): string
{
    // Normal trafik får bara en flat lista. Debug-läge får både events och meta.
    $payload = $debug ? ['events' => $events, 'debug' => $meta] : $events;
    $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($encoded === false) {
        throw new RuntimeException('Kunde inte skapa svarspayload.');
    }

    return $encoded;
}
// #endregion

// #region Shared Helpers
function normalize_text(string $value): string
{
    $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $value = preg_replace('/\s+/u', ' ', trim($value)) ?? trim($value);
    return mb_strtolower($value, 'UTF-8');
}

function extract_month_day(string $headingText): ?array
{
    if (!preg_match('/(\d{1,2})\/(\d{1,2})/u', $headingText, $matches)) {
        return null;
    }

    return [
        'day' => (int) $matches[1],
        'month' => (int) $matches[2]
    ];
}

function build_date_string(int $year, int $month, int $day): string
{
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
}

function extract_event_links(string $eventsJson): array
{
    $decoded = json_decode($eventsJson, true);
    $events = is_array($decoded['events'] ?? null) ? $decoded['events'] : [];
    $links = [];

    foreach ($events as $event) {
        $name = trim((string) ($event['name'] ?? $event['title'] ?? ''));
        if ($name === '') {
            continue;
        }

        $url = trim((string) (
            $event['registration']['url'] ??
            $event['url'] ??
            $event['source'] ??
            ''
        ));

        if ($url === '') {
            continue;
        }

        $links[normalize_text($name)] = $url;
    }

    return $links;
}

function parse_events_payload(string $eventsJson): array
{
    $decoded = json_decode($eventsJson, true);
    return is_array($decoded['events'] ?? null) ? $decoded['events'] : [];
}

function find_next_table(DOMNode $node): ?DOMElement
{
    $sibling = $node->nextSibling;
    while ($sibling !== null) {
        if ($sibling instanceof DOMElement) {
            if ($sibling->tagName === 'table') {
                return $sibling;
            }

            $tables = $sibling->getElementsByTagName('table');
            if ($tables->length > 0) {
                return $tables->item(0);
            }
        }
        $sibling = $sibling->nextSibling;
    }

    return null;
}

function parse_time_slot(string $slotText): ?array
{
    $slotText = trim(html_entity_decode($slotText, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    if ($slotText === '' || preg_match('/^Bokat\b/iu', $slotText)) {
        return null;
    }

    if (!preg_match('/^(\d{1,2})[.:](\d{2})-(\d{1,2})[.:](\d{2})\s+(.+)$/u', $slotText, $matches)) {
        return null;
    }

    return [
        'startTime' => sprintf('%02d:%02d:00', (int) $matches[1], (int) $matches[2]),
        'endTime' => sprintf('%02d:%02d:00', (int) $matches[3], (int) $matches[4]),
        'title' => trim($matches[5])
    ];
}

function create_datetime(string $date, string $time): ?DateTimeImmutable
{
    $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);
    return $dateTime === false ? null : $dateTime;
}

function extract_time_range_from_info(?string $value): ?array
{
    if (!$value) {
        return null;
    }

    if (!preg_match('/(\d{1,2})[.:](\d{2})\s*[-–]\s*(\d{1,2})[.:](\d{2})/u', $value, $matches)) {
        return null;
    }

    return [
        'startTime' => sprintf('%02d:%02d:00', (int) $matches[1], (int) $matches[2]),
        'endTime' => sprintf('%02d:%02d:00', (int) $matches[3], (int) $matches[4])
    ];
}

function build_event_url(array $event): ?string
{
    $url = trim((string) (
        $event['registration']['url'] ??
        $event['url'] ??
        $event['source'] ??
        ''
    ));

    return $url === '' ? null : $url;
}

function score_location(string $location): int
{
    $trimmedLocation = trim($location);
    if ($trimmedLocation === '') {
        return 0;
    }

    $normalizedLocation = normalize_text($trimmedLocation);
    $score = 20;
    $wordCount = preg_match_all('/[\p{L}\p{N}]+/u', $trimmedLocation);

    if (preg_match('/\b(okänd|saknas|tba|senare|info)\b/iu', $trimmedLocation)) {
        $score -= 12;
    }

    $score += min(20, mb_strlen($normalizedLocation, 'UTF-8'));
    $score += min(12, (int) $wordCount * 2);

    if (preg_match('/[,()\-\/]/u', $trimmedLocation)) {
        $score += 3;
    }

    return max(0, $score);
}

function select_better_location(string $existingLocation, string $candidateLocation): string
{
    $existingLocation = trim($existingLocation);
    $candidateLocation = trim($candidateLocation);

    if ($existingLocation === '') {
        return $candidateLocation;
    }

    if ($candidateLocation === '') {
        return $existingLocation;
    }

    $existingNormalized = normalize_text($existingLocation);
    $candidateNormalized = normalize_text($candidateLocation);

    if ($existingNormalized === $candidateNormalized) {
        return mb_strlen($candidateLocation, 'UTF-8') > mb_strlen($existingLocation, 'UTF-8')
            ? $candidateLocation
            : $existingLocation;
    }

    if (str_contains($candidateNormalized, $existingNormalized)) {
        return $candidateLocation;
    }

    if (str_contains($existingNormalized, $candidateNormalized)) {
        return $existingLocation;
    }

    return score_location($candidateLocation) > score_location($existingLocation)
        ? $candidateLocation
        : $existingLocation;
}

function build_event_key(string $name, string $start, string $end): string
{
    return normalize_text($name) . '|' . $start . '|' . $end;
}

function append_unique_event(array &$events, array &$eventKeys, array $event): void
{
    $key = build_event_key(
        (string) ($event['name'] ?? ''),
        (string) ($event['start'] ?? ''),
        (string) ($event['end'] ?? '')
    );

    if ($key === '||') {
        return;
    }

    if (isset($eventKeys[$key])) {
        $existingIndex = $eventKeys[$key];
        $existingEvent = $events[$existingIndex];

        if (($existingEvent['url'] ?? null) === null && !empty($event['url'])) {
            $events[$existingIndex]['url'] = $event['url'];
        }

        $events[$existingIndex]['location'] = select_better_location(
            (string) ($existingEvent['location'] ?? ''),
            (string) ($event['location'] ?? '')
        );

        if (($existingEvent['end'] ?? '') === '' && !empty($event['end'])) {
            $events[$existingIndex]['end'] = $event['end'];
        }

        return;
    }

    $eventKeys[$key] = count($events);
    $events[] = $event;
}
// #endregion

// #region Source Parsers
function parse_schedule_events(string $scheduleHtml, array $eventLinks): array
{
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($scheduleHtml);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $headings = $xpath->query('//h2[contains(normalize-space(.), "/")]');
    $events = [];
    $eventKeys = [];
    $currentYear = (int) date('Y');
    $previousMonthDay = null;

    foreach ($headings as $heading) {
        $monthDay = extract_month_day(trim($heading->textContent));
        if ($monthDay === null) {
            continue;
        }

        $monthDayKey = sprintf('%02d-%02d', $monthDay['month'], $monthDay['day']);
        if ($previousMonthDay !== null && strcmp($monthDayKey, $previousMonthDay) < 0) {
            $currentYear += 1;
        }
        $previousMonthDay = $monthDayKey;

        $table = find_next_table($heading);
        if ($table === null) {
            continue;
        }

        $columnHeadings = $xpath->query('.//tr[1]//div[contains(@class, "cwSchemeColumnHeading")]', $table);
        $timeColumns = $xpath->query('.//tr[2]//td[contains(@class, "cwSchemeTimeSlotsColumn")]', $table);

        if ($columnHeadings === false || $timeColumns === false) {
            continue;
        }

        $dateString = build_date_string($currentYear, $monthDay['month'], $monthDay['day']);
        $columnCount = min($columnHeadings->length, $timeColumns->length);

        for ($index = 0; $index < $columnCount; $index += 1) {
            // Varje kolumn motsvarar en sal, till exempel Lilla salen eller Stora salen.
            $location = trim(html_entity_decode($columnHeadings->item($index)->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $slots = $xpath->query('.//div[contains(@class, "cwSyncedTimeSlotContent")]', $timeColumns->item($index));

            if ($slots === false) {
                continue;
            }

            foreach ($slots as $slot) {
                $parsedSlot = parse_time_slot($slot->textContent);
                if ($parsedSlot === null) {
                    continue;
                }

                $name = $parsedSlot['title'];
                $start = $dateString . ' ' . $parsedSlot['startTime'];
                $end = $dateString . ' ' . $parsedSlot['endTime'];
                $normalizedTitle = normalize_text($name);

                append_unique_event($events, $eventKeys, [
                    'name' => $name,
                    'start' => $start,
                    'end' => $end,
                    'location' => $location,
                    'url' => $eventLinks[$normalizedTitle] ?? null
                ]);
            }
        }
    }

    return $events;
}

function parse_api_events(string $eventsJson, int $days): array
{
    $sourceEvents = parse_events_payload($eventsJson);
    $events = [];
    $eventKeys = [];
    $today = new DateTimeImmutable('today');
    $cutoff = $today->modify('+' . $days . ' days');

    foreach ($sourceEvents as $event) {
        $name = trim((string) ($event['name'] ?? $event['title'] ?? ''));
        $location = trim((string) ($event['place'] ?? $event['location'] ?? ''));
        $schedule = is_array($event['schedule'] ?? null) ? $event['schedule'] : [];
        $startInfo = is_array($schedule['start'] ?? null) ? $schedule['start'] : [];
        $endInfo = is_array($schedule['end'] ?? null) ? $schedule['end'] : [];
        $plannedOccasions = (int) ($schedule['numberOfPlannedOccasions'] ?? 0);
        $timeRange = extract_time_range_from_info((string) ($schedule['dayAndTimeInfo'] ?? ''));
        $eventUrl = build_event_url($event);

        if ($name === '' || empty($startInfo['date'])) {
            continue;
        }

        $startTime = (string) ($startInfo['time'] ?? ($timeRange['startTime'] ?? '00:00:00'));
        $seriesStart = create_datetime((string) $startInfo['date'], $startTime);
        if ($seriesStart === null) {
            continue;
        }

        $defaultEndTime = (string) ($endInfo['time'] ?? ($timeRange['endTime'] ?? $startTime));
        $seriesEndDate = (string) ($endInfo['date'] ?? '');
        $occurrenceCount = max(1, $plannedOccasions);

        for ($index = 0; $index < $occurrenceCount; $index += 1) {
            // API:t returnerar ofta en serie, inte alla enskilda tillfällen.
            // Här expanderas serien veckovis så att den kan jämföras med schedule-källan.
            $occurrenceStart = $seriesStart->modify('+' . ($index * 7) . ' days');
            if ($occurrenceStart === false) {
                continue;
            }

            if ($occurrenceStart < $today || $occurrenceStart > $cutoff) {
                continue;
            }

            $occurrenceEnd = create_datetime($occurrenceStart->format('Y-m-d'), $defaultEndTime);
            if ($occurrenceEnd === null) {
                $occurrenceEnd = $occurrenceStart;
            }

            if ($occurrenceEnd < $occurrenceStart) {
                $occurrenceEnd = $occurrenceEnd->modify('+1 day');
            }

            if ($seriesEndDate !== '') {
                $seriesEndLimit = create_datetime($seriesEndDate, '23:59:59');
                if ($seriesEndLimit !== null && $occurrenceStart > $seriesEndLimit) {
                    break;
                }
            }

            append_unique_event($events, $eventKeys, [
                'name' => $name,
                'start' => $occurrenceStart->format('Y-m-d H:i:s'),
                'end' => $occurrenceEnd->format('Y-m-d H:i:s'),
                'location' => $location,
                'url' => $eventUrl
            ]);
        }
    }

    return $events;
}
// #endregion

// #region Merge
function merge_events(array $primaryEvents, array $supplementalEvents): array
{
    $mergedEvents = [];
    $eventKeys = [];

    foreach ($primaryEvents as $event) {
        append_unique_event($mergedEvents, $eventKeys, $event);
    }

    foreach ($supplementalEvents as $event) {
        append_unique_event($mergedEvents, $eventKeys, $event);
    }

    usort($mergedEvents, static function (array $left, array $right): int {
        return strcmp((string) $left['start'], (string) $right['start']);
    });

    return $mergedEvents;
}
// #endregion

// #region Endpoint Flow
try {
    $cachedPayload = read_cache_if_fresh($cacheFile, $cacheTtlSeconds);
    if ($cachedPayload !== null) {
        $cachedData = decode_cache_payload($cachedPayload);
        if ($cachedData !== null) {
            $cacheMeta = $cachedData['meta'];
            $cacheMeta['cache'] = [
                'status' => 'fresh',
                'ttlSeconds' => $cacheTtlSeconds,
                'file' => basename($cacheFile),
                'updatedAt' => date('c', (int) filemtime($cacheFile))
            ];
            echo build_response_payload($cachedData['events'], $cacheMeta, $debug);
            return;
        }

        return;
    }

    $eventsJson = fetch_remote_text($eventsUrl);
    $scheduleHtml = fetch_remote_text($scheduleUrl);
    $eventLinks = extract_event_links($eventsJson);

    // Schedule är huvudkälla för faktiska visningstillfällen.
    // API:t används både för kompletterande poster och för att hitta bokningslänkar.
    $scheduleEvents = parse_schedule_events($scheduleHtml, $eventLinks);
    $apiEvents = parse_api_events($eventsJson, $days);
    $mergedEvents = merge_events($scheduleEvents, $apiEvents);
    $meta = [
        'org' => $org,
        'days' => $days,
        'generatedAt' => date('c'),
        'sources' => [
            'scheduleCount' => count($scheduleEvents),
            'apiCount' => count($apiEvents),
            'mergedCount' => count($mergedEvents)
        ],
        'cache' => [
            'status' => 'miss',
            'ttlSeconds' => $cacheTtlSeconds,
            'file' => basename($cacheFile)
        ]
    ];
    $cachePayload = encode_cache_payload($mergedEvents, $meta);

    write_cache($cacheDir, $cacheFile, $cachePayload);
    echo build_response_payload($mergedEvents, $meta, $debug);
} catch (Throwable $throwable) {
    $stalePayload = read_stale_cache($cacheFile);
    if ($stalePayload !== null) {
        // Om dans.se inte svarar just nu använder vi senaste cache i stället för tom kalender.
        $staleData = decode_cache_payload($stalePayload);
        if ($staleData !== null) {
            $staleMeta = $staleData['meta'];
            $staleMeta['cache'] = [
                'status' => 'stale',
                'ttlSeconds' => $cacheTtlSeconds,
                'file' => basename($cacheFile),
                'updatedAt' => date('c', (int) filemtime($cacheFile))
            ];
            $staleMeta['error'] = $throwable->getMessage();
            echo build_response_payload($staleData['events'], $staleMeta, $debug);
            return;
        }
    }

    http_response_code(502);
    echo build_response_payload([], [
        'error' => 'Kunde inte hämta aktivitetskalendern just nu.',
        'details' => $debug ? $throwable->getMessage() : null
    ], true);
}
// #endregion