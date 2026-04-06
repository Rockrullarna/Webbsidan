<?php
  $header_title = "Skicka ärende eller fråga - Kontakt";
  $header_description = "Här kan du kontakta oss via e-post";

  $page_updated = "2026-04-04 23:15";
  $page_url = "/kontakt/skicka-arende-eller-fraga";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";
  
  include_once '../../includes/header.php'
  ?>
    <div class="rr-page-shell rr-association-page rr-contact-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Kontakt</a> / <span>Skicka ärende eller fråga</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="kontakt-mail-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Mejla rätt funktion</p>
          <h1 id="kontakt-mail-heading">Skicka ärende eller <em>fråga</em></h1>
          <p class="rr-association-lead">
            När du kontaktar oss via mejl går ditt ärende direkt till rätt områdesansvarig.
            Det ger snabbare svar och minskar risken att viktig information hamnar fel.
          </p>
          <p class="rr-association-lead">
            Beskriv gärna ärendet tydligt och ta med referensnummer om du har en bokning,
            till exempel <strong>R1234567</strong>.
          </p>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="kontakt-mail-snabb-heading">
          <p class="rr-style-label" aria-hidden="true">Snabb vägledning</p>
          <h2 id="kontakt-mail-snabb-heading">Vet du inte vem du ska skriva till?</h2>
          <p class="rr-association-lead">Börja med info-mejlen så hjälper vi dig vidare till rätt funktion inom föreningen.</p>
          <div class="rr-association-actions">
            <a class="rr-btn-inline" href="mailto:info@rockrullarna.se" title="Maila info@rockrullarna.se">Maila info</a>
            <a class="rr-btn-inline" href="../fragor-och-svar" title="Läs vanliga frågor och svar">Läs FAQ först</a>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="kontakt-mail-lista-heading">
        <p class="rr-style-label" aria-hidden="true">Kontaktvägar via mejl</p>
        <h2 id="kontakt-mail-lista-heading">Välj rätt <em>mejladress</em></h2>
        <div class="rr-contact-method-grid">
          <article class="rr-contact-method-card">
            <h3>Info</h3>
            <p><a href="mailto:info@rockrullarna.se" title="Maila info@rockrullarna.se">info@rockrullarna.se</a></p>
            <ul>
              <li>Generella frågor som berör föreningen.</li>
            </ul>
          </article>
          <article class="rr-contact-method-card">
            <h3>Kurser</h3>
            <p><a href="mailto:kurser@rockrullarna.se" title="Maila kurser@rockrullarna.se">kurser@rockrullarna.se</a></p>
            <ul>
              <li>Frågor som gäller kurser, anmälningar och avanmälningar.</li>
              <li>Frågor om bokning av lokalen för evenemang.</li>
            </ul>
          </article>
          <article class="rr-contact-method-card">
            <h3>Ekonomi/Kassör</h3>
            <p><a href="mailto:ekonomi@rockrullarna.se" title="Maila ekonomi@rockrullarna.se">ekonomi@rockrullarna.se</a></p>
            <ul>
              <li>Frågor om ekonomi, kursavgifter, medlemsavgift och friskvårdsbidrag.</li>
            </ul>
          </article>
          <article class="rr-contact-method-card">
            <h3>Tävlingsansvarig</h3>
            <p><a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tavlingsansvarig@rockrullarna.se">tavlingsansvarig@rockrullarna.se</a></p>
            <ul>
              <li>Frågor som specifikt gäller tävlingsverksamhet.</li>
            </ul>
          </article>
          <article class="rr-contact-method-card">
            <h3>Styrelsen</h3>
            <p><a href="mailto:styrelsen@rockrullarna.se" title="Maila styrelsen@rockrullarna.se">styrelsen@rockrullarna.se</a></p>
            <ul>
              <li>Förslag och synpunkter.</li>
              <li>Information som behöver nå styrelsen.</li>
              <li>Frågor som kräver styrelsebeslut.</li>
              <li>Ärenden om dåligt bemötande, kränkning eller särbehandling.</li>
            </ul>
          </article>
          <article class="rr-contact-method-card">
            <h3>Valberedningen</h3>
            <p><a href="mailto:valberedningen@rockrullarna.se" title="Maila valberedningen@rockrullarna.se">valberedningen@rockrullarna.se</a></p>
            <ul>
              <li>Nomineringar till styrelsen inför årsmötet som hålls innan mars månads utgång.</li>
            </ul>
          </article>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>