<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

$fname = $email = $phn = $pass1 = $pass2 = $hashedpass = $gender = $dob = $errmsg = $phnerrmsg =  '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $phn = $_POST['phn'];
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $membersince = date('Y-m-d'); 
    
    if ($pass1 !== $pass2) {
        $errmsg = "<p class='text-danger'>Passwords do not match </p>";
    } else {
        $hashedpass = password_hash($pass1, PASSWORD_DEFAULT);
    }

    try {

        $stmt = $pdo->prepare("SELECT COUNT(*) AS email_count FROM users WHERE email_add = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $email_row = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT COUNT(*) AS phn_count FROM users WHERE phn_number = :phn");
        $stmt->bindParam(':phn', $phn, PDO::PARAM_INT);
        $stmt->execute();
        $phn_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($email_row['email_count'] > 0) {
            $errmsg = '<p class="text-danger">Email already exists. Please choose a different email.</p>';
        } elseif ($phn_row['phn_count'] > 0) {
            $phnerrmsg = '<p class="text-danger">Phone number already exists. Please choose a different phone number.</p>';
        } else {
            $sql = 'INSERT INTO users (email_add, user_name, phn_number, gender, dob, user_password, member_since) VALUES (:email, :fname, :phn, :gender, :dob, :hashedpass, :membersince)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':hashedpass', $hashedpass, PDO::PARAM_STR);
            $stmt->bindParam(':phn', $phn, PDO::PARAM_INT);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
            $stmt->bindParam(':membersince', $membersince, PDO::PARAM_STR);

            if($stmt->execute()){
                session_start();
                $_SESSION['phnNumber'];
                header('Location: ../html/seeker_dashboard.php');
                exit();
            }
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
