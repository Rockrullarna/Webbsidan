<?php
  function buildInstagramProxyUrl($imageUrl) {
    // Hämtar den aktuella mappen dynamiskt (t.ex. "/beta/sociala-media" eller "/sociala-media")
    $currentDir = dirname($_SERVER['SCRIPT_NAME']);

    // Bygg ihop sökvägen till image.php
    $proxyPath = rtrim($currentDir, '/') . '/image.php?url=';

    $imageUrl = trim((string)$imageUrl);

    if ($imageUrl === '') {
      return '';
    }

    if (str_starts_with($imageUrl, $proxyPath)) {
      return $imageUrl;
    }

    return $proxyPath . rawurlencode($imageUrl);
  }

  function readInstagramFeedCache($filePath) {
    if (!is_file($filePath)) {
      return [];
    }

    $cachedContent = @file_get_contents($filePath);

    if ($cachedContent === false || $cachedContent === '') {
      return [];
    }

    $payload = json_decode($cachedContent, true);

    if (!is_array($payload) || !is_array($payload['posts'] ?? null)) {
      return [];
    }

    $posts = $payload['posts'];

    foreach ($posts as &$post) {
      if (!is_array($post)) {
        continue;
      }

      $post['image'] = buildInstagramProxyUrl($post['image'] ?? '');
    }

    unset($post);

    return $posts;
  }

  function formatInstagramPostDate($timestamp) {
    $timestamp = trim((string)$timestamp);

    if ($timestamp === '') {
      return '';
    }

    $date = date_create($timestamp);

    if ($date === false) {
      return '';
    }

    return $date->format('Y-m-d');
  }

  function getInstagramMediaTypeLabel($mediaType) {
    if ($mediaType === 'VIDEO') {
      return 'Video på Instagram';
    }

    if ($mediaType === 'CAROUSEL_ALBUM') {
      return 'Karusell på Instagram';
    }

    return 'Bild på Instagram';
  }

  $header_title = "Sociala medier";
  $header_description = "Följ Rockrullarna på sociala medier och se våra senaste uppdateringar från Facebook, Instagram och TikTok";

  $page_updated = "2026-04-06 21:35";
  $page_url = "/sociala-media";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";
  $instagramCacheFile = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'instagram-rockrullarna.json';
  $instagram_posts = readInstagramFeedCache($instagramCacheFile);
  $instagram_feed_ready = !empty($instagram_posts);

  include_once '../includes/header.php'
