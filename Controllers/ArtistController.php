<?php
namespace App\Controllers;

use App\Entity\Artist;
use App\Entity\ExternalUrl;
use App\Entity\Image;

class ArtistController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $artists = [];

        if (isset($_POST['search'])){
            $search = $_POST['search'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/search?q='. $search .'&type=artist');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $jsonResult = json_decode($result, true);

            if (isset($jsonResult['artists'])) {
                foreach ($jsonResult['artists']['items'] as $key => $value){
                    $artist = $this->checkArtistPicture($value);
                    $artists[] = $artist;
                }
            }
        }

        $favoriteArtists = $this->getAllArtistFavorite();

        $this->render('artist/index', compact('artists', 'favoriteArtists'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getArtist($id): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/artists/'. $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }


    /**
     * @param $artistJson
     * @return Artist
     */
    public function checkArtistPicture($artistJson): Artist
    {
        if(!isset($artistJson['images'][0])){
            $artist = Artist::fromJson($artistJson);
            $images = [];
            $image = new Image(100, 'https://media.tenor.com/4fH8zSIuSvcAAAAM/cristiano-ronaldo-soccer.gif', 100);
            $images[] = $image;
            $artist->setImages($images);
        }else{
            $artist = Artist::fromJson($artistJson);
        }
        return $artist;
    }

    public function addFavorite() {
        $artistJson = $this->getArtist($_POST['id']);
        $artist = $this->checkArtistPicture($artistJson);

        $checkInDB = $artist->findBy(['artistId' => $artist->getArtistId()]);

        if(empty($checkInDB)) {
            $artist->create();
        }

        header('Location:/artist');
    }

    public function deleteFavorite() {
        $id = $_POST['id'];
        $artist = Artist::createEmptyArtist();
        $artist->delete($id);

        header('Location:/artist');
    }

    /**
     * @return array
     */
    public function getAllArtistFavorite(): array
    {
        $artists = [];
        $artist = Artist::createEmptyArtist();
        $artistFavorite = $artist->findAll();

        if (is_bool($artistFavorite)) {
            return $artists;
        }
        foreach ($artistFavorite as $key => $value){
            $artist = Artist::fromJsonDB((array)$value);
            $artists[] = $artist;
        }
        return $artists;
    }
}