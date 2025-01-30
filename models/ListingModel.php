<?php
namespace Models;

use PDO;


class ListingModel extends Model{

    

    public function __construct(PDO $db)
    {
        parent::__construct($db, 'listing');
    }
}