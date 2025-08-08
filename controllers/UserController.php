<?php

namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;
// use App\Models\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
class UserController
{
    final public function create()
    {
        return View::render('user/create');
    }

    final public function store($data)
    {

        $validator = new Validator;
        $validator->field('nom', $data['nom'])->onlyLetters()->min(2)->max(45);
        $validator->field('prenom', $data['prenom'])->onlyLetters()->min(2)->max(25);
        $validator->field('adresse', $data['adresse'])->min(4)->max(80);
        $validator->field('telephone', $data['telephone'])->number()->min(10)->max(13);
        $validator->field('courriel', $data['courriel'])->email()->min(4)->max(80);
        $validator->field('motPasse', $data['motPasse'])->onlyLettersAndNumbers();
        // print("ici");
        // die;
        if ($validator->isSuccess()) {
            $user = new User;
            $data['motPasse'] = $user->hashPassword($data['motPasse']);
            $insertUser = $user->insert($data);

            if ($insertUser == "Le courriel existe déjà.") {
                $errors = $validator->getErrors();
                // print_r($insertUser);
                // die;
                return View::render('user/create', ['errors' => $errors, 'user' => $data, 'message' => $insertUser]);
            } else {
                $mail = new PHPMailer(true);

                try {
                    // Configuration SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // change ça si tu utilises un autre service
                    $mail->SMTPAuth = true;
                    $mail->Username = 'dancc86@gmail.com'; // ton email
                    $mail->Password = 'oylp wijw sigd eoiq';   // mot de passe d’application
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Destinataires
                    $mail->setFrom('dancc86@gmail.com', 'Ton Projet');
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

    final public function show($data)
    {

        if (isset($data['id']) && isset($_SESSION['userId']) && $data['id'] != null && $data['id'] == $_SESSION['userId']) {
            $user = new User;
            $user = $user->selectId($data['id']);

            if ($user) {

                return View::render('user/show', ['user' => $user]);
                // print_r($user);
                // print_r($data['id']);
                // print($_SESSION['userId']);
                // die;
            } else {
                return View::render('error', ['message' => "Ce Client n'existe pas!"]);
            }
        } else {
            return View::render('error', ['message' => '404 page non trouve!']);
        }
    }

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

                $courrielExistant = $user->selectId($_SESSION['userId']);
                $courrielExistant = $courrielExistant['courriel'];
                $testUser = $user->unique('courriel', $data['courriel']);

                if (isset($testUser['courriel']) && $testUser['courriel'] != $courrielExistant) {
                    $errors = $validator->getErrors();
                    return View::render('user/edit', ['message' => "Le courriel existe déjà.", 'user' => $data]);
                } else {
                    $insertUser = $user->update($data, $data['id']);
                    return View::redirect('user/show?id=' . $data['id'], ['user' => $insertUser]);
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('user/edit', ['errors' => $errors, 'user' => $data]);
            }
        } else {
            return View::render('error', ['message' => 'Impossible de mettre vos informations a jour!']);
        }
    }

    final public function delete($data)
    {
        if ($data['id'] == $_SESSION['userId']) {
            $user = new User;
            $delete = $user->delete($data['id']);
            if ($delete) {
                return View::redirect('auth/logout');
            }
        }
    }
}
