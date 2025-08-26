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
use App\Models\Favoris;
use Intervention\Image\ImageManager;

class EnchereController
{
    // Affichage des pages Encheres, Favoris, En vigueur, Archivees et Coup du couer du Lord
    public function index($get = [])
    {
        $timbresToutUsage = new Timbre;
        $timbres = $timbresToutUsage->select();
        $encheres = (new Enchere)->select();
        $images = (new Image)->select();
        $pays = (new Pays)->select();
        $certifies = (new Certifie)->select();
        $etats = (new Etat)->select();
        $couleurs = (new Couleur)->select();

        // Variables Archivees
        $encheresArchivee = [];
        $timbreArchivee = [];
        $imagesArchivee = [];

        // Variables En vigeur
        $encheresEnVigueur = [];
        $timbreEnVigueur = [];
        $imagesEnVigueur = [];

        // Variables Lord
        $encheresLord = [];
        $timbreLord  = [];
        $imagesLord  = [];

        // Variables Favoris
        $encheresFavoris = [];
        $timbreFavoris  = [];
        $imagesFavoris  = [];

        $dateActuelle = date('Y-m-d H:i:s');

        // Séparer les enchères  Archivées, En vigueur, du Lord et Favoris
        foreach ($encheres as $enchere) {

            // Archivees
            $timbreEnchere = $timbresToutUsage->selectId($enchere['idTimbreEnchere']);
            if ($enchere['dateFin'] < $dateActuelle) {
                $encheresArchivee[] = $enchere;
                $timbreArchivee[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesArchivee[] = $image;
                    }
                }
            }
            // En vigueur
            else {
                $encheresEnVigueur[] = $enchere;
                $timbreEnVigueur[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesEnVigueur[] = $image;
                    }
                }
            }
            // Lord
            if ($enchere['coupLord'] == 1) {
                $encheresLord[] = $enchere;
                $timbreLord[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesLord[] = $image;
                    }
                }
            }
            // Favoris
            $favoris = (new Favoris)->select2Id($_SESSION['userId'], $enchere['id']);
            if (!empty($favoris)) {
                $encheresFavoris[] = $enchere;
                $timbreFavoris[] = $timbreEnchere;
                foreach ($images as $image) {
                    if ($image['idTimbre'] == $timbreEnchere['id']) {
                        $imagesFavoris[] = $image;
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
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Encheres en vigueur',
                'condition' => $condition
            ]);
        } elseif ($condition === 'archivee') {
            return View::render('enchere/index', [
                'encheres' => $encheresArchivee,
                'timbres' => $timbreArchivee,
                'images' => $imagesArchivee,
                'pays' => $pays,
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Encheres archivees',
                'condition' => $condition
            ]);
        } elseif ($condition === 'coupDuLord') {
            return View::render('enchere/index', [
                'encheres' => $encheresLord,
                'timbres' => $timbreLord,
                'images' => $imagesLord,
                'pays' => $pays,
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Coup du coeur du Lord',
                'condition' => $condition
            ]);
        } elseif ($condition === 'favoris') {
            return View::render('enchere/index', [
                'encheres' => $encheresFavoris,
                'timbres' => $timbreFavoris,
                'images' => $imagesFavoris,
                'pays' => $pays,
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Mes Favoris',
                'condition' => $condition
            ]);
        } else {
            return View::render('enchere/index', [
                'encheres' => $encheres,
                'timbres' => $timbres,
                'images' => $images,
                'pays' => $pays,
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Toutes les enchères',
                'condition' => $condition
            ]);
        }
    }

    public function filtre($data)
    {
        // pays
        // certifie
        // etat
        // envigueur
        // archivee
        // lord
        print("<pre>");
        print_r($data);
        print("<pre>");
        die;
        $timbresToutUsage = new Timbre;
        $timbres = $timbresToutUsage->select();

        $encheres = (new Enchere)->select();
        $images = (new Image)->select();
        $pays = (new Pays)->select();
        $certifies = (new Certifie)->select();
        $couleurs = (new Couleur)->select();
        $etats = (new Etat)->select();

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
        $condition = $get['condition']; // 'tous' par défaut

        if ($condition === 'envigueur') {
            return View::render('enchere/index', [
                'encheres' => $encheresEnVigueur,
                'timbres' => $timbreEnVigueur,
                'images' => $imagesEnVigueur,
                'pays' => $pays,
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Encheres en vigueur',
                'condition' => $condition
            ]);
        } elseif ($condition === 'archivee') {
            return View::render('enchere/index', [
                'encheres' => $encheresArchivee,
                'timbres' => $timbreArchivee,
                'images' => $imagesArchivee,
                'pays' => $pays,
                'etats' => $etats,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'page' => 'Encheres archivees',
                'condition' => $condition
            ]);
        }
    }
}
