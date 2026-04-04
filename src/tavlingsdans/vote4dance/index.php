<?php
  $header_title = "Vote4Dance - Tävlingsdans";
  $header_description = "Information om tävlingssystemet Vote 4 Dance";

  $page_updated = "2026-04-05 00:20";
  $page_url = "/tavlingsdans/vote4dance";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Vote4Dance</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="vote4dance-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Liveinfo och resultat</p>
          <h1 id="vote4dance-heading">Vote4Dance</h1>
          <p class="rr-association-lead">På Vote4Dance kan du följa kommande tävlingar, resultat direkt från tävlingen och i vissa fall förenklade livesändningar via dansTV.</p>
          <p class="rr-association-lead">Tjänsten är särskilt användbar när du vill följa startlistor och resultat i realtid under pågående tävlingar.</p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="http://vote4dance.com" title="Öppna Vote4Dance" target="_blank" rel="noopener">Öppna Vote4Dance</a>
            <a class="rr-btn-inline" href="../vilka-tavlar-vart" title="Se vilka som tävlar vart">Vilka tävlar vart?</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="vote4dance-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att känna till</p>
          <h2 id="vote4dance-info-heading">Vanliga användningar</h2>
          <ul class="rr-association-list">
            <li><strong>Startlistor och resultat</strong><br />Följ tävlingar under dagen i mobilen.</li>
            <li><strong>Appstöd</strong><br />Ett bra tips är att använda Vote4Dance-appen för snabb uppföljning på plats.</li>
            <li><strong>Klubbens starter</strong><br /><a href="../vilka-tavlar-vart" title="Se vilka som tävlar vart">Se vilka par som anmält sig var</a></li>
          </ul>
        </aside>
      </section>

      <section class="rr-competition-card-grid" aria-label="Information om Vote4Dance">
        <section class="rr-association-card rr-association-card--section rr-competition-logo-card">
          <p class="rr-style-label" aria-hidden="true">Extern tjänst</p>
          <img alt="Logga för Vote4Dance" src="Vote4Dance.png" />
          <p class="rr-association-lead">Vote4Dance är en praktisk tjänst för att följa tävlingsdagen när du vill hålla koll på resultat, starter och uppdateringar.</p>
          <a class="rr-btn-inline" href="http://vote4dance.com" title="Öppna Vote4Dance" target="_blank" rel="noopener">Besök www.vote4dance.com</a>
        </section>

        <section class="rr-association-card rr-association-card--section rr-competition-meta-card" aria-labelledby="vote4dance-tips-heading">
          <p class="rr-style-label" aria-hidden="true">Tips</p>
          <h2 id="vote4dance-tips-heading">För dig som följer tävlingar live</h2>
          <ul class="rr-association-list">
            <li><strong>Under tävlingsdagen</strong><br />Använd tjänsten för att se resultat och startlistor utan att vänta på senare sammanställningar.</li>
            <li><strong>I mobilen</strong><br />Appen gör det enklare att följa uppdateringar när du är på plats eller på språng.</li>
            <li><strong>I kombination med dans.se</strong><br />Anmälningar hanteras i dans.se medan Vote4Dance är starkt för löpande tävlingsinformation.</li>
          </ul>
        </section>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>