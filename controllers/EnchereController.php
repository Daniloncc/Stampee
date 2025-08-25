<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Timbre;
use App\Models\Certifie;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\Etat;
use App\Models\Enchere;
use App\Models\Image;
use App\Providers\Validator;
use Intervention\Image\ImageManager;

class EnchereController
{
    public function index($get = [])
    {
        $timbresToutUsage = new Timbre;
        $timbres = $timbresToutUsage->select();

        $encheres = (new Enchere)->select();
        $images = (new Image)->select();
        $pays = (new Pays)->select();

        $dateActuelle = date('Y-m-d H:i:s');

        $encheresArchivee = [];
        $timbreArchivee = [];
        $imagesArchivee = [];

        $encheresEnVigueur = [];
        $timbreEnVigueur = [];
        $imagesEnVigueur = [];

        $encheresLord = [];
        $timbreLord  = [];
        $imagesLord  = [];

        // Séparer les enchères en vigueur et archivées
        foreach ($encheres as $enchere) {

            $timbreEnchere = $timbresToutUsage->selectId($enchere['idTimbreEnchere']);
            if ($enchere['dateFin'] < $dateActuelle) {
                $encheresArchivee[] = $enchere;
                $timbreArchivee[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesArchivee[] = $image;
                    }
                }
            } else {
                $encheresEnVigueur[] = $enchere;
                $timbreEnVigueur[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesEnVigueur[] = $image;
                    }
                }
            }
            if ($enchere['coupLord'] == 1) {
                $encheresLord[] = $enchere;
                $timbreLord[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesLord[] = $image;
                    }
                }
            }
        }

        // Déterminer la condition
        $condition = $get['condition'] ?? 'tous'; // 'tous' par défaut

        if ($condition === 'envigueur') {
            return View::render('enchere/index', [
                'encheres' => $encheresEnVigueur,
                'timbres' => $timbreEnVigueur,
                'images' => $imagesEnVigueur,
                'pays' => $pays,
                'page' => 'Encheres en vigueur',
                'condition' => $condition
            ]);
        } elseif ($condition === 'archivee') {
            return View::render('enchere/index', [
                'encheres' => $encheresArchivee,
                'timbres' => $timbreArchivee,
                'images' => $imagesArchivee,
                'pays' => $pays,
                'page' => 'Encheres archivees',
                'condition' => $condition
            ]);
        } elseif ($condition === 'coupDuLord') {
            return View::render('enchere/index', [
                'encheres' => $encheresLord,
                'timbres' => $timbreLord,
                'images' => $imagesLord,
                'pays' => $pays,
                'page' => 'Coup du coeur du Lord',
                'condition' => $condition
            ]);
        } else {
            // Cas "tous" : on envoie tout
            // print_r($encheres);
            // die;
            return View::render('enchere/index', [
                'encheres' => $encheres,
                'timbres' => $timbres,
                'images' => $images,
                'pays' => $pays,
                'page' => 'Toutes les enchères',
                'condition' => $condition
            ]);
        }
    }
}
