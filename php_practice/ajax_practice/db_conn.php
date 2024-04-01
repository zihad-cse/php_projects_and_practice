<?php
$server = 'localhost';
$user = 'huda';
$pass = 'huda123';
$dbname = 'php_practice';

$link = new mysqli($server, $user, $pass, $dbname);

if ($link->connect_error) {
    $error = "Connection Error". $link->connect_error;
}
?>