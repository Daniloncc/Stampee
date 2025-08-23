<?php

namespace App\Models;

use App\Models\CRUD;

class Enchere extends CRUD
{
    protected $table = "Enchere";
    protected $primaryKey = "id";
    protected $fillable = ['dateDebut', 'dateFin', 'prixPlancher', 'coupLord', 'idUtilisateurEnchere', 'idTimbreEnchere'];
}
