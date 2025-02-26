<?php

namespace Controllers;
use Models\TaskModel;
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
    public function deletetask(){
    }
    public function changestatus(){
    }
}