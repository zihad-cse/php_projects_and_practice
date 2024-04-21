<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';
include 'seeker_auth.php';

session_start();
$phnNumber = $_SESSION['phnNumber'];

$newUserName = $newEmail = $newPhnNumber = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUserName = isset($_POST['userName']) ? $_POST['userName'] : '';
    $newEmail = isset($_POST['eMail']) ? filter_var($_POST['eMail'], FILTER_SANITIZE_EMAIL) : '';
    $newPhnNumber = isset($_POST['phnNumber']) ? $_POST['phnNumber'] : '';

    if ($newUserName) {
        $stmt = $pdo->prepare("UPDATE users SET user_name = :userName WHERE phn_number = $phnNumber");
        $stmt->bindParam(':userName', $newUserName, PDO::PARAM_STR);
        $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
    }
    if ($newEmail) {
        $stmt = $pdo->prepare("UPDATE users SET email_add = :eMail WHERE phn_number = $phnNumber");
        $stmt->bindParam(':eMail', $newEmail, PDO::PARAM_STR);
        $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
    }
    if ($newPhnNumber) {
        $stmt = $pdo->prepare("UPDATE users SET phn_number = :newPhnNumber WHERE phn_number = $phnNumber");
        $stmt->bindParam(':newPhnNumber', $newPhnNumber, PDO::PARAM_STR);
        $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
    }


    if ($stmt->execute()) {
        header("Location: ../html/seeker_dashboard.php");
        exit;
    }
}
