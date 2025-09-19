<?php
// index.php
require_once 'db.php';
$page_title = "DHL - Home";
require 'header.php';

// featured articles
$featured = db_query("SELECT a.*, c.title AS category_name, c.slug AS category_slug FROM articles a JOIN categories c ON a.category_id=c.id WHERE a.is_featured=1 ORDER BY a.published_at DESC LIMIT 1")->fetch_assoc();

// latest articles
$latestRes = db_query("SELECT a.id,a.title,a.slug,a.summary,a.image,a.published_at,c.title AS category_name FROM articles a JOIN categories c ON a.category_id=c.id ORDER BY a.published_at DESC LIMIT 9");

// trending (by views)
$trendingRes = db_query("SELECT id,title,slug,image,views FROM articles ORDER BY views DESC LIMIT 5");

?>
<div style="display:flex;gap:16px;flex-wrap:wrap">
  <div style="flex:2; min-width:280px">
    <?php if($featured): ?>
      <div class="card hero">
        <div>
          <img src="<?=htmlspecialchars($featured['image'])?>" alt="">
          <div class="meta">
            <div class="label"><?=htmlspecialchars($featured['category_name'])?></div>
            <h2 class="title"><?=htmlspecialchars($featured['title'])?></h2>
            <div class="summary"><?=htmlspecialchars($featured['summary'])?></div>
            <a class="read-more" href="article.php?id=<?= $featured['id'] ?>">Read full</a>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="categories" aria-hidden="false">
      <?php
      $cats = db_query("SELECT id, title FROM categories ORDER BY id");
      while($c = $cats->fetch_assoc()):
      ?>
      <button class="cat-btn" onclick="goTo('category.php?cat_id=<?= $c['id'] ?>')"><?=htmlspecialchars($c['title'])?></button>
      <?php endwhile; ?>
    </div>

    <h3 style="margin-top:18px">Latest</h3>
    <div class="grid">
      <?php while($row = $latestRes->fetch_assoc()): ?>
      <article class="card">
        <img src="<?=htmlspecialchars($row['image'])?>" alt="">
        <div class="meta">
          <div class="author"><?=htmlspecialchars($row['category_name'])?> • <?=date('M d, Y', strtotime($row['published_at']))?></div>
          <h4 class="title"><?=htmlspecialchars($row['title'])?></h4>
          <div class="summary"><?=htmlspecialchars($row['summary'])?></div>
          <button class="read-more" onclick="goTo('article.php?id=<?= $row['id'] ?>')">Read</button>
        </div>
      </article>
      <?php endwhile; ?>
    </div>

  </div>

  <aside style="flex:1; min-width:240px">
    <div class="card" style="padding:12px">
      <h4 style="margin-top:0">Trending</h4>
      <div class="trending-list">
        <?php while($t = $trendingRes->fetch_assoc()): ?>
          <div class="small-item">
            <img src="<?=htmlspecialchars($t['image'])?>" alt="">
            <div>
              <div style="font-weight:700; font-size:14px"><?=htmlspecialchars($t['title'])?></div>
              <div class="author" style="font-size:12px"><?= (int)$t['views'] ?> views</div>
              <button style="margin-top:6px" class="cat-btn" onclick="goTo('article.php?id=<?= $t['id'] ?>')">Open</button>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="card" style="padding:12px; margin-top:12px">
      <h4 style="margin-top:0">About</h4>
      <p style="color:var(--muted); font-size:14px">DHL — Daily Headline & Live. A sample news clone for educational use.</p>
    </div>
  </aside>
</div>

<?php require 'footer.php'; ?>
