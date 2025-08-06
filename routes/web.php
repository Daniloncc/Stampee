<?php

use App\Routes\Route;

// Route de base
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// Route de User GET
Route::get('/user/create', 'UserController@create');

Route::dispatch();
