<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titre</title>
    <link href="/theme/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 ul-navbar" style="gap: 10px">
                <li>
                    <a href="/" class="btn btn-light">Accueil</a>
                </li>
                <li>
                    <a href="/artist" class="btn btn-light">Artists</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <!--        --><?php //if(!empty($_SESSION['erreur'])): ?>
    <!--            <div class="alert alert-danger" role="alert">-->
    <!--                --><?php //echo $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
    <!--            </div>-->
    <!--        --><?php //endif; ?>
    <!--        --><?php //if(!empty($_SESSION['message'])): ?>
    <!--            <div class="alert alert-success" role="alert">-->
    <!--                --><?php //echo $_SESSION['message']; unset($_SESSION['message']); ?>
    <!--            </div>-->
    <!--        --><?php //endif; ?>
    <?= $contenu ?>
</div>

<footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item">
            <a href="/" class="nav-link px-2 text-muted">Accueil</a>
        </li>
        <li class="nav-item">
            <a href="/artist" class="nav-link px-2 text-muted">Artists</a>
        </li>
    </ul>
    <div class="d-flex align-items-center justify-content-center">
        <span class="mb-3 mb-md-0 text-muted">© 2022 Company, Inc</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>