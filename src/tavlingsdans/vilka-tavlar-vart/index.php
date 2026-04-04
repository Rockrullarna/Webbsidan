<?php
  $header_title = "Vilka tävlar vart? - Tävlingsdans";
  $header_description = "Här ser du alla våra tävlande som är anmälda till kommande tävlingar";

  $page_updated = "2026-04-05 00:20";
  $page_url = "/tavlingsdans/vilka-tavlar-vart";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Vilka tävlar vart?</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tavlar-vart-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Kommande anmälningar</p>
          <h1 id="tavlar-vart-heading">Vilka tävlar vart?</h1>
          <p class="rr-association-lead">Här ser du vilka tävlande från Rockrullarna som är anmälda till kommande tävlingar enligt dans.se.</p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="https://dans.se/tools/comp/registrations/?org=Rockrullarna" title="Öppna registreringar på dans.se" target="_blank" rel="noopener">Öppna på dans.se</a>
            <a class="rr-btn-inline" href="../resultat" title="Se tävlingsresultat">Se resultat</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tavlar-vart-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="tavlar-vart-info-heading">Så använder du sidan</h2>
          <ul class="rr-association-list">
            <li><strong>Aktuell information</strong><br />Listan hämtas direkt från klubbens registreringar i dans.se.</li>
            <li><strong>Planering</strong><br />Bra stöd när du vill se vilka tävlingar klubbkamrater ska åka på.</li>
            <li><strong>Kontakt</strong><br /><a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">tavlingsansvarig@rockrullarna.se</a></li>
          </ul>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section rr-competition-frame-card" aria-labelledby="tavlar-vart-frame-heading">
        <p class="rr-style-label" aria-hidden="true">Direkt från dans.se</p>
        <h2 id="tavlar-vart-frame-heading">Rockrullarnas kommande tävlingsstarter</h2>
        <div class="rr-competition-frame-wrap">
          <iframe height="1000" src="https://dans.se/tools/comp/registrations/?org=ROCKRULLARNA" title="Vilka tävlar vart från dans.se"></iframe>
        </div>
        <div class="rr-association-note">
          <p>Om inbäddningen inte fungerar kan du öppna samma information direkt på <a href="https://dans.se/tools/comp/registrations/?org=Rockrullarna" title="Rockrullarnas tävlingsanmälningar på dans.se" target="_blank" rel="noopener">dans.se</a>.</p>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>