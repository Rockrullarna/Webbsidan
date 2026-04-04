<?php
  $header_title = "Anmälan till danskurser";
  $header_description = "Här finner du anmälningslänkar till alla våra danskurser! Välkommen med din anmälan";

  $page_updated = "2026-04-05 00:35";
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
          <p class="rr-style-label" aria-hidden="true">Kurser och aktiviteter via dans.se</p>
          <h1 id="anmalan-heading">Anmälan till <em>danskurser</em></h1>
          <p class="rr-courses-lead">
            Här hittar ni anmälningslänkar till alla danskurser och aktiviteter hos Dansklubben
            Rockrullarna. Klicka på respektive kurs för att se pris, läsa mer och anmäla er.
          </p>

          <div class="rr-courses-actions">
            <a class="rr-hero-btn" href="https://dans.se/shop/?lang=sv&amp;org=rockrullarna&amp;showPrice=1&amp;new" title="Öppna Rockrullarna på dans.se" target="_blank" rel="noopener">Öppna på dans.se</a>
            <a class="rr-btn-inline" href="https://facebook.com/Rockrullarna" title="Rockrullarna på Facebook" target="_blank" rel="noopener">Följ nästa termin på Facebook</a>
          </div>
        </div>

        <aside class="rr-courses-info-card" aria-labelledby="anmalan-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="anmalan-info-heading">Innan du anmäler dig</h2>
          <div class="rr-courses-info-list">
            <div class="rr-courses-info-item">
              <strong>Nästa termin</strong>
              <p>Information om kommande kursstarter publiceras först via vår Facebook-sida: <a href="https://facebook.com/Rockrullarna" title="facebook.com/Rockrullarna" target="_blank" rel="noopener">facebook.com/Rockrullarna</a>.</p>
            </div>
            <div class="rr-courses-note">
              <p><strong>Bindande anmälan:</strong> Anmälan till alla våra aktiviteter är bindande inom 14 dagar före start.</p>
              <p>Det gäller inte nybörjarkurs med prova-på-gång.</p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-courses-links-section rr-courses-embed-card" aria-labelledby="anmalan-lista-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Aktuella länkar</p>
            <h2 id="anmalan-lista-heading">Anmälningar och <em>priser</em></h2>
          </div>
        </div>

        <div class="rr-courses-embed-shell">
          <p>
            <a class="cwLoadContent" href="https://dans.se/rockrullarna/shop/?lang=sv;showPrice=1;reset">Hämtar Rockrullarnas aktiviteter ifrån dans.se... (dans.se/rockrullarna/shop) <br />(Uppdatera sidan om detta meddelande fortfarande visas om 10 sekunder)</a>
            <script type="text/javascript" src="https://dans.se/api/init.js"></script>
          </p>
        </div>

        <div class="rr-courses-footer-note">
          Om hämtningen inte fungerar automatiskt hittar ni kurserna direkt via
          <a href="https://dans.se/shop/?lang=sv&amp;org=rockrullarna&amp;showPrice=1&amp;new" title="Rockrullarna på dans.se" target="_blank" rel="noopener">dans.se/rockrullarna/shop</a>.
        </div>

        <p class="rr-courses-lead">
          Om det bara står <strong>INFO</strong> på aktiviteterna håller vi på att förbereda publiceringen av nästa termin.
        </p>

        <div class="rr-courses-info-item">
          <strong>Mobilvy</strong>
          <p class="rr-courses-mobile-tip">Har du telefonen liggande ser du fler fält i listan, till exempel <b>pris</b> och om <b>anmälan är öppen eller stängd</b>.</p>
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
          <p><strong>Anmälan till kurser och lösande av medlemskap sker enligt nedan.</strong></p>
          <p>Anmälan till alla våra aktiviteter är bindande inom 14 dagar före start, med undantag för nybörjarkurs med prova-på-gång.</p>
        </div>

        <ol class="rr-courses-process-list">
          <li><strong>Anmälan:</strong> När du anmäler dig till en kurs får du en bekräftelse via e-post på att vi mottagit din anmälan.</li>
          <li><strong>Antagningsbesked:</strong> När vi behandlat din anmälan och antagningen slutförts skickar vi ut ett antagningsbesked via e-post med utförlig betalningsinformation.</li>
          <li><strong>Betalning:</strong> Observera att betalning inte ska ske innan du fått ditt antagningsbesked från oss via e-post.</li>
          <li><strong>Kvitto:</strong> När vi mottagit din betalning kommer ett kvitto att skickas via e-post.</li>
        </ol>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>