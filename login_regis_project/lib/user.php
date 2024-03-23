<?php 
include_once 'session.php';
include 'database.php';


class User{
    private $db;
    public function __construct(){
        $this->db = new Database();       
    }
}
?>