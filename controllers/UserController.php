<?php

namespace App\Controllers;

//use App\Models\User;
use App\Providers\View;
//use App\Providers\Validator;
//use App\Models\Auth;

class UserController
{
    final public function create()
    {
        // print("ixi");
        // die;
        return View::render('user/create');
    }
}
