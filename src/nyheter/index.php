<?php
declare(strict_types=1);

require_once __DIR__ . '/../api/posts-cache.php';

$allPosts = rrPostsGetAll();
$categories = rrPostsGetCategories($allPosts);

$search = trim((string) ($_GET['q'] ?? ''));
$category = trim((string) ($_GET['category'] ?? ''));
$featuredOnly = filter_var($_GET['featured'] ?? false, FILTER_VALIDATE_BOOLEAN);
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);

$filteredPosts = rrPostsFilter($allPosts, $category !== '' ? $category : null, $search, $featuredOnly);
$pagination = rrPostsPaginate($filteredPosts, $page, 10);
$posts = $pagination['items'];

$header_title = 'Nyheter';
$header_description = 'Nyheter, bloggposter och aktiviteter från Dansklubben Rockrullarna.';
$page_updated = '2026-08-28 16:55';
$page_url = '/nyheter';
$page_contact_name = 'Info';
$page_contact_email = 'info@rockrullarna.se';

include_once '../includes/header.php';
?>
    <div id="BreadCrumbsDiv">
      <a href="../">Rockrullarna.se</a> / <span>Nyheter</span>
    </div>

    <section class="rr-news-page" aria-labelledby="nyheter-heading">
      <p class="rr-style-label" aria-hidden="true">Rockrullarna</p>
      <h1 id="nyheter-heading">Nyheter och uppdateringar</h1>
      <p class="rr-news-intro">Här hittar du våra senaste nyheter, evenemang och kursstarter.</p>

      <form class="rr-news-filter-form" method="get" action="/nyheter/">
        <div>
          <label for="news-search" class="form-label">Sök i nyheter</label>
          <input
            id="news-search"
            class="form-control"
            name="q"
            type="search"
            value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Sök på titel, innehåll eller författare"
          />
        </div>
        <div>
          <label for="news-category" class="form-label">Kategori</label>
          <select id="news-category" class="form-select" name="category">
            <option value="">Alla kategorier</option>
            <?php foreach ($categories as $categoryName) { ?>
              <option value="<?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?>" <?= $categoryName === $category ? 'selected' : '' ?>>
                <?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="rr-news-filter-check">
          <input id="news-featured" class="form-check-input" type="checkbox" name="featured" value="1" <?= $featuredOnly ? 'checked' : '' ?> />
          <label for="news-featured" class="form-check-label">Endast utvalda nyheter</label>
        </div>
        <div class="rr-news-filter-actions">
          <button type="submit" class="rr-hero-btn">Filtrera</button>
          <a class="rr-btn-inline" href="/nyheter/">Rensa filter</a>
        </div>
      </form>

      <?php if ($posts === []) { ?>
        <p class="rr-news-empty">Inga nyheter matchade din sökning just nu.</p>
      <?php } else { ?>
        <div class="rr-news-grid">
          <?php foreach ($posts as $post) { ?>
            <article class="rr-news-card" aria-labelledby="post-<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">
              <a class="rr-news-image-link" href="/nyheter/post.php?slug=<?= rawurlencode((string) $post['slug']) ?>" aria-label="Läs hela nyheten: <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>">
                <?php if (!empty($post['thumbnail'])) { ?>
                  <img src="<?= htmlspecialchars((string) $post['thumbnail'], ENT_QUOTES, 'UTF-8') ?>" alt="" loading="lazy" class="rr-news-thumbnail" />
                <?php } else { ?>
                  <span class="rr-news-thumbnail rr-news-thumbnail--placeholder" aria-hidden="true">📰</span>
                <?php } ?>
              </a>

              <div class="rr-news-card-body">
                <p class="rr-news-card-meta">
                  <span><?= htmlspecialchars(rrPostsFormatDate((string) $post['published_at']), ENT_QUOTES, 'UTF-8') ?></span>
                  <span>•</span>
                  <span><?= htmlspecialchars((string) $post['author'], ENT_QUOTES, 'UTF-8') ?></span>
                </p>
                <?php if (!empty($post['category'])) { ?>
                  <p class="rr-news-card-category"><?= htmlspecialchars((string) $post['category'], ENT_QUOTES, 'UTF-8') ?></p>
                <?php } ?>
                <h2 id="post-<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>" class="rr-news-card-title">
                  <a href="/nyheter/post.php?slug=<?= rawurlencode((string) $post['slug']) ?>">
                    <?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?>
                  </a>
                </h2>
                <p class="rr-news-card-excerpt"><?= htmlspecialchars((string) $post['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
                <a class="rr-btn-inline" href="/nyheter/post.php?slug=<?= rawurlencode((string) $post['slug']) ?>">Läs mer</a>
              </div>
            </article>
          <?php } ?>
        </div>
      <?php } ?>

      <?php if ((int) $pagination['total_pages'] > 1) { ?>
        <nav class="rr-news-pagination" aria-label="Sidindelning nyheter">
          <?php for ($i = 1; $i <= (int) $pagination['total_pages']; $i++) { ?>
            <?php
            $query = http_build_query(array_filter([
                'page' => $i,
                'q' => $search,
                'category' => $category,
                'featured' => $featuredOnly ? '1' : null,
            ], static fn ($value) => $value !== null && $value !== ''));
            ?>
            <a class="<?= $i === (int) $pagination['page'] ? 'is-active' : '' ?>" href="/nyheter/?<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>">
              <?= $i ?>
            </a>
          <?php } ?>
        </nav>
      <?php } ?>
    </section>
<?php
include_once '../includes/footer.php';
?>
