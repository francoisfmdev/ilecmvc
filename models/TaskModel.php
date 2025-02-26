<?php
namespace Models;

use PDO;


class TaskModel extends Model{

    

    public function __construct(PDO $db)
    {
        parent::__construct($db, 'tasks');
    }

    public function findByUserId(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = :id");
        $stmt->execute([':id' => $id]);
        
        return  $stmt->fetchAll(PDO::FETCH_OBJ) ;
    }
}