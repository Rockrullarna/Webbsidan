<?php
  $header_title = "Kalender - Tävlingsdans";
  include_once '../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Kalender</span>
    </div>
    <h1>
      Tävlingskalender
    </h1>
    <p>
      <iframe frameborder="0" height="1200" scrolling="auto" src="https://dans.se/tools/comp/events/?fed=dsf" width="100%"></iframe>
    </p>
    <p>
      Om hämtningen inte fungerar automatiskt, hittar ni tävlingskalendern via dans.se :<br />
      <a href="https://dans.se/tools/comp/events/?fed=dsf" title="Tävlingskalender på dans.se" target="_blank">https://dans.se/tools/comp/events/?fed=dsf</a>
    </p>
<?php
  include_once '../../includes/footer.php'
?>