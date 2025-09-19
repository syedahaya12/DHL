<?php
// category.php
require_once 'db.php';
$cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
if($cat_id <= 0){
  header("Location: index.php"); exit;
}
$cat = db_query("SELECT * FROM categories WHERE id = ?", 'i', [$cat_id])->fetch_assoc();
if(!$cat){ header("Location: index.php"); exit; }

$page_title = "DHL - ".htmlspecialchars($cat['title']);
require 'header.php';

$res = db_query("SELECT a.id,a.title,a.slug,a.summary,a.image,a.published_at,au.name AS author_name FROM articles a LEFT JOIN authors au ON a.author_id=au.id WHERE a.category_id = ? ORDER BY a.published_at DESC", 'i', [$cat_id]);
?>

<h2 style="margin-top:8px"><?=htmlspecialchars($cat['title'])?></h2>
<p style="color:var(--muted)"><?=htmlspecialchars($cat['description'])?></p>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:14px; margin-top:12px;">
<?php while($a = $res->fetch_assoc()): ?>
  <article class="card">
    <img src="<?=htmlspecialchars($a['image'])?>" alt="">
    <div class="meta">
      <div class="author"><?=htmlspecialchars($a['author_name'])?> • <?=date('M d, Y', strtotime($a['published_at']))?></div>
      <h4 class="title"><?=htmlspecialchars($a['title'])?></h4>
      <div class="summary"><?=htmlspecialchars($a['summary'])?></div>
      <button class="read-more" onclick="goTo('article.php?id=<?= $a['id'] ?>')">Read</button>
    </div>
  </article>
<?php endwhile; ?>
</div>

<?php require 'footer.php'; ?>
