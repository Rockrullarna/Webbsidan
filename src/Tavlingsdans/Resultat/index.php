<?php
  $header_title = "Resultat - Tävlingsdans";
  include_once '../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../">Hem</a> / <a href="../">Tävlingsdans</a> / <span>Resultat</span>
    </div>
    <h1>
      Tävlingsresultat
    </h1>
    <p>
      <iframe frameborder="0" height="1000" id="iframe1" marginheight="0" marginwidth="0" scrolling="yes" src="https://www.dans.se/tools/comp/results/?org=ROCKRULLARNA" width="540"></iframe>
    </p>
    <p>
      Om hämtningen inte fungerar automatiskt, hittar ni resultat för RR via dans.se :<br />
      <a href="https://www.dans.se/tools/comp/results/?org=Rockrullarna" title="Rockrullarnas tävlingskalender på dans.se" target="_blank">https://www.dans.se/tools/comp/results/?org=Rockrullarna</a>
    </p>
<?php
  include_once '../../includes/footer.php'
?>