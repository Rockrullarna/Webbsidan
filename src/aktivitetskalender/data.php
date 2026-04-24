<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// #region Config
$cacheTtlSeconds = 15 * 60;
$cacheSchemaVersion = 4;
$debug = filter_input(INPUT_GET, 'debug', FILTER_VALIDATE_BOOLEAN) ?? false;
$org = 'rockrullarna';
const DANS_BASE_URL = 'https://dans.se';
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
        'meta' => $meta,
        'events' => $events
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($payload === false) {
        throw new RuntimeException('Kunde inte skapa cache-payload.');
    }

    return $payload;
}

function build_response_payload(array $events, array $meta, bool $debug): string
{
    // Normal trafik får bara en flat lista. Debug-läge får både events och meta.
    $payload = $debug ? ['meta' => $meta, 'events' => $events] : $events;
    $encoded = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($encoded === false) {
        throw new RuntimeException('Kunde inte skapa svarspayload.');
    }

    return $encoded;
}

function is_current_cache_version(array $meta, int $cacheSchemaVersion): bool
{
    return (int) ($meta['schemaVersion'] ?? 0) === $cacheSchemaVersion;
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

    $day = (int) $matches[1];
    $month = (int) $matches[2];

    if ($day < 1 || $day > 31 || $month < 1 || $month > 12) {
        return null;
    }

    return ['day' => $day, 'month' => $month];
}

function build_date_string(int $year, int $month, int $day): string
{
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
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
    return normalize_event_url((string) (
        $event['registration']['url'] ??
        $event['url'] ??
        $event['source'] ??
        ''
    ));
}

function normalize_event_url(string $url): ?string
{
    $url = trim($url);
    if ($url === '') {
        return null;
    }

    if (preg_match('~^https?://~', $url)) {
        return $url;
    }

    if (str_starts_with($url, '//')) {
        return 'https:' . $url;
    }

    if (str_starts_with($url, '/')) {
        return DANS_BASE_URL . $url;
    }

    return null;
}

