<?php
  $header_title = "Sociala medier";
  $header_description = "Följ Rockrullarna på sociala medier och se våra senaste uppdateringar från Facebook, Instagram och TikTok";

  $page_updated = "2026-04-06 07:10";
  $page_url = "/sociala-media";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";

  include_once '../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-social-page">
      <div id="BreadCrumbsDiv">
        <a href="../">Rockrullarna.se</a> / <span>Sociala medier</span>
      </div>

      <section class="rr-association-layout" aria-labelledby="sociala-medier-heading">
        <div class="rr-association-card rr-association-card--hero">
          <p class="rr-style-label" aria-hidden="true">Facebook, Instagram och TikTok</p>
          <h1 id="sociala-medier-heading">Följ våra senaste <em>uppdateringar</em></h1>
          <p class="rr-association-lead">
            Här samlar vi Rockrullarnas sociala kanaler i en gemensam vy med nyheter,
            inspiration och glimtar från kurser, evenemang och föreningslivet.
          </p>
          <p class="rr-association-lead">
            Du kan gå vidare till respektive kanal eller följa innehållet direkt här på sidan
            när du vill få snabb överblick över vad som händer hos oss.
          </p>
          <div class="rr-association-actions">
            <a class="rr-hero-btn" href="https://www.instagram.com/rockrullarna" title="Öppna Rockrullarna på Instagram" target="_blank" rel="noopener">Instagram</a>
            <a class="rr-btn-inline" href="https://fb.me/rockrullarna" title="Öppna Rockrullarna på Facebook" target="_blank" rel="noopener">Facebook</a>
            <a class="rr-btn-inline" href="https://www.tiktok.com/@dansklubbrockrullarna" title="Öppna Rockrullarna på TikTok" target="_blank" rel="noopener">TikTok</a>
          </div>
        </div>

        <aside class="rr-association-card rr-association-card--aside" aria-labelledby="sociala-medier-snabbt-heading">
          <p class="rr-style-label" aria-hidden="true">Snabb överblick</p>
          <h2 id="sociala-medier-snabbt-heading">Det här hittar du här</h2>
          <ul class="rr-association-list">
            <li><strong>Facebook</strong><br />Nyheter, evenemang och uppdateringar från föreningen.</li>
            <li><strong>Instagram</strong><br />Senaste inlägg direkt på webben med snabb länk till profilen.</li>
            <li><strong>TikTok</strong><br />Korta klipp från dans, gemenskap och livet i lokalen.</li>
          </ul>
          <div class="rr-association-note">
            <p><strong>Tips:</strong> Sociala medier-flöden laddas från respektive tjänst och kan därför ta någon extra sekund innan de visas fullt ut.</p>
          </div>
        </aside>
      </section>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="sociala-medier-floden-heading">
        <p class="rr-style-label" aria-hidden="true">Direkt från våra kanaler</p>
        <h2 id="sociala-medier-floden-heading">Flöden i samma <em>designspråk</em></h2>
        <div class="rr-contact-method-grid">
          <article class="rr-contact-method-card rr-social-platform-card">
            <div class="rr-social-platform-header">
              <span class="rr-social-platform-icon" aria-hidden="true">
                <svg width="28" height="28" fill="currentColor" class="bi bi-facebook"><use href="#facebook"></use></svg>
              </span>
              <div>
                <p class="rr-style-label" aria-hidden="true">Facebook</p>
                <h3>Nyheter och evenemang</h3>
              </div>
            </div>
            <p>Följ vår Facebook-sida för inbjudningar, uppdateringar och händelser i föreningen.</p>
            <a class="rr-btn-inline" href="https://fb.me/rockrullarna" title="Öppna Rockrullarna på Facebook" target="_blank" rel="noopener">fb.me/rockrullarna</a>
            <div class="rr-courses-embed-shell rr-social-embed-shell">
              <!-- Feed uppdateras från: https://developers.facebook.com/docs/plugins/page-plugin/ -->
              <iframe
                src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Frockrullarna&tabs=timeline&width=500&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=702771861196793"
                title="Facebook-flöde från Rockrullarna"
                loading="lazy"
                scrolling="no"
                allowfullscreen="true"
                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>
          </article>

          <article class="rr-contact-method-card rr-social-platform-card">
            <div class="rr-social-platform-header">
              <span class="rr-social-platform-icon" aria-hidden="true">
                <svg width="28" height="28" fill="currentColor" class="bi bi-instagram"><use href="#instagram"></use></svg>
              </span>
              <div>
                <p class="rr-style-label" aria-hidden="true">Instagram</p>
                <h3>Senaste inlägg direkt på webben</h3>
              </div>
            </div>
            <p>Här visas ett integrerat flöde från vårt Instagram-konto med de senaste publiceringarna från Rockrullarna.</p>
            <a class="rr-btn-inline" href="https://www.instagram.com/rockrullarna" title="Öppna Rockrullarna på Instagram" target="_blank" rel="noopener">instagram.com/rockrullarna</a>
            <div id="rr-instagram-feed" class="rr-courses-embed-shell rr-social-embed-shell" data-rr-instagram-feed>
              <p class="rr-social-feed-status">Instagram-flödet laddas… Om förhandsvisningen inte visas kan du öppna kontot direkt via länken ovan.</p>
              <noscript>
                <p class="rr-social-feed-status">Instagram-flödet kräver JavaScript för att visas.</p>
              </noscript>
            </div>
          </article>

          <article class="rr-contact-method-card rr-social-platform-card">
            <div class="rr-social-platform-header">
              <span class="rr-social-platform-icon" aria-hidden="true">
                <svg width="28" height="28" fill="currentColor" class="bi bi-tiktok"><use href="#tiktok"></use></svg>
              </span>
              <div>
                <p class="rr-style-label" aria-hidden="true">TikTok</p>
                <h3>Klipp från dansgolvet</h3>
              </div>
            </div>
            <p>Se korta klipp från träningar, socialdans och andra nedslag från verksamheten.</p>
            <a class="rr-btn-inline" href="https://www.tiktok.com/@dansklubbrockrullarna" title="Öppna Rockrullarna på TikTok" target="_blank" rel="noopener">tiktok.com/@dansklubbrockrullarna</a>
            <div class="rr-courses-embed-shell rr-social-embed-shell rr-social-embed-shell--tiktok">
              <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@dansklubbrockrullarna" data-unique-id="dansklubbrockrullarna" data-embed-type="creator">
                <section>
                  <a target="_blank" rel="noopener" href="https://www.tiktok.com/@dansklubbrockrullarna?refer=creator_embed">@dansklubbrockrullarna</a>
                </section>
              </blockquote>
            </div>
          </article>
        </div>
      </section>
    </div>

    <script type="module">
      const instagramFeedTarget = document.querySelector('[data-rr-instagram-feed]');

      if (instagramFeedTarget) {
        import('https://cdn.fouita.com/public/instagram-feed.js')
          .then(({ default: App }) => {
            instagramFeedTarget.innerHTML = '';

            new App({
              target: instagramFeedTarget,
              props: {
                settings: {
                  username: 'rockrullarna'
                }
              }
            });
          })
          .catch(() => {
            instagramFeedTarget.setAttribute('data-rr-instagram-fallback', 'true');
          });
      }
    </script>
    <script async src="https://www.tiktok.com/embed.js"></script>
<?php
  include_once '../includes/footer.php'
?>
