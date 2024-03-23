<?php 
class UserData{
    public $users;
    public $userId;
    
    public function __construct($users, $id){
        $this->users = $users;
        $this->userId = $id;

        echo "Username is ". $this->users. " and user ID is ". $this->userId;
    }
    

}
class Status extends UserData{
    public $status;
    public function display($status){
        $this->status = $status;
        echo "Username is ". $this->users. " and user ID is ". $this->userId. " With the status of ". $this->status;
    }
}


?>