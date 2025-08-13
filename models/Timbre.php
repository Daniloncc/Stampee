<?php

namespace App\Models;

use App\Models\CRUD;

class Timbre extends CRUD
{
    protected $table = "timbre";
    protected $primaryKey = "id";
    protected $fillable = ['titre', 'prix', 'tirage', 'dimensions', 'idCertifie', 'idEtat', 'idPays', 'idCouleur', 'description', 'dateCreation'];
}
