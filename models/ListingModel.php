<?php
namespace Models;

use PDO;


class ListingModel extends Model{

    

    public function __construct(PDO $db)
    {
        parent::__construct($db, 'tickets');
    }

    public function create_ticket($title, $content, $user_id,$status){
       return  $this->create(["title","content","user_id","status"],$title, $content, $user_id,$status);
    }

    public function get_ticket_where_user_id($user_id){
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_ticket_where_admin_id($admin_id){
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE admin_id = :admin_id");
        $stmt->execute([':admin_id' => $admin_id]);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_tickets_with_admin(){
        $stmt = $this->db->prepare("
        SELECT t.*, u.username AS admin_name
        FROM tickets t
        LEFT JOIN users u ON t.admin_id = u.id
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    
    
}