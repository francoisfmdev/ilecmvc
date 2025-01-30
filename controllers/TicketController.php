<?php 
namespace Controllers;
use PDO;

class TicketController extends Controller{
    public function __construct(PDO $db){
        parent::__construct($db);
    }

    public function create(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title']?? '';
            $content = $_POST['content']?? '';
            $user_id = $_SESSION["user_id"];
        }
    }
}
