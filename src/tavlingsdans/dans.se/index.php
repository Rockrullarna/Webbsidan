<?php
  $header_title = "Dans.se - Tävlingsdans";
  $header_description = "Information om vårt kurs och tävlingssystem";

  $page_updated = "2026-04-05 00:20";
  $page_url = "/tavlingsdans/dans.se";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../../includes/header.php';
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Dans.se</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tavlingsdans-dansse-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">System för anmälningar och starter</p>
          <h1 id="tavlingsdans-dansse-heading">dans.se</h1>
          <p class="rr-association-lead">dans.se, tidigare Swingweb, är tjänsten där du skapar konto och hanterar anmälningar till både kurser och tävlingar.</p>
          <p class="rr-association-lead">För tävlingsdans är det här navet för starter, registreringar och flera av de underlag som används vidare i klubbens tävlingsflöde.</p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="https://dans.se/" title="Öppna dans.se" target="_blank" rel="noopener">Öppna dans.se</a>
            <a class="rr-btn-inline" href="/kontakt/fragor-och-svar#dans-se" title="Läs vanliga frågor om dans.se">Frågor och svar om dans.se</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tavlingsdans-dansse-links-heading">
          <p class="rr-style-label" aria-hidden="true">Snabbt vidare</p>
          <h2 id="tavlingsdans-dansse-links-heading">Vanliga behov</h2>
          <ul class="rr-association-list">
            <li><strong>Skapa eller hantera konto</strong><br /><a href="https://dans.se/" title="Gå till dans.se" target="_blank" rel="noopener">Gå till dans.se</a></li>
            <li><strong>Hjälp med inloggning</strong><br /><a href="/kontakt/fragor-och-svar#dans-se" title="Frågor och svar om dans.se">Läs FAQ om dans.se</a></li>
            <li><strong>Frågor till klubben</strong><br /><a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">tavlingsansvarig@rockrullarna.se</a></li>
          </ul>
        </aside>
      </section>

      <section class="rr-competition-card-grid" aria-label="Information om dans.se">
        <section class="rr-association-card rr-association-card--section rr-competition-logo-card">
          <p class="rr-style-label" aria-hidden="true">Extern tjänst</p>
          <img alt="Logga för dans.se" src="dans-se.jpg" width="202" height="59" />
          <p class="rr-association-lead">Använd dans.se när du ska logga in, hantera dina uppgifter och anmäla dig till tävlingar.</p>
          <a class="rr-btn-inline" href="https://dans.se/" title="Öppna dans.se" target="_blank" rel="noopener">Besök www.dans.se</a>
        </section>

        <section class="rr-association-card rr-association-card--section rr-competition-meta-card" aria-labelledby="tavlingsdans-dansse-steps-heading">
          <p class="rr-style-label" aria-hidden="true">Så kommer du igång</p>
          <h2 id="tavlingsdans-dansse-steps-heading">Kort guide</h2>
          <ul class="rr-association-list">
            <li><strong>1. Skapa konto</strong><br />Använd samma e-postadress som du anmäler kurser med hos Rockrullarna.</li>
            <li><strong>2. Kontrollera uppgifter</strong><br />Säkerställ att dina personuppgifter är korrekta innan du anmäler starter.</li>
            <li><strong>3. Sök upp tävlingar</strong><br />Hitta tävlingar i systemet och registrera dina starter där.</li>
          </ul>
          <div class="rr-association-note">
            <p>Mer information om konto och inloggning finns under <a href="/kontakt/fragor-och-svar#dans-se" title="Gå till frågor och svar om dans.se">Frågor och svar</a>.</p>
          </div>
        </section>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php';
?>