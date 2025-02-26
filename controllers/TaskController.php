<?php

namespace Controllers;
use Models\TaskModel;
use Middleware\AuthMiddleware;
use PDO;

class TaskController extends Controller
{
    public function __construct(PDO $database)
    {
        parent::__construct($database);
    }

    

    public function addtask(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {   
            
            $task = $_POST['content']?? '';
            $user_id = $_SESSION['user_id'] ?? '';
            if(!empty($task)and !empty($user_id)){
                $taskformated = htmlspecialchars($task);
                $taskModel = new TaskModel($this->db);
               $success = $taskModel->create(["content","user_id"],$taskformated, $user_id);
                if($success){
                    header('Location: /ilecmvc/admin');
                    exit();
                }
                else{
                    echo "Erreur lors de l'ajout de la tâche";
                }

            }
        }    

    }
    public function change_status(){
        
        AuthMiddleware::check_auth();
       
        if($_SERVER["REQUEST_METHOD"] =="POST"){ 
                $status = (int) $_POST["status"];
                $id = $_POST["task_id"];
                if($status == 0){
                    $status = 1;
                }else{
                    $status = 0;
                }
                $taskModel = new TaskModel($this->db); // Assure-toi que le modèle reçoit la connexion DB
                $success = $taskModel->update($id, ['status'], [$status]); // Mise à jour de la colonne "status" à 1 pour l'id 1
                header('Location: /ilecmvc/admin');
            
        }else{
            header('Location: /admin');
        }
    }
    public function delete_task(){
    }
}