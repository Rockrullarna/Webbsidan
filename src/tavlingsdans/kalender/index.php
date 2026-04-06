<?php
  $header_title = "Kalender - Tävlingsdans";
  $header_description = "Tävlingskalendern för kommande tävlingar";

  $page_updated = "2026-04-05 00:20";
  $page_url = "/tavlingsdans/kalender";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Tävlingsdans</a> / <span>Kalender</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tavlingskalender-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Kommande tävlingar</p>
          <h1 id="tavlingskalender-heading">Tävlingskalender</h1>
          <p class="rr-association-lead">Här visas kommande tävlingar via dans.se. Använd sidan för att planera starter och få en överblick över kommande arrangemang.</p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="https://dans.se/tools/comp/events/?fed=dsf" title="Öppna tävlingskalendern på dans.se" target="_blank" rel="noopener">Öppna på dans.se</a>
            <a class="rr-btn-inline" href="../vilka-tavlar-vart" title="Se vilka som tävlar vart">Vilka tävlar vart?</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tavlingskalender-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="tavlingskalender-info-heading">Om inbäddningen</h2>
          <ul class="rr-association-list">
            <li><strong>Datakälla</strong><br />Kalendern hämtas direkt från dans.se.</li>
            <li><strong>Om något inte laddar</strong><br />Öppna samma innehåll i ett eget fönster via länken nedan.</li>
            <li><strong>Frågor</strong><br /><a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">tavlingsansvarig@rockrullarna.se</a></li>
          </ul>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section rr-competition-frame-card" aria-labelledby="tavlingskalender-frame-heading">
        <p class="rr-style-label" aria-hidden="true">Direkt från dans.se</p>
        <h2 id="tavlingskalender-frame-heading">Kalender för tävlingsstarter</h2>
        <div class="rr-competition-frame-wrap">
          <iframe height="1200" scrolling="auto" src="https://dans.se/tools/comp/events/?fed=dsf" title="Tävlingskalender från dans.se"></iframe>
        </div>
        <div class="rr-association-note">
          <p>Om hämtningen inte fungerar automatiskt hittar du kalendern direkt på <a href="https://dans.se/tools/comp/events/?fed=dsf" title="Tävlingskalender på dans.se" target="_blank" rel="noopener">dans.se</a>.</p>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>