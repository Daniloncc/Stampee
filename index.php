<?php
// code pour afficher les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'routes/web.php';

// Pour le  webdev :
// Changer le chemin d'insertion d'image dans le TimbreController - ligne: 62,
// Changer le chemin d'insertion d'image dans le ImageController - ligne: 39, ,210
// Effacer envoyer un courriel quand on cree un utilisateur UtilisateurController - ligne: 45
// CRUD: 
// .htaccess : 