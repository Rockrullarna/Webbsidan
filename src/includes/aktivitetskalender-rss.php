<?php
/**
 * Hämtar och visar aktivitetskalendern från RSS-flödet på dans.se.
 *
 * Parametrar (definieras innan include):
 *   $rss_max_items  - Max antal händelser att visa (default: 15)
 *   $rss_show_desc  - Om beskrivning ska visas (default: true)
 */

$rss_url       = 'https://dans.se/rockrullarna/rss';
$rss_max_items = isset($rss_max_items) ? (int)$rss_max_items : 15;
$rss_show_desc = isset($rss_show_desc) ? (bool)$rss_show_desc : true;

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

$months    = ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'];
$weekdays  = ['sön','mån','tis','ons','tor','fre','lör'];
?>

<?php if ($rss_error): ?>
  <div class="alert alert-warning" role="alert">
    <?php echo htmlspecialchars($rss_error, ENT_QUOTES, 'UTF-8'); ?>
    Visa <a href="https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1" target="_blank" rel="noopener" title="Öppna aktivitetskalendern på dans.se (öppnas i nytt fönster)">aktivitetskalendern på dans.se</a>.
  </div>
<?php elseif (empty($rss_items)): ?>
  <p class="text-center">Inga kommande aktiviteter hittades just nu.</p>
<?php else: ?>
  <div class="aktivitetskalender-scroll" role="list"
    style="max-height:500px; overflow-y:auto; border-radius:.5rem; display:flex; flex-direction:column; gap:.4rem;">
    <?php foreach ($rss_items as $rss_item): ?>
      <?php
        $has_link = !empty($rss_item['link']);
        $item_url = $has_link ? htmlspecialchars($rss_item['link'], ENT_QUOTES, 'UTF-8') : '';
      ?>
      <div class="aktivitetskalender-item"
        role="listitem"
        style="display:flex; flex-direction:row; align-items:stretch; border:1px solid rgba(0,171,214,.3); border-radius:.375rem; overflow:hidden; transition:border-color .15s, box-shadow .15s;">
        <!-- Datumkolumn -->
        <div style="flex:0 0 3.8rem; width:3.8rem; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:.4rem .2rem; background:rgba(0,171,214,.15); border-right:1px solid rgba(0,171,214,.3); text-align:center;">
          <?php if ($rss_item['date']): ?>
            <div style="font-weight:700; font-size:1.3rem; color:#00ABD6; line-height:1;">
              <?php echo htmlspecialchars($rss_item['date']->format('d'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div style="font-size:.7rem; text-transform:uppercase; color:#00ABD6; opacity:.9; letter-spacing:.05em;">
              <?php echo $months[(int)$rss_item['date']->format('n') - 1]; ?>
            </div>
            <div style="font-size:.65rem; opacity:.65; margin-top:.15rem;">
              <?php echo $weekdays[(int)$rss_item['date']->format('w')]; ?>
            </div>
            <div style="font-size:.7rem; opacity:.75; margin-top:.1rem;">
              <?php echo htmlspecialchars($rss_item['date']->format('H:i'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
          <?php else: ?>
            <div style="font-size:.65rem; opacity:.4;">—</div>
          <?php endif; ?>
        </div>

        <!-- Innehållskolumn -->
        <div style="flex:1 1 auto; min-width:0; display:flex; flex-direction:column; justify-content:center; padding:.45rem .6rem; overflow:hidden;">
          <div style="font-weight:600; color:#00ABD6; font-size:.9rem; line-height:1.2; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            <?php echo $rss_item['title']; ?>
          </div>
          <?php if ($rss_show_desc && $rss_item['description']): ?>
            <div style="margin-top:.2rem; font-size:.75rem; opacity:.75; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; line-height:1.35;">
              <?php echo $rss_item['description']; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Anmäl dig-knapp -->
        <?php if ($has_link): ?>
          <div style="flex:0 0 auto; display:flex; align-items:center; padding:.3rem .5rem;">
            <a href="<?php echo $item_url; ?>"
              target="_blank"
              rel="noopener"
              class="btn btn-primary btn-sm"
              style="font-size:.72rem; white-space:nowrap; padding:.3rem .55rem; font-weight:600;"
              title="<?php echo $rss_item['title']; ?> – öppna anmälningssidan på dans.se">
              Anmäl dig&nbsp;»
            </a>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <style>
    .aktivitetskalender-item:hover {
      border-color: #00ABD6 !important;
      box-shadow: 0 0 0 .15rem rgba(0,171,214,.25);
    }
  </style>
<?php endif; ?>

