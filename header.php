<?php
// header.php
if (!isset($page_title)) $page_title = 'DHL News';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=htmlspecialchars($page_title)?></title>
<style>
/* INTERNAL CSS - make it beautiful and realistic */
:root{--accent:#d40000;--muted:#666;--bg:#f4f4f6;--card:#fff;--maxw:1100px}
*{box-sizing:border-box}
body{font-family: "Helvetica Neue", Arial, sans-serif; background:var(--bg); color:#222; margin:0; padding:0; -webkit-font-smoothing:antialiased}
.container{max-width:var(--maxw); margin:24px auto; padding:0 16px}
.header{background:linear-gradient(90deg,#fff, #fafafa); border-bottom:1px solid #e6e6e6; padding:18px 0; position:sticky; top:0; z-index:50}
.brand{display:flex; align-items:center; gap:16px}
.brand .logo{font-weight:800; color:var(--accent); font-size:28px; letter-spacing:1px}
.nav{margin-top:8px; display:flex; gap:12px; flex-wrap:wrap}
.nav button{background:none; border:none; padding:8px 12px; cursor:pointer; font-weight:600; color:#333; border-radius:6px}
.nav button:hover{background:#f0f0f0}
.searchbar{margin-left:auto; display:flex; gap:8px; align-items:center}
.searchbar input{padding:8px 10px; border:1px solid #ddd; border-radius:6px; min-width:220px}
.hero{display:grid; grid-template-columns: 2fr 1fr; gap:16px; margin-top:18px}
.card{background:var(--card); border-radius:8px; overflow:hidden; box-shadow:0 6px 18px rgba(10,10,20,0.06); border:1px solid #eee}
.card img{width:100%; display:block}
.card .meta{padding:14px}
.title{font-size:20px; margin:0 0 8px}
.summary{color:var(--muted); font-size:14px}
.categories{display:flex; gap:12px; margin-top:16px; flex-wrap:wrap}
.cat-btn{background:#fff; border:1px solid #e9e9e9; padding:8px 12px; border-radius:6px; cursor:pointer}
.grid{display:grid; grid-template-columns: repeat(3,1fr); gap:16px; margin-top:18px}
@media(max-width:900px){ .hero{grid-template-columns:1fr} .grid{grid-template-columns:repeat(2,1fr)} .searchbar input{min-width:140px}}
@media(max-width:600px){ .grid{grid-template-columns:1fr} .nav{display:none} .brand{justify-content:space-between} .searchbar{margin-left:0} }
.footer-small{font-size:13px; color:var(--muted); margin-top:14px; padding:14px 0; text-align:center}
.label{display:inline-block; background:#f8f8f8; padding:6px 8px; border-radius:6px; color:#333; font-weight:600; font-size:13px}
.trending-list{display:flex; flex-direction:column; gap:10px; padding:12px}
.small-item{display:flex; gap:10px; align-items:center}
.small-item img{width:80px; height:56px; object-fit:cover; border-radius:6px}
.author{font-size:13px; color:var(--muted)}
.read-more{display:inline-block; margin-top:10px; padding:8px 12px; background:var(--accent); color:#fff; border-radius:6px; text-decoration:none}
.comment-box{margin-top:14px}
.comment{border-top:1px solid #f0f0f0; padding:10px 0}
</style>
</head>
<body>
<header class="header">
  <div class="container" style="display:flex;flex-direction:column">
    <div style="display:flex;align-items:center">
      <div class="brand">
        <div class="logo">DHL</div>
        <div style="font-size:13px;color:var(--muted)">Daily Headline & Live</div>
      </div>
      <div class="searchbar" style="margin-left:auto">
        <input id="top-search" type="search" placeholder="Search articles...">
        <button onclick="doSearch()">Search</button>
      </div>
    </div>
    <nav class="nav" id="top-nav">
      <button onclick="goTo('index.php')">Home</button>
      <button onclick="goTo('category.php?cat_id=1')">World</button>
      <button onclick="goTo('category.php?cat_id=2')">Business</button>
      <button onclick="goTo('category.php?cat_id=3')">Tech</button>
      <button onclick="goTo('category.php?cat_id=4')">Sports</button>
      <button onclick="goTo('category.php?cat_id=5')">Entertainment</button>
    </nav>
  </div>
</header>
<main class="container" style="padding-top:10px;">
