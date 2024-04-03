<?php 
// $server = 'localhost';
// $username = 'huda';
// $password = 'huda123';
// $database = 'php_practice';

// //connects db

// $link = new mysqli($server, $username, $password, $database);

// //if connect failed, error message.

// if($link->connect_error){
//     die('Connection Failed, '. $link->connect_error);
// }
?>

<?php
$dsn = 'mysql:host=localhost;dbname=php_practice';  // 'mysql:host=hostname;dbname=databasename';
$username = 'huda';
$password = 'huda123';

try {
    $pdo = new PDO($dsn, $username, $password); // Sets up a connection

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Sets up error handling

} catch (PDOException $e) {
    echo 'Connection Failed'. $e->getMessage(); // Sets up error Message
}

?>