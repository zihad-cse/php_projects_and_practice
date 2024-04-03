<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_conn.php';

$email = $password1 = $password2 = $toscheck = $finalpassword = $errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if($password1 !== $password2){
        $errorMessage = "<p class='text-danger'>Passwords do not match.</p>";
    } else {
        $finalpassword = password_hash($password1, PASSWORD_DEFAULT);
        
        try{
            $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM user_info WHERE user_email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['count'] > 0) {
                $errorMessage = '<p class="text-danger">Email already exists. Please choose a different email.</p>';
            } else {
                $sql = 'INSERT INTO user_info (user_email, user_password) VALUES (:email, :pass)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $finalpassword, PDO::PARAM_STR);

                if($stmt->execute()){
                    header('Location: signin_success.html');
                    exit();
                }
            }
        } catch (PDOException $e){
            echo 'Error: '. $e->getMessage();
        }
    }
}