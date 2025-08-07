<?php

namespace App\Controllers;

use App\Providers\Auth;
use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;

class AuthController
{
    final public function connection()
    {
        return View::render('auth/index');
    }

    final public function login($data)
    {

        $validator = new Validator;
        $validator->field('courriel', $data['courriel'])->email()->min(4)->max(80);
        $validator->field('motPasse', $data['motPasse'])->onlyLettersAndNumbers();

        if ($validator->isSuccess()) {
            $userCheck = new User;
            $user = new User;
            $champ = array_key_first($data);
            $userExist = $user->unique($champ, $data['courriel']);

            if ($userExist) {
                $checkuser = $userCheck->checkUser($data['courriel'], $data['motPasse']);
                if ($checkuser) {
                    if (Auth::session()) {
                        $user = new User;
                        $user = $user->selectId($_SESSION['userId']);
                        return View::redirect('user/show?id=' . $_SESSION['userId'], ['user' => $user]);
                    } else {
                        $errors['message'] = "Mauvaise utilisateur!";
                        return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
                    }
                } else {
                    $errors['message'] = 'Mot de pass incorrect !';
                    return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
                }
            } else {
                $errors['message'] = "C'est Utilisateur n'existe pas!";
                return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
        }
    }

    final public function delete()
    {
        session_destroy();
        return View::redirect('auth/index');
    }
}
