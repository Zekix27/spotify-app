<?php
namespace App\Controllers;


class MainController extends Controller
{
    public function index()
    {
        $this->render('main/index');
    }

    public function json() {
        $this->render('main/json', [], 'empty');
    }
}