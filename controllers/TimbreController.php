<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Timbre;
use App\Models\Certifie;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\Etat;
use App\Models\Image;
use App\Models\Enchere;
use App\Models\Mise;
use App\Models\Favoris;
use App\Providers\Validator;
use Intervention\Image\ImageManager;

class TimbreController
{
    // Affichage de tous les timbres
    public function index()
    {
        $encheres = (new Enchere)->select();
        $timbres = (new Timbre)->select();
        $images = (new Image)->select();
        $pays = (new Pays)->select();

        return View::render('timbre/index', ['encheres' => $encheres, 'timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Tous les timbres']);
    }
    // Affichage de mes timbres
    public function mytimbres()
    {
        $encheres = (new Enchere)->select();
        $timbres = (new Timbre)->select();
        $images = (new Image)->select();
        $pays = (new Pays)->select();

        return View::render('timbre/mytimbres', ['encheres' => $encheres, 'timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
    }

    // Creation d'un timbre
    final public function create()
    {
        $certifies = (new Certifie)->select();
        $couleurs = (new Couleur)->select();
        $pays = (new Pays)->select();
        $etats = (new Etat)->select();

        return View::render('timbre/create', ['certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etats]);
    }

    // Enregistrer un timbre avec ces images
    final public function store($data)
    {
        $certifies = (new Certifie)->select();
        $couleurs = (new Couleur)->select();
        $pays = (new Pays)->select();
        $etats = (new Etat)->select();

        // ADRESSE POUR ENREGISTRER L'IMAGE, CHANGER POUR LE WEBDEV
        $upload_dir_on_server = "/Applications/MAMP/htdocs/STAMPEE/mvc/public/img/";
        //$upload_dir_on_server = "/home/e2495746/www/STAMPEE/mvc/public/img/";

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
                $data['prix'] = number_format($prix_float, 2);


                // Inserer le timbre
                $insertTimbre = (new Timbre)->insert($data);

                // Selectioner le Id du timbre enregistre pour faire l'insertion des images
                $selectId = (new Timbre)->selectId($insertTimbre);
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

                        // Nouveau nom d'image avec _idTimbre
                        $newFileName = $filename_without_ext . "_" . $idTimbre . "." . $imageFileType;

                        // Nouveau chemin cible
                        $target_file_path_on_server = $upload_dir_on_server . $newFileName;

                        // Enregistrer l'image en local et apres dans la base de donnees
                        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file_path_on_server)) {

                            $imageTableau = [];
                            $imageTableau['image'] = $filename_without_ext;
                            $imageTableau['lien'] = $filename_without_ext . "_" . $idTimbre . "." . $imageFileType;
                            $imageTableau['idTimbre'] = $idTimbre;
                            $imageTableau['ordre'] = $index;

                            $image = new Image;
                            $image = $image->insert($imageTableau);
                            // Augmanter la valeur pour l'image suivante (ORDRE)
                            $index++;
                        }
                    }
                }
                $timbres = (new Timbre)->select();
                $images = (new Image)->select();

                return View::redirect('timbre/index', ['timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
            } else {

                $certifies = (new Certifie)->select();
                $couleurs = (new Couleur)->select();
                $pays = (new Pays)->select();
                $etat = (new Etat)->select();

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

            // Message si aucune image envoyée
            if (empty($_FILES['images']['name'][0])) {
                $errors['images'] = "L'image est nécessaire !";
            }

            return View::render('timbre/create', [
                'timbre' => $data,
                'certifies' => $certifies,
                'couleurs' => $couleurs,
                'pays' => $pays,
                'etat' => $etats,
                'errors' => $errors
            ]);
        }
    }

    // Affichage d'un timbre
    public function timbre($get)
    {
        $certifies = (new Certifie)->select();
        $couleurs = (new Couleur)->select();
        $pays = (new Pays)->select();
        $etats = (new Etat)->select();
        $timbres = (new Timbre)->select();
        $timbre = (new Timbre)->selectId($get['id']);
        $encheres = (new Enchere)->select();
        $mises = (new Mise)->select();
        $images = (new Image)->select();

        // Verifier s'il y a une enchere pour ce timbre
        $enchereTimbre = (new Enchere)->select2Id($timbre['idUtilisateur'], $get['id']);

        // Verifier si c'est un favorit
        $favoris = (new Favoris)->select2Id($_SESSION['userId'], $enchereTimbre['id']);

        if (empty($favoris)) {
            $favoris = "inactive";
            // print("pas de favorit");
        } else {
            // print("favorit");
            $favoris = "";
        }

        //Enregistrer les images du timbre
        $usersImages = [];
        foreach ($images as $image) {
            if ($image['idTimbre'] == $get['id']) {
                $usersImages[] = $image;
            }
        }

        // Si existe une enchere pour ce timbre on cherche les mises de cet enchere
        $enchereMise = [];
        if ($enchereTimbre) {
            foreach ($mises as $key => $mise) {
                if ($mise['idEnchereMise'] == $enchereTimbre['id']) {
                    $enchereMise[] = $mise;
                }
            }
        }

        // S'il y a des mises on prend la derniere mise
        if (!empty($enchereMise)) {
            $mise = end($enchereMise);

            return View::render('timbre/timbre', ['favoris' => $favoris, 'mise' => $mise, 'encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
        } else {
            return View::render('timbre/timbre', ['encheres' => $encheres, 'timbres' => $timbres, 'timbre' => $timbre, 'imagesTimbres' => $images, 'images' => $usersImages, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etats' => $etats, 'page' => 'Timbre']);
        }
    }

    // Affichage de la page pour editer un timbre
    final public function edit($get)
    {
        $timbre = (new Timbre)->selectId($get['id']);

        // Verifier si la cle etrangere du timbre(utilisateur) est la mame de la session ouverte
        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {

            $certifies = (new Certifie)->select();
            $couleurs = (new Couleur)->select();
            $pays = (new Pays)->select();
            $etat = (new Etat)->select();

            return View::render('timbre/edit', ['timbre' => $timbre, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etat, 'page' => 'Timbre']);
        } else {
            return View::render('error', ['message' => "Vous n'etes pas autorise!"]);
        }
    }

    // Faire le mise a jour du timbre
    final public function update($data)
    {
        // Verifier si la cle etrangere du timbre(utilisateur) est la mame de la session ouverte
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
                // Ajouter la date actuelle pour l'enregistrement aussi comme le prix au bon format FLOAT
                $dataActuelle = date("Y-m-d");
                $data['dateCreation'] = $dataActuelle;
                $data['prix'] = $prix_float;

                // Faire le mise a jour du timbre
                $updateTimbre = (new Timbre)->update($data, $data['id']);
                if ($updateTimbre) {
                    return View::redirect('timbre/timbre?id=' . $data['id'], ['timbre' => $$data]);
                }
            } else {

                $certifies = (new Certifie)->select();
                $couleurs = (new Couleur)->select();
                $pays = (new Pays)->select();
                $etats = (new Etat)->select();

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

                return View::render('timbre/edit', ['errors' => $errors, 'timbre' => $data, 'certifies' => $certifies, 'couleurs' => $couleurs, 'pays' => $pays, 'etat' => $etats]);
            }
        } else {
            return View::render('error', ['message' => 'Impossible de mettre vos informations a jour!']);
        }
    }

    // Supprimer un timbre
    final public function delete($get)
    {
        $timbre = (new Timbre)->selectId($get['id']);
        $images = (new Image)->select();

        // Verifier si la cle etrangere du timbre(utilisateur) est la mame de la session ouverte
        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {

            // Deleter tous les images du timbre avant de deleter le timbre a cause de la cle etrangere
            foreach ($images as $image) {
                if ($image['idTimbre'] == $timbre['id']) {
                    $imageDeleter = new Image;
                    $deleter = $imageDeleter->delete($image['id']);
                }
            }
            $timbres = (new Timbre)->select();
            $pays = (new Pays)->select();
            $deleteTimbre = (new Timbre)->delete($get['id']);

            if ($deleteTimbre) {
                return View::redirect('timbre/index', ['timbres' => $timbres, 'images' => $images, 'pays' => $pays, 'page' => 'Mes timbres']);
            } else {
                return View::redirect('auth/logout');
            }
        }
    }
}
