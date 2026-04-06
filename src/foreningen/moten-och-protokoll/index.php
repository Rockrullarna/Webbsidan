<?php
  $header_title = "Möten och protokoll - Föreningen";
  $header_description = "Här finner du våra publika mötesprotokoll från olika möten vi genomfört";

  $page_updated = "2026-04-04 22:10";
  $page_url = "/foreningen/moten-och-protokoll";
  $page_contact_name = "Styrelsen";
  $page_contact_email = "styrelsen@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Föreningen</a> / <span>Möten och protokoll</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="protokoll-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Insyn i föreningen</p>
          <h1 id="protokoll-heading">Möten och <em>protokoll</em></h1>
          <p class="rr-association-lead">
            Här hittar du våra publika mötesprotokoll från olika typer av möten i föreningen.
            Tränarmöten och vissa andra interna möten dokumenteras också, men delas bara med
            berörda parter.
          </p>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="protokoll-info-heading">
          <p class="rr-style-label" aria-hidden="true">Kontakt</p>
          <h2 id="protokoll-info-heading">Saknar du något?</h2>
          <div class="rr-association-meta">
            <div class="rr-association-meta-item">
              <strong>Behöver du ett protokoll?</strong>
              <p>Kontakta styrelsen om du saknar ett dokument eller behöver hjälp att hitta rätt material.</p>
            </div>
            <div class="rr-association-meta-item">
              <strong>E-post</strong>
              <p><a href="mailto:styrelsen@rockrullarna.se" title="Mejla till styrelsen@rockrullarna.se">styrelsen@rockrullarna.se</a></p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="protokoll-lankar-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Välj mötestyp</p>
            <h2 id="protokoll-lankar-heading">Publika protokoll och <em>handlingar</em></h2>
          </div>
        </div>

        <div class="rr-courses-links-grid">
          <a class="rr-courses-link-card" href="./arsmote" title="Gå till Årsmöte">
            <span class="rr-courses-link-kicker">Föreningens högsta beslutande organ</span>
            <h3>Årsmöte</h3>
            <p>Här finns handlingar, arkiv och praktisk information om våra årsmöten.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>

          <a class="rr-courses-link-card" href="./medlemsmote" title="Gå till Medlemsmöte">
            <span class="rr-courses-link-kicker">Dialog med medlemmarna</span>
            <h3>Medlemsmöte</h3>
            <p>Ta del av information och protokoll från medlemsmöten under höstterminen.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>

          <a class="rr-courses-link-card" href="./styrelsemote" title="Gå till Styrelsemöte">
            <span class="rr-courses-link-kicker">Löpande styrelsearbete</span>
            <h3>Styrelsemöte</h3>
            <p>Här samlas publika protokoll från styrelsemöten och relevanta SharePoint-arkiv.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>