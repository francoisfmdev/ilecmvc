<?php
namespace Models;

use PDO;

class UserModel extends Model
{
    public function __construct(PDO $db)
    {
        // Appeler le constructeur parent avec la table "users"
        parent::__construct($db, 'users');
    }

    // Ajoutez ici des méthodes spécifiques à l'utilisateur si nécessaire
}