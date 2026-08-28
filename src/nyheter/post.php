<?php
declare(strict_types=1);

require_once __DIR__ . '/../api/posts-cache.php';

$allPosts = rrPostsGetAll();
$postIdentifier = trim((string) ($_GET['slug'] ?? $_GET['id'] ?? ''));
$post = rrPostsFindByIdOrSlug($allPosts, $postIdentifier);

if ($post === null) {
    http_response_code(404);
    $header_title = 'Nyhet saknas';
    $header_description = 'Den efterfrågade nyheten kunde inte hittas.';
    $page_updated = '2026-08-28 16:55';
    $page_url = '/nyheter';
    include_once '../includes/header.php';
    ?>
      <div id="BreadCrumbsDiv">
        <a href="../">Rockrullarna.se</a> / <a href="/nyheter/">Nyheter</a> / <span>Saknas</span>
      </div>
      <h1>Nyheten kunde inte hittas</h1>
      <p>Nyheten kan ha flyttats eller tagits bort.</p>
      <p><a class="rr-btn-inline" href="/nyheter/">Tillbaka till alla nyheter</a></p>
    <?php
    include_once '../includes/footer.php';
    exit;
}

$postTitle = (string) $post['title'];
$postUrl = '/nyheter/post.php?slug=' . rawurlencode((string) $post['slug']);
$postDescription = (string) ($post['excerpt'] ?? '');
$postImage = (string) ($post['featured_image'] ?? '');

$header_title = $postTitle;
$header_description = $postDescription !== '' ? $postDescription : 'Nyhet från Dansklubben Rockrullarna.';
$page_image = $postImage !== '' ? $postImage : null;
$page_updated = (string) $post['published_at'];
$page_url = $postUrl;
$page_contact_name = 'Info';
$page_contact_email = 'info@rockrullarna.se';

$relatedPosts = rrPostsGetRelated($allPosts, $post, 3);

include_once '../includes/header.php';
?>
    <div id="BreadCrumbsDiv">
      <a href="../">Rockrullarna.se</a> / <a href="/nyheter/">Nyheter</a> / <span><?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?></span>
    </div>

    <article class="rr-news-post" aria-labelledby="news-post-heading">
      <header class="rr-news-post-header">
        <?php if (!empty($post['category'])) { ?>
          <p class="rr-news-card-category"><?= htmlspecialchars((string) $post['category'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php } ?>
        <h1 id="news-post-heading"><?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="rr-news-post-meta">
          <span><?= htmlspecialchars(rrPostsFormatDate((string) $post['published_at']), ENT_QUOTES, 'UTF-8') ?></span>
          <span>•</span>
          <span><?= htmlspecialchars((string) $post['author'], ENT_QUOTES, 'UTF-8') ?></span>
        </p>
      </header>

      <?php if ($postImage !== '') { ?>
        <figure class="rr-news-post-image">
          <img src="<?= htmlspecialchars($postImage, ENT_QUOTES, 'UTF-8') ?>" alt="" loading="eager" />
        </figure>
      <?php } ?>

      <div class="rr-news-post-content">
        <?= rrPostsRenderBody($post) ?>
      </div>

      <section class="rr-news-share" aria-label="Dela nyheten">
        <?php
        $encodedTitle = rawurlencode($postTitle);
        $encodedUrl = rawurlencode('https://rockrullarna.se' . $postUrl);
        ?>
        <h2>Dela nyheten</h2>
        <div class="rr-news-share-links">
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $encodedUrl ?>" target="_blank" rel="noopener noreferrer">Facebook</a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $encodedUrl ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
          <a href="mailto:?subject=<?= $encodedTitle ?>&body=<?= $encodedUrl ?>">E-post</a>
        </div>
      </section>

      <?php if ($relatedPosts !== []) { ?>
        <section class="rr-news-related" aria-labelledby="related-news-heading">
          <h2 id="related-news-heading">Relaterade nyheter</h2>
          <div class="rr-news-related-grid">
            <?php foreach ($relatedPosts as $relatedPost) { ?>
              <article class="rr-news-related-card">
                <h3>
                  <a href="/nyheter/post.php?slug=<?= rawurlencode((string) $relatedPost['slug']) ?>">
                    <?= htmlspecialchars((string) $relatedPost['title'], ENT_QUOTES, 'UTF-8') ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars((string) $relatedPost['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
              </article>
            <?php } ?>
          </div>
        </section>
      <?php } ?>
    </article>

    <script type="application/ld+json">
      <?= json_encode([
          '@context' => 'https://schema.org',
          '@type' => 'NewsArticle',
          'headline' => $postTitle,
          'author' => [
              '@type' => 'Organization',
              'name' => (string) $post['author'],
          ],
          'datePublished' => date(DATE_ATOM, strtotime((string) $post['published_at']) ?: time()),
          'dateModified' => date(DATE_ATOM, strtotime((string) $post['published_at']) ?: time()),
          'image' => $postImage !== '' ? ['https://rockrullarna.se' . $postImage] : [],
          'mainEntityOfPage' => 'https://rockrullarna.se' . $postUrl,
      ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
    </script>
<?php
include_once '../includes/footer.php';
?>
