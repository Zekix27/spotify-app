<?php

use App\Autoloader;
use App\Entity\Artist;

require 'Auth-Spotify.php';
require 'Autoloader.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=booba&type=artist");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch));
curl_close($ch);
echo '<pre>';
//var_dump($result);
echo '</pre>';

$artists = [];

foreach ($result->artists->items as $item) {
    $artist = new Artist($item->name, $item->id, $item->followers->total, $item->genres, $item->external_urls->spotify, $item->images[0]->url);
    array_push($artists, $artist);
}

var_dump($artists);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<?php include_once "./components/header.php" ?>

<main>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php
                    foreach ($result->artists->items as $item) {
                        echo '<div class="col">
                    <div class="card shadow-sm">
                    <img src="' . $item->images[0]->url . '">

                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted">'. $item->name .'</small>
                            </div>
                        </div>
                    </div>
                </div>';
                    }
                ?>
            </div>
        </div>
    </div>
</main>
<?php include_once "./components/footer.php" ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>


