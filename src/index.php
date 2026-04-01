<?php
  $header_title = "";
  $header_description = "Dansklubben Rockrullarna är ideell dansförening som är öppen för alla oavsett ålder, kön, religion eller etnicitet. Vi har kurser inom Bugg (barn, ungdom, vuxen), Fox och West Coast Swing. Vid utvalda tillfällen erbjuder vi även intensivkurser av olika slag. För mer information kontakta oss via e-post info@rockrullarna.se";
  $header_keywords = "bugg,  bugg center,  bugg centrum,  bugg dans,  bugg dans i örebro,  bugg dans örebro,  bugg i örebro,  bugg kurs,  bugg kurser,  bugg nerke,  bugg sverige,  bugg örebro,  bugga i närke,  bugga i sverige,  bugga i örebro,  bugga nerke,  bugga sverige,  bugga örebro,  buggcenter,  buggcenter nerke,  buggcenter sverige,  buggcenter örebro,  buggkurs,  buggkurs i örebro,  buggkurser,  centrum för bugg,  centrum för dans,  centrum för wcs,  dans,  dans center,  dans centrum,  dans kurs,  dans kurser,  dans skola,  dans sport,  dans örebro,  dansa,  dansa bugg,  dansa bugg i örebro,  dansa bugg örebro,  dansa i örebro,  dansa örebro,  danscenter,  dans-center,  danscenter i örebro,  danscenter örebro,  danscentrum,  dans-centrum,  danscentrum i örebro,  danscentrum örebro,  danskurser ,  danskurser i nerke,  danskurser i örebro,  dansskola,  dans-skola,  danssport,  dans-sport,  danssport i örebro,  danssport örebro,  fox dans,  fox kurs,  fox kurser,  foxkurs,  foxtrott,  foxtrott dans,  foxtrott kurs,  foxtrott kurser,  kurs i bugg,  kurs i dans,  kurs i foxtrott,  kurs i wcs,  kurs i west coast swing,  kurser i bugg,  kurser i dans,  kurser i foxtrott,  kurser i wcs,  kurser i west coast swing,  nerke,  närke,  WCS i örebro,  wcs kurs,  wcs kurser,  WCS örebro,  wcskurs,  west coast swing,  west coast swing i örebro,  west coast swing örebro,  west cost swing kurser,  örebro,  örebro bugg,  örebro bugg dans,  örebro buggdans, dans i Örebro, zumba, sumba";


  // Läs innehållet från version.txt
  $versionUrl = 'https://rockrullarna.se/version.txt';
  $versionContent = file_get_contents($versionUrl);

  // Kontrollera om läsningen lyckades
  if ($versionContent === false) {
    // Misslyckades att läsa innehållet från version.txt,
    // skriver ut en hårdkodad version från nu när denna automatiska inläsning lades till
    $page_updated = "2025-08-26 17:26";
  } else {
    // Skriver ut datum och tid från version.txt
    $versionString = $versionContent;

    // Extrahera datum och tid från strängen
    preg_match('/\d{8}\.\d{4}/', $versionString, $matches);

    if (!empty($matches)) {
      $dateTimeString = $matches[0]; // "20250330.2038"
      $date = substr($dateTimeString, 0, 8); // "20250330"
      $time = substr($dateTimeString, 9, 4); // "2038"

      // Omformatera till "YYYY-MM-DD HH:MM"
      $formattedDateTime = substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2) . ' ' . substr($time, 0, 2) . ':' . substr($time, 2, 2);

      $page_updated = $formattedDateTime; // "2025-03-30 20:38"
    } else {
      // Visar datum/tid för senaste version v12.18.20250329
      // om det inte går att läsa innehållet från version.txt
      $page_updated = "2026-02-24 07:56";
    }
  }

  //$page_updated = "2025-03-07 23:05";
  $page_hidden_logo = true; // Dölj "Lär dig dansa hos oss"-bilden på startsidan
  $page_url = "";
  $page_contact_name = "";
  $page_contact_email = "";

  include_once 'includes/header.php'
