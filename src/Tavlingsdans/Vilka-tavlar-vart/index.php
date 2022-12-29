<?php
  $header_title = "Vilka tävlar vart? - Tävlingsdans";
  $header_description = "Här ser du alla våra tävlande som är anmälda till kommande tävlingar";

  $page_updated = "2022-12-29 23:48";
  $page_url = "/Tavlingsdans/Vilka-tavlar-vart";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Vilka tävlar vart?</span>
    </div>
    <h1>
      Vilka tävlar vart?
    </h1>
    <p>
      <iframe frameborder="0" height="1000" marginheight="0" marginwidth="0" src="https://dans.se/tools/comp/registrations/?org=ROCKRULLARNA"  style="width: 95%; min-width: 540px;"></iframe>
    </p>
    <p>
      Om hämtningen inte fungerar automatiskt, hittar ni tävlingsanmälningar via dans.se :<br />
      <a href="https://dans.se/tools/comp/registrations/?org=Rockrullarna" title="Rockrullarnas tävlingskalender på dans.se" target="_blank">https://dans.se/tools/comp/registrations/?org=Rockrullarna</a>
    </p>
<?php
  include_once '../../includes/footer.php'
?>