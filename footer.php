<?php
// footer.php
?>
</main>
<footer class="container footer-small">
  &copy; <?=date('Y')?> DHL — All rights reserved.
</footer>

<script>
/* Internal JS - use JS for page redirection as requested */
function goTo(url){
  // client-side redirect
  window.location.href = url;
}

function doSearch(){
  var q = document.getElementById('top-search').value.trim();
  if(!q) return;
  // use JS to redirect to search.php with query param
  window.location.href = 'search.php?q=' + encodeURIComponent(q);
}
</script>
</body>
</html>
