<?php

namespace App\Controllers;

use App\Providers\View;

class HomeController
{

    public function index()
    {
        return View::render('/home');
    }

    public function error()
    {
        return View::render('/error');
    }
}
