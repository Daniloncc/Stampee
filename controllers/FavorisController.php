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
    public function index($data, $get)
    {
        $favoris = (new Favoris)->select2Id($data['idUtilisateurFavorit'], $data['idEnchereFavorit']);
        if (empty($favoris)) {
            $insert = (new Favoris)->insert($data);
            print("non");
        } else {
            $delete = (new Favoris)->delete2Id($data['idUtilisateurFavorit'], $data['idEnchereFavorit']);
            print("ici");
        }

        $timbre = new Timbre;
        return View::redirect('timbre/timbre?id=' . $get['id'], ['timbre' => $timbre]);
    }
}
