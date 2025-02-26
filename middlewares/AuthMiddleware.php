<?php
namespace Middleware;


abstract class AuthMiddleware  {

    public static function check_auth(){
        // Vérifier si l'utilisateur est authentifié
        // Si non, rediriger vers la page de connexion
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
            exit;
        }
    }
}