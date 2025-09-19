<?php
// comment_handler.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php'); exit;
}
$article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if(!$article_id || !$name || !$comment){
    // Basic validation failure - redirect back
    echo "<script>window.location.href='article.php?id={$article_id}';</script>";
    exit;
}

// insert comment (approved)
$stmt = $mysqli->prepare("INSERT INTO comments (article_id,name,email,comment,approved) VALUES (?,?,?,?,1)");
$stmt->bind_param('isss', $article_id, $name, $email, $comment);
$stmt->execute();
$stmt->close();

// JS redirect back to article (as you requested client-side redirect)
echo "<script>window.location.href='article.php?id={$article_id}';</script>";
exit;
