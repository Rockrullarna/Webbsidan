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
  // Platshållare från Unsplash (https://unsplash.com/license – gratis att använda).
  // Ersätt 'img'-URL med egna bilder när sådana finns.
  // Unsplash-parametrar: w=1400 – bredd; auto=format – väljer bästa format; q=80 – kvalitet.
  $hero_images = [
    [
      'img'   => 'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?auto=format&fit=crop&w=1400&q=80',
      'color' => '#0d1117',
      'label' => 'Pardans – Danskvällen på Rockrullarna',
      'credit_url'  => 'https://unsplash.com/photos/photo-1504609813442-a8924e83f76e',
      'credit_name' => 'Unsplash',
    ],
    [
      'img'   => 'https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=1400&q=80',
      'color' => '#0a0a14',
      'label' => 'Social dans – Bugg på dansgolvet',
      'credit_url'  => 'https://unsplash.com/photos/photo-1547153760-18fc86324498',
      'credit_name' => 'Unsplash',
    ],
    [
      'img'   => 'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?auto=format&fit=crop&w=1400&q=80',
      'color' => '#080c10',
      'label' => 'Balsal – Fox och elegant dans',
      'credit_url'  => 'https://unsplash.com/photos/photo-1578301978693-85fa9c0320b9',
      'credit_name' => 'Unsplash',
    ],
    [
      'img'   => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=1400&q=80',
      'color' => '#090916',
      'label' => 'Dansgolvet – Rockrullarna i rörelse',
      'credit_url'  => 'https://unsplash.com/photos/photo-1516450360452-9312f5e86fc7',
      'credit_name' => 'Unsplash',
    ],
    [
      'img'   => 'https://images.unsplash.com/photo-1535525153412-5a42439a210d?auto=format&fit=crop&w=1400&q=80',
      'color' => '#0c0810',
      'label' => 'Dansuppvisning – West Coast Swing',
      'credit_url'  => 'https://unsplash.com/photos/photo-1535525153412-5a42439a210d',
      'credit_name' => 'Unsplash',
    ],
  ];
  $hero = $hero_images[array_rand($hero_images)];

  // ── Dansstils-kort (3 slumpade bilder per stil) ───────────────────────────
  // Lägg till fler poster per stil för mer variation (2–5 rekommenderas).
  $style_images = [
    'bugg' => [
      [
        'img'   => 'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#0d0020',
        'label' => 'Bugg – pardans i nära omfamning',
      ],
      [
        'img'   => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#10001a',
        'label' => 'Bugg – nybörjarkurs hos Rockrullarna',
      ],
      [
        'img'   => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#0a0014',
        'label' => 'Bugg – social dans för alla nivåer',
      ],
    ],
    'fox' => [
      [
        'img'   => 'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#001020',
        'label' => 'Fox – elegant balsalsdans',
      ],
      [
        'img'   => 'https://images.unsplash.com/photo-1574680178050-55c6a6a96e0a?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#001018',
        'label' => 'Fox – smooth och dynamisk dans',
      ],
      [
        'img'   => 'https://images.unsplash.com/photo-1508700929628-666bc8bd84ea?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#00131f',
        'label' => 'Fox – kurs för nybörjare och avancerade',
      ],
    ],
    'wcs' => [
      [
        'img'   => 'https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#001a18',
        'label' => 'West Coast Swing – modern slot-dans',
      ],
      [
        'img'   => 'https://images.unsplash.com/photo-1614680376573-df3480f0c6ff?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#001618',
        'label' => 'WCS – musikalisk och improviserad',
      ],
      [
        'img'   => 'https://images.unsplash.com/photo-1535525153412-5a42439a210d?auto=format&fit=crop&w=700&h=900&q=80',
        'color' => '#0c0818',
        'label' => 'West Coast Swing – social dance',
      ],
    ],
  ];
  $bugg = $style_images['bugg'][array_rand($style_images['bugg'])];
  $fox  = $style_images['fox'][array_rand($style_images['fox'])];
  $wcs  = $style_images['wcs'][array_rand($style_images['wcs'])];
