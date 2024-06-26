<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_const.php';

class Database{
    public $host = DB_SERVER;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $dbname = DB_TABLE;

    public $link;
    public $error;
    public $status;
    public $result;

    public function __construct()
    {
        $this->connectDB();
    }

    private function connectDB(){
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if($this->link->connect_error){
            $this->error = 'Connection Failed '. $this->link->connect_error;
            return false;
        } else {
            $this->status = 'Connected';
        }
    }

    public function select($query) {
        $this->result = $this->link->query($query) or die($this->link->error.__LINE__);
        if ($this->result->num_rows > 0) {
            return $this->result;
        } else {
            return false;
        }
    }

    public function create($query){
        $createRow = $this->link->query($query) or die($this->link->error);
        if($createRow){
            header("Location: read.php?msg=".urlencode('Data Inserted'));
        } else {
            die("Error: (".$this->link->errno." )". $this->link->error);
        }
    }
}
$db = new Database();
$query = "SELECT * FROM customers";
$read = $db->select($query);
