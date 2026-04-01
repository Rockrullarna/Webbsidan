<?php
  $header_title = "Aktivitetskalender";
  $header_description = "Här finns schema för alla våra aktiviteter vi håller vid dansklubben";

  $page_updated = "2025-01-06 23:25";
  $page_url = "/aktivitetskalender";
  $page_contact_name = "Kurser";
  $page_contact_email = "kurser@rockrullarna.se";

  include_once '../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../">Rockrullarna.se</a> / <span>Aktivitetskalender</span>
    </div>
    <h1>Aktivitetskalender</h1>
    <p>
      Här visas våra kommande händelser hämtade från dans.se, vårt bokningssystem.
    </p>
<?php
  $rss_max_items = 50;
  $rss_show_desc = true;
  include_once '../includes/aktivitetskalender-rss.php';
?>
    <p class="mt-3">
      Aktivitetskalendern hämtas från vårt bokningssystem dans.se via RSS-flödet: <br />
      <?php $rss_source_url = 'https://dans.se/rockrullarna/rss'; ?>
      <a href="<?php echo htmlspecialchars($rss_source_url, ENT_QUOTES, 'UTF-8'); ?>" title="RSS-flödet från dans.se (öppnas i nytt fönster)" target="_blank" rel="noopener"><?php echo htmlspecialchars($rss_source_url, ENT_QUOTES, 'UTF-8'); ?></a>
    </p>
    <p>
      Du kan också se schemat direkt på dans.se: <br />
      <a href="https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1" title="Aktivitetskalendern på dans.se (öppnas i nytt fönster)" target="_blank" rel="noopener">https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1</a>
    </p>
<?php
  include_once '../includes/footer.php'
?>
