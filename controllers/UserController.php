<?php
namespace Controllers;
use Models\UserModel;

class UserController extends Controller
{
    /**
     * Afficher la page de connexion.
     */
    public function index()
    {
        $data = [
            "title" => "Connection",
            "h1" => "Connection",
        ];

        $this->render("connection.html.twig", $data);
    }

    /**
     * Afficher le formulaire d'inscription et traiter l'inscription.
     */
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['mail'] ?? '';
            $password = $_POST['pass'] ?? '';

            if (!empty($username) && !empty($email) && !empty($password)) {
                try {
                    $userModel = new UserModel($this->db);
                    $userId = $userModel->register($username, $email, $password);

                    if ($userId) {
                        header('Location: /ilecmvc/connection');
                        exit;
                    } else {
                        $error = 'Impossible de créer l\'utilisateur.';
                    }
                } catch (\PDOException $e) {
                    $error = 'Erreur lors de l\'inscription : ' . $e->getMessage();
                }
            } else {
                $error = 'Tous les champs sont obligatoires.';
            }
        }

        $this->render('inscription.html.twig', [
            'error' => $error ?? null,
        ]);
    }


    public function connection(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $email = $_POST['mail'] ?? '';
            $password = $_POST['pass'] ?? '';

            if(!empty($email) && !empty($password)){
                 try{

                 }catch(\PDOException $e){
                        $userModel = new UserModel($this->db);
                 }
            }
        }
        

    }
}
