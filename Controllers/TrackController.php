<?php
namespace App\Controllers;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Image;
use App\Entity\Track;

class TrackController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $isQuery = true;
        $tracks = [];

        if (isset($_POST['search'])){
            $search = $_POST['search'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/search?q='. $search .'&type=track');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $jsonResult = json_decode($result, true);

            if (isset($jsonResult['tracks'])) {
                foreach ($jsonResult['tracks']['items'] as $key => $value){
                    $track = Track::fromJson($value);
                    $tracks[] = $track;
                }
            }
        }

        $favoriteTracks = $this->getAllTrackFavorite();

        $this->render('track/index', compact('tracks', 'isQuery', 'favoriteTracks'));
    }

    public function id($albumId)
    {
        $isQuery = false;
        $tracks = [];
        $jsonAlbum = AlbumController::getAlbum($albumId);
        $album = Artist::fromJson($jsonAlbum);

        $jsonResult = $this->getTracksByAlbumId($albumId);
        if (isset($jsonResult['items'])) {
            foreach ($jsonResult['items'] as $key => $value){
                $track = Track::fromJson($value);
                $tracks[] = $track;
            }
        }

        $favoriteTracks = $this->getAllTrackFavorite();

        $this->render('track/index', compact('tracks', 'isQuery', 'album', 'favoriteTracks'));
    }

    public function getTracksByAlbumId($albumId): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/albums/'. $albumId . '/tracks');
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
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/tracks/'. $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function addFavorite() {
        $trackJson = self::getTrack($_POST['id']);
        $track = Track::fromJson($trackJson);

        $checkInDB = $track->findBy(['trackId' => $track->getTrackId()]);

        if(empty($checkInDB)) {
            $track->create();
        }

        header('Location:/track');
    }

    public function deleteFavorite() {
        $id = $_POST['id'];
        $track = Track::createEmptyTrack();
        $track->delete($id);
    }

    /**
     * @return array
     */
    public function getAllTrackFavorite(): array
    {
        $tracks = [];
        $track = Track::createEmptyTrack();
        $trackFavorite = $track->findAll();

        if (is_bool($trackFavorite)) {
            return $tracks;
        }
        foreach ($trackFavorite as $key => $value){
            $track = Track::fromJsonDB((array)$value);
            $tracks[] = $track;
        }
        return $tracks;
    }
}