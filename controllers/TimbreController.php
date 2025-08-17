<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Timbre;
use App\Models\Certifie;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\Etat;
use App\Models\Image;
use App\Providers\Validator;
use Intervention\Image\ImageManager;

class TimbreController
{
    public function index()
    {
        $timbres = new Timbre;
        $timbres = $timbres->select();

        $images = new Image;
        $images = $images->select();

        $pays = new Pays;
        $pays = $pays->select();
        // print_r($images);
        //print_r($timbres);
        // print_r($pays);
        // die;
        return View::render('timbre/index', ['timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
    }

    final public function create()
    {

        $certifie = new Certifie;
        $certifies = $certifie->select();
        $couleur = new Couleur;
        $couleurs = $couleur->select();
        $pays = new Pays;
        $pays = $pays->select();
        $etat = new Etat;
        $etat = $etat->select();
        // print_r($certifies);
        // die;
        return View::render('timbre/create', ['certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat]);
    }

    final public function store($data)
    {
        // ADRESSE POUR ENREGISTRER L'IMAGE, CHANGER POUR LE WEBDEV
        $upload_dir_on_server = "/Applications/MAMP/htdocs/STAMPEE/mvc/public/img/";
        $db_image_prefix = "img/";
        $imagesData = [];

        // print_r($data);
        // die;

        // Verifier si cest pas vide l'array d'image
        if (!empty($_FILES['images']['name'][0])) {

            // filtrer le prix pour la validation et pour enregistrer au bon format
            $prix_input = $_POST['prix'] ?? '';
            $prix_cleaned = trim($prix_input);
            $prix_cleaned = str_replace(',', '.', $prix_cleaned);
            $prix_float = floatval($prix_cleaned);

            $validator = new Validator;
            $validator->field('titre', $data['titre'])->onlyLetters()->min(2)->max(45);
            $validator->field('tirage', $data['tirage'], 'tirage')->number()->required();
            $validator->field('dimensions', $data['dimensions'])->min(2)->max(45)->required();
            $validator->field('prix', $prix_cleaned)->number()->required();
            $validator->field('idCertifie', $data['idCertifie'], 'idCertifie')->required();
            $validator->field('idPays', $data['idPays'], 'idPays')->required();
            $validator->field('idEtat', $data['idEtat'], 'idEtat')->required();
            $validator->field('idCouleur', $data['idCouleur'], 'idCouleur')->required();
            $validator->field('description', $data['description'], 'description')->required();

            if ($validator->isSuccess()) {
                // Ajouter la Date actuelle pour l'enregistrement aussi comme le prix au bon format FLOAT
                $dataActuelle = date("Y-m-d H:i:s");
                $data['dateCreation'] = $dataActuelle;
                $data['prix'] = $prix_float;

                $timbre = new Timbre;
                $insertTimbre = $timbre->insert($data);

                $selectId = new Timbre;
                $selectId = $selectId->selectId($insertTimbre);
                $idTimbre = $selectId['id'];

                // Boucle pour valider les images
                foreach ($_FILES['images']['name'] as $key => $originalFileName) {

                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {

                        $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
                        $filename_without_ext = pathinfo($originalFileName, PATHINFO_FILENAME);
                        $filename = $filename_without_ext . "." . $imageFileType;
                        $target_file_path_on_server = $upload_dir_on_server . $filename;

                        // Validation format
                        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                        if (!in_array($imageFileType, $allowed)) {
                            continue;
                        }

                        // Validation taille
                        if ($_FILES['images']['size'][$key] > 500000) {
                            continue;
                        }

                        // Vérifie si c'est bien une image
                        $check = getimagesize($_FILES['images']['tmp_name'][$key]);
                        if ($check === false) {
                            continue;
                        }

                        // Déplace l'image
                        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file_path_on_server)) {
                            $imagesData[] = $db_image_prefix . $filename;
                            $image = new Image;
                            $imageTableau = [];
                            $imageTableau['image'] = $filename_without_ext;
                            $imageTableau['lien'] = $filename;
                            $imageTableau['idTimbre'] = $idTimbre;

                            $image = $image->insert($imageTableau);
                        }
                    }
                }
                $timbres = new Timbre;
                $timbres = $timbres->select();

                $images = new Image;
                $images = $images->select();

                $pays = new Pays;
                $pays = $pays->select();
                //print_r($pays);
                //die;
                // print_r($images);
                // print_r($timbres);
                // die;
                return View::redirect('timbre/index', ['timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
            } else {
                $certifie = new Certifie;
                $certifies = $certifie->select();
                $couleur = new Couleur;
                $couleurs = $couleur->select();
                $pays = new Pays;
                $pays = $pays->select();
                $etat = new Etat;
                $etat = $etat->select();

                if (isset($errors['idCertifie']) && $errors['idCertifie'] != null) {
                    $errors['idCertifie'] = "Une reponse est necessaire!";
                }
                if (isset($errors['idCouleur']) && $errors['idCouleur'] != null) {
                    $errors['idCouleur'] = "La couleur est necessaire!";
                }
                if (isset($errors['idPays']) && $errors['idPays'] != null) {
                    $errors['idPays'] = "Un pays est necessaire!";
                }
                if (isset($errors['idEtat']) && $errors['idEtat'] != null) {
                    $errors['idEtat'] = "L'etat est necessaire!";
                }
                if (isset($errors['description']) && $errors['description'] != null) {
                    $errors['description'] = "La description est necessaire!";
                }

                $errors = $validator->getErrors();
                return View::render('timbre/create', ['errors' => $errors, 'timbre' => $data, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat]);
            }
        } else {
            $errors['images'] = "Une erreur inattendue s'est produite lors de l'upload.";

            // On récupère les codes d'erreur de tous les fichiers
            foreach ($_FILES['images']['error'] as $index => $errorCode) {
                if ($errorCode !== UPLOAD_ERR_OK) {
                    $errors['images'] .= " (Fichier $index : Code d'erreur $errorCode)";
                }
            }

            // Recharge les données pour le formulaire
            $certifie = new Certifie;
            $certifies = $certifie->select();
            $couleur = new Couleur;
            $couleurs = $couleur->select();
            $pays = new Pays;
            $pays = $pays->select();
            $etat = new Etat;
            $etat = $etat->select();

            // Message si aucune image envoyée
            if (empty($_FILES['images']['name'][0])) {
                $errors['images'] = "L'image est nécessaire !";
            }

            return View::render('timbre/create', [
                'timbre' => $data,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'pays' => $pays,
                'etat' => $etat,
                'errors' => $errors
            ]);
        }
    }

    public function timbre($get)
    {

        $timbre = new Timbre;
        $timbre = $timbre->selectId($get['id']);

        $timbres = new Timbre;
        $timbres = $timbres->select();
        $timbreParPays = [];

        foreach ($timbres as $timbresPays) {

            if ($timbresPays['idPays'] == $timbre['idPays']) {
                $timbreParPays[] = $timbresPays;
            }
        }

        $images = new Image;
        $images = $images->select();
        $usersImages = [];
        foreach ($images as $image) {

            if ($image['idTimbre'] == $get['id']) {
                $usersImages[] = $image;
            }
        }

        $pays = new Pays;
        $pays = $pays->select();
        $usersPays = "";
        foreach ($pays as $pay) {
            if ($pay['id'] == $timbre['idPays']) {
                $usersPays = $pay;
            }
        }

        $certifie = new Certifie;
        $certifies = $certifie->select();
        $couleur = new Couleur;
        $couleurs = $couleur->select();
        $pays = new Pays;
        $pays = $pays->select();
        $etat = new Etat;
        $etat = $etat->select();
        // print("<pre>");
        // print_r($usersPays);
        // print("</pre>");
        // die;
        return View::render('timbre/timbre', ['timbres' => $timbreParPays, 'timbre' => $timbre, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat, 'page' => 'Timbre']);
    }

    final public function edit($get)
    {
        $timbre = new Timbre;
        $timbre = $timbre->selectId($get['id']);
        $utilisateurIdTimbre = $timbre['idUtilisateur'];

        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {
            // print_r($utilisateurIdTimbre);
            // die;
            $certifie = new Certifie;
            $certifies = $certifie->select();
            $couleur = new Couleur;
            $couleurs = $couleur->select();
            $pays = new Pays;
            $pays = $pays->select();
            $etat = new Etat;
            $etat = $etat->select();

            return View::render('timbre/edit', ['timbre' => $timbre, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat, 'page' => 'Timbre']);
        } else {
            return View::render('error', ['message' => "Vous n'etes pas autorise!"]);
        }
    }

    final public function delete($data)
    {

        if ($data['idUtilisateur'] == $_SESSION['userId']) {

            $images = new Image;
            $images = $images->select();
            $usersImages = [];
            // Deleter tous les images du timbre avant de deleter le timbre a cause de la cle etrangere
            foreach ($images as $image) {
                if ($image['idTimbre'] == $data['id']) {
                    $imageDeleter = new Image;
                    $deleter = $imageDeleter->delete($image['id']);
                }
            }

            $timbres = new Timbre;
            $timbres = $timbres->select();

            $pays = new Pays;
            $pays = $pays->select();

            $timbre = new Timbre;
            $deleteTimbre = $timbre->delete($data['id']);
            if ($deleteTimbre) {
                return View::render('timbre/index', ['timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
            }
        }
    }
}
