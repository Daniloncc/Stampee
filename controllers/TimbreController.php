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

        return View::render('timbre/create', ['certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat]);
    }

    final public function store($data)
    {
        // ADRESSE POUR ENREGISTRER L'IMAGE, CHANGER POUR LE WEBDEV
        $upload_dir_on_server = "/Applications/MAMP/htdocs/STAMPEE/mvc/public/img/";

        // Verifier si cest pas vide l'array d'image
        if (!empty($_FILES['images']['name'][0])) {

            // Filtrer le prix pour la validation et pour enregistrer au bon format
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

                // Inserer le timbre
                $timbre = new Timbre;
                $insertTimbre = $timbre->insert($data);

                // Selectioner le Id du timbre enregistre pour faire l'insertion des images
                $selectId = new Timbre;
                $selectId = $selectId->selectId($insertTimbre);
                $idTimbre = $selectId['id'];

                // Boucle pour valider les images
                // Lister l'ordre de chaque image enregistre
                $index = 0;
                foreach ($_FILES['images']['name'] as $key => $originalFileName) {

                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {

                        // Variables
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

                        // Nouveau nom avec _idTimbre
                        $newFileName = $filename_without_ext . "_" . $idTimbre . "." . $imageFileType;

                        // Nouveau chemin cible
                        $target_file_path_on_server = $upload_dir_on_server . $newFileName;

                        // Enregistrer l'image en local et apres dans la base de donnees
                        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file_path_on_server)) {

                            $image = new Image;
                            $imageTableau = [];
                            $imageTableau['image'] = $filename_without_ext;
                            $imageTableau['lien'] = $filename_without_ext . "_" . $idTimbre . "." . $imageFileType;
                            $imageTableau['idTimbre'] = $idTimbre;
                            $imageTableau['ordre'] = $index;

                            $image = $image->insert($imageTableau);
                            $index++;
                        }
                    }
                }
                $timbres = new Timbre;
                $timbres = $timbres->select();

                $images = new Image;
                $images = $images->select();

                $pays = new Pays;
                $pays = $pays->select();

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
                $errors = $validator->getErrors();
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

        // Validation de Id
        if (isset($timbre['idUtilisateur']) && $get['id'] != null && $_SESSION['userId'] == $timbre['idUtilisateur']) {

            $timbres = new Timbre;
            $timbres = $timbres->select();
            $timbreParPays = [];

            // Filtre pour afficher les timbres par pays
            // foreach ($timbres as $timbresPays) {

            //     if ($timbresPays['idPays'] == $timbre['idPays']) {
            //         $timbreParPays[] = $timbresPays;
            //     }
            // }

            // Filtrer les images du timbre
            $images = new Image;
            $images = $images->select();
            $usersImages = [];
            foreach ($images as $image) {

                if ($image['idTimbre'] == $get['id']) {
                    $usersImages[] = $image;
                }
            }

            $certifie = new Certifie;
            $certifies = $certifie->select();

            $couleur = new Couleur;
            $couleurs = $couleur->select();

            $pays = new Pays;
            $pays = $pays->select();

            $etat = new Etat;
            $etats = $etat->select();

            return View::render('timbre/timbre', ['timbres' => $timbreParPays, 'timbre' => $timbre, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
        } else {
            return View::render('error', ['message' => '404 page non trouve!']);
        }
    }

    final public function edit($get)
    {
        $timbre = new Timbre;
        $timbre = $timbre->selectId($get['id']);

        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {

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

    final public function update($data)
    {

        if (isset($data) && $data != null && $data['idUtilisateur'] == $_SESSION['userId']) {

            // Filtrer le prix pour la validation et pour enregistrer au bon format
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
                $dataActuelle = date("Y-m-d");
                $data['dateCreation'] = $dataActuelle;
                $data['prix'] = $prix_float;

                // Faire le mise a jour du timbre
                $timbre = new Timbre;
                $updateTimbre = $timbre->update($data, $data['id']);
                if ($updateTimbre) {
                    return View::redirect('timbre/timbre?id=' . $data['id'], ['timbre' => $$data]);
                }
            } else {
                $certifie = new Certifie;
                $certifies = $certifie->select();

                $couleur = new Couleur;
                $couleurs = $couleur->select();

                $pays = new Pays;
                $pays = $pays->select();

                $etat = new Etat;
                $etat = $etat->select();

                $errors = $validator->getErrors();
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

                return View::render('timbre/edit', ['errors' => $errors, 'timbre' => $data, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat]);
            }
        } else {
            return View::render('error', ['message' => 'Impossible de mettre vos informations a jour!']);
        }
    }

    final public function delete($get)
    {
        $timbre = new Timbre;
        $timbre = $timbre->selectId($get['id']);

        $images = new Image;
        $images = $images->select();

        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {

            // Deleter tous les images du timbre avant de deleter le timbre a cause de la cle etrangere
            foreach ($images as $image) {
                if ($image['idTimbre'] == $timbre['id']) {
                    $imageDeleter = new Image;
                    $deleter = $imageDeleter->delete($image['id']);
                }
            }
            $timbres = new Timbre;
            $timbres = $timbres->select();

            $pays = new Pays;
            $pays = $pays->select();

            $timbredel = new Timbre;
            $deleteTimbre = $timbredel->delete($get['id']);
            if ($deleteTimbre) {
                return View::redirect('timbre/index', ['timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
            }
        }
    }
}
