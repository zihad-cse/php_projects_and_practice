<?php 

include 'db_const.php';

class Database{
    public $host = DB_SERVER;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $table = DB_TABLE;

    public $link;
    public $error;
    public $status;

    public function __construct()
    {
        $this->connectDB();
    }

    private function connectDB(){
        
        $this->link =  new mysqli($this->host, $this->user, $this->pass, $this->table);
        if(!$this->link){
            $this->error = 'Connection Failed'. $this->link->connect_error;
            return false;
        }
    }

    public function select(){}
}



?>