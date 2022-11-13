<?php
use App\Autoloader;
use App\Entity\Track;
use App\Entity\Album;


?>

<main>
    <div class="d-flex flex-column align-items-center mb-2">
        <?php
        /** @var boolean $isQuery */
        $title = 'Cherchez une musique';

        if (!$isQuery) {
            /** @var Album $album */
            $title = 'Voici les musiques de l\'album '. $album->getName();
        }
        ?>
        <h1 class="display-5 fw-bold"><?= $title ?></h1>
        <?php
        if ($isQuery) {
            echo '   
                    <form class="col-lg-auto mb-3 mb-lg-0 w-50" role="search" method="post" action="track">
                        <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>
                ';
        }
        ?>
    </div>
    <div class="container mt-4">
        <table class="table table-dark table-striped">
            <tr>
                <th>Name</th>
                <th>Duration</th>
                <th>Song</th>
                <th>Author</th>
                <th>Nombre de disque</th>
                <th>Favorite</th>
            </tr>
            <?php
            function millisecondToMinSecFormat(int $milliseconde): string
            {

                $uSec = $milliseconde % 1000;
                $input = floor($milliseconde / 1000);

                $seconds = $input % 60;
                $input = floor($input / 60);

                $minutes = $input % 60;
                $input = floor($input / 60);

                return $minutes.':'.$seconds;
            }

            /** @var Track[] $tracks */
            foreach ($tracks as $item) {
                $artists = [];
                foreach ($item->getArtists() as $artist) {
                    $artists[] = $artist->getName();
                }
                $artists = implode(', ', $artists);

                /** @var Track[] $favoriteTracks */
                $svgFill = 'none';

                foreach ($favoriteTracks as $key => $value){
                    if ($item->getTrackId() === $value->getTrackId()) {
                        $svgFill = 'red';
                    }
                }
                echo '        
                <tr>
                    <td>'. $item->getName() .'</td>
                    <td>'. millisecondToMinSecFormat($item->getDurationMs()) .'</td>
                    <td><a href="'. $item->getExternalUrls()->getSpotify() .'">Spotify link</a></td>
                    <td>'. $artists .'</td>
                    <td>'. $item->getDiscNumber() .'</td>
                    <td>
                        <form action="/track/addFavorite" method="post">
                            <input type="hidden" name="id" value="'. $item->getTrackId() .'">
                            <label>
                                <input type="submit" style="display: none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="'. $svgFill .'" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart top-0 end-0 m-1 favorite">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </label>
                        </form>
                    </td>
                </tr>
        ';
            }
            ?>
        </table>
    </div>
</main>
