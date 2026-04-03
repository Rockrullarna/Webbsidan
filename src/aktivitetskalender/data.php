<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$cacheTtlSeconds = 15 * 60;
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

function build_event_key(string $name, string $start, string $location): string
{
    return normalize_text($name) . '|' . $start . '|' . normalize_text($location);
}

function append_unique_event(array &$events, array &$eventKeys, array $event): void
{
    $key = build_event_key(
        (string) ($event['name'] ?? ''),
        (string) ($event['start'] ?? ''),
        (string) ($event['location'] ?? '')
    );

    if ($key === '||' || isset($eventKeys[$key])) {
        return;
    }

    $eventKeys[$key] = true;
    $events[] = $event;
}

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

try {
    $cachedPayload = read_cache_if_fresh($cacheFile, $cacheTtlSeconds);
    if ($cachedPayload !== null) {
        echo $cachedPayload;
        return;
    }

    $eventsJson = fetch_remote_text($eventsUrl);
    $scheduleHtml = fetch_remote_text($scheduleUrl);
    $eventLinks = extract_event_links($eventsJson);
    $scheduleEvents = parse_schedule_events($scheduleHtml, $eventLinks);
    $apiEvents = parse_api_events($eventsJson, $days);
    $mergedEvents = merge_events($scheduleEvents, $apiEvents);
    $payload = json_encode($mergedEvents, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($payload === false) {
        throw new RuntimeException('Kunde inte skapa JSON-svar.');
    }

    write_cache($cacheDir, $cacheFile, $payload);
    echo $payload;
} catch (Throwable $throwable) {
    $stalePayload = read_stale_cache($cacheFile);
    if ($stalePayload !== null) {
        echo $stalePayload;
        return;
    }

    http_response_code(502);
    echo json_encode([
        'error' => 'Kunde inte hämta aktivitetskalendern just nu.'
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}