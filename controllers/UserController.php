<?php
namespace Controllers;
use Models\UserModel;
use Models\ListingModel;
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
                        $_SESSION["role"] = $user->role;
                        $_SESSION["user_id"] = $user->id;
                        header('Location: /litemvc/admin');
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
                        $_SESSION["role"] = $user->role;
                        $_SESSION["user_id"] = $user->id;
                        header('Location: /litemvc/admin');
                    }
                    else{
                        
                        header('Location: /litemvc/connection');
                    }

                 }catch(\PDOException $e){
                        $userModel = new UserModel($this->db);
                 }
            }
        }
        

    }
    public function admin(){

        $ticketModel = new ListingModel($this->db,"tickets");
      $tickets =   $ticketModel->get_ticket_where_user_id($_SESSION["user_id"]);
        $data = [
            "mail" => $_SESSION["mail"],
            "username"=> $_SESSION["username"],
            "role" => $_SESSION["role"],
            "h1" => "Admin",
            "tickets"=>$tickets
        ];
        

        $this->render("admin.html.twig",$data);
    }
}
