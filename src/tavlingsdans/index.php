<?php
  $header_title = "Tävlingsdans";
  $header_description = "Här hittar du information om vår tävlingsdans";

  $page_updated = "2026-07-10 22:10";
  $page_url = "/tavlingsdans";
  $page_contact_name = "Tävlingsansvarig";
  $page_contact_email = "tavlingsansvarig@rockrullarna.se";

  $media_video_embed_url = "";
  $media_video_title = "YouTube-video med tävlingsdans och West Coast Swing";
  $media_video_heading = "Från träningsgolv till tävlingsgolv";
  $media_video_description = "Här får du en känsla för uttryck, teknik och närvaro som växer fram när man tränar målmedvetet tillsammans.";

  $has_media_video = trim($media_video_embed_url) !== "";
  $media_layout_class = $has_media_video
    ? "rr-courses-media-layout"
    : "rr-courses-media-layout rr-courses-media-layout--gallery-only";

  include_once '../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-competition-page">
      <div id="BreadCrumbsDiv">
        <a href="../">Rockrullarna.se</a> / <span>Tävlingsdans</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="tavlingsdans-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Bugg, Fox och West Coast Swing</p>
          <h1 id="tavlingsdans-heading">Tävlingsdans med fokus på <em>utveckling</em> och startglädje</h1>
          <p class="rr-association-lead">
            Rockrullarna erbjuder tävlingsinriktade satsningar inom Bugg, Fox och West Coast Swing.
            Här får danspar utveckla teknik, uttryck och mental förberedelse inför tävlingsgolvet.
          </p>
          <p class="rr-association-lead">
            I sektionen hittar du kalender, anmälda par, resultat och praktisk information om de
            system som används i tävlingssammanhang.
          </p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="./kalender" title="Öppna tävlingskalendern">Tävlingskalender</a>
            <a class="rr-btn-inline" href="#tavlingsdans-media-heading" title="Se bilder från tävlingsdans">Se bilder och inspiration</a>
            <a class="rr-btn-inline" href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">Kontakta tävlingsansvarig</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="tavlingsdans-snabblankar-heading">
          <p class="rr-style-label" aria-hidden="true">Snabbt vidare</p>
          <h2 id="tavlingsdans-snabblankar-heading">Vanliga ingångar</h2>
          <ul class="rr-association-list">
            <li><strong>Planera starter</strong><br /><a href="./kalender" title="Se tävlingskalendern">Tävlingskalender</a></li>
            <li><strong>Följ klubbens starter</strong><br /><a href="./vilka-tavlar-vart" title="Se vilka som tävlar vart">Vilka tävlar vart?</a></li>
            <li><strong>Se historik</strong><br /><a href="./resultat" title="Se tävlingsresultat">Tävlingsresultat</a></li>
          </ul>
          <div class="rr-association-note">
            <p><strong>Kontakt:</strong> Mejla <a href="mailto:tavlingsansvarig@rockrullarna.se" title="Maila tävlingsansvarig">tavlingsansvarig@rockrullarna.se</a> om du har frågor om starter, anmälningar eller tävlingsupplägg.</p>
          </div>
        </aside>
      </section>

      <!-- <section class="rr-association-card rr-association-card--section" aria-labelledby="tavlingsdans-overview-heading">
        <p class="rr-style-label" aria-hidden="true">Kort om satsningen</p>
        <h2 id="tavlingsdans-overview-heading">Det här hittar du i sektionen</h2>
        <div class="rr-competition-stats">
          <div class="rr-association-meta-item"><strong>Tävlingsformer</strong>Bugg, Fox och West Coast Swing</div>
          <div class="rr-association-meta-item"><strong>För dig som</strong>vill planera starter, följa tävlingar och hitta praktisk information</div>
          <div class="rr-association-meta-item"><strong>Systemstöd</strong>dans.se för anmälningar och Vote4Dance för liveinformation och resultat</div>
          <div class="rr-association-meta-item"><strong>Extern översikt</strong><a href="https://www.danssport.se/kalender/kalender/" title="Öppna DSF (Klicka på Tävlingskalender)" target="_blank" rel="noopener">DSF Tävlingskalender</a></div>
        </div>
      </section> -->

      <section id="film-och-bilder" class="rr-courses-links-section rr-courses-detail-section" aria-labelledby="tavlingsdans-media-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Film och bilder</p>
            <h2 id="tavlingsdans-media-heading">Känn pulsen i <em>tävlingsdansen</em></h2>
          </div>
        </div>

        <div class="<?= htmlspecialchars($media_layout_class, ENT_QUOTES, 'UTF-8') ?>">
          <?php if ($has_media_video): ?>
          <article class="rr-courses-media-feature">
            <div class="rr-courses-media-copy">
              <div class="rr-iframe-responsive">
                <iframe src="<?= htmlspecialchars($media_video_embed_url, ENT_QUOTES, 'UTF-8') ?>" title="<?= htmlspecialchars($media_video_title, ENT_QUOTES, 'UTF-8') ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
              <h3><?= htmlspecialchars($media_video_heading, ENT_QUOTES, 'UTF-8') ?></h3>
              <p><?= htmlspecialchars($media_video_description, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          </article>
          <?php endif; ?>

          <div class="rr-courses-media-gallery" aria-label="Bilder från tävlingsdans">

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-1.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-1.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-2.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-2.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-3.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-3.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-4.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-4.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-5.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-5.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-6.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-6.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-7.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-7.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-8.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-8.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-9.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-9.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-10.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-10.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-11.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-11.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-12.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-12.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-13.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-13.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-14.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-14.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-15.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-15.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/tavling/tavling-16.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/tavling/tavling-16.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">På golvet</span>
              </div>
            </button>

            <button class="rr-courses-media-thumb rr-courses-media-thumb-btn" data-image-url="/filer/bilder/webb/fox/tavling.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" style="background-image: url('/filer/bilder/webb/fox/tavling.jpg'), radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 34%), linear-gradient(145deg, rgba(0,171,214,0.42), rgba(0,32,72,0.8)); background-size: cover, auto, auto; background-position: center, right top, 0 0; background-repeat: no-repeat, no-repeat, no-repeat;" title="Klicka för att visa bilden i fullskärm">
              <div class="rr-courses-media-copy">
                <span class="rr-courses-media-tag">Fox tävling</span>
              </div>
            </button>
          </div>
        </div>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="tavlingsdans-links-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Navigera vidare</p>
            <h2 id="tavlingsdans-links-heading">Sidor om <em>tävlingsdans</em></h2>
          </div>
        </div>

        <div class="rr-courses-links-grid">
          <a class="rr-courses-link-card" href="./kalender" title="Öppna tävlingskalendern">
            <span class="rr-courses-link-kicker">Planera säsongen</span>
            <h3>Tävlingskalender</h3>
            <p>Se kommande tävlingar via dans.se och öppna hela kalendern i eget fönster om du vill.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./vilka-tavlar-vart" title="Se vilka som tävlar vart">
            <span class="rr-courses-link-kicker">Kommande starter</span>
            <h3>Vilka tävlar vart?</h3>
            <p>Följ vilka tävlande från Rockrullarna som är anmälda till kommande tävlingar.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./resultat" title="Se tävlingsresultat">
            <span class="rr-courses-link-kicker">Historik</span>
            <h3>Tävlingsresultat</h3>
            <p>Bläddra bland tidigare resultat från tävlingar där klubbens tävlande deltagit.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./dans.se" title="Läs om dans.se">
            <span class="rr-courses-link-kicker">Systemguide</span>
            <h3>dans.se</h3>
            <p>Läs mer om konton, anmälningar och varför dans.se är centralt i tävlingsflödet.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="./vote4dance" title="Läs om Vote4Dance">
            <span class="rr-courses-link-kicker">Resultat och live</span>
            <h3>Vote4Dance</h3>
            <p>Få koll på appen och tjänsten som används för liveinformation, resultat och startlistor.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
          <a class="rr-courses-link-card" href="https://www.danssport.se/kalender/kalender/" title="Öppna DSF Tävlingskalender" target="_blank" rel="noopener">
            <span class="rr-courses-link-kicker">Extern resurs</span>
            <h3>DSF Tävlingskalender</h3>
            <p>Gå vidare till förbundets egen kalender för en bredare överblick över tävlingar (klicka där på "Tävlingskalender").</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
        </div>
      </section>

      <section class="rr-courses-links-section" aria-labelledby="tavlingsdans-courses-heading">
        <div class="rr-courses-links-header">
          <div>
            <p class="rr-style-label" aria-hidden="true">Kurser via dans.se</p>
            <h2 id="tavlingsdans-courses-heading">Tävlingsrelevanta <em>kurser</em> och träning</h2>
          </div>
        </div>

        <div class="rr-courses-utility-grid">
          <a class="rr-courses-link-card" href="https://dans.se/rockrullarna/shop/?lang=sv;showPrice=1;cat=bugg;reset" title="Öppna buggkurser på dans.se" target="_blank" rel="noopener">
            <span class="rr-courses-link-kicker">Teknik och tempo</span>
            <h3>Buggkurser på dans.se</h3>
            <p>För dig som vill bygga trygg teknik, bättre tajming och tävlingsmässig kvalitet i buggen.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>

          <a class="rr-courses-link-card" href="https://dans.se/rockrullarna/shop/?lang=sv;showPrice=1;&catId=207;reset" title="Öppna foxkurser på dans.se" target="_blank" rel="noopener">
            <span class="rr-courses-link-kicker">Flyt och musikalitet</span>
            <h3>Foxkurser på dans.se</h3>
            <p>Kurser för dig som vill stärka kontakt, balans och uttryck som även hjälper i tävlingssammanhang.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>

          <a class="rr-courses-link-card" href="https://dans.se/rockrullarna/shop/?lang=sv;showPrice=1;cat=dance_West_Coast_Swing;reset" title="Öppna WCS-kurser på dans.se" target="_blank" rel="noopener">
            <span class="rr-courses-link-kicker">Precision och kreativitet</span>
            <h3>WCS-kurser på dans.se</h3>
            <p>Passar dig som vill utveckla connection, improvisation och musikalitet i en modern tävlingsstil.</p>
            <span class="rr-courses-link-arrow" aria-hidden="true">&rarr;</span>
          </a>
        </div>

        <div class="rr-courses-note mt-3">
          <p>Hittar du inte det du söker just nu? Se hela utbudet på <a href="../kurser" title="Öppna Rockrullarnas kursutbud på rockrullarna.se" target="_blank" rel="noopener">rockrullarna.se/kurser</a> och filtrera efter nivå, stil och termin.</p>
        </div>
      </section>
    </div>
<?php
  include_once '../includes/modal-image-viewer.php';

  include_once '../includes/footer.php'
?>