<?php

namespace App\Models;

use App\Models\CRUD;

class Enchere extends CRUD
{
    protected $table = "Enchere";
    protected $primaryKey = "id";
    protected $secondaryKey1 = "idUtilisateurEnchere";
    protected $secondaryKey2 = "idTimbreEnchere";
    protected $fillable = ['dateDebut', 'dateFin', 'prixPlancher', 'coupLord', 'idUtilisateurEnchere', 'idTimbreEnchere'];
}
