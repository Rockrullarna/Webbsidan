<?php
  $header_title = "Hjälp - Kontakt";
  $header_description = "Här finner du hjälp hur du kommer i kontakt med oss";

  $page_updated = "2026-04-04 23:15";
  $page_url = "/kontakt/hjalp";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-contact-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Kontakt</a> / <span>Hjälp</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="kontakt-hjalp-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Vägledning</p>
          <h1 id="kontakt-hjalp-heading">Behöver du <em>hjälp</em>?</h1>
          <p class="rr-association-lead">
            Här är den snabbaste vägen till rätt svar. Börja med vår FAQ om ditt ärende gäller
            dans.se, friskvårdsbetalning, Teams eller Zoom.
          </p>
          <p class="rr-association-lead">
            Hittar du inte det du söker där, hjälper vi dig vidare via mejl eller på plats i
            danslokalen när verksamheten är igång.
          </p>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="kontakt-hjalp-snabb-heading">
          <p class="rr-style-label" aria-hidden="true">Snabbhjälp</p>
          <h2 id="kontakt-hjalp-snabb-heading">Tre enkla steg</h2>
          <ul class="rr-association-list">
            <li><strong>1. Läs FAQ</strong><br />Se om frågan redan är besvarad.</li>
            <li><strong>2. Mejla oss</strong><br />Skriv till rätt funktion om du behöver mer hjälp.</li>
            <li><strong>3. Besök lokalen</strong><br />Kontrollera kalendern innan du kommer förbi.</li>
          </ul>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="kontakt-hjalp-vagar-heading">
        <p class="rr-style-label" aria-hidden="true">Kontaktvägar</p>
        <h2 id="kontakt-hjalp-vagar-heading">Så får du svar snabbast</h2>
        <div class="rr-contact-method-grid">
          <article class="rr-contact-method-card">
            <h3>Vanliga frågor och svar</h3>
            <p>Vi har samlat svar på återkommande frågor om dans.se, friskvård med ePassi, Teams-möten och Zoom-möten.</p>
            <a class="rr-btn-inline" href="../fragor-och-svar" title="Gå till vanliga frågor och svar">Gå till FAQ</a>
          </article>
          <article class="rr-contact-method-card">
            <h3>Kontakta oss via e-post</h3>
            <p>Om du inte hittar svaret i FAQ kan du alltid mejla oss på <a href="mailto:info@rockrullarna.se" title="Maila info@rockrullarna.se">info@rockrullarna.se</a>.</p>
            <a class="rr-btn-inline" href="../skicka-arende-eller-fraga" title="Gå till Skicka ärende eller fråga">Se alla kontaktvägar</a>
          </article>
          <article class="rr-contact-method-card">
            <h3>Besök oss på plats</h3>
            <p>Du är välkommen att komma förbi när någon är på plats i lokalen. Använd aktivitetskalendern för att se när det är öppet.</p>
            <a class="rr-btn-inline" href="../../aktivitetskalender" title="Gå till aktivitetskalendern">Öppna aktivitetskalendern</a>
          </article>
          <article class="rr-contact-method-card">
            <h3>Osäker på vart du ska vända dig?</h3>
            <p>Börja med info-mejlen så hjälper vi dig vidare till rätt person eller funktion inom föreningen.</p>
            <a class="rr-btn-inline" href="mailto:info@rockrullarna.se" title="Maila info@rockrullarna.se">Maila info</a>
          </article>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>
