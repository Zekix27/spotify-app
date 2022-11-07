<?php

use App\Autoloader;
use App\Entity\Artist;

?>

<main>
    <div class="album py-5 bg-light">
        <div class="d-flex flex-column align-items-center mb-2">
            <h1 class="display-5 fw-bold">Cherchez un artiste</h1>
            <form class="col-lg-auto mb-3 mb-lg-0" role="search" method="post" action="artist">
                <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php
                /** @var Artist[] $artists */
                foreach ($artists as $item) {
                    $genders = implode(' ', $item->getGenres());
                    $link = '"artist/album/' . $item->getId() . '"';

                    echo '<div class="col">
                    <div class="card shadow-sm">
                    <img src="' . $item->getImages()[0]->getUrl(). '">

                        <div class="card-body">
                            <p class="card-text">'. $item->getName() .'</p>
                            <p class="card-text">'. $genders .'</p>
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