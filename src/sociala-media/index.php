<?php
  function logInstagramFeedIssue($message) {
    error_log('[sociala-media] ' . $message);
  }

  function getInstagramConfigValue($key, $default = '') {
    $value = getenv($key);

    if ($value === false || $value === null) {
      return $default;
    }

    $value = trim((string)$value);

    if ($value === '') {
      return $default;
    }

    return $value;
  }

  function fetchInstagramJson($endpoint) {
    $headers = [
      'Accept: application/json',
      'User-Agent: RockrullarnaWeb/1.0 (+https://rockrullarna.se/)',
    ];

    $response = false;
    $status = 0;

    if (function_exists('curl_init')) {
      $ch = curl_init($endpoint);

      curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 8,
      ]);

      $response = curl_exec($ch);
      $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
      curl_close($ch);

      if ($status !== 200 || $response === false) {
        logInstagramFeedIssue('Instagram Graph API request failed with status ' . (string)$status . '.');
        return null;
      }
    } else {
      $context = stream_context_create([
        'http' => [
          'method' => 'GET',
          'header' => implode("\r\n", $headers),
          'timeout' => 8,
        ],
      ]);

      $response = @file_get_contents($endpoint, false, $context);

      if ($response === false) {
        logInstagramFeedIssue('Instagram Graph API request failed when using file_get_contents.');
        return null;
      }
    }

    $payload = json_decode($response, true);

    if (!is_array($payload)) {
      logInstagramFeedIssue('Instagram Graph API response could not be decoded as JSON.');
      return null;
    }

    if (!empty($payload['error']['message'])) {
      logInstagramFeedIssue('Instagram Graph API returned an error: ' . $payload['error']['message']);
      return null;
    }

    return $payload;
  }

  function getInstagramCachePath($username) {
    return rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'rr-instagram-feed-' . preg_replace('/[^a-z0-9_-]/i', '-', $username) . '.json';
  }

  function readInstagramPostCache($username, $ttlSeconds) {
    $cachePath = getInstagramCachePath($username);

    if (!is_file($cachePath)) {
      return null;
    }

    $modifiedTime = @filemtime($cachePath);

    if ($modifiedTime === false || ($modifiedTime + $ttlSeconds) < time()) {
      return null;
    }

    $cachedContent = @file_get_contents($cachePath);

    if ($cachedContent === false || $cachedContent === '') {
      return null;
    }

    $cachedPayload = json_decode($cachedContent, true);

    if (!is_array($cachedPayload)) {
      return null;
    }

    return $cachedPayload;
  }

  function writeInstagramPostCache($username, $posts) {
    $cachePath = getInstagramCachePath($username);
    @file_put_contents($cachePath, json_encode($posts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
  }

  function fetchInstagramPosts($username, $limit = 4) {
    $limit = (int)$limit;

    if ($limit < 1) {
      return [];
    }

    $cachedPosts = readInstagramPostCache($username, 900);

    if (is_array($cachedPosts) && !empty($cachedPosts)) {
      return array_slice($cachedPosts, 0, $limit);
    }

    $accessToken = getInstagramConfigValue('RR_INSTAGRAM_ACCESS_TOKEN');

    if ($accessToken === '') {
      logInstagramFeedIssue('Instagram access token is missing. Set RR_INSTAGRAM_ACCESS_TOKEN to enable the feed.');
      return [];
    }

    $endpoint = 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp&limit=' . rawurlencode((string)$limit) . '&access_token=' . rawurlencode($accessToken);
    $payload = fetchInstagramJson($endpoint);

    if (!is_array($payload)) {
      return [];
    }

    $mediaItems = $payload['data'] ?? [];

    if (!is_array($mediaItems) || empty($mediaItems)) {
      logInstagramFeedIssue('Instagram Graph API response did not contain any posts.');
      return [];
    }

    $posts = [];

    foreach (array_slice($mediaItems, 0, $limit) as $item) {
      $permalink = trim((string)($item['permalink'] ?? ''));
      $mediaUrl = trim((string)($item['media_url'] ?? ''));
      $thumbnailUrl = trim((string)($item['thumbnail_url'] ?? ''));
      $mediaType = trim((string)($item['media_type'] ?? ''));

      if ($permalink === '') {
        continue;
      }

      $caption = trim((string)($item['caption'] ?? ''));

      if ($caption === '') {
        $caption = 'Se senaste uppdateringen från Rockrullarna på Instagram.';
      }

      $imageUrl = $mediaUrl;

      if ($mediaType === 'VIDEO' && $thumbnailUrl !== '') {
        $imageUrl = $thumbnailUrl;
      }

      if ($mediaType === 'CAROUSEL_ALBUM' && $imageUrl === '' && $thumbnailUrl !== '') {
        $imageUrl = $thumbnailUrl;
      }

      $timestamp = trim((string)($item['timestamp'] ?? ''));
      $altText = $caption;

      if ($altText === '') {
        $altText = 'Instagram-inlägg från Rockrullarna';
      }

      $posts[] = [
        'url' => $permalink,
        'image' => $imageUrl,
        'alt' => $altText,
        'caption' => $caption,
        'timestamp' => $timestamp,
        'mediaType' => $mediaType,
      ];
    }

    if (!empty($posts)) {
      writeInstagramPostCache($username, $posts);
    }

    return $posts;
  }

  $header_title = "Sociala medier";
  $header_description = "Följ Rockrullarna på sociala medier och se våra senaste uppdateringar från Facebook, Instagram och TikTok";

  $page_updated = "2026-04-06 07:10";
  $page_url = "/sociala-media";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";
  $instagram_posts = fetchInstagramPosts('rockrullarna', 4);
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
                <h3>Senaste inlägg direkt på webben</h3>
              </div>
            </div>
            <p>Här visas de fyra senaste publiceringarna från vårt Instagram-konto, hämtade via Instagram Graph API.</p>
            <a class="rr-btn-inline" href="https://www.instagram.com/rockrullarna" title="Öppna Rockrullarna på Instagram" target="_blank" rel="noopener noreferrer">instagram.com/rockrullarna</a>
            <div id="rr-instagram-feed" class="rr-courses-embed-shell rr-social-embed-shell">
              <?php if ($instagram_feed_ready) { ?>
                <div class="rr-instagram-feed-grid">
                  <?php foreach ($instagram_posts as $instagram_post) { ?>
                    <a class="rr-instagram-feed-card" href="<?php echo htmlspecialchars($instagram_post['url']); ?>" title="Öppna inlägget på Instagram" target="_blank" rel="noopener noreferrer">
                      <?php if (!empty($instagram_post['image'])) { ?>
                        <img src="<?php echo htmlspecialchars($instagram_post['image']); ?>" alt="<?php echo htmlspecialchars($instagram_post['alt']); ?>" loading="lazy" />
                      <?php } ?>
                      <span class="rr-instagram-feed-card-content">
                        <?php if (!empty($instagram_post['timestamp'])) { ?>
                          <time datetime="<?php echo htmlspecialchars($instagram_post['timestamp']); ?>"><?php echo htmlspecialchars(date('Y-m-d', strtotime($instagram_post['timestamp']))); ?></time>
                        <?php } ?>
                        <strong><?php echo htmlspecialchars(mb_strimwidth($instagram_post['caption'], 0, 140, '…')); ?></strong>
                        <small>
                          <?php
                            if (($instagram_post['mediaType'] ?? '') === 'VIDEO') {
                              echo 'Video pa Instagram';
                            } elseif (($instagram_post['mediaType'] ?? '') === 'CAROUSEL_ALBUM') {
                              echo 'Karusell pa Instagram';
                            } else {
                              echo 'Bild pa Instagram';
                            }
                          ?>
                        </small>
                      </span>
                    </a>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <p class="rr-social-feed-status">Instagram-flödet kunde inte hämtas just nu. Kontrollera att miljövariabeln RR_INSTAGRAM_ACCESS_TOKEN finns satt och öppna annars kontot direkt via länken ovan.</p>
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
    <script async src="https://www.tiktok.com/embed.js"></script>
<?php
  include_once '../includes/footer.php'
?>
