<?php
  $header_title = "Valberedningen - Organisation - Föreningen";
  $header_description = "Information om den ideella föreningens valberedning";

  $page_updated = "2026-03-31 22:39";
  $page_url = "/foreningen/organisation/valberedningen";
  $page_contact_name = "Valberedningen";
  $page_contact_email = "valberedningen@rockrullarna.se";
  $committeeMembersFile = __DIR__ . DIRECTORY_SEPARATOR . 'medlemmar-valberedningen.json';
  $committee_members = [];

  function clampThumbnailOffsetPercent($value): int {
    if (!is_numeric($value)) {
      return 50;
    }

    $number = (int) round((float) $value);

    if ($number < 0) {
      return 0;
    }

    if ($number > 100) {
      return 100;
    }

    return $number;
  }

  if (is_file($committeeMembersFile)) {
    $membersContent = @file_get_contents($committeeMembersFile);

    if ($membersContent !== false && $membersContent !== '') {
      $membersPayload = json_decode($membersContent, true);

      if (is_array($membersPayload)) {
        foreach ($membersPayload as $member) {
          if (!is_array($member)) {
            continue;
          }

          $name = trim((string) ($member['name'] ?? ''));

          if ($name === '') {
            continue;
          }

          $committee_members[] = [
            'name' => $name,
            'image' => trim((string) ($member['image'] ?? '')),
            'thumbnailOffsetY' => clampThumbnailOffsetPercent($member['thumbnailOffsetY'] ?? 50),
          ];
        }
      }
    }
  }

  include_once '../../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page">
      <div id="BreadCrumbsDiv">
        <a href="../../../">Rockrullarna.se</a> / <a href="../../">Föreningen</a> / <a href="../">Organisation</a> / <span>Valberedningen</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="valberedningen-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Valarbete i föreningen</p>
          <h1 id="valberedningen-heading">Valberedningen</h1>
          <p class="rr-association-lead">Valberedningens uppgift är att föreslå revisorer och ledamöter till styrelsen. Som representant i valberedningen behöver du ha god kännedom om verksamheten och om de personer som är aktiva i föreningen.</p>
          <p class="rr-association-lead">Valberedningen är fristående från styrelsen och ska löpande följa verksamheten för att kunna hitta en bra representation av föreningens medlemmar.</p>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="valberedningen-kontakt-heading">
          <p class="rr-style-label" aria-hidden="true">Kontakt</p>
          <h2 id="valberedningen-kontakt-heading">Nominera någon</h2>
          <div class="rr-association-meta">
            <div class="rr-association-meta-item">
              <strong>E-post</strong>
              <p><a href="mailto:valberedningen@rockrullarna.se" title="Mejla till valberedningen">valberedningen@rockrullarna.se</a></p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="valberedningen-lista-heading">
        <p class="rr-style-label" aria-hidden="true">Mandatperiod 2026-2027</p>
        <h2 id="valberedningen-lista-heading">Valberedningen 2026-2027</h2>
        <?php if (!empty($committee_members)) { ?>
          <div class="rr-board-grid" aria-label="Valberedning i kortformat">
            <?php foreach ($committee_members as $member) { ?>
              <?php $memberImage = trim((string) ($member['image'] ?? '')); ?>
              <?php $thumbFocusY = clampThumbnailOffsetPercent($member['thumbnailOffsetY'] ?? 50); ?>
              <article class="rr-board-card">
                <div class="rr-board-photo-shell">
                  <?php if ($memberImage !== '') { ?>
                    <img
                      src="<?php echo htmlspecialchars($memberImage); ?>"
                      alt="Porträtt av <?php echo htmlspecialchars($member['name']); ?>"
                      class="rr-board-photo"
                      style="--rr-thumb-focus-y: center <?php echo $thumbFocusY; ?>%; object-position: center <?php echo $thumbFocusY; ?>%;"
                      loading="lazy"
                    />
                  <?php } else { ?>
                    <div class="rr-board-photo-placeholder" role="img" aria-label="Bild saknas för <?php echo htmlspecialchars($member['name']); ?>">
                      <span>Bild saknas</span>
                    </div>
                  <?php } ?>
                </div>
                <div class="rr-board-card-content">
                  <h3 class="rr-board-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                </div>
              </article>
            <?php } ?>
          </div>
        <?php } else { ?>
          <p class="rr-social-feed-status">Valberedningens medlemmar kunde inte läsas in just nu. Uppdatera <a href="/foreningen/organisation/valberedningen/medlemmar-valberedningen.json">medlemmar-valberedningen.json</a> och försök igen.</p>
        <?php } ?>
        <div class="rr-association-note">
          <p>Har du förslag på personer som vill vara verksamma i styrelsen? Skicka ditt förslag till valberedningen.</p>
          <p><strong>Obs:</strong> Personen du föreslår måste vara tillfrågad och vilja ställa upp för val till styrelsen.</p>
        </div>
      </section>
    </div>
<?php
  include_once '../../../includes/footer.php'
?>