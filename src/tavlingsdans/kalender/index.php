<?php
  $header_title = "Kalender - Tävlingsdans";
  $header_description = "Tävlingskalendern för kommande tävlingar";

  $page_updated = "2022-12-29 21:33";
  $page_url = "/tavlingsdans/kalender";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Kalender</span>
    </div>
    <h1>
      Tävlingskalender
    </h1>
    <p>
      <iframe frameborder="0" height="1200" scrolling="auto" src="https://dans.se/tools/comp/events/?fed=dsf" style="width: 98%; min-width: 320px;"></iframe>
    </p>
    <p>
      Om hämtningen inte fungerar automatiskt, hittar ni tävlingskalendern via dans.se :<br />
      <a href="https://dans.se/tools/comp/events/?fed=dsf" title="Tävlingskalender på dans.se" target="_blank">https://dans.se/tools/comp/events/?fed=dsf</a>
    </p>
<?php
  include_once '../../includes/footer.php'
?>