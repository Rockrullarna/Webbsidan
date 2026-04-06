<?php
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

    return $payload['posts'];
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
      return 'Video pa Instagram';
    }

    if ($mediaType === 'CAROUSEL_ALBUM') {
      return 'Karusell pa Instagram';
    }

    return 'Bild pa Instagram';
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
            <p>Följ vår Facebook-sida för inbjudningar, uppdateringar och händelser i föreningen.</p>
            <a class="rr-btn-inline" href="https://fb.me/rockrullarna" title="Öppna Rockrullarna på Facebook" target="_blank" rel="noopener noreferrer">fb.me/rockrullarna</a>
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
                <h3>Senaste inläggen</h3>
              </div>
            </div>
            <p>Här visas de fyra senaste publiceringarna från vårt Instagram-konto, hämtade via vårt eget Instagram-api.</p>
            <a class="rr-btn-inline" href="https://www.instagram.com/rockrullarna" title="Öppna Rockrullarna på Instagram" target="_blank" rel="noopener noreferrer">instagram.com/rockrullarna</a>
            <div id="rr-instagram-feed" class="rr-courses-embed-shell rr-social-embed-shell" data-instagram-api="/sociala-media/data.php">
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
    <script>
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
            return 'Video pa Instagram';
          }

          if (mediaType === 'CAROUSEL_ALBUM') {
            return 'Karusell pa Instagram';
          }

          return 'Bild pa Instagram';
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
              + timeMarkup
              + '<strong>' + escapeHtml(trimCaption(post.caption)) + '</strong>'
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