?>
<?php
  // ── Hero-bilder (slumpmässig vid sidladdning) ──────────────────────────────
  // Platshållare: ersätt src-värdet med faktiska bilder när de finns.
  // Lägg till fler rader för att utöka samlingen (3–5 rekommenderas).
  $hero_images = [
    [
      'bg'    => 'linear-gradient(135deg,#0a1f10 0%,#052010 40%,#0a2818 100%)',
      'label' => 'Danskvällen – Rockrullarna',
    ],
    [
      'bg'    => 'linear-gradient(135deg,#12011f 0%,#200540 40%,#0e0325 100%)',
      'label' => 'Bugg på dansgolvet',
    ],
    [
      'bg'    => 'linear-gradient(135deg,#011524 0%,#022a45 40%,#011828 100%)',
      'label' => 'Fox – elegans i rörelse',
    ],
    [
      'bg'    => 'linear-gradient(135deg,#1a0808 0%,#3a0e0e 40%,#200a0a 100%)',
      'label' => 'West Coast Swing',
    ],
    [
      'bg'    => 'linear-gradient(135deg,#0c1a00 0%,#1a3300 40%,#0e2200 100%)',
      'label' => 'Gemenskap på Rockrullarna',
    ],
  ];
  $hero = $hero_images[array_rand($hero_images)];

  // ── Dansstils-kort (2–5 slumpade bilder per stil) ─────────────────────────
  $style_images = [
    'bugg' => [
      ['bg' => 'linear-gradient(160deg,#1a0040 0%,#2a006a 100%)', 'label' => 'Bugg – nybörjarkurs'],
      ['bg' => 'linear-gradient(160deg,#12003a 0%,#200058 100%)', 'label' => 'Bugg på dansgolvet'],
      ['bg' => 'linear-gradient(160deg,#200050 0%,#380080 100%)', 'label' => 'Bugg friträning'],
    ],
    'fox' => [
      ['bg' => 'linear-gradient(160deg,#001a30 0%,#003060 100%)', 'label' => 'Fox – elegans'],
      ['bg' => 'linear-gradient(160deg,#00121f 0%,#002244 100%)', 'label' => 'Fox-kurs'],
      ['bg' => 'linear-gradient(160deg,#001828 0%,#003558 100%)', 'label' => 'Fox avancerad'],
    ],
    'wcs' => [
      ['bg' => 'linear-gradient(160deg,#001a20 0%,#003040 100%)', 'label' => 'West Coast Swing'],
      ['bg' => 'linear-gradient(160deg,#001216 0%,#002230 100%)', 'label' => 'WCS social dance'],
      ['bg' => 'linear-gradient(160deg,#00181e 0%,#002d3a 100%)', 'label' => 'WCS kurs'],
    ],
  ];
  $bugg = $style_images['bugg'][array_rand($style_images['bugg'])];
  $fox  = $style_images['fox'][array_rand($style_images['fox'])];
  $wcs  = $style_images['wcs'][array_rand($style_images['wcs'])];
