<?php
use App\Autoloader;
use App\Entity\Track;


?>

<main>
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
