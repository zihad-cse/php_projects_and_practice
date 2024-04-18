<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

include 'db_connection.php';

$userName = $pass = $errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = $_POST['userName'];
    $pass = $_POST['pass'];

    try {
        $stmt = $pdo->prepare("SELECT pass FROM org WHERE orguser = :userName");
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($pass, $user['pass'])) {
                header('Location: ');
                exit();
            } else {
                $errorMessage = "<p class='text-danger'>Incorrect Credentials</p>";
            }
        } else {
            $errorMessage = "<p class='text-danger'>User not found. Please check your credentials and try again</p>";
        }
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        $errorMessage = "<p class='text-danger'>An unexpected error occurred. Please try again later.</p>";
    }
}
