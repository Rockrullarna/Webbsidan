<?php
  $header_title = "Anmälan till danskurser";
  $header_description = "Här finner du anmälningslänkar till alla våra danskurser! Välkommen med din anmälan";

  $page_updated = "2026-05-26 21:20";
  $page_url = "/danskurser/anmalan-danskurser";
  $page_contact_name = "Kurser";
  $page_contact_email = "kurser@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-courses-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Danskurser</a> / <span>Anmälan danskurser</span>
      </div>

      <section class="rr-courses-hero" aria-labelledby="anmalan-heading">
        <div class="rr-courses-hero-copy">
          <p class="rr-style-label" aria-hidden="true">Kurser och aktiviteter</p>
          <h1 id="anmalan-heading">Anmälan till <em>danskurser</em></h1>
          <p class="rr-courses-lead">
            Här hittar ni anmälningslänkar till våra danskurser och aktiviteter hos Dansklubben
            Rockrullarna. Klicka på respektiv kurs i listan nedan för att läsa mer, se aktuella priser och anmäla dig. Välkommen med din anmälan!
          </p>

          <div class="rr-courses-actions">
            <a class="rr-hero-btn" href="#kursutbud" title="Anmäl dig till Rockrullarnas danskurser och aktiviteter">Se aktuellt kursutbud<br /> längre ned på sidan 👇</a>
          </div>
        </div>

        <aside class="rr-courses-info-card" aria-labelledby="anmalan-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="anmalan-info-heading">Innan du anmäler dig</h2>
          <div class="rr-courses-info-list">
            <div class="rr-courses-info-item">
              <strong>Nästa kursstart</strong>
              <p>
                Nya kursstarter läggs först ut på vår Facebook-sida. <br/>
                Står det bara <b>INFO</b> på en aktivitet är nästa termin ännu inte öppen för anmälan. Klicka då på aktiviteten så ser du längst ned, när anmälan öppnar.
              </p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="anmalan-process-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Så går det till</p>
            <h2 id="anmalan-process-heading">Information om <em>anmälan</em></h2>
          </div>
        </div>
        <div class="rr-courses-note mb-3">
          <p>
            <strong>Bindande anmälan:</strong><br />
            Anmälan är bindande 14 dagar före start.
            Nybörjarkurserna är undantagna.
          </p>
        </div>
        <ol class="rr-courses-process-list">
          <li>
            <strong>Anmäl dig</strong><br />
            Du får direkt en bekräftelse på att din anmälan är mottagen.
          </li>
          <li>
            <strong>Vänta på antagningsbesked</strong><br />
            Antagningen sker manuellt. När du fått plats får du ett mejl med betalningsinfo.
          </li>
          <li>
            <strong>Betala kursen</strong><br />
            Betala först efter du fått ett antagningsbesked. <i>Friskvård gäller ej medlemsavgiften.</i> Se <a href="/danskurser/betalning" target="_blank" rel="noopener">betalsidan</a>.
          </li>
          <li>
            <strong>Kvitto via mejl</strong><br />
            Ett kvitto skickas automatiskt så fort din betalning är registrerad.
          </li>
          <li>
            <strong>Välkommen på kurs!</strong><br />
            Vi ses på dansgolvet!
          </li>
        </ol>
        <p class="mt-4">
          <strong>Frågor?</strong><br />
          Kontakta oss gärna via <a href="mailto:kurser@rockrullarna.se">kurser@rockrullarna.se</a> om du har frågor kring anmälan eller våra kurser så hjälper vi dig!
        </p>
      </section>

      <section id="kursutbud" class="rr-courses-links-section rr-courses-embed-card" aria-labelledby="kursutbud-heading">
        <div>
          <p class="rr-style-label" aria-hidden="true">Anmäl dig</p>
          <h2 id="kursutbud-heading">Kursutbud och <em>aktiviteter</em></h2>
          <p class="mt-3">
            Här nedanför hittar du våra aktuella kurser och aktiviteter som är öppna för anmälan. Listan hämtas direkt från dans.se, där du kan läsa mer om respektive kurs och anmäla er. Välkommen med din anmälan! Antigen som singelanmälan eller en paranmälan.
          </p>
        </div>
        <p id="kursutbud-lista">
          <a class="cwLoadContent" href="https://dans.se/rockrullarna/shop/?lang=sv;showPrice=1;reset">Hämtar Rockrullarnas aktiviteter ifrån dans.se... (dans.se/rockrullarna/shop) <br />(Uppdatera sidan om detta meddelande fortfarande visas om 10 sekunder)</a>
          <script type="text/javascript" src="https://dans.se/api/init.js"></script>
        </p>
        <div class="rr-courses-note">
          <p>Om listan inte laddas automatiskt hittar du kurserna via <a href="https://dans.se/shop/?lang=sv&amp;org=rockrullarna&amp;showPrice=1&amp;new" title="Rockrullarna på dans.se" target="_blank" rel="noopener">dans.se/rockrullarna/shop</a>.</p>
        </div>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="anmalan-lankar-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Direktlänkar</p>
            <h2 id="anmalan-lankar-heading">Öppna <em>kurserna direkt</em> via dans.se</h2>
          </div>
        </div>

        <div class="rr-courses-footer-note">
          Om listan ovan inte laddas kan ni öppna kurserna direkt på dans.se eller följa nästa kursstart på Facebook.
        </div>

        <div class="rr-courses-actions mt-3">
          <a class="rr-hero-btn" href="https://dans.se/shop/?lang=sv&amp;org=rockrullarna&amp;showPrice=1&amp;new" title="Öppna Rockrullarna på dans.se" target="_blank" rel="noopener">Öppna på dans.se</a>
          <a class="rr-btn-inline" href="https://facebook.com/Rockrullarna" title="Rockrullarna på Facebook" target="_blank" rel="noopener">Följ nästa termin på Facebook</a>
        </div>
      </section>
      <p class="mt-3">
        Direktlänk för att komma till denna sidan är: <a href="https://rockrullarna.se/kurser" title="Anmälan till danskurser hos Rockrullarna">rockrullarna.se/kurser</a>
      </p>
    </div>
<?php
  include_once '../../includes/footer.php'
?>