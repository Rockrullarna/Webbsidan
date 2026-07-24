<?php
  $header_title = "Tränare - Organisation - Föreningen";
  $header_description = "Klubbens tränare, assistenter och hjälpdansare inom Barndans, Bugg, Fox och West Coast Swing";

  $page_updated = "2026-07-24 14:10";
  $page_url = "/foreningen/organisation/tranare";
  $page_contact_name = "Tränare";
  $page_contact_email = "info@rockrullarna.se";

  $trainerCatalogFile = __DIR__ . DIRECTORY_SEPARATOR . 'klubbens-tranare.json';
  $trainer_sections = ['Barndans', 'Bugg', 'Fox', 'West Coast Swing'];
  $trainer_meta = [
    'senastUppdaterad' => '',
    'notes' => '',
    'ansvarig' => '',
  ];
  $trainer_people = [];

  if (is_file($trainerCatalogFile)) {
    $catalogContent = @file_get_contents($trainerCatalogFile);

    if ($catalogContent !== false && $catalogContent !== '') {
      $catalogPayload = json_decode($catalogContent, true);

      if (is_array($catalogPayload)) {
        if (is_array($catalogPayload['meta'] ?? null)) {
          $catalogMeta = $catalogPayload['meta'];

          $trainer_meta['senastUppdaterad'] = trim((string) ($catalogMeta['senastUppdaterad'] ?? ''));
          $trainer_meta['notes'] = trim((string) ($catalogMeta['notes'] ?? ''));
          $trainer_meta['ansvarig'] = trim((string) ($catalogMeta['ansvarig'] ?? ''));

          if (is_array($catalogMeta['sektioner'] ?? null)) {
            $customSections = [];

            foreach ($catalogMeta['sektioner'] as $sectionName) {
              $sectionName = trim((string) $sectionName);

              if ($sectionName === '') {
                continue;
              }

              $customSections[$sectionName] = true;
            }

            if (!empty($customSections)) {
              $trainer_sections = array_keys($customSections);
            }
          }
        }

        if (is_array($catalogPayload['data'] ?? null)) {
          foreach ($catalogPayload['data'] as $index => $person) {
            if (!is_array($person)) {
              continue;
            }

            $name = trim((string) ($person['name'] ?? ''));

            if ($name === '') {
              continue;
            }

            $image = trim((string) ($person['image'] ?? ''));
            $personId = trim((string) ($person['id'] ?? ''));

            if ($personId === '') {
              $personId = 'trainer-' . (string) $index . '-' . md5($name);
            }

            $assignments = [];
            $personSections = [];

            if (is_array($person['assignments'] ?? null)) {
              foreach ($person['assignments'] as $assignment) {
                if (!is_array($assignment)) {
                  continue;
                }

                $section = trim((string) ($assignment['section'] ?? ''));

                if ($section === '') {
                  continue;
                }

                $role = trim((string) ($assignment['role'] ?? ''));

                if ($role === '') {
                  $role = 'Tränare';
                }

                $assignments[] = [
                  'section' => $section,
                  'role' => $role,
                ];

                $personSections[$section] = true;
              }
            }

            if (empty($assignments)) {
              continue;
            }

            $trainer_people[] = [
              'id' => $personId,
              'name' => $name,
              'image' => $image,
              'assignments' => $assignments,
              'sections' => array_keys($personSections),
            ];
          }
        }
      }
    }
  }

  $section_members = [];

  foreach ($trainer_sections as $sectionName) {
    $section_members[$sectionName] = [];
  }

  foreach ($trainer_people as $person) {
    foreach ($person['assignments'] as $assignment) {
      $sectionName = $assignment['section'];
      $roleName = $assignment['role'];

      if (!isset($section_members[$sectionName])) {
        $section_members[$sectionName] = [];
        $trainer_sections[] = $sectionName;
      }

      $entryKey = $person['id'];

      if (!isset($section_members[$sectionName][$entryKey])) {
        $section_members[$sectionName][$entryKey] = [
          'name' => $person['name'],
          'image' => $person['image'],
          'roles' => [],
          'otherSections' => array_values(array_diff($person['sections'], [$sectionName])),
        ];
      }

      if (!in_array($roleName, $section_members[$sectionName][$entryKey]['roles'], true)) {
        $section_members[$sectionName][$entryKey]['roles'][] = $roleName;
      }
    }
  }

  $trainer_people_total = count($trainer_people);
  $trainer_assignments_total = 0;

  foreach ($trainer_people as $person) {
    $trainer_assignments_total += count($person['assignments']);
  }

  include_once '../../../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-trainer-page">
      <div id="BreadCrumbsDiv">
        <a href="../../../">Rockrullarna.se</a> / <a href="../../">Föreningen</a> / <a href="../">Organisation</a> / <span>Tränare</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tranare-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label rr-trainer-overline" aria-hidden="true">Klubbens</p>
          <h1 id="tranare-heading">Tränare</h1>
          <p class="rr-association-lead">Här hittar du Dansklubben Rockrullarnas tränare, assistenter och hjälpdansare uppdelade efter danssektion. Samma person kan ha flera roller i olika dansstilar.</p>

          <div class="rr-trainer-highlights" aria-label="Översikt av tränarteamet">
            <div class="rr-trainer-highlight">
              <strong><?php echo $trainer_people_total; ?></strong>
              <span>personer</span>
            </div>
            <div class="rr-trainer-highlight">
              <strong><?php echo $trainer_assignments_total; ?></strong>
              <span>roller totalt</span>
            </div>
            <div class="rr-trainer-highlight">
              <strong><?php echo count($trainer_sections); ?></strong>
              <span>danssektioner</span>
            </div>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tranare-kontakt-heading">
          <p class="rr-style-label" aria-hidden="true">Kontakt</p>
          <h2 id="tranare-kontakt-heading">Tränarteamet</h2>
          <div class="rr-association-meta">
            <div class="rr-association-meta-item">
              <strong>Kontakt för träningsfrågor</strong>
              <p><a href="mailto:info@rockrullarna.se" title="Mejla till Rockrullarna">info@rockrullarna.se</a></p>
            </div>
            <?php if ($trainer_meta['senastUppdaterad'] !== '') { ?>
              <div class="rr-association-meta-item">
                <strong>Senast uppdaterad</strong>
                <p><?php echo htmlspecialchars($trainer_meta['senastUppdaterad']); ?></p>
              </div>
            <?php } ?>
            <?php if ($trainer_meta['ansvarig'] !== '') { ?>
              <div class="rr-association-meta-item">
                <strong>Ansvarig</strong>
                <p><?php echo htmlspecialchars($trainer_meta['ansvarig']); ?></p>
              </div>
            <?php } ?>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="tranare-sektioner-heading">
        <p class="rr-style-label" aria-hidden="true">Danssektioner</p>
        <h2 id="tranare-sektioner-heading">Klubbens tränare per dansstil</h2>

        <?php if ($trainer_meta['notes'] !== '') { ?>
          <div class="rr-association-note">
            <p><?php echo htmlspecialchars($trainer_meta['notes']); ?></p>
          </div>
        <?php } ?>

        <div class="rr-trainer-sections">
          <?php foreach ($trainer_sections as $sectionName) { ?>
            <?php $sectionCards = array_values($section_members[$sectionName] ?? []); ?>
            <div class="rr-association-roster-block rr-trainer-section" aria-labelledby="tranare-sektion-<?php echo md5($sectionName); ?>">
              <div class="rr-trainer-section-header">
                <h3 id="tranare-sektion-<?php echo md5($sectionName); ?>" class="rr-association-roster-title"><?php echo htmlspecialchars($sectionName); ?></h3>
                <p class="rr-association-roster-meta"><?php echo count($sectionCards); ?> personer</p>
              </div>

              <?php if (!empty($sectionCards)) { ?>
                <div class="rr-trainer-grid" aria-label="<?php echo htmlspecialchars($sectionName); ?> - tränare och assistenter">
                  <?php foreach ($sectionCards as $card) { ?>
                    <?php $memberImage = trim((string) ($card['image'] ?? '')); ?>
                    <article class="rr-trainer-card">
                      <div class="rr-trainer-photo-shell">
                        <?php if ($memberImage !== '') { ?>
                          <img
                            src="<?php echo htmlspecialchars($memberImage); ?>"
                            alt="Porträtt av <?php echo htmlspecialchars($card['name']); ?>"
                            class="rr-trainer-photo"
                            loading="lazy"
                          />
                        <?php } else { ?>
                          <div class="rr-trainer-photo-placeholder" role="img" aria-label="Bild saknas för <?php echo htmlspecialchars($card['name']); ?>">
                            <span>Bild saknas</span>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="rr-trainer-card-content">
                        <h4 class="rr-trainer-name"><?php echo htmlspecialchars($card['name']); ?></h4>
                        <div class="rr-trainer-role-list" aria-label="Roller i <?php echo htmlspecialchars($sectionName); ?>">
                          <?php foreach ($card['roles'] as $roleName) { ?>
                            <span class="rr-trainer-role-pill"><?php echo htmlspecialchars($roleName); ?></span>
                          <?php } ?>
                        </div>
                        <?php if (!empty($card['otherSections'])) { ?>
                          <p class="rr-trainer-cross-sections">Även i: <?php echo htmlspecialchars(implode(', ', $card['otherSections'])); ?></p>
                        <?php } ?>
                      </div>
                    </article>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <p class="rr-social-feed-status">Inga publicerade tränare i denna sektion ännu.</p>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </section>
    </div>
<?php
  include_once '../../../includes/footer.php'
?>