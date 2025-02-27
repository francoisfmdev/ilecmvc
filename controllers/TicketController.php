<?php 
namespace Controllers;
use PDO;
use Models\ListingModel;

class TicketController extends Controller{
    public function __construct(PDO $db){
        parent::__construct($db);
    }

    public function create_ticket(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title']?? '';
            $content = $_POST['content']?? '';
            $user_id = $_SESSION["user_id"];
            $status = "Non attribué";

            if(!empty($title) &&!empty($content) &&!empty($user_id)){
                    $ticketModel = new ListingModel($this->db);
                $success  =  $ticketModel->create_ticket($title, $content, $user_id,$status);
                if($success  == 0){
                    $ticketModel = new ListingModel($this->db);
                      $tickets = $ticketModel->get_ticket_where_user_id($user_id);
                      
                    $this->render("admin.html.twig", ['tickets' => $tickets]);
                }else{

                    $ticketModel = new ListingModel($this->db);
                      $tickets = $ticketModel->get_ticket_where_user_id($user_id);
                      $data = [
                        "mail" => $_SESSION["mail"],
                        "username"=> $_SESSION["username"],
                        "role" => $_SESSION["role"],
                        "h1" => "Admin",
                        "tickets"=>$tickets
                    ];  
                    $this->render("admin.html.twig", ['tickets' => $tickets]);
                }
            }
        }
    }
    public function assign_ticket(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           
            if(!empty($_POST["ticket_id"]) &&!empty($_POST["user_id"])){
               
                $ticket_id = $_POST['ticket_id']?? '';
                $user_id = $_POST['user_id']?? '';
                $listingModel = new ListingModel($this->db);
                
                $success = $listingModel->assign_ticket_to_admin($user_id, $ticket_id);
                header("Location: /litemvc/admin");
            }

        }
    }
}
