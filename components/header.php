<?php
function getActiveLinkClass($url)
{
  return str_contains($_SERVER['REQUEST_URI'], $url) ? 'btn-light' : 'btn-outline-light';
}
?>
<header class="p-3 text-bg-dark">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 ul-navbar" style="gap: 10px">
        <li>
          <a href="../index.php" title="Allez à l'accueil" class="btn <?= getActiveLinkClass('index.php') ?>">Accueil</a>
        </li>
        <li>
          <a href="../json.php" title="Allez à la boutique" class="btn <?= getActiveLinkClass('json.php') ?>">Json</a>
        </li>
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
        <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" />
      </form>
    </div>
  </div>
</header>
