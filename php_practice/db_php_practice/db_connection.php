<?php 
$server = 'localhost';
$username = 'huda';
$password = 'huda123';
$database = 'php_practice';

//connects db

$link = new mysqli($server, $username, $password, $database);

//if connect failed, error message.

if($link->connect_error){
    die('Connection Failed, '. $link->connect_error);
}
?>