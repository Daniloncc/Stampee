<?php

namespace App\Models;

use App\Models\CRUD;

class User extends CRUD
{
    protected $table = "utilisateur";
    protected $primaryKey = "id";
    protected $fillable = ['nom', 'prenom', 'adresse', 'telephone', 'courriel', 'motPasse'];

    public function hashPassword($password, $cost = 10)
    {
        $options = [
            'cost' => $cost
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function checkUser($email, $password)
    {
        $user = $this->unique('courriel', $email);
        if ($user) {
            if (password_verify($password, $user['motPasse'])) {
                // print_r($user['id']);
                // print_r($user['courriel']);
                // print_r($user['idRole']);
                session_regenerate_id();
                $_SESSION['userId'] = $user['id'];
                $_SESSION['userCourriel'] = $user['courriel'];
                $_SESSION['userPrenom'] = $user['prenom'];
                $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
                return true;
            } else {
                return false;
            }
        } else {
            // print("ici");
            // die;
            return false;
        }
    }
}
