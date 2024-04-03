<?php

$dsn = 'mysql:host=localhost;dbname=user_info';
$username = 'huda';
$password = 'huda123';

try {
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Database Connection Failed'. $e->getMessage();
}