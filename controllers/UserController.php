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
                    $issuccess = $userModel->register($username, $email, $password);

                    if ($issuccess) {
                        $id = $userModel->get_last_id();
                        $user = $userModel->get_user_by_id($id);
                        $_SESSION["mail"] = $user->mail;
                        $_SESSION["username"] = $user->username;
                        header('Location: /ilecmvc/admin');
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
            
           
           $userModel =  new UserModel($this->db);
           
            if(!empty($email) && !empty($password)){
                 try{

                    $connected = $userModel->connection($email,$password);
                   
                    if($connected == 1){
                        
                        $user = $userModel->get_user_by_mail($email);
                        $_SESSION["mail"] = $user->mail;
                        $_SESSION["username"] = $user->username;
                        header('Location: /ilecmvc/admin');
                    }
                    else{
                        
                        header('Location: /ilecmvc/connection');
                    }

                 }catch(\PDOException $e){
                        $userModel = new UserModel($this->db);
                 }
            }
        }
        

    }
    public function admin(){

        $data = [
            "mail" => $_SESSION["mail"],
            "username"=> $_SESSION["username"],
            "h1" => "Admin",
        ];


        $this->render("admin.html.twig",$data);
    }
}
