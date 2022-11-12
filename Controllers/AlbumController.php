<?php
namespace App\Controllers;

use App\Entity\Album;
use App\Entity\Artist;

class AlbumController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $isQuery = true;
        $albums = [];

        if (isset($_POST['search'])){
            $search = $_POST['search'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/search?q='. $search .'&type=album');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $jsonResult = json_decode($result, true);

            if (isset($jsonResult['albums'])) {
                foreach ($jsonResult['albums']['items'] as $key => $value){
                    $album = Album::fromJson($value);
                    $albums[] = $album;
                }
            }
        }

        $this->render('album/index', compact('albums', 'isQuery'));
    }

    public function id($artistId) {
        $isQuery = false;
        $albums = [];
        $jsonArtist = ArtistController::getArtist($artistId);
        $artist = Artist::fromJson($jsonArtist);

        $jsonResult = $this->getAlbumsByArtistId($artistId);
        if (isset($jsonResult['items'])) {
            foreach ($jsonResult['items'] as $key => $value){
                $album = Album::fromJson($value);
                $albums[] = $album;
            }
        }
        $this->render('album/index', compact('albums', 'isQuery', 'artist'));
    }

    /**
     * @param $artistId
     * @return mixed
     */
    public function getAlbumsByArtistId($artistId): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/artists/'. $artistId . '/albums');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public static function getAlbum($id) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/albums/'. $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function addFavorite() {
        $albumJson = self::getAlbum($_POST['id']);
        $album = Album::fromJson($albumJson);

        $checkInDB = $album->findBy(['albumId' => $album->getAlbumId()]);

        if(empty($checkInDB)) {
            $album->create();
        }

        header('Location:/album');
    }

    public function deleteFavorite() {
        $id = $_POST['id'];
        $album = Album::createEmptyAlbum();
        $album->delete($id);
    }
}