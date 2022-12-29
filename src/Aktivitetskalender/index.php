<?php
  $header_title = "Aktivitetskalender";
  $header_description = "Här finns schema för alla våra aktiviteter vi håller vid dansklubben";

  $page_updated = "2022-12-29 22:33";
  $page_url = "/Aktivitetskalender";
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
    <p>
      <iframe frameborder="0" height="700" scrolling="yes" src="https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1" style="border-width: 0; width: 95%; min-width: 540px;"></iframe>
    </p>
    <p>
      Aktivitetskalendern hämtas från vårt bokningssystem dans.se via direktlänken: <br />
      <a href="https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1" alt="Direktlänk till dans.se" title="Externa webbplatsen dans.se öppnas i ny flik" target="_blank" rel="noopener">https://dans.se/view/schedule/?org=rockrullarna&days=180&showEndTime=1</a>
    </p>
<?php
  include_once '../includes/footer.php'
?>