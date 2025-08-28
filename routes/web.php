<?php

use App\Routes\Route;

// Route de base
Route::get('/', 'EnchereController@accueil');
Route::get('/home', 'EnchereController@accueil');

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
Route::get('/timbre/mytimbres', 'TimbreController@mytimbres');
Route::get('/timbre/create', 'TimbreController@create');
Route::get('/timbre/index', 'TimbreController@index');
Route::get('/timbre/timbre', 'TimbreController@timbre');
Route::get('/timbre/edit', 'TimbreController@edit');
Route::get('/timbre/delete', 'TimbreController@delete');

// Route POST pour le Timbre
Route::post('/timbre/update', 'TimbreController@update');
Route::post('/timbre/store', 'TimbreController@store');
Route::post('/timbre/delete', 'TimbreController@delete');

// Route GET pour les images
Route::get('/image/edit', 'ImageController@edit');
Route::get('/image/delete', 'ImageController@delete');

// Route POST pour l'Image
Route::post('/image/action', 'ImageController@action');

// Route GET pour les encheres
Route::get('/enchere/index', 'EnchereController@index');

// Route POST pour les encheres
Route::post('/enchere/index', 'EnchereController@index');

// Route POST pour la mise
Route::post('/mise/index', 'MiseController@index');

// Route api pour la Favoris
Route::get('/api/favoris/favoris', 'FavorisController@favoris');


Route::dispatch();
