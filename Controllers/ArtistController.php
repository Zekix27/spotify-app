<?php
namespace App\Controllers;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Image;
use App\Entity\Track;

class ArtistController extends Controller
{
    public function index()
    {
        $search = 'orelsan';
        if (isset($_POST['search'])){
            $search = $_POST['search'];
        }

        $artists = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/search?q='. $search .'&type=artist');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result, true);

        foreach ($jsonResult['artists']['items'] as $key => $value){

            if(!isset($value['images'][0])){
                $artist = Artist::fromJson($value);
                $images = [];
                $image = new Image(100, 'https://media.tenor.com/4fH8zSIuSvcAAAAM/cristiano-ronaldo-soccer.gif', 100);
                array_push($images, $image);
                $artist->setImages($images);
            }else{
                $artist = Artist::fromJson($value);
            }

            array_push($artists, $artist);

        }

        curl_close($ch);

        $this->render('artists/index', compact('artists'));
    }

    public function album($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/artists/'. $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result, true);

        if(!isset($jsonResult['images'][0])){
            $artist = Artist::fromJson($jsonResult);
            $images = [];
            $image = new Image(100, 'https://media.tenor.com/4fH8zSIuSvcAAAAM/cristiano-ronaldo-soccer.gif', 100);
            array_push($images, $image);
            $artist->setImages($images);
        }else{
            $artist = Artist::fromJson($jsonResult);
        }

        $albums = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/artists/'. $id . '/albums');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result, true);

        foreach ($jsonResult['items'] as $key => $value){

            $album = Album::fromJson($value);

            array_push($albums, $album);
        }

        curl_close($ch);
        $this->render('artists/artist', compact('artist', 'albums'));
    }

    public function track($id) {
        $tracks = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/albums/'. $id . '/tracks');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result, true);

        foreach ($jsonResult['items'] as $key => $value){

            $track = Track::fromJson($value);

            array_push($tracks, $track);
        }

        curl_close($ch);
        $this->render('artists/track', compact('tracks'));
    }
}