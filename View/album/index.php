<?php

use App\Autoloader;
use App\Entity\Artist;

?>

<main>
    <div class="album py-5 bg-light">
        <div class="d-flex flex-column align-items-center mb-2">
            <?php
            /** @var boolean $isQuery */
            $title = 'Cherchez un album';

            if (!$isQuery) {
                /** @var Artist $artist */
                $title = 'Voici les albums de '. $artist->getName();
            }?>
            <h1 class="display-5 fw-bold"><?= $title ?></h1>
            <?php
            if ($isQuery) {
                echo '   
                    <form class="col-lg-auto mb-3 mb-lg-0 w-50" role="search" method="post" action="album">
                        <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>
                ';
            }
            ?>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php
                /** @var Album[] $albums */
                foreach ($albums as $item) {
                    $artists = [];
                    foreach ($item->getArtists() as $artist) {
                        $artists[] = $artist->getName();
                    }
                    $artists = implode(', ', $artists);
                    $link = '"/track/id/' . $item->getAlbumId() . '"';

                    /** @var Album[] $favoriteAlbums */
                    $svgFill = 'none';

                    foreach ($favoriteAlbums as $key => $value){
                        if ($item->getAlbumId() === $value->getAlbumId()) {
                            $svgFill = 'red';
                        }
                    }

                    echo '<div class="col">
                    <div class="card shadow-sm">
                    <img src="' . $item->getImages()[0]->getUrl(). '">
                    <form action="/album/addFavorite" method="post">
                    <input type="hidden" name="id" value="'. $item->getAlbumId() .'">
                    <label>
                        <input type="submit" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="'. $svgFill .'" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart position-absolute top-0 end-0 m-1 favorite">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </label>
                    </form>

                        <div class="card-body">
                            <p class="card-text">Titre : '. $item->getName() .'</p>
                            <p class="card-text">Artistes : '. $artists .'</p>
                            <p class="card-text">Total de track : '. $item->getTotalTracks() .'</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href='. $link .' type="button" class="btn btn-sm btn-outline-secondary">View</a>
                                </div>
                                <small class="text-muted"></small>
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