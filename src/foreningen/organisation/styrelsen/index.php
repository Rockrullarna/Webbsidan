<?php
  $header_title = "Styrelsen - Organisation - Föreningen";
  $header_description = "Information om den ideella dansföreningen Rockrullarnas styrelse";

  $page_updated = "2026-03-31 22:27";
  $page_url = "/foreningen/organisation/styrelsen";
  $page_contact_name = "Styrelsen";
  $page_contact_email = "styrelsen@rockrullarna.se";
  $boardMembersFile = __DIR__ . DIRECTORY_SEPARATOR . 'medlemmar-styrelsen.json';
  $board_members = [];

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

  if (is_file($boardMembersFile)) {
    $membersContent = @file_get_contents($boardMembersFile);

    if ($membersContent !== false && $membersContent !== '') {
      $membersPayload = json_decode($membersContent, true);

      if (is_array($membersPayload)) {
        foreach ($membersPayload as $member) {
          if (!is_array($member)) {
            continue;
          }

          $name = trim((string) ($member['name'] ?? ''));
          $role = trim((string) ($member['role'] ?? ''));
          $term = trim((string) ($member['term'] ?? ''));

          if ($name === '' || $role === '' || $term === '') {
            continue;
          }

          $board_members[] = [
            'role' => $role,
            'term' => $term,
            'name' => $name,
            'image' => trim((string) ($member['image'] ?? '')),
            'thumbnailOffsetY' => clampThumbnailOffsetPercent($member['thumbnailOffsetY'] ?? 50),
          ];
        }
      }
    }
  }
  $board_regular_members = array_values(array_filter(
    $board_members,
    static fn($member) => ($member['role'] ?? '') !== 'Suppleant'
  ));
  $board_substitutes = array_values(array_filter(
    $board_members,
    static fn($member) => ($member['role'] ?? '') === 'Suppleant'
  ));

  include_once '../../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page">
      <div id="BreadCrumbsDiv">
        <a href="../../../">Rockrullarna.se</a> / <a href="../../">Föreningen</a> / <a href="../">Organisation</a> / <span>Styrelsen</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="styrelsen-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Nuvarande mandatperiod</p>
          <h1 id="styrelsen-heading">Styrelsen</h1>
          <p class="rr-association-lead">Det här är personerna som sitter i styrelsen sedan årsmötet 2026-03-28.</p>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="styrelsen-kontakt-heading">
          <p class="rr-style-label" aria-hidden="true">Kontakt</p>
          <h2 id="styrelsen-kontakt-heading">Nå styrelsen</h2>
          <div class="rr-association-meta">
            <div class="rr-association-meta-item">
              <strong>Gemensam e-post</strong>
              <p><a href="mailto:styrelsen@rockrullarna.se" title="Mejla till styrelsen@rockrullarna.se">styrelsen@rockrullarna.se</a></p>
            </div>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="styrelsen-lista-heading">
        <p class="rr-style-label" aria-hidden="true">Sammansättning</p>
        <h2 id="styrelsen-lista-heading">Styrelsen 2026-2027</h2>
        <div class="rr-association-roster-block" aria-labelledby="styrelsen-ledamoter-heading">
          <h3 id="styrelsen-ledamoter-heading" class="rr-association-roster-title">Ledamöter</h3>
          <p class="rr-association-roster-meta"><?php echo count($board_regular_members); ?> personer</p>
          <div class="rr-board-grid" aria-label="Ledamöter i kortformat">
            <?php foreach ($board_regular_members as $member) { ?>
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
                  <p class="rr-board-role"><?php echo htmlspecialchars($member['role']); ?> (<?php echo htmlspecialchars($member['term']); ?>)</p>
                  <h4 class="rr-board-name"><?php echo htmlspecialchars($member['name']); ?></h4>
                </div>
              </article>
            <?php } ?>
          </div>
        </div>

        <div class="rr-association-roster-block" aria-labelledby="styrelsen-suppleanter-heading">
          <h3 id="styrelsen-suppleanter-heading" class="rr-association-roster-title">Suppleanter</h3>
          <p class="rr-association-roster-meta"><?php echo count($board_substitutes); ?> personer</p>
          <div class="rr-board-grid" aria-label="Suppleanter i kortformat">
            <?php foreach ($board_substitutes as $member) { ?>
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
                  <p class="rr-board-role"><?php echo htmlspecialchars($member['role']); ?> (<?php echo htmlspecialchars($member['term']); ?>)</p>
                  <h4 class="rr-board-name"><?php echo htmlspecialchars($member['name']); ?></h4>
                </div>
              </article>
            <?php } ?>
          </div>
        </div>
      </section>
    </div>
<?php
  include_once '../../../includes/footer.php'
?>