?>
    <!-- Hero – bildfokuserad ──────────────────────────────────────────── -->
    <section class="rr-hero" aria-label="Välkommen till Dansklubben Rockrullarna">
      <div class="rr-hero-bg" style="background: <?= htmlspecialchars($hero['bg']) ?>;" role="img" aria-label="<?= htmlspecialchars($hero['label']) ?>"></div>
      <div class="rr-hero-overlay"></div>
      <div class="container rr-hero-content">
        <span class="rr-hero-badge">
          <span class="rr-hero-dot" aria-hidden="true"></span>
          Örebros dansgemenskap sedan 1983
        </span>
        <h1 id="hero-heading">Dans&shy;glädjens<br>hem i <em>Örebro</em></h1>
        <p>En ideell förening för alla som vill lära sig dansa Bugg, Fox och West Coast Swing — i en varm och välkomnande gemenskap.</p>
        <div class="d-flex flex-wrap gap-3">
          <a class="rr-btn-inline" style="font-size:1rem; padding:0.7rem 1.8rem;" href="/danskurser/anmalan-danskurser" title="Anmäl dig till Rockrullarnas danskurser">Anmäl dig till kurs</a>
          <a href="#dansstilar" style="color:rgba(255,255,255,0.75); display:inline-flex; align-items:center; text-decoration:none; font-weight:500; gap:0.4rem; font-size:0.95rem;">
            Utforska dansstilar <span aria-hidden="true">↓</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Dansstilar – tre kort ──────────────────────────────────────────── -->
    <section id="dansstilar" class="rr-style-section" aria-labelledby="dansstilar-heading">
      <p class="rr-style-label" aria-hidden="true">Våra dansstilar</p>
      <div class="row align-items-end mb-3">
        <div class="col-12 col-md-8">
          <h2 id="dansstilar-heading">Tre stilar, <em>ett hjärta</em></h2>
          <p style="color:var(--b-muted); margin-top:0.3rem;">Kurser för nybörjare till avancerade — välj den stil som lockar dig!</p>
        </div>
        <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
          <a href="/danskurser" class="rr-btn-inline" title="Visa alla danskurser">Visa alla kurser</a>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <a href="/danskurser/kursoversikt/bugg" class="rr-style-card" title="Läs mer om Bugg">
            <div class="rr-style-card-bg" style="background: <?= htmlspecialchars($bugg['bg']) ?>;" role="img" aria-label="<?= htmlspecialchars($bugg['label']) ?>">
              <div class="rr-style-card-overlay"></div>
            </div>
            <div class="rr-style-card-body">
              <span class="rr-style-card-icon" aria-hidden="true">💃</span>
              <h3 class="rr-style-card-title">Bugg</h3>
              <p class="rr-style-card-desc">Sveriges folkligaste pardans — social och rolig</p>
              <span class="rr-btn-inline">Läs mer →</span>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="/danskurser/kursoversikt/fox" class="rr-style-card" title="Läs mer om Fox">
            <div class="rr-style-card-bg" style="background: <?= htmlspecialchars($fox['bg']) ?>;" role="img" aria-label="<?= htmlspecialchars($fox['label']) ?>">
              <div class="rr-style-card-overlay"></div>
            </div>
            <div class="rr-style-card-body">
              <span class="rr-style-card-icon" aria-hidden="true">🎩</span>
              <h3 class="rr-style-card-title">Fox</h3>
              <p class="rr-style-card-desc">Dynamisk och elegant med tidlöst uttryck</p>
              <span class="rr-btn-inline">Läs mer →</span>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="/danskurser/kursoversikt/west-coast-swing" class="rr-style-card" title="Läs mer om West Coast Swing">
            <div class="rr-style-card-bg" style="background: <?= htmlspecialchars($wcs['bg']) ?>;" role="img" aria-label="<?= htmlspecialchars($wcs['label']) ?>">
              <div class="rr-style-card-overlay"></div>
            </div>
            <div class="rr-style-card-body">
              <span class="rr-style-card-icon" aria-hidden="true">🎵</span>
              <h3 class="rr-style-card-title">West Coast Swing</h3>
              <p class="rr-style-card-desc">Modern, musikalisk och improviserad</p>
              <span class="rr-btn-inline">Läs mer →</span>
            </div>
          </a>
        </div>
      </div>
    </section>

    <section class="py-4 mb-4 border-bottom" aria-labelledby="intro-heading">
      <div class="row align-items-center g-4">
        <div class="col-12 col-lg-7">
          <h2 id="intro-heading" class="display-5 fw-bold">Dansklubben Rockrullarna</h2>
          <p class="lead">
            Välkommen till dansglädjen hos vår ideella dansförening i Örebro! Våra primära dansstilar är
            <a href="/danskurser/kursoversikt/bugg" title="Gå till översiktssidan för Bugg"><strong>Bugg</strong></a>,
            <a href="/danskurser/kursoversikt/fox" title="Gå till översiktssidan för Fox"><strong>Fox</strong></a> och
            <a href="/danskurser/kursoversikt/west-coast-swing" title="Gå till översiktssidan för West Coast Swing"><strong>West Coast Swing</strong></a>.
          </p>
          <p class="mb-3">Klubben är till för dig som medlem. Vi som dansar här ställer alla upp ideellt och lär varandra.</p>
          <div class="d-flex flex-wrap gap-2 mb-3" aria-label="Snabbknappar">
            <a class="btn btn-primary btn-lg" role="button" href="/danskurser/anmalan-danskurser" title="Anmäl dig till Rockrullarnas danskurser">Anmäl dig nu</a>
            <a class="btn btn-outline-secondary d-inline-flex align-items-center" role="button" href="/danskurser" title="Läs mer om våra danskurser">Utforska kurser</a>
            <a class="btn btn-outline-secondary d-inline-flex align-items-center" role="button" href="/bli-medlem" title="Bli stödmedlem i Dansklubben Rockrullarna">Bli stödmedlem</a>
          </div>
        </div>
      </div>
    </section>
    <div class="row">
      <section id="start-activity" class="col-12 col-lg-6 text-center" aria-labelledby="lar-dig-dansa-heading">
        <h2 id="lar-dig-dansa-heading">
          <svg class="bi me-2 header-icon"><use href="#music-note-beamed"></use></svg>
          Lär dig att dansa!
          <svg class="bi me-2 header-icon"><use href="#music-note-beamed"></use></svg>
        </h2>
        <p class="mb-3">
          Vill du lära dig dansa Bugg, Fox eller West Coast Swing? Anmäl dig till våra kurser eller läs mer om hur vi hjälper dig utvecklas.
        </p>
        <p class="mb-4">
          <a class="btn btn-primary btn-lg mb-2" role="button" href="/danskurser/anmalan-danskurser" title="Anmälan till Rockrullarnas danskurser och aktiviteter">Jag vill anmäla mig till danskurs</a>
          <a class="btn btn-outline-secondary" role="button" href="/danskurser" title="Lär dig mer om Rockrullarnas danskurser och aktiviteter">Om våra kurser</a>
        </p>
        <h2>
          <svg class="bi me-2 header-icon"><use href="#person-heart"></use></svg>
          Bli stödmedlem
        </h2>
        <p class="mb-1">
          Bli stödmedlem snabbt och enkelt via sidan <a class="fw-semibold" href="/bli-medlem" title="Bli stödmedlem i Dansklubben Rockrullarna">bli medlem</a>.
        </p>
        <p class="mb-1">
          Du får instruktioner för direktbetalning via Swish eller bankgiro.
        </p>
        <p class="mb-5">
          När betalningen registrerats är ditt medlemskap aktivt (vanligen inom en vecka).
        </p>
        <h2 id="nyheter-heading">
          <svg class="bi me-2 header-icon"><use href="#newspaper"></use></svg>
          Nyheter
        </h2>
        <div class="mb-4">
          <h3 id="arsmote-heading" class="h5 mb-2">Årsmöte 2026-03-28</h3>
          <p class="mb-2">Information om årsmötet hittar du på sidan: <a href="/foreningen/moten-och-protokoll/arsmote" title="Information om årsmötet 2026" target="_self">Föreningen / Möten och protokoll / Årsmöte 2026</a>.</p>
        </div>
        <div class="mb-4">
          <h3 id="betalningar-heading" class="h5 mb-2">Betalningar & rabatter</h3>
          <p class="mb-2">Information om friskvårdsintyg, studentrabatter och betalningssätt finns på vår <a href="https://rockrullarna.se/danskurser/betalning/#studentrabatt">sida om betalningar</a>.</p>
        </div>
        <div class="mb-5">
          <h3 id="fler-uppdateringar-heading" class="h5 mb-2">Fler uppdateringar</h3>
          <p class="mb-3">Följ våra kanaler för löpande nyheter, bilder och evenemang.</p>
          <a class="btn btn-outline-secondary" role="button" href="/sociala-media" title="Sociala media">
            <svg width="16" height="16" fill="currentColor" class="bi bi-facebook"><use href="#facebook"></use></svg>
            Sociala media
            <svg width="16" height="16" fill="currentColor" class="bi bi-tiktok"><use href="#tiktok"></use></svg>
          </a>
        </div>
        <figure class="text-end mb-5">
          <blockquote class="blockquote">
            <p>"Rockrullarna erbjuder en varm gemenskap och glädje."</p>
          </blockquote>
          <figcaption class="blockquote-footer">
            Medlem hos <cite title="Source Title">Dansklubben Rockrullarna</cite>
          </figcaption>
        </figure>
      </section>
      <section id="start-news" class="col-12 col-lg-6 text-center" aria-labelledby="aktiviteter-heading">
        <h2 id="aktiviteter-heading">
          <svg class="bi me-2 header-icon"><use href="#calendar-week"></use></svg>
          Kommande aktiviteter
        </h2>
        <p>
          Här hittar du våra kommande aktiviteter från <a href="/aktivitetskalender">Aktivitetskalendern</a>.
        </p>
        <p>
          Vill du anmäla dig till någon av våra aktiviteter eller kurser, kan du göra detta via sidan:
          <br />
          <strong>
            <a href="/danskurser/anmalan-danskurser" title="Anmälan till Rockrullarnas danskurser och aktiviteter">Anmälan till danskurser</a>
          </strong>
        </p>
        <div id="rr-kalender" data-mode="compact" data-days="180" data-limit="500" aria-label="Kommande aktiviteter"></div>
        <script src="/filer/js/aktivitetskalender.js"></script>
        <p class="mt-3">
          <a class="btn btn-outline-secondary" role="button" href="/aktivitetskalender" title="Visa alla aktiviteter i Aktivitetskalendern">Visa alla aktiviteter</a>
        </p>
      </section>
    </div>

    <!-- Bootstrap Icons symbols, from: https://icons.getbootstrap.com/ -->
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <!-- /*** Homepage icons ***/ -->
    <!-- https://icons.getbootstrap.com/icons/person-heart -->
    <symbol id="person-heart" viewBox="0 0 16 16">
      <path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
    </symbol>
    <!-- https://icons.getbootstrap.com/icons/music-note-beamed -->
    <symbol id="music-note-beamed" viewBox="0 0 16 16">
      <path d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2zm9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2z"/>
      <path fill-rule="evenodd" d="M14 11V2h1v9h-1zM6 3v10H5V3h1z"/>
      <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4V2.905z"/>
    </symbol>
    <!-- https://icons.getbootstrap.com/icons/calendar-week -->
    <symbol id="calendar-week" viewBox="0 0 16 16">
      <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
    </symbol>
    <!-- https://icons.getbootstrap.com/icons/newspaper -->
    <symbol id="newspaper" viewBox="0 0 16 16">
      <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5v-11zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5H12z"/>
      <path d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z"/>
    </symbol>
  </svg><!-- End of Bootstrap Icons symbols -->
<?php
  include_once 'includes/footer.php'
?>