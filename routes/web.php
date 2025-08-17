<?php

use App\Routes\Route;

// Route de base
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// Route de User GET
Route::get('/user/create', 'UserController@create');
Route::get('/user/show', 'UserController@show');
Route::get('/user/edit', 'UserController@edit');

// Route POST pour le user
Route::post('/user/connection', 'UserController@login');
Route::post('/user/store', 'UserController@store');
Route::post('/user/edit', 'UserController@update');
Route::post('/user/delete', 'UserController@delete');

// Route GET pour l'auth'
Route::get('/auth/index', 'AuthController@connection');
Route::get('/auth/logout', 'AuthController@delete');

// Route POST pour l'auth'
Route::post('/auth/index', 'AuthController@login');

// Route GET pour les timbre
Route::get('/timbre/create', 'TimbreController@create');
Route::get('/timbre/index', 'TimbreController@index');
Route::get('/timbre/timbre', 'TimbreController@timbre');
Route::get('/timbre/edit', 'TimbreController@edit');

// Route POST pour le Timbre
Route::post('/timbre/delete', 'UserController@delete');

// Route POST pour l'auth'
Route::post('/timbre/store', 'TimbreController@delete');



Route::dispatch();
