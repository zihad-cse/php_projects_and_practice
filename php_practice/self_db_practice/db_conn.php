<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

class Database{
    public $host = 'localhost';
    public $user = 'huda';
    public $pass = 'huda123';
    public $dbname = 'php_practice';

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
}

$dbStatus = new Database();

echo $dbStatus->error;
echo $dbStatus->status;