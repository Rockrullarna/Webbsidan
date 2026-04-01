<?php
/**
 * Hämtar och visar aktivitetskalendern från RSS-flödet på dans.se.
 *
 * Parametrar (definieras innan include):
 *   $rss_max_items  - Max antal händelser att visa (default: 15)
 *   $rss_show_desc  - Om beskrivning ska visas (default: false)
 */

$rss_url       = 'https://dans.se/rockrullarna/rss';
$rss_max_items = isset($rss_max_items) ? (int)$rss_max_items : 15;
$rss_show_desc = isset($rss_show_desc) ? (bool)$rss_show_desc : false;

$rss_items  = [];
$rss_error  = null;
$rss_loaded = false;

// Hämta och tolka RSS-flödet
$rss_context = stream_context_create([
  'http' => [
    'timeout'    => 5,
    'user_agent' => 'Mozilla/5.0 (compatible; Rockrullarna-kalender/1.0)',
  ],
  'https' => [
    'timeout'    => 5,
    'user_agent' => 'Mozilla/5.0 (compatible; Rockrullarna-kalender/1.0)',
  ],
]);

$rss_raw = file_get_contents($rss_url, false, $rss_context);

if ($rss_raw === false) {
  $rss_error = 'Kunde inte hämta RSS-flödet från dans.se.';
} else {
  libxml_use_internal_errors(true);
  $rss_xml = simplexml_load_string($rss_raw);
  if ($rss_xml === false) {
    $rss_error = 'Kunde inte tolka RSS-flödet.';
  } else {
    $rss_loaded = true;
    $now = new DateTime('now', new DateTimeZone('Europe/Stockholm'));

    foreach ($rss_xml->channel->item as $item) {
      // Datum – prova pubDate (RFC 2822), annars hoppa
      $date_str = isset($item->pubDate) ? trim((string)$item->pubDate) : null;
      $event_date = null;
      if ($date_str) {
        $event_date = DateTime::createFromFormat(DateTime::RFC2822, $date_str)
          ?: DateTime::createFromFormat('D, d M Y H:i:s O', $date_str)
          ?: DateTime::createFromFormat('Y-m-d\TH:i:sP', $date_str)
          ?: date_create($date_str);
        if ($event_date) {
          $event_date->setTimezone(new DateTimeZone('Europe/Stockholm'));
        }
      }

      $rss_items[] = [
        'title'       => htmlspecialchars(trim((string)$item->title), ENT_QUOTES, 'UTF-8'),
        'link'        => filter_var(trim((string)$item->link), FILTER_VALIDATE_URL) ? trim((string)$item->link) : '',
        'description' => htmlspecialchars(trim(strip_tags((string)$item->description)), ENT_QUOTES, 'UTF-8'),
        'date'        => $event_date,
        'date_str'    => $date_str,
      ];
    }

    // Sortera på datum (tidigast först)
    usort($rss_items, function ($a, $b) {
      if (!$a['date'] && !$b['date']) return 0;
      if (!$a['date']) return 1;
      if (!$b['date']) return -1;
      return $a['date'] <=> $b['date'];
    });

    // Begränsa antal
    $rss_items = array_slice($rss_items, 0, $rss_max_items);
  }
}
?>

<?php if ($rss_error): ?>
  <div class="alert alert-warning" role="alert">
    <?php echo htmlspecialchars($rss_error, ENT_QUOTES, 'UTF-8'); ?>
    Visa <a href="https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1" target="_blank" rel="noopener" title="Öppna aktivitetskalendern på dans.se (öppnas i nytt fönster)">aktivitetskalendern på dans.se</a>.
  </div>
<?php elseif (empty($rss_items)): ?>
  <p class="text-center">Inga kommande aktiviteter hittades just nu.</p>
<?php else: ?>
  <div class="aktivitetskalender-scroll list-group" role="list" style="max-height:500px; overflow-y:auto; border-radius:.375rem;">
    <?php foreach ($rss_items as $rss_item): ?>
      <?php
        $months = ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'];
        $item_classes = 'list-group-item list-group-item-action d-flex gap-3 align-items-start py-2 px-3';
      ?>
      <?php if ($rss_item['link']): ?>
        <a href="<?php echo htmlspecialchars($rss_item['link'], ENT_QUOTES, 'UTF-8'); ?>"
          class="<?php echo $item_classes; ?>"
          role="listitem"
          target="_blank"
          rel="noopener"
          title="<?php echo $rss_item['title']; ?> (öppnas på dans.se i nytt fönster)">
      <?php else: ?>
        <div class="<?php echo $item_classes; ?>" role="listitem">
      <?php endif; ?>
        <?php if ($rss_item['date']): ?>
          <div class="text-center flex-shrink-0" style="min-width:3.5rem;" aria-label="Datum">
            <div class="fw-bold" style="font-size:.85rem; color:#00ABD6; line-height:1.1;">
              <?php echo htmlspecialchars($rss_item['date']->format('d'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div style="font-size:.75rem; text-transform:uppercase; opacity:.8;">
              <?php echo $months[(int)$rss_item['date']->format('n') - 1]; ?>
            </div>
            <div style="font-size:.7rem; opacity:.65;">
              <?php echo htmlspecialchars($rss_item['date']->format('H:i'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
          </div>
        <?php else: ?>
          <div class="flex-shrink-0" style="min-width:3.5rem;"></div>
        <?php endif; ?>
        <div class="flex-grow-1 overflow-hidden">
          <div class="fw-semibold text-truncate" style="color:#00ABD6;">
            <?php echo $rss_item['title']; ?>
          </div>
          <?php if ($rss_show_desc && $rss_item['description']): ?>
            <div class="small text-truncate" style="opacity:.8;">
              <?php echo $rss_item['description']; ?>
            </div>
          <?php endif; ?>
        </div>
        <?php if ($rss_item['link']): ?>
          <div class="flex-shrink-0 align-self-center" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#00ABD6" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
              <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
            </svg>
          </div>
        <?php endif; ?>
      <?php if ($rss_item['link']): ?>
        </a>
      <?php else: ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
