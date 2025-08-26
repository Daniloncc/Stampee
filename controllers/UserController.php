<?php

namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;
use App\Models\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
class UserController
{
    // Afficher la lage de creation
    final public function create()
    {
        return View::render('user/create');
    }

    // Ajouter un utilisateur
    final public function store($data)
    {

        $validator = new Validator;
        $validator->field('nom', $data['nom'])->onlyLetters()->min(2)->max(45);
        $validator->field('prenom', $data['prenom'])->onlyLetters()->min(2)->max(25);
        $validator->field('adresse', $data['adresse'])->min(4)->max(80);
        $validator->field('telephone', $data['telephone'])->number()->min(10)->max(13);
        $validator->field('courriel', $data['courriel'])->email()->min(4)->max(80);
        $validator->field('motPasse', $data['motPasse'])->onlyLettersAndNumbers();

        if ($validator->isSuccess()) {
            $user = new User;
            // Hash du mot de passe
            $data['motPasse'] = $user->hashPassword($data['motPasse']);

            // Inserer l'utilisateur
            $insertUser = $user->insert($data);

            if ($insertUser == "Le courriel existe déjà.") {
                $errors = $validator->getErrors();
                return View::render('user/create', ['errors' => $errors, 'user' => $data, 'message' => $insertUser]);
            } else {
                // Envoyer courriel de confirmation  -  enlever pour WEBDEV
                $mail = new PHPMailer(true);

                try {
                    // Configuration SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'dancc86@gmail.com';
                    $mail->Password = 'oylp wijw sigd eoiq';   // mot de passe d’application
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Destinataires
                    $mail->setFrom('dancc86@gmail.com', 'Bienvenue du monsieur Stampee!');
                    $mail->addAddress($data['courriel'], $data['prenom']);

                    $nom = $data['prenom'];
                    // Contenu
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmation d\'inscription';
                    $mail->Body    = "Bonjour $nom,<br><br>Ton inscription a bien été prise en compte.<br>Merci et bienvenue !";

                    $mail->send();
                    return View::render('auth/index');
                    //return true;
                } catch (Exception $e) {
                    error_log("Erreur d'envoi de mail : {$mail->ErrorInfo}");
                    return false;
                }
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('user/create', ['errors' => $errors, 'user' => $data]);
        }
    }

    // Affichage des donnes du utilisateur connecte
    final public function show()
    {
        // Connexion avec la session ouverte
        if (isset($_SESSION['userId'])) {
            $user = new User;
            $user = $user->selectId($_SESSION['userId']);

            return View::render('user/show', ['user' => $user]);
        } else {
            return View::render('error', ['message' => '404 page non trouve!']);
        }
    }

    // Afficher la page pour mettre ajout avec les infos du utilisateur
    final public function edit($data)
    {
        if (isset($data['id']) && $data['id'] != null && $data['id'] == $_SESSION['userId']) {
            $user = new User;
            $user = $user->selectId($data['id']);

            if ($user) {
                return View::render('user/edit', ['user' => $user]);
            } else {
                return View::render('error', ['message' => "Ce Client n'existe pas!"]);
            }
        } else {
            return View::render('error', ['message' => '404 page non trouve!']);
        }
    }

    // Mise a jour du utilisateur
    final public function update($data, $get)
    {
        if (isset($get['id']) && $get['id'] != null && $get['id'] == $_SESSION['userId']) {

            $validator = new Validator;
            $validator->field('nom', $data['nom'])->onlyLetters()->min(2)->max(45);
            $validator->field('prenom', $data['prenom'])->onlyLetters()->min(2)->max(25);
            $validator->field('adresse', $data['adresse'])->min(4)->max(80);
            $validator->field('telephone', $data['telephone'])->number()->min(10)->max(13);
            $validator->field('courriel', $data['courriel'])->email()->min(4)->max(80);

            if ($validator->isSuccess()) {
                $user = new User;

                // Selectionner le utilisateur connecte avec la session
                $courrielExistant = $user->selectId($_SESSION['userId']);

                // Selectionner le courriel dans la base de donnes de cet utilisateur
                $courrielExistant = $courrielExistant['courriel'];

                // Comparer le nouveau courriel choisi avec les courriels dans la base de donnees, soit retourne rien ou le curriel trouve
                $testUser = $user->unique('courriel', $data['courriel']);

                // Verifier si le nouveau courriel choisi par l'utilisatuer exite das la base de donnees, si oui, comparer si le courriel qui est dans la base de donnees est different du nouveau courriel choisi
                if (isset($testUser['courriel']) && $testUser['courriel'] != $courrielExistant) {
                    $errors = $validator->getErrors();
                    return View::render('user/edit', ['message' => "Le courriel existe déjà.", 'user' => $data]);
                } else {
                    $insertUser = $user->update($data, $data['id']);
                    return View::redirect('user/show', ['user' => $insertUser]);
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('user/edit', ['errors' => $errors, 'user' => $data]);
            }
        } else {
            return View::render('error', ['message' => 'Impossible de mettre vos informations a jour!']);
        }
    }

    // Supprimer un utilisateur
    final public function delete($data)
    {
        // Supprimer l'utilisateur et aussi faire la deconnexion
        if ($data['id'] == $_SESSION['userId']) {
            $user = new User;
            $delete = $user->delete($data['id']);
            if ($delete) {
                return View::redirect('auth/logout');
            }
        }
    }
}
