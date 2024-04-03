<?php
require 'db_connection.php';

$name = $_POST['fullName'];
$email = $_POST['eMail'];

try {
    $stmt = $pdo->prepare('INSERT INTO customers(customer_name, email) VALUES (:fullname, :email)');

    $stmt->bindParam(':fullname', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    $stmt->execute();


} catch (PDOException $e){
    echo $e->getMessage();
}

$pdo = null;