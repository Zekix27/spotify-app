<?php
namespace App\Controllers;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Image;
use App\Entity\Track;

class SpotifyController extends Controller
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

            if (isset($jsonResult['spotify'])) {
                foreach ($jsonResult['spotify']['items'] as $key => $value){
                    $artist = $this->checkArtistPicture($value);
                    $artists[] = $artist;
                }
            }
        }

        $this->render('spotify/index', compact('artists'));
    }

    /**
     * @param $id
     * @return void
     */
    public function album($id)
    {
        $jsonArtistResult = $this->getArtist($id);
        $artist = $this->checkArtistPicture($jsonArtistResult);

        $albums = [];

        $jsonAlbumResult = $this->getAlbum($id);
        foreach ($jsonAlbumResult['items'] as $key => $value){
            $album = Album::fromJson($value);
            $albums[] = $album;
        }

        $this->render('spotify/artist', compact('artist', 'albums'));
    }

    /**
     * @param $id
     * @return void
     */
    public function track($id) {
        $tracks = [];
        $jsonTrackResult = $this->getTrack($id);
        foreach ($jsonTrackResult['items'] as $key => $value){
            $track = Track::fromJson($value);
            $tracks[] = $track;
        }

        $this->render('spotify/track', compact('tracks'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getArtist($id): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/spotify/'. $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAlbum($id): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/spotify/'. $id . '/albums');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTrack($id): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/albums/'. $id . '/tracks');
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
    }
}