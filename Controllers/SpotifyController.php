<?php
namespace App\Controllers;

class SpotifyController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
//        $artists = [];
//
//        if (isset($_POST['search'])){
//            $search = $_POST['search'];
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/search?q='. $search .'&type=artist');
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $result = curl_exec($ch);
//            curl_close($ch);
//
//            $jsonResult = json_decode($result, true);
//
//            if (isset($jsonResult['spotify'])) {
//                foreach ($jsonResult['spotify']['items'] as $key => $value){
//                    $artist = $this->checkArtistPicture($value);
//                    $artists[] = $artist;
//                }
//            }
//        }

        $this->render('spotify/index');
    }
}