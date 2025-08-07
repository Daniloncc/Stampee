<?php

namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;
//use App\Models\Auth;

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
                return View::render('auth/index');
                //return View::redirect('user/show?id=' . $insertUser);
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('user/create', ['errors' => $errors, 'user' => $data]);
        }
    }

    final public function show($data)
    {

        if (isset($data['id']) && $data['id'] != null && $data['id'] == $_SESSION['userId']) {
            $user = new User;
            $user = $user->selectId($data['id']);

            if ($user) {

                return View::render('user/show', ['user' => $user]);
                print_r($user);
                print_r($data['id']);
                print($_SESSION['userId']);
                die;
            } else {
                return View::render('error', ['message' => "Ce Client n'existe pas!"]);
            }
        } else {
            return View::render('error', ['message' => '404 page non trouve!']);
        }
    }
}
