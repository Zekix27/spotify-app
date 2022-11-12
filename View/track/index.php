<?php
use App\Autoloader;
use App\Entity\Track;
use App\Entity\Album;


?>

<main>
    <div class="d-flex flex-column align-items-center mb-2">
        <?php
        /** @var boolean $isQuery */
        $title = 'Cherchez un album';

        if (!$isQuery) {
            /** @var Album $album */
            $title = 'Voici les albums de '. $album->getName();
        }
        ?>
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
    <div class="container mt-4">
        <table class="table table-dark table-striped">
            <tr>
                <th>Name</th>
                <th>Duration</th>
                <th>Song</th>
                <th>Author</th>
                <th>Nombre de disque</th>
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
                    array_push($artists, $artist->getName());
                }
                $artists = implode(', ', $artists);
                echo '        
                <tr>
                    <td>'. $item->getName() .'</td>
                    <td>'. millisecondToMinSecFormat($item->getDurationMs()) .'</td>
                    <td><a href="'. $item->getExternalUrls()->getSpotify() .'">Spotify link</a></td>
                    <td>'. $artists .'</td>
                    <td>'. $item->getDiscNumber() .'</td>
                </tr>
        ';
            }
            ?>
        </table>
    </div>
</main>
