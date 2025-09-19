<?php
// search.php
require_once 'db.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$page_title = 'Search: ' . htmlspecialchars($q);
require 'header.php';

if($q === ''){
  echo "<p style='color:var(--muted)'>Please enter a search query.</p>";
  require 'footer.php'; exit;
}

// use fulltext search first; fallback to LIKE if fulltext returns nothing
$res = null;
if(strlen($q) >= 3){
  $safe_q = $mysqli->real_escape_string($q);
  $res = $mysqli->query("SELECT id,title,summary,image, MATCH(title,summary,content) AGAINST ('{$safe_q}' IN NATURAL LANGUAGE MODE) as score FROM articles WHERE MATCH(title,summary,content) AGAINST ('{$safe_q}' IN NATURAL LANGUAGE MODE) ORDER BY score DESC LIMIT 20");
}
if(!$res || $res->num_rows === 0){
  $like = "%".$q."%";
  $stmt = $mysqli->prepare("SELECT id,title,summary,image FROM articles WHERE title LIKE ? OR summary LIKE ? OR content LIKE ? ORDER BY published_at DESC LIMIT 30");
  $stmt->bind_param('sss', $like, $like, $like);
  $stmt->execute();
  $res = $stmt->get_result();
  $stmt->close();
}
?>

<h2>Search results for "<?=htmlspecialchars($q)?>"</h2>
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:12px; margin-top:10px">
  <?php while($r = $res->fetch_assoc()): ?>
    <article class="card">
      <img src="<?=htmlspecialchars($r['image'])?>" alt="">
      <div class="meta">
        <h4 class="title"><?=htmlspecialchars($r['title'])?></h4>
        <div class="summary"><?=htmlspecialchars($r['summary'])?></div>
        <button class="read-more" onclick="goTo('article.php?id=<?= $r['id'] ?>')">Read</button>
      </div>
    </article>
  <?php endwhile; ?>
</div>

<?php require 'footer.php'; ?>