?>
    <div class="rr-page-shell rr-association-page rr-social-page">
      <div id="BreadCrumbsDiv">
        <a href="../">Rockrullarna.se</a> / <span>Sociala medier</span>
      </div>

      <section class="rr-association-card rr-association-card--section" aria-labelledby="sociala-medier-floden-heading">
        <p class="rr-style-label" aria-hidden="true">Sociala medier</p>
        <h2 id="sociala-medier-floden-heading">Följ våra senaste <em>uppdateringar</em></h2>
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
            <p>Följ vår Facebook-sida för uppdateringar och händelser i föreningen.</p>
            <a class="rr-btn-inline" href="https://fb.me/rockrullarna" title="Öppna Rockrullarna på Facebook" target="_blank" rel="noopener noreferrer">fb.me/rockrullarna</a>
            <div class="rr-courses-embed-shell rr-social-embed-shell rr-social-embed-shell--facebook">
              <div id="fb-root"></div>
              <script async defer crossorigin="anonymous"
                src="https://connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v19.0">
              </script>

              <div class="fb-page"
                data-href="https://www.facebook.com/rockrullarna"
                data-tabs="timeline"
                data-width="500"
                data-height="700"
                data-small-header="false"
                data-adapt-container-width="true"
                data-hide-cover="false"
                data-show-facepile="true">
              </div>

              <div class="rr-social-link-panel-grid">
                <a class="rr-social-link-card" href="https://www.facebook.com/rockrullarna" target="_blank" rel="noopener noreferrer">
                  <strong>Facebook-sidan</strong>
                  <span>Läs senaste uppdateringar och inlägg direkt på Facebook.</span>
                </a>
                <a class="rr-social-link-card" href="https://www.facebook.com/rockrullarna/events" target="_blank" rel="noopener noreferrer">
                  <strong>Evenemang</strong>
                  <span>Se kommande danser, kursstarter och andra aktiviteter.</span>
                </a>
                <a class="rr-social-link-card" href="https://m.me/rockrullarna" target="_blank" rel="noopener noreferrer">
                  <strong>Skicka meddelande</strong>
                  <span>Öppna Messenger om du vill ställa en snabb fråga.</span>
                </a>
              </div>
            </div>
          </article>

          <article class="rr-contact-method-card rr-social-platform-card">
            <div class="rr-social-platform-header">
              <span class="rr-social-platform-icon" aria-hidden="true">
                <svg width="28" height="28" fill="currentColor" class="bi bi-instagram"><use href="#instagram"></use></svg>
              </span>
              <div>
                <p class="rr-style-label" aria-hidden="true">Instagram</p>
                <h3>Senaste inläggen</h3>
              </div>
            </div>
            <p>Här visas de senaste publiceringarna från vårt Instagram-konto.</p>
            <a class="rr-btn-inline" href="https://www.instagram.com/rockrullarna" title="Öppna Rockrullarna på Instagram" target="_blank" rel="noopener noreferrer">instagram.com/rockrullarna</a>
            <div id="rr-instagram-feed" class="rr-courses-embed-shell rr-social-embed-shell" data-instagram-api="./data.php">
              <?php if ($instagram_feed_ready) { ?>
                <div class="rr-instagram-feed-grid">
                  <?php foreach ($instagram_posts as $instagram_post) { ?>
                    <a class="rr-instagram-feed-card" href="<?php echo htmlspecialchars($instagram_post['url']); ?>" title="Öppna inlägget på Instagram" target="_blank" rel="noopener noreferrer">
                      <?php if (!empty($instagram_post['image'])) { ?>
                        <img src="<?php echo htmlspecialchars($instagram_post['image']); ?>" alt="<?php echo htmlspecialchars($instagram_post['alt']); ?>" loading="lazy" />
                      <?php } ?>
                      <span class="rr-instagram-feed-card-content">
                        <?php $instagramPostDate = formatInstagramPostDate($instagram_post['timestamp'] ?? ''); ?>
                        <?php if ($instagramPostDate !== '') { ?>
                          <time datetime="<?php echo htmlspecialchars($instagram_post['timestamp']); ?>"><?php echo htmlspecialchars($instagramPostDate); ?></time>
                        <?php } ?>
                        <strong><?php echo htmlspecialchars(mb_strimwidth($instagram_post['caption'], 0, 140, '…')); ?></strong>
                        <small><?php echo htmlspecialchars(getInstagramMediaTypeLabel($instagram_post['mediaType'] ?? '')); ?></small>
                      </span>
                    </a>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <p class="rr-social-feed-status">Instagram-flödet laddas eller saknar cache just nu. Öppna gärna kontot direkt via länken ovan om inget visas strax.</p>
              <?php } ?>
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
            <a class="rr-btn-inline" href="https://www.tiktok.com/@dansklubbrockrullarna" title="Öppna Rockrullarna på TikTok" target="_blank" rel="noopener noreferrer">tiktok.com/@dansklubbrockrullarna</a>
            <div class="rr-courses-embed-shell rr-social-embed-shell rr-social-embed-shell--tiktok">
              <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@dansklubbrockrullarna" data-unique-id="dansklubbrockrullarna" data-embed-type="creator">
                <section>
                  <a target="_blank" rel="noopener noreferrer" href="https://www.tiktok.com/@dansklubbrockrullarna?refer=creator_embed">@dansklubbrockrullarna</a>
                </section>
              </blockquote>
            </div>
          </article>
        </div>
      </section>
    </div>
    <script id="facebook-sdk-loader">
      document.addEventListener("DOMContentLoaded", function () {
        // Vänta tills Facebook SDK är redo
        function waitForFB(callback) {
            if (typeof FB !== "undefined" && FB.XFBML && FB.XFBML.parse) {
                callback()
            } else {
                setTimeout(() => waitForFB(callback), 100)
            }
        }

        waitForFB(function () {
            const fbShell = document.querySelector(".rr-social-embed-shell--facebook")
            if (!fbShell) return

            FB.init({
              appId      : '702771861196793',
              xfbml      : true,
              version    : 'v25.0'
            });
            FB.getLoginStatus(function(response) {
              console.log(response);
            });

            // Rendera direkt om elementet redan är synligt
            if (fbShell.offsetParent !== null) {
                FB.XFBML.parse(fbShell)
                return
            }

            // Annars: vänta tills elementet blir synligt i viewport
            const observer = new IntersectionObserver(entries => {
                if (entries[0].isIntersecting) {
                    FB.XFBML.parse(fbShell)
                    observer.disconnect()
                }
            })

            observer.observe(fbShell)
        })
      })
    </script>
    <script id="instagram-feed-loader">
      (function () {
        const instagramFeed = document.getElementById('rr-instagram-feed');

        if (!instagramFeed) {
          return;
        }

        const apiUrl = instagramFeed.getAttribute('data-instagram-api');

        if (!apiUrl || !window.fetch) {
          return;
        }

        const escapeHtml = function (value) {
          return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
        };

        const mediaTypeLabel = function (mediaType) {
          if (mediaType === 'VIDEO') {
            return 'Video från Instagram';
          }

          if (mediaType === 'CAROUSEL_ALBUM') {
            return 'Karusell från Instagram';
          }

          return 'Bild från Instagram';
        };

        const trimCaption = function (caption) {
          const text = String(caption || '').trim();

          if (text.length <= 140) {
            return text;
          }

          return text.slice(0, 139).trimEnd() + '…';
        };

        const renderPosts = function (posts) {
          if (!Array.isArray(posts) || posts.length === 0) {
            return;
          }

          const cards = posts.map(function (post) {
            const imageMarkup = post.image
              ? '<img src="' + escapeHtml(post.image) + '" alt="' + escapeHtml(post.alt || 'Instagram-inlägg från Rockrullarna') + '" loading="lazy" />'
              : '';

            const timeMarkup = post.timestamp
              ? '<time datetime="' + escapeHtml(post.timestamp) + '">' + escapeHtml(String(post.timestamp).slice(0, 10)) + '</time>'
              : '';

            return '<a class="rr-instagram-feed-card" href="' + escapeHtml(post.url || '#') + '" title="Öppna inlägget på Instagram" target="_blank" rel="noopener noreferrer">'
              + imageMarkup
              + '<span class="rr-instagram-feed-card-content">'
              + timeMarkup + '<br />'
              + '<strong>' + escapeHtml(trimCaption(post.caption)) + '</strong><br />'
              + '<small>' + escapeHtml(mediaTypeLabel(post.mediaType)) + '</small>'
              + '</span>'
              + '</a>';
          }).join('');

          instagramFeed.innerHTML = '<div class="rr-instagram-feed-grid">' + cards + '</div>';
        };

        fetch(apiUrl, { headers: { 'Accept': 'application/json' } })
          .then(function (response) {
            if (!response.ok) {
              throw new Error('Instagram API request failed.');
            }

            return response.json();
          })
          .then(function (payload) {
            renderPosts(payload.posts || []);
          })
          .catch(function () {
          });
      }());
    </script>
    <script async src="https://www.tiktok.com/embed.js"></script>
<?php
  include_once '../includes/footer.php'
?>
