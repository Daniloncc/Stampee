<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Image;
use App\Models\Certifie;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\Etat;
use App\Models\Timbre;
use Intervention\Image\ImageManager;

class ImageController
{

    final public function action($data)
    {
        // Selecioner tous les images
        $images = new Image;
        $images = $images->select();

        // Selecioner le timbre par son Id
        $timbre = new Timbre;
        $timbre = $timbre->selectId($data['id']);

        // Variable pour avoir tous les images du timbre et l'image principale
        $timbreImages = [];
        $imagePrincipale = [];

        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {
            foreach ($images as $image) {
                if ($image['idTimbre'] == $timbre['id']) {

                    if ($image['ordre'] == 0) {
                        // Variable pour enregistrer l'image d'ordre 0 (la principale)
                        $imagePrincipale = $image;
                    }
                    $timbreImages[] = $image;
                }
            }

            // Chemin pour enregistrer l'image en local
            $chemin_local = "/Applications/MAMP/htdocs/STAMPEE/mvc/public/img/";
            //$chemin_local = "https://e2495746.webdev.cmaisonneuve.qc.ca/STAMPEE/mvc/public/img/";

            // MISE A JOUR DE L'IMAGE PRINCIPALE
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {

                // Variables 
                $uploadOk = 1;
                $originalFileName = basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
                $filename_without_ext = pathinfo($originalFileName, PATHINFO_FILENAME);
                $filename = $filename_without_ext . "." . $imageFileType;
                $target_file_path_on_server = $chemin_local . $filename_without_ext . "_" . $timbre['id'] . "." . $imageFileType;

                //  Validations de l'image 
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check === false) {
                    $errors['image'] = "Le fichier n'est pas une image.";
                    $uploadOk = 0;
                }

                if ($_FILES["image"]["size"] > 500000) {
                    $errors['image'] = "Désolé, votre fichier est trop volumineux (max 500KB).";
                    $uploadOk = 0;
                }

                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp"
                    && $imageFileType != "gif"
                ) {
                    $errors['image'] = "Désolé, seuls les fichiers JPG, JPEG, PNG, WEBP et GIF sont autorisés.";
                    $uploadOk = 0;
                }

                if ($uploadOk == 0) {
                } else {
                    $imagePremiere = new Image;

                    // Variable/array pour l'image a envoyer
                    $timbreImage = [];
                    $timbreImage['ordre'] = 0;
                    $timbreImage['image'] = $filename_without_ext;
                    $timbreImage['idTimbre'] = $timbre['id'];
                    $timbreImage['lien'] = $filename_without_ext . "_" . $timbre['id'] . "." . $imageFileType;

                    // Deleter l'ancien image principale premier dans le local et apres dans la base de donnees
                    if (file_exists($chemin_local . $imagePrincipale['lien'])) {
                        unlink($chemin_local . $imagePrincipale['lien']);

                        $imageDeleter = new Image;
                        $delete = $imageDeleter->delete($imagePrincipale['id']);
                    }

                    // Inserer la nouvelle image dans le local et apres dans la base de donnees
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file_path_on_server)) {

                        $imageUpdate = new Image;
                        $image = $imageUpdate->insert($timbreImage);

                        return View::redirect('image/edit?id=' . $data['id']);
                    } else {
                        $errors['image'] = "Désolé, une erreur s'est produite lors de l'upload de votre fichier.";
                    }
                }
            } else {
                $errors['image'] = "Une erreur inattendue s'est produite lors de l'upload : Code d'erreur " . $_FILES["image"]["error"];
            }

            // AJOUTER DES IMAGES SECONDAIRES

            // Variable pour lister l'ordre de chaque image enregistre
            $index = 0;
            // Boucle pour valider les images
            foreach ($_FILES['images']['name'] as $key => $originalFileName) {

                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    // Variables 
                    $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
                    $filename_without_ext = pathinfo($originalFileName, PATHINFO_FILENAME);
                    $filename = $filename_without_ext . "." . $imageFileType;
                    $target_file_path_on_server = $chemin_local . $filename;

                    // Validations
                    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($imageFileType, $allowed)) {
                        continue;
                    }

                    if ($_FILES['images']['size'][$key] > 500000) {
                        continue;
                    }

                    $check = getimagesize($_FILES['images']['tmp_name'][$key]);
                    if ($check === false) {
                        continue;
                    }

                    // Variable: Lien pour l'image
                    $imgLien = $filename_without_ext . "_" . $timbre['id'] . "." . $imageFileType;

                    // Verification si l'image est unique, si non on l'enregistre
                    $imgUnique = new Image;
                    $userExist = $imgUnique->unique('lien', $imgLien);

                    if (!$userExist) {

                        // Nouveau chemin cible
                        $target_file_path_on_server = $chemin_local . $imgLien;
                        // Variable pour assurer que l'image ne sera jamais l'image principale avec ordre = 0
                        $index = 1;
                        // Enregistrer l'image en local
                        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file_path_on_server)) {
                            // Variable/array pour l'image a envoyer
                            $image = new Image;
                            $imageTableau = [];
                            $imageTableau['image'] = $filename_without_ext;
                            $imageTableau['lien'] = $filename_without_ext . "_" . $timbre['id'] . "." . $imageFileType;
                            $imageTableau['idTimbre'] = $timbre['id'];
                            $imageTableau['ordre'] = $index;

                            $image = $image->insert($imageTableau);
                            // Assuerer qu'on va donner une ordre croissante a les images ajoutees
                            $index++;
                        }
                    }
                }
            }
            return View::redirect('image/edit?id=' . $timbre['id'], ['images' => $timbreImages, 'page' => 'Images']);
        }
    }

    final public function edit($get)
    {
        // Selecioner tous les images
        $images = new Image;
        $images = $images->select();
        $timbreImages = [];

        // Selecioner le timbre souhaite
        $timbre = new Timbre;
        $timbre = $timbre->selectId($get['id']);

        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {
            foreach ($images as $image) {
                if ($image['idTimbre'] == $timbre['id']) {
                    // Enregister tous le images du timbre souhaite
                    $timbreImages[] = $image;
                }
            }
            return View::render('image/edit', ['timbre' => $timbre, 'images' => $timbreImages, 'page' => 'Images']);
        } else {
            return View::render('error', ['message' => "Vous n'etes pas autorise!"]);
        }
    }

    final public function delete($get)
    {
        // Selecioner tous les images
        $images = new Image;
        $images = $images->select();
        $timbreImages = [];

        // Selecioner l'image souhaite
        $image = new Image;
        $image = $image->selectId($get['id']);

        // Selecioner le timbre souhaite
        $timbre = new Timbre;
        $timbre = $timbre->selectId($image['idTimbre']);

        if ($timbre['idUtilisateur'] == $_SESSION['userId']) {
            $chemin_local = "/Applications/MAMP/htdocs/STAMPEE/mvc/public/img/";
            //$chemin_local = "https://e2495746.webdev.cmaisonneuve.qc.ca/STAMPEE/mvc/public/img/";
            $imgLienDeleter = $image['lien'];
            $imagePath = $chemin_local . $imgLienDeleter;

            // Verifier si l'image existe en local, si ou l'effacer et apres l'effacer dans la base de donnees
            if (file_exists($imagePath)) {
                unlink($imagePath);

                $imageDeleter = new Image;
                $delete = $imageDeleter->delete($image['id']);

                if ($delete) {
                    foreach ($images as $image) {
                        if ($image['idTimbre'] == $timbre['id']) {
                            // Reselecioner tous les images dans la base de donnees du timbre souhaite
                            $timbreImages[] = $image;
                        }
                    }
                    return View::redirect('image/edit?id=' . $image['idTimbre'], ['images' => $timbreImages, 'page' => 'Images']);
                }
            } else {
                echo "Le fichier n'existe pas.";
            }
        }
    }
}
