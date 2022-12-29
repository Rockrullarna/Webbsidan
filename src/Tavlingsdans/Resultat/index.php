<?php
  $header_title = "Resultat - Tävlingsdans";
  $header_description = "Historiska tävlingsresultat från de tävlingar där våra tävlande har medverkat";

  $page_updated = "2022-12-29 23:47";
  $page_url = "/Tavlingsdans/Resultat";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Resultat</span>
    </div>
    <h1>
      Tävlingsresultat
    </h1>
    <p>
      <iframe frameborder="0" height="1000" marginheight="0" marginwidth="0" scrolling="yes" src="https://www.dans.se/tools/comp/results/?org=ROCKRULLARNA" style="width: 98%; min-width: 320px;"></iframe>
    </p>
    <p>
      Om hämtningen inte fungerar automatiskt, hittar ni resultat för RR via dans.se :<br />
      <a href="https://www.dans.se/tools/comp/results/?org=Rockrullarna" title="Rockrullarnas tävlingskalender på dans.se" target="_blank">https://www.dans.se/tools/comp/results/?org=Rockrullarna</a>
    </p>
<?php
  include_once '../../includes/footer.php'
?>