<?php
  $header_title = "Anmälan till danskurser";
  $header_description = "Här finner du anmälningslänkar till alla våra danskurser! Välkommen med din anmälan";

  $page_updated = "2026-04-06 21:20";
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
        </div>

        <aside class="rr-courses-info-card" aria-labelledby="anmalan-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="anmalan-info-heading">Innan du anmäler dig</h2>
          <div class="rr-courses-info-list">
            <div class="rr-courses-info-item">
              <strong>Nästa kursstart</strong>
              <p>
                Nya kursstarter läggs först ut på vår Facebook-sida. <br/>
                Står det bara <b>INFO</b> på en aktivitet är nästa termin ännu inte öppen för anmälan.
              </p>
            </div>
            <div class="rr-courses-note">
              <p><strong>Bindande anmälan:</strong> Anmälan är bindande 14 dagar före start.</p>
              <p>Nybörjarkurserna är undantagna.</p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-courses-links-section rr-courses-embed-card" aria-labelledby="anmalan-lista-heading">
        <p>
          <a class="cwLoadContent" href="https://dans.se/rockrullarna/shop/?lang=sv;showPrice=1;reset">Hämtar Rockrullarnas aktiviteter ifrån dans.se... (dans.se/rockrullarna/shop) <br />(Uppdatera sidan om detta meddelande fortfarande visas om 10 sekunder)</a>
          <script type="text/javascript" src="https://dans.se/api/init.js"></script>
        </p>
        
        <div class="rr-courses-footer-note">
          Om hämtningen inte fungerar automatiskt hittar ni kurserna direkt via
          <a href="https://dans.se/shop/?lang=sv&amp;org=rockrullarna&amp;showPrice=1&amp;new" title="Rockrullarna på dans.se" target="_blank" rel="noopener">dans.se/rockrullarna/shop</a>.
        </div>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="anmalan-process-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Så går det till</p>
            <h2 id="anmalan-process-heading">Information om <em>anmälan</em></h2>
          </div>
        </div>

        <div class="rr-courses-note mb-3">
          <p><strong>Så här går anmälan till.</strong></p>
          <p>Anmälan är bindande 14 dagar före start, utom för nybörjarkurs med prova-på-gång.</p>
        </div>

        <ol class="rr-courses-process-list">
          <li><strong>Anmäl dig:</strong> Du får först en bekräftelse på att din anmälan har kommit in.</li>
          <li><strong>Vänta på besked:</strong> När antagningen är klar får du e-post med betalningsinformation.</li>
          <li><strong>Betala efter besked:</strong> Betala inte innan du fått ditt antagningsbesked.</li>
          <li><strong>Klart:</strong> När betalningen är registrerad skickas ett kvitto via e-post.</li>
        </ol>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="anmalan-lankar-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Direktlänkar</p>
            <h2 id="anmalan-lankar-heading">Öppna <em>kurserna direkt</em></h2>
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
    </div>
<?php
  include_once '../../includes/footer.php'
?>