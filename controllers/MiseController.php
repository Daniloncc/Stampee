<?php

namespace App\Controllers;


use App\Providers\View;
use App\Models\Timbre;
use App\Models\Mise;
use App\Models\Certifie;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\Etat;
use App\Models\Enchere;
use App\Models\Image;
use App\Providers\Validator;
use Intervention\Image\ImageManager;

class MiseController
{
    public function index($data, $get)
    {
        $certifies = (new Certifie)->select();
        $couleurs = (new Couleur)->select();
        $pays = (new Pays)->select();
        $etats = (new Etat)->select();
        $timbres = (new Timbre)->select();
        $timbre = (new Timbre)->selectId($get['id']);
        $encheres = (new Enchere)->select();
        $enchere = (new Enchere)->selectId($data['idEnchereMise']);
        $mises = (new Mise)->select();
        $images = (new Image)->select();
        $usersImages = [];

        if (isset($_SESSION['userId']) && $_SESSION['userId'] == $data['idUtilisateurMise']) {

            foreach ($images as $image) {
                if ($image['idTimbre'] == $get['id']) {
                    $usersImages[] = $image;
                }
            }

            // Filtrer le prix pour la validation et pour enregistrer au bon format
            $prix_input = $_POST['prix'] ?? '';
            $prix_cleaned = trim($prix_input);
            $prix_cleaned = str_replace(',', '.', $prix_cleaned);
            $prix_float = floatval($prix_cleaned);

            $validator = new Validator;
            $validator->field('prix', $prix_cleaned)->number()->required();

            if ($validator->isSuccess()) {
                $dataActuelle = date("Y-m-d H:i:s");
                $data['date'] = $dataActuelle;
                $data['prix'] = $prix_float;

                $enchereTimbre = (new Enchere)->select2Id($timbre['idUtilisateur'], $get['id']);

                foreach ($mises as $key => $mise) {
                    if ($mise['idEnchereMise'] == $enchereTimbre['id']) {
                        //print_r($mise['idEnchereMise']);

                        $enchereMise[] = $mise;
                    }
                }

                if (empty($enchereMise)) {
                    if ($data['prix'] <= $timbre['prix']) {
                        $errors['prix'] = "La mise doit etre en haut de " . $timbre['prix'] . "$!";
                        return View::render('timbre/timbre', ['errors' => $errors, 'encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
                    } else {
                        $premierMise = (new Mise)->insert($data);
                        return View::render('timbre/timbre', ['mise' => $data, 'encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
                    }
                } else {
                    if ($data['prix'] <= $mise['prix']) {
                        $errors['prix'] = "La mise doit etre en haut de " . $mise['prix'] . "$!";
                        return View::render('timbre/timbre', ['mise' => $mise, 'errors' => $errors, 'encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
                    } else {
                        $remise = (new Mise)->insert($data);
                        return View::render('timbre/timbre', ['mise' => $data, 'encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
                    }
                }
            } else {
                $errors = $validator->getErrors();
                if (isset($errors['prix']) && $errors['prix'] != null) {
                    $errors['prix'] = "La valeur doit etre un chiffre!";
                }
                return View::render('timbre/timbre', ['errors' => $errors, 'encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
            }
        } else {
            return View::redirect('auth/logout');
        }
    }
}
