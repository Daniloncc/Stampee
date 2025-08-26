<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Timbre;
use App\Models\Certifie;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\Etat;
use App\Models\Enchere;
use App\Models\Favoris;
use App\Models\Image;

class FavorisController
{

    public function favoris()
    {
        $enchereId = $_GET["enchereId"];
        $utilisateurId = $_GET["utilisateurId"];
        $reponse = [];

        $data['idUtilisateurFavorit'] = $utilisateurId;
        $data['idEnchereFavorit'] = $enchereId;

        // Verifier s'il ya un favoris ou pas
        $favoris = (new Favoris)->select2Id($utilisateurId, $enchereId);
        if (empty($favoris)) {
            $insert = (new Favoris)->insert($data);
            $reponse = "oui";
        } else {
            $delete = (new Favoris)->delete2Id($utilisateurId, $enchereId);
            $reponse = "non";
        }
        echo json_encode(["reponse" => $reponse]);
    }
}
