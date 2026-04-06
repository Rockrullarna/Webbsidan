<?php
  function logInstagramFeedIssue($message) {
    error_log('[sociala-media] ' . $message);
  }

  function fetchInstagramPosts($username, $limit = 3) {
    $limit = (int)$limit;

    if ($limit < 1) {
      return [];
    }

    $endpoint = 'https://www.instagram.com/api/v1/users/web_profile_info/?username=' . rawurlencode($username);
    $headers = [
      'Accept: application/json',
      'Referer: https://www.instagram.com/' . rawurlencode($username) . '/',
      'User-Agent: Mozilla/5.0 (compatible; RockrullarnaBot/1.0; +https://www.rockrullarna.se/)',
      'X-IG-App-ID: 936619743392459',
    ];

    $response = false;

    if (function_exists('curl_init')) {
      $ch = curl_init($endpoint);

      curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 8,
      ]);

      $response = curl_exec($ch);
      $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
      curl_close($ch);

      if ($status !== 200 || $response === false) {
        logInstagramFeedIssue('Instagram feed request failed with status ' . (string)$status . '.');
        return [];
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
        logInstagramFeedIssue('Instagram feed request failed when using file_get_contents.');
        return [];
      }
    }

    $payload = json_decode($response, true);

    if (!is_array($payload)) {
      logInstagramFeedIssue('Instagram feed response could not be decoded as JSON.');
      return [];
    }

    $edges = $payload['data']['user']['edge_owner_to_timeline_media']['edges']
      ?? $payload['graphql']['user']['edge_owner_to_timeline_media']['edges']
      ?? [];

    if (!is_array($edges) || empty($edges)) {
      logInstagramFeedIssue('Instagram feed response did not contain any posts.');
      return [];
    }

    $posts = [];

    foreach (array_slice($edges, 0, $limit) as $edge) {
      $node = $edge['node'] ?? [];
      $shortcode = $node['shortcode'] ?? '';

      if ($shortcode === '') {
        continue;
      }

      $caption_edges = $node['edge_media_to_caption']['edges'] ?? [];
      $caption = '';

      if (!empty($caption_edges[0]['node']['text'])) {
        $caption = trim($caption_edges[0]['node']['text']);
      }

      if ($caption === '' && !empty($node['accessibility_caption'])) {
        $caption = trim($node['accessibility_caption']);
      }

      if ($caption === '') {
        $caption = 'Se senaste uppdateringen från Rockrullarna på Instagram.';
      }

      $posts[] = [
        'url' => 'https://www.instagram.com/p/' . rawurlencode($shortcode) . '/',
        'image' => $node['thumbnail_src'] ?? $node['display_url'] ?? '',
        'alt' => $node['accessibility_caption'] ?? 'Instagram-inlägg från Rockrullarna',
        'caption' => $caption,
      ];
    }

    return $posts;
  }

  $header_title = "Sociala medier";
  $header_description = "Följ Rockrullarna på sociala medier och se våra senaste uppdateringar från Facebook, Instagram och TikTok";

  $page_updated = "2026-04-06 07:10";
  $page_url = "/sociala-media";
  $page_contact_name = "Info";
  $page_contact_email = "info@rockrullarna.se";
  $instagram_posts = fetchInstagramPosts('rockrullarna', 3);

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
            <p>Här visas ett integrerat flöde från vårt Instagram-konto med de senaste publiceringarna från Rockrullarna.</p>
            <a class="rr-btn-inline" href="https://www.instagram.com/rockrullarna" title="Öppna Rockrullarna på Instagram" target="_blank" rel="noopener noreferrer">instagram.com/rockrullarna</a>
            <div id="rr-instagram-feed" class="rr-courses-embed-shell rr-social-embed-shell">
              <?php if (!empty($instagram_posts)) { ?>
                <div class="rr-instagram-feed-grid">
                  <?php foreach ($instagram_posts as $instagram_post) { ?>
                    <a class="rr-instagram-feed-card" href="<?php echo htmlspecialchars($instagram_post['url']); ?>" title="Öppna inlägget på Instagram" target="_blank" rel="noopener noreferrer">
                      <?php if (!empty($instagram_post['image'])) { ?>
                        <img src="<?php echo htmlspecialchars($instagram_post['image']); ?>" alt="<?php echo htmlspecialchars($instagram_post['alt']); ?>" loading="lazy" />
                      <?php } ?>
                      <span><?php echo htmlspecialchars(mb_strimwidth($instagram_post['caption'], 0, 180, '…')); ?></span>
                    </a>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <p class="rr-social-feed-status">Instagram-flödet kunde inte hämtas just nu. Öppna gärna kontot direkt via länken ovan för att se de senaste inläggen.</p>
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