function extract_slot_url(DOMElement $slot): ?string
{
    $links = $slot->getElementsByTagName('a');
    if ($links->length === 0) {
        return null;
    }

    $firstLink = $links->item(0);
    $href = $firstLink instanceof DOMElement ? $firstLink->getAttribute('href') : '';
    $href = html_entity_decode($href, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $href = trim($href);
    if ($href === '') {
        return null;
    }

    return normalize_event_url($href);
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

function build_event_start_key(string $name, string $start): string
{
    return normalize_text($name) . '|' . $start;
}

function create_datetime_from_timestamp(string $value): ?DateTimeImmutable
{
    $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $value);
    return $dateTime === false ? null : $dateTime;
}

function add_event_url_lookup(array &$urlsByExactKey, array &$urlsByStartKey, string $name, DateTimeImmutable $start, DateTimeImmutable $end, string $url): void
{
    $formattedStart = $start->format('Y-m-d H:i:s');
    $formattedEnd = $end->format('Y-m-d H:i:s');
    $urlsByExactKey[build_event_key($name, $formattedStart, $formattedEnd)] = $url;
    $urlsByStartKey[build_event_start_key($name, $formattedStart)] = $url;
}

function build_event_url_lookups(array $sourceEvents): array
{
    $urlsByExactKey = [];
    $urlsByStartKey = [];
    $recurringEvents = [];

    foreach ($sourceEvents as $event) {
        $name = trim((string) ($event['name'] ?? $event['title'] ?? ''));
        $schedule = is_array($event['schedule'] ?? null) ? $event['schedule'] : [];
        $startInfo = is_array($schedule['start'] ?? null) ? $schedule['start'] : [];
        $endInfo = is_array($schedule['end'] ?? null) ? $schedule['end'] : [];
        $timeRange = extract_time_range_from_info((string) ($schedule['dayAndTimeInfo'] ?? ''));
        $url = build_event_url($event);

        if ($name === '' || $url === null || empty($startInfo['date'])) {
            continue;
        }

        $startTime = (string) ($startInfo['time'] ?? ($timeRange['startTime'] ?? '00:00:00'));
        $endTime = (string) ($endInfo['time'] ?? ($timeRange['endTime'] ?? $startTime));
        $eventStart = create_datetime((string) $startInfo['date'], $startTime);
        if ($eventStart === null) {
            continue;
        }

        $endDate = (string) ($endInfo['date'] ?? $startInfo['date']);
        $eventEnd = create_datetime($endDate, $endTime);
        if ($eventEnd === null) {
            $eventEnd = $eventStart;
        }

        if ($eventEnd < $eventStart) {
            $eventEnd = $eventEnd->modify('+1 day');
        }

        $plannedOccasions = max(1, (int) ($schedule['numberOfPlannedOccasions'] ?? 0));
        if ($plannedOccasions <= 1) {
            add_event_url_lookup($urlsByExactKey, $urlsByStartKey, $name, $eventStart, $eventEnd, $url);
            continue;
        }

        $occasions = is_array($schedule['occasions'] ?? null) ? $schedule['occasions'] : [];
        if (!empty($occasions)) {
            $defaultDurationSeconds = max(0, $eventEnd->getTimestamp() - $eventStart->getTimestamp());

            foreach ($occasions as $occasion) {
                $occasionStart = create_datetime_from_timestamp((string) ($occasion['startDateTime'] ?? ''));
                if ($occasionStart === null) {
                    continue;
                }

                $occasionEnd = create_datetime_from_timestamp((string) ($occasion['endDateTime'] ?? ''));
                if ($occasionEnd === null) {
                    $occasionLength = max(0, (int) ($occasion['length'] ?? $defaultDurationSeconds));
                    $occasionEnd = $occasionStart->modify('+' . $occasionLength . ' seconds');
                }

                if ($occasionEnd === false) {
                    $occasionEnd = $occasionStart;
                }

                add_event_url_lookup($urlsByExactKey, $urlsByStartKey, $name, $occasionStart, $occasionEnd, $url);
            }
        }

        $recurringEvents[] = [
            'name' => normalize_text($name),
            'start' => $eventStart,
            'end' => $eventEnd,
            'startTime' => $eventStart->format('H:i:s'),
            'endTime' => $eventEnd->format('H:i:s'),
            'endDate' => $endInfo['date'] ?? null,
            'dayOfWeek' => (int) ($startInfo['dayOfWeek'] ?? 0),
            'plannedOccasions' => $plannedOccasions,
            'url' => $url
        ];
    }

    return [
        'exact' => $urlsByExactKey,
        'start' => $urlsByStartKey,
        'recurring' => $recurringEvents
    ];
}

function find_matching_event_url(array $eventUrlLookups, string $name, string $start, string $end): ?string
{
    $exactKey = build_event_key($name, $start, $end);
    if (isset($eventUrlLookups['exact'][$exactKey])) {
        return $eventUrlLookups['exact'][$exactKey];
    }

    $startKey = build_event_start_key($name, $start);
    if (isset($eventUrlLookups['start'][$startKey])) {
        return $eventUrlLookups['start'][$startKey];
    }

    $scheduleStart = create_datetime_from_timestamp($start);
    if ($scheduleStart === null) {
        return null;
    }

    $scheduleEnd = create_datetime_from_timestamp($end);
    $normalizedName = normalize_text($name);

    $bestMatch = null;
    $bestMatchStart = null;

    foreach ($eventUrlLookups['recurring'] ?? [] as $recurringEvent) {
        if ($recurringEvent['name'] !== $normalizedName) {
            continue;
        }

        if ($scheduleStart->format('H:i:s') !== $recurringEvent['startTime']) {
            continue;
        }

        if ($scheduleStart < $recurringEvent['start']) {
            continue;
        }

        if ((int) $scheduleStart->format('N') !== (int) $recurringEvent['dayOfWeek']) {
            continue;
        }

        if (!empty($recurringEvent['endDate'])) {
            $seriesEndDate = DateTimeImmutable::createFromFormat('Y-m-d', (string) $recurringEvent['endDate']);
            if ($seriesEndDate !== false && $scheduleStart->format('Y-m-d') > $seriesEndDate->format('Y-m-d')) {
                continue;
            }
        } else {
            $intervalDays = (int) $recurringEvent['start']->diff($scheduleStart)->format('%a');
            if ($intervalDays % 7 !== 0) {
                continue;
            }

            $occurrenceIndex = (int) floor($intervalDays / 7);
            if ($occurrenceIndex >= (int) $recurringEvent['plannedOccasions']) {
                continue;
            }
        }

        if ($scheduleEnd !== null && $scheduleEnd->format('H:i:s') !== $recurringEvent['endTime']) {
            continue;
        }

        // Välj den matchande serie vars start är närmast (men inte efter) schemat,
        // för att undvika att en äldre serie (t.ex. vårtermin) får företräde framför
        // en nyare serie (t.ex. hösttermin) med samma namn och tid.
        if ($bestMatch === null || $recurringEvent['start'] > $bestMatchStart) {
            $bestMatch = $recurringEvent;
            $bestMatchStart = $recurringEvent['start'];
        }
    }

    return $bestMatch !== null ? $bestMatch['url'] : null;
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
function parse_schedule_events(string $scheduleHtml, array $eventUrlLookups): array
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

        $table = find_next_table($heading);
        if ($table === null) {
            continue;
        }

        // Uppdatera årsräknaren bara när ett datumhuvud med tillhörande tabell
        // hittats, så att icke-schemarelaterade h2-element inte påverkar årsberäkningen.
        if ($previousMonthDay !== null && strcmp($monthDayKey, $previousMonthDay) < 0) {
            $currentYear += 1;
        }
        $previousMonthDay = $monthDayKey;

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
                $eventUrl = find_matching_event_url($eventUrlLookups, $name, $start, $end)
                    ?? extract_slot_url($slot);

                append_unique_event($events, $eventKeys, [
                    'name' => $name,
                    'start' => $start,
                    'end' => $end,
                    'location' => $location,
                    'url' => $eventUrl
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

        $plannedOccasions = max(1, (int) ($schedule['numberOfPlannedOccasions'] ?? 0));
        if ($plannedOccasions > 1) {
            continue;
        }

        $defaultEndTime = (string) ($endInfo['time'] ?? ($timeRange['endTime'] ?? $startTime));
        $eventEndDate = (string) ($endInfo['date'] ?? $startInfo['date']);
        $eventEnd = create_datetime($eventEndDate, $defaultEndTime);

        // Återkommande serier ska inte synas som egna poster här, eftersom API:t
        // då bara beskriver serien och inte nödvändigtvis de faktiska tillfällena.
        // Kvar här blir enbart explicita engångsposter från API:t.
        if ($seriesStart < $today || $seriesStart > $cutoff) {
            continue;
        }

        if ($eventEnd === null) {
            $eventEnd = $seriesStart;
        }

        if ($eventEnd < $seriesStart) {
            $eventEnd = $eventEnd->modify('+1 day');
        }

        append_unique_event($events, $eventKeys, [
            'name' => $name,
            'start' => $seriesStart->format('Y-m-d H:i:s'),
            'end' => $eventEnd->format('Y-m-d H:i:s'),
            'location' => $location,
            'url' => $eventUrl
        ]);
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
        if ($cachedData !== null && is_current_cache_version($cachedData['meta'], $cacheSchemaVersion)) {
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
    }

    $eventsJson = fetch_remote_text($eventsUrl);
    $scheduleHtml = fetch_remote_text($scheduleUrl);

    // Schedule är huvudkälla för faktiska visningstillfällen.
    // API:t används både för kompletterande poster och för att hitta bokningslänkar.
    $sourceEvents = parse_events_payload($eventsJson);
    $apiEvents = parse_api_events($eventsJson, $days);
    $eventUrlLookups = build_event_url_lookups($sourceEvents);
    $scheduleEvents = parse_schedule_events($scheduleHtml, $eventUrlLookups);
    $mergedEvents = merge_events($scheduleEvents, $apiEvents);
    $meta = [
        'schemaVersion' => $cacheSchemaVersion,
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
        if ($staleData !== null && is_current_cache_version($staleData['meta'], $cacheSchemaVersion)) {
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
