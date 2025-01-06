<?php
  $header_title = "Evenemang - Kursöversikt - Danskurser";
  $header_description = "Evenemang utanför ordinarie verksamhet styrs bland annat av efterfrågan. Vi välkomnar önskemål från föreningens medlemmar";

  $page_updated = "2022-12-29 22:52";
  $page_url = "/danskurser/kursoversikt/evenemang";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../../">Rockrullarna.se</a> / <a href="../../">Danskurser</a> / <a href="../">Kursöversikt</a> / <span>Evenemang</span>
    </div>
    <h1>Evenemang utanför ordinarie verksamhet</h1>
    <p>
      Utöver ordinarie kursverksamhet erbjuds ibland helgevenemang med externa eller interna ledare. Evenemang kan vara danskurser som inte ingår i den ordinarie kursverksamheten som exempelvis Boogie Woogie, Lindy Hop eller en fördjupning inom föreningens grundutbud.
    </p>
    <p>
      Evenemang utanför ordinarie verksamhet styrs bland annat av efterfrågan. Styrelsen välkomnar önskemål från föreningens medlemmar.
    </p>
    <h2>Här nedan visas våra helg och intensivkurser:</h2>
    <p>
      <a class="cwLoadContent" href="https://dans.se/rockrullarna/shop/?eventGroup1=helg;sorting=startDate+asc;lang=sv;showPrice=1;reset">
        Hämtar data om foxkurser ifrån dans.se... <br />
        (testa uppdatera sidan om detta meddelande inte försvinner)
      </a>
      <script src="https://dans.se/api/init.js" type="text/javascript"></script>
    <p class="visible-phone">
      <strong>Tips</strong> eftersom att du kollar på en mobiltelefon:<br />
      Har du telefonen liggandes så ser du fler fält i listan. Till exempel: <strong>Pris</strong> och om <strong>anmälan är öppen/stängd</strong>.
    </p>
    <p>
      Om hämtningen inte fungerar automatiskt, hittar ni kurserna via: <a href="https://dans.se/shop/?lang=sv&org=rockrullarna&showPrice=1&new" title="Rockrullarna på dans.se" target="_blank">dans.se/rockrullarna/shop</a>
    </p>
<?php
  include_once '../../../includes/footer.php'
?>