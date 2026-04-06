<?php
  $header_title = "Medlemsrabatter - Föreningen";
  $header_description = "Som medlem i den ideella föreningen DK Rockrullarna så har du medlemsrabatt hos följande företag";

  $page_updated = "2026-04-04 22:10";
  $page_url = "/foreningen/medlemsrabatter";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page">
      <div id="BreadCrumbsDiv">
        <a href="../../">Rockrullarna.se</a> / <a href="../">Föreningen</a> / <span>Medlemsrabatter</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="rabatter-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Medlemsförmåner</p>
          <h1 id="rabatter-heading">Förmåner för dig som är <em>medlem</em></h1>
          <p class="rr-association-lead">
            Som medlem i DK Rockrullarna kan du ta del av rabatter hos företag som vill stötta
            vår förening. Visa ditt medlemsbevis i samband med köp för att ta del av erbjudandet.
          </p>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="rabatter-info-heading">
          <p class="rr-style-label" aria-hidden="true">Bra att veta</p>
          <h2 id="rabatter-info-heading">Hur rabatten används</h2>
          <div class="rr-association-meta">
            <div class="rr-association-meta-item">
              <strong>Visa medlemsbevis</strong>
              <p>Ta med giltigt medlemsbevis när du handlar eller hänvisa till aktuell rabattkod.</p>
            </div>
            <div class="rr-association-meta-item">
              <strong>Vill du bidra?</strong>
              <p>Har du ett företag som vill erbjuda rabatt till våra medlemmar är du välkommen att kontakta oss.</p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="rabatter-lista-heading">
        <p class="rr-style-label" aria-hidden="true">Aktuella erbjudanden</p>
        <h2 id="rabatter-lista-heading">Medlemsrabatter just nu</h2>
        <div class="rr-association-table">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Företag</th>
                <th>Hemsida</th>
                <th>Telefon</th>
                <th>Tjänster</th>
                <th>Rabatt</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Dansshopen</td>
                <td><a href="http://www.dansshopen.nu/" title="Besök Dansshopen" target="_blank" rel="noopener">www.dansshopen.nu</a></td>
                <td>019-10 15 05</td>
                <td>Dansskor</td>
                <td>10% på dansskor med rabattkoden <strong>RR</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="rr-association-note">
          <p>Har du ett företag och vill erbjuda våra medlemmar rabatt?</p>
          <p>Skicka ett mejl till <a href="mailto:info@rockrullarna.se" title="Mejla till info@rockrullarna.se">info@rockrullarna.se</a>.</p>
        </div>
      </section>
    </div>
<?php
  include_once '../../includes/footer.php'
?>