<?php
  $header_title = "Resultat - Tävlingsdans";
  $header_description = "Historiska tävlingsresultat från de tävlingar där våra tävlande har medverkat";

  $page_updated = "2026-04-05 00:20";
  $page_url = "/tavlingsdans/resultat";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Resultat</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tavlingsresultat-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Historik och uppföljning</p>
          <h1 id="tavlingsresultat-heading">Tävlingsresultat</h1>
          <p class="rr-association-lead">Här hittar du historiska tävlingsresultat från tävlingar där Rockrullarnas tävlande har deltagit.</p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="https://www.dans.se/tools/comp/results/?org=Rockrullarna" title="Öppna resultaten på dans.se" target="_blank" rel="noopener">Öppna på dans.se</a>
            <a class="rr-btn-inline" href="../kalender" title="Se tävlingskalendern">Tävlingskalender</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tavlingsresultat-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="tavlingsresultat-info-heading">Resultatöversikt</h2>
          <ul class="rr-association-list">
            <li><strong>Datakälla</strong><br />Resultaten hämtas från dans.se.</li>
            <li><strong>Användning</strong><br />Bra för uppföljning av starter och tidigare tävlingar.</li>
            <li><strong>Frågor</strong><br /><a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">tavlingsansvarig@rockrullarna.se</a></li>
          </ul>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section rr-competition-frame-card" aria-labelledby="tavlingsresultat-frame-heading">
        <p class="rr-style-label" aria-hidden="true">Direkt från dans.se</p>
        <h2 id="tavlingsresultat-frame-heading">Resultat för Rockrullarna</h2>
        <div class="rr-competition-frame-wrap">
          <iframe height="1000" scrolling="yes" src="https://www.dans.se/tools/comp/results/?org=ROCKRULLARNA" title="Tävlingsresultat från dans.se"></iframe>
        </div>
        <div class="rr-association-note">
          <p>Om inbäddningen inte fungerar kan du öppna resultaten direkt på <a href="https://www.dans.se/tools/comp/results/?org=Rockrullarna" title="Rockrullarnas tävlingsresultat på dans.se" target="_blank" rel="noopener">dans.se</a>.</p>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>