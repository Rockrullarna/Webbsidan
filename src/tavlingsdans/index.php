<?php
  $header_title = "Tävlingsdans";
  $header_description = "Här hittar du information om vår tävlingsdans";

  $page_updated = "2026-04-05 00:20";
  $page_url = "/tavlingsdans";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../">Rockrullarna.se</a> / <span>Tävlingsdans</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tavlingsdans-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Bugg, Fox och West Coast Swing</p>
          <h1 id="tavlingsdans-heading">Tävlingsdans med fokus på <em>utveckling</em> och startglädje</h1>
          <p class="rr-association-lead">
            Rockrullarna erbjuder tävlingsinriktade satsningar inom Bugg, Fox och West Coast Swing.
            Här får danspar utveckla teknik, uttryck och mental förberedelse inför tävlingsgolvet.
          </p>
          <p class="rr-association-lead">
            I sektionen hittar du kalender, anmälda par, resultat och praktisk information om de
            system som används i tävlingssammanhang.
          </p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="./kalender" title="Öppna tävlingskalendern">Tävlingskalender</a>
            <a class="rr-btn-inline" href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">Kontakta tävlingsansvarig</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tavlingsdans-snabblankar-heading">
          <p class="rr-style-label" aria-hidden="true">Snabbt vidare</p>
          <h2 id="tavlingsdans-snabblankar-heading">Vanliga ingångar</h2>
          <ul class="rr-association-list">
            <li><strong>Planera starter</strong><br /><a href="./kalender" title="Se tävlingskalendern">Tävlingskalender</a></li>
            <li><strong>Följ klubbens starter</strong><br /><a href="./vilka-tavlar-vart" title="Se vilka som tävlar vart">Vilka tävlar vart?</a></li>
            <li><strong>Se historik</strong><br /><a href="./resultat" title="Se tävlingsresultat">Tävlingsresultat</a></li>
          </ul>
          <div class="rr-association-note">
            <p><strong>Kontakt:</strong> Mejla <a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">tavlingsansvarig@rockrullarna.se</a> om du har frågor om starter, anmälningar eller tävlingsupplägg.</p>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="tavlingsdans-overview-heading">
        <p class="rr-style-label" aria-hidden="true">Kort om satsningen</p>
        <h2 id="tavlingsdans-overview-heading">Det här hittar du i sektionen</h2>
        <div class="rr-competition-stats">
          <div class="rr-association-meta-item"><strong>Tävlingsformer</strong>Bugg, Fox och West Coast Swing</div>
          <div class="rr-association-meta-item"><strong>För dig som</strong>vill planera starter, följa tävlingar och hitta praktisk information</div>
          <div class="rr-association-meta-item"><strong>Systemstöd</strong>dans.se för anmälningar och Vote4Dance för liveinformation och resultat</div>
          <div class="rr-association-meta-item"><strong>Extern översikt</strong><a href="https://www.danssport.se/taevling/taevlingskalender" title="Öppna DSF Tävlingskalender" target="_blank" rel="noopener">DSF Tävlingskalender</a></div>
        </div>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="tavlingsdans-links-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Navigera vidare</p>
            <h2 id="tavlingsdans-links-heading">Sidor om <em>tävlingsdans</em></h2>
          </div>
        </div>

        <div class="rr-courses-links-grid">
          <a class="rr-courses-link-card" href="./kalender" title="Öppna tävlingskalendern">
            <span class="rr-courses-link-kicker">Planera säsongen</span>
            <h3>Tävlingskalender</h3>
            <p>Se kommande tävlingar via dans.se och öppna hela kalendern i eget fönster om du vill.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./vilka-tavlar-vart" title="Se vilka som tävlar vart">
            <span class="rr-courses-link-kicker">Kommande starter</span>
            <h3>Vilka tävlar vart?</h3>
            <p>Följ vilka tävlande från Rockrullarna som är anmälda till kommande tävlingar.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./resultat" title="Se tävlingsresultat">
            <span class="rr-courses-link-kicker">Historik</span>
            <h3>Tävlingsresultat</h3>
            <p>Bläddra bland tidigare resultat från tävlingar där klubbens tävlande deltagit.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./dans.se" title="Läs om dans.se">
            <span class="rr-courses-link-kicker">Systemguide</span>
            <h3>dans.se</h3>
            <p>Läs mer om konton, anmälningar och varför dans.se är centralt i tävlingsflödet.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./vote4dance" title="Läs om Vote4Dance">
            <span class="rr-courses-link-kicker">Resultat och live</span>
            <h3>Vote4Dance</h3>
            <p>Få koll på appen och tjänsten som används för liveinformation, resultat och startlistor.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="https://www.danssport.se/taevling/taevlingskalender" title="Öppna DSF Tävlingskalender" target="_blank" rel="noopener">
            <span class="rr-courses-link-kicker">Extern resurs</span>
            <h3>DSF Tävlingskalender</h3>
            <p>Gå vidare till förbundets egen kalender för en bredare överblick över tävlingar.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
        </div>
      </section>
    </div>
<?php
  include_once '../includes/footer.php'
?>