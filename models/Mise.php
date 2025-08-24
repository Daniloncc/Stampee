<?php

namespace App\Models;

use App\Models\CRUD;

class Mise extends CRUD
{
    protected $table = "Mise";
    protected $primaryKey = "id";
    protected $secondaryKey1 = "idUtilisateurMise";
    protected $secondaryKey2 = "idEnchereMise";
    protected $fillable = ['idUtilisateurMise', 'idEnchereMise', 'prix', 'date'];
}