?>
    <!-- Hero – bildfokuserad ────────────────────────────────────────────── -->
    <section class="rr-hero" aria-label="Välkommen till Dansklubben Rockrullarna">
      <div class="rr-hero-bg"
           style="background-image: url('<?= htmlspecialchars($hero['img']) ?>'); background-color: <?= htmlspecialchars($hero['color']) ?>;"
           role="img"
           aria-label="<?= htmlspecialchars($hero['label']) ?>"></div>
      <div class="rr-hero-overlay" aria-hidden="true"></div>
      <div class="container rr-hero-content">
        <span class="rr-hero-badge">
          <span class="rr-hero-dot" aria-hidden="true"></span>
          Örebros dansgemenskap sedan 1983
        </span>
        <h1 id="hero-heading">Dans&shy;glädjens<br>hem i <em>Örebro</em></h1>
        <p class="rr-hero-lead">En ideell förening för alla som vill lära sig dansa Bugg, Fox och West Coast Swing — i en varm och välkomnande gemenskap.</p>
        <div class="rr-hero-actions">
          <a class="rr-hero-btn" href="/danskurser/anmalan-danskurser" title="Anmäl dig till Rockrullarnas danskurser">Anmäl dig till kurs</a>
          <a class="rr-hero-link" href="#dansstilar">
            Utforska dansstilar <span class="rr-hero-scroll" aria-hidden="true">↓</span>
          </a>
        </div>
      </div>
      <a class="rr-hero-credit"
         href="<?= htmlspecialchars($hero['credit_url']) ?>"
         target="_blank"
         rel="noopener noreferrer"
         title="Foto: <?= htmlspecialchars($hero['credit_name']) ?>">
        Foto: <?= htmlspecialchars($hero['credit_name']) ?>
      </a>
    </section>

    <!-- Dansstilar – tre kort ───────────────────────────────────────────── -->
    <section id="dansstilar" class="rr-style-section" aria-labelledby="dansstilar-heading">
      <p class="rr-style-label" aria-hidden="true">Våra dansstilar</p>
      <div class="row align-items-end mb-4">
        <div class="col-12 col-md-8">
          <h2 id="dansstilar-heading">Tre stilar, <em>ett hjärta</em></h2>
          <p style="color:var(--b-muted); margin-top:0.25rem; font-size:0.95rem;">Kurser för nybörjare till avancerade — välj den stil som lockar dig!</p>
        </div>
        <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
          <a href="/danskurser" class="rr-btn-inline" title="Visa alla danskurser">Visa alla kurser</a>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <a href="/danskurser/kursoversikt/bugg" class="rr-style-card" title="Läs mer om Bugg">
            <div class="rr-style-card-bg"
                 style="background-image: url('<?= htmlspecialchars($bugg['img']) ?>'); background-color: <?= htmlspecialchars($bugg['color']) ?>;"
                 role="img"
                 aria-label="<?= htmlspecialchars($bugg['label']) ?>"></div>
            <div class="rr-style-card-overlay" aria-hidden="true"></div>
            <div class="rr-style-card-body">
              <span class="rr-style-card-cat">Pardans</span>
              <h3 class="rr-style-card-title">Bugg</h3>
              <p class="rr-style-card-desc">Sveriges folkligaste pardans — social, energisk och rolig för alla.</p>
              <span class="rr-style-card-link">Läs mer <span aria-hidden="true">→</span></span>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="/danskurser/kursoversikt/fox" class="rr-style-card" title="Läs mer om Fox">
            <div class="rr-style-card-bg"
                 style="background-image: url('<?= htmlspecialchars($fox['img']) ?>'); background-color: <?= htmlspecialchars($fox['color']) ?>;"
                 role="img"
                 aria-label="<?= htmlspecialchars($fox['label']) ?>"></div>
            <div class="rr-style-card-overlay" aria-hidden="true"></div>
            <div class="rr-style-card-body">
              <span class="rr-style-card-cat">Balsal</span>
              <h3 class="rr-style-card-title">Fox</h3>
              <p class="rr-style-card-desc">Dynamisk och elegant — en tidlös pardans med smidiga rörelser.</p>
              <span class="rr-style-card-link">Läs mer <span aria-hidden="true">→</span></span>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="/danskurser/kursoversikt/west-coast-swing" class="rr-style-card" title="Läs mer om West Coast Swing">
            <div class="rr-style-card-bg"
                 style="background-image: url('<?= htmlspecialchars($wcs['img']) ?>'); background-color: <?= htmlspecialchars($wcs['color']) ?>;"
                 role="img"
                 aria-label="<?= htmlspecialchars($wcs['label']) ?>"></div>
            <div class="rr-style-card-overlay" aria-hidden="true"></div>
            <div class="rr-style-card-body">
              <span class="rr-style-card-cat">Swing</span>
              <h3 class="rr-style-card-title">West Coast Swing</h3>
              <p class="rr-style-card-desc">Modern, musikalisk och improviserad — dans som lever med musiken.</p>
              <span class="rr-style-card-link">Läs mer <span aria-hidden="true">→</span></span>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- Intro band ────────────────────────────────────────────────── -->
    <section class="rr-intro-band" aria-labelledby="intro-heading">
      <div class="row align-items-center g-4">
        <div class="col-12 col-lg-8">
          <h2 id="intro-heading">Dansklubben Rockrullarna</h2>
          <p class="rr-intro-lead">
            Välkommen till dansglädjen hos vår ideella dansförening i Örebro! Våra primära dansstilar är
            <a href="/danskurser/kursoversikt/bugg" title="Gå till översiktssidan för Bugg"><strong>Bugg</strong></a>,
            <a href="/danskurser/kursoversikt/fox" title="Gå till översiktssidan för Fox"><strong>Fox</strong></a> och
            <a href="/danskurser/kursoversikt/west-coast-swing" title="Gå till översiktssidan för West Coast Swing"><strong>West Coast Swing</strong></a>.
            Klubben är till för dig som medlem — vi ställer alla upp ideellt och lär varandra.
          </p>
        </div>
        <div class="col-12 col-lg-4 rr-intro-actions" aria-label="Snabbknappar">
          <a class="rr-hero-btn" href="/danskurser/anmalan-danskurser" title="Anmäl dig till Rockrullarnas danskurser">Anmäl dig nu</a>
          <a class="rr-btn-inline" href="/danskurser" title="Läs mer om våra danskurser">Utforska kurser</a>
          <a class="rr-btn-inline" href="/bli-medlem" title="Bli stödmedlem i Dansklubben Rockrullarna">Bli stödmedlem</a>
        </div>
      </div>
    </section>

    <section class="rr-brand-strip" aria-labelledby="brand-strip-heading">
      <div class="row g-4 align-items-stretch">
        <div class="col-12 col-lg-8">
          <article class="rr-brand-card rr-brand-photo-card">
            <picture>
              <source type="image/webp" srcset="/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.webp" />
              <source type="image/jpeg" srcset="/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.jpg" />
              <img src="/filer/bilder/Rockrullarna-lar-dig-dansa-hos-oss.jpg" alt="Lär dig dansa hos Rockrullarna" class="rr-brand-photo" />
            </picture>
          </article>
        </div>
        <div class="col-12 col-lg-4">
          <aside class="rr-brand-card rr-brand-logo-card" aria-labelledby="brand-strip-heading">
            <p class="rr-style-label" aria-hidden="true">Välkommen till klubben</p>
            <h2 id="brand-strip-heading">Dansglädje, <em>gemenskap</em> och kurser</h2>
            <p class="rr-brand-copy">Hos Rockrullarna möts kurskvällar, socialdans och gemenskap i Haga Centrum. Här finns plats för både första stegen och många timmar på dansgolvet.</p>
            <div class="rr-brand-logo-wrap">
              <img src="/filer/bilder/rockrullarna-svg-logga.svg" alt="Rockrullarnas logotyp" class="rr-brand-logo-img" />
            </div>
          </aside>
        </div>
      </div>
    </section>

      <section class="rr-activity-section" aria-labelledby="startsida-section-heading">
        <div class="row g-5 align-items-start">
          <div class="col-12 col-lg-5">
            <p class="rr-style-label" aria-hidden="true">Gemenskap och kurser</p>
            <h2 id="startsida-section-heading">Allt du behöver för att <em>komma igång</em></h2>
            <p class="rr-activity-lead">
              Vill du lära dig dansa Bugg, Fox eller West Coast Swing? Hos oss hittar du kurser,
              aktiviteter och en varm gemenskap som gör det enkelt att komma in i dansen.
            </p>

            <div class="rr-activity-actions" aria-label="Snabbval för startsidan">
              <a class="rr-hero-btn" href="/danskurser/anmalan-danskurser" title="Anmälan till Rockrullarnas danskurser och aktiviteter">Jag vill anmäla mig</a>
              <a class="rr-btn-inline" href="/danskurser" title="Lär dig mer om Rockrullarnas danskurser och aktiviteter">Om våra kurser</a>
            </div>

            <blockquote class="rr-blockquote">
              <p>"Rockrullarna erbjuder en varm gemenskap och glädje. Hit vill man komma tillbaka."</p>
              <footer>Medlem hos <cite>Dansklubben Rockrullarna</cite></footer>
            </blockquote>

            <div class="rr-feature-list" aria-label="Fördelar med Rockrullarna">
              <div class="rr-feature-item">
                <span class="rr-feature-marker" aria-hidden="true"></span>
                <div>
                  <strong>Ideell förening</strong>
                  <p>Vi ställer upp för varandra och bygger verksamheten tillsammans.</p>
                </div>
              </div>
              <div class="rr-feature-item">
                <span class="rr-feature-marker" aria-hidden="true"></span>
                <div>
                  <strong>Alla nivåer</strong>
                  <p>Kurser för nybörjare, fortsättning och dig som vill utvecklas vidare.</p>
                </div>
              </div>
              <div class="rr-feature-item">
                <span class="rr-feature-marker" aria-hidden="true"></span>
                <div>
                  <strong>Alla välkomna</strong>
                  <p>Oavsett ålder, bakgrund eller tidigare erfarenhet finns det en plats för dig.</p>
                </div>
              </div>
            </div>

            <div class="rr-membership-card">
              <div>
                <p class="rr-membership-label">Stöd klubben</p>
                <h3 class="rr-membership-title">Bli stödmedlem</h3>
                <p>
                  Bli stödmedlem snabbt och enkelt via sidan <a href="/bli-medlem" title="Bli stödmedlem i Dansklubben Rockrullarna">bli medlem</a>.
                  Du får instruktioner för direktbetalning via Swish eller bankgiro, och medlemskapet är normalt aktivt inom en vecka.
                </p>
                <a class="rr-btn-inline" href="/bli-medlem" title="Bli stödmedlem i Dansklubben Rockrullarna">Bli stödmedlem</a>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-7">
            <div class="rr-activity-panel">
              <div class="rr-activity-panel-header">
                <div>
                  <p class="rr-style-label" aria-hidden="true">Aktiviteter</p>
                  <h2 id="aktiviteter-heading">Kommande <em>aktiviteter</em></h2>
                </div>
                <a class="rr-btn-inline" href="/aktivitetskalender" title="Visa aktivitetskalendern">Hela kalendern</a>
              </div>

              <div class="rr-event-list">
                <article class="rr-event-card" aria-labelledby="arsmote-heading">
                  <div class="rr-event-card-top">
                    <div class="rr-event-date-badge">
                      <div class="rr-edb-day">28</div>
                      <div class="rr-edb-mon">Mar</div>
                    </div>
                    <div>
                      <h3 id="arsmote-heading" class="rr-event-card-title">Årsmöte 2026</h3>
                      <small class="rr-event-card-meta">Haga Centrum, Örebro</small>
                    </div>
                  </div>
                  <div class="rr-event-card-body">
                    Information om årsmötet hittar du på sidan
                    <a href="/foreningen/moten-och-protokoll/arsmote" title="Information om årsmötet 2026">Föreningen / Möten och protokoll / Årsmöte 2026</a>.
                  </div>
                </article>

                <article class="rr-event-card" aria-labelledby="betalningar-heading">
                  <div class="rr-event-card-top">
                    <div class="rr-event-date-badge rr-event-date-badge-alt">
                      <span class="rr-event-date-text">Info</span>
                    </div>
                    <div>
                      <h3 id="betalningar-heading" class="rr-event-card-title">Betalningar och rabatter</h3>
                      <small class="rr-event-card-meta">Friskvård, studentrabatt och betalningssätt</small>
                    </div>
                  </div>
                  <div class="rr-event-card-body">
                    Information om friskvårdsintyg, studentrabatter och betalningssätt finns på vår
                    <a href="https://rockrullarna.se/danskurser/betalning/#studentrabatt" title="Läs mer om betalningar och rabatter">sida om betalningar</a>.
                  </div>
                </article>

                <article class="rr-event-card" aria-labelledby="sociala-kanaler-heading">
                  <div class="rr-event-card-top">
                    <div class="rr-event-date-badge rr-event-date-badge-alt">
                      <span class="rr-event-date-text">Nu</span>
                    </div>
                    <div>
                      <h3 id="sociala-kanaler-heading" class="rr-event-card-title">Följ våra kanaler</h3>
                      <small class="rr-event-card-meta">Nyheter, bilder och kommande evenemang</small>
                    </div>
                  </div>
                  <div class="rr-event-card-body">
                    Få fler uppdateringar via <a href="/sociala-media" title="Sociala media">sociala media</a> och håll koll på vad som är på gång i föreningen.
                  </div>
                </article>
              </div>

              <div class="rr-calendar-card">
                <p class="rr-calendar-intro">
                  Här hittar du våra kommande aktiviteter från <a href="/aktivitetskalender" title="Gå till aktivitetskalendern">aktivitetskalendern</a>.
                  Vill du boka en plats går du vidare till
                  <a href="/danskurser/anmalan-danskurser" title="Anmälan till Rockrullarnas danskurser och aktiviteter"><strong>anmälan till danskurser</strong></a>.
                </p>
                <div id="rr-kalender" data-mode="compact" data-days="180" data-limit="500" aria-label="Kommande aktiviteter"></div>
                <script src="/filer/js/aktivitetskalender.js"></script>
                <p class="mt-3">
                  <a class="btn btn-outline-secondary" role="button" href="/aktivitetskalender" title="Visa alla aktiviteter i Aktivitetskalendern">Visa alla aktiviteter</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

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