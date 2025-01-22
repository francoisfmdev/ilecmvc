<?php
namespace Controllers;

class UserController extends Controller{

    public function index(){
        $data = [
            "title" => "Connection",
            "h1" => "Connection",
         
        ];

        $this->render("connection.html.twig", $data);
    } 

    // Afficher le formulaire d'inscription
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traiter les données du formulaire
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($username) && !empty($email) && !empty($password)) {
                try {
                    // Hasher le mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insérer l'utilisateur dans la base de données
                    $stmt = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
                    $stmt->execute([
                        ':username' => $username,
                        ':email' => $email,
                        ':password' => $hashedPassword,
                    ]);

                    // Rediriger vers la page de connexion ou afficher un message de succès
                    header('Location: /lightmvc/connection');
                    exit;
                } catch (\PDOException $e) {
                    $error = 'Erreur lors de l\'inscription : ' . $e->getMessage();
                }
            } else {
                $error = 'Tous les champs sont obligatoires.';
            }
        }

        // Afficher le formulaire avec un message d'erreur éventuel
        $this->render('inscription.html.twig', [
            'error' => $error ?? null,
        ]);
    }

}