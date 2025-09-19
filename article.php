<?php
// article.php
require_once 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0) { header("Location: index.php"); exit; }

// get article
$artRes = db_query("SELECT a.*, c.title AS category_name, au.name AS author_name FROM articles a LEFT JOIN categories c ON a.category_id=c.id LEFT JOIN authors au ON a.author_id=au.id WHERE a.id = ?", 'i', [$id]);
$article = $artRes->fetch_assoc();
if(!$article){ header("Location: index.php"); exit; }

// increment views (separate statement)
$stmt = $mysqli->prepare("UPDATE articles SET views = views + 1 WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

// comments
$comments = db_query("SELECT name,comment,created_at FROM comments WHERE article_id = ? AND approved = 1 ORDER BY created_at DESC", 'i', [$id]);

$page_title = "DHL - " . htmlspecialchars($article['title']);
require 'header.php';
?>

<article class="card" style="padding:0; overflow:visible;">
  <img src="<?=htmlspecialchars($article['image'])?>" alt="">
  <div class="meta">
    <div class="label"><?=htmlspecialchars($article['category_name'])?></div>
    <h1 class="title"><?=htmlspecialchars($article['title'])?></h1>
    <div class="author"><?=htmlspecialchars($article['author_name'])?> • <?=date('M d, Y', strtotime($article['published_at']))?></div>
    <div style="margin-top:12px"><?= $article['content'] // content may contain HTML ?></div>
  </div>
</article>

<div class="card" style="padding:12px; margin-top:12px">
  <h3>Comments</h3>
  <div class="comment-box">
    <form id="comment-form" method="post" action="comment_handler.php">
      <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <input required name="name" placeholder="Your name" style="flex:1;padding:8px;border:1px solid #ddd;border-radius:6px">
        <input name="email" type="email" placeholder="Email (optional)" style="flex:1;padding:8px;border:1px solid #ddd;border-radius:6px">
      </div>
      <textarea required name="comment" placeholder="Write your comment..." style="width:100%;margin-top:8px;padding:10px;border:1px solid #ddd;border-radius:6px" rows="4"></textarea>
      <div style="display:flex;gap:8px; align-items:center">
        <button type="submit" class="read-more" style="border:none; cursor:pointer">Post Comment</button>
        <div style="color:var(--muted);font-size:13px">Comments are public.</div>
      </div>
    </form>
  </div>

  <div style="margin-top:12px">
    <?php while($c = $comments->fetch_assoc()): ?>
      <div class="comment">
        <div style="font-weight:700"><?=htmlspecialchars($c['name'])?></div>
        <div class="author"><?=date('M d, Y H:i', strtotime($c['created_at']))?></div>
        <div style="margin-top:6px"><?=nl2br(htmlspecialchars($c['comment']))?></div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php require 'footer.php'; ?>
