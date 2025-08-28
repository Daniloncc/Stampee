<?php

namespace App\Models;

use App\Models\CRUD;

class Favoris extends CRUD
{
    protected $table = "Favoris";
    protected $secondaryKey1 = "idUtilisateurFavorit";
    protected $secondaryKey2 = "idEnchereFavorit";
    protected $fillable = ['idUtilisateurEnchere', 'idTimbreEnchere'];
}
