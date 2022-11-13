<?php

use App\Autoloader;
use App\Entity\Artist;

?>

<main>
    <div class="album py-5 bg-light">
        <div class="d-flex flex-column align-items-center mb-2">
            <h1 class="display-5 fw-bold">Cherchez un artiste</h1>
            <form class="col-lg-auto mb-3 mb-lg-0 w-50" role="search" method="post" action="artist">
                <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php
                /** @var Artist[] $artists */
                foreach ($artists as $item) {
                    $genders = implode(' ', $item->getGenres());
                    $link = '"album/id/' . $item->getArtistId() . '"';

                    /** @var Artist[] $favoriteArtists */
                    $svgFill = 'none';
                    $clickFavCall = 'addFavorite';

                    foreach ($favoriteArtists as $key => $value){
                        if ($item->getArtistId() === $value->getArtistId()) {
                            $svgFill = 'red';
                            $clickFavCall = 'deleteFavorite';
                        }
                    }

                    echo '<div class="col">
                    <div class="card shadow-sm">
                    <img src="' . $item->getImages()[0]->getUrl(). '">
                    <form action="/artist/'. $clickFavCall .'" method="post">
                    <input type="hidden" name="id" value="'. $item->getArtistId() .'">
                    <label>
                        <input type="submit" style="display: none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="'. $svgFill .'" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart position-absolute top-0 end-0 m-1 favorite">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </label>
                    </form>

                        <div class="card-body">
                            <p class="card-text d-block text-truncate">'. $item->getName() .'</p>
                            <p class="card-text d-block text-truncate">'. $genders .'</p>
                            <p class="card-text">Followers : '. $item->getFollowers()->getTotal() .'</p>
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