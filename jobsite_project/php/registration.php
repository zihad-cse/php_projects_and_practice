<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 
include 'utility.php';
include 'db_connection.php';

$fname = $email = $phn = $pass1 = $pass2 = $hashedpass = $errmsg = $phnerrmsg = $captchaErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $phn = $_POST['phn'];
    $fname = $_POST['fname'];
    $user_captcha = $_POST['captcha'];
    $membersince = date('Y-m-d');
    if ($user_captcha === $_SESSION['captcha']) {
        if ($pass1 !== $pass2) {
            $errmsg = "<p class='text-danger'>Passwords do not match </p>";
        } else {
            $hashedpass = password_hash($pass1, PASSWORD_DEFAULT);
        }

        try {

            $stmt = $pdo->prepare("SELECT COUNT(*) AS email_count FROM org WHERE premail = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $email_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare("SELECT COUNT(*) AS phn_count FROM org WHERE prphone = :phn");
            $stmt->bindParam(':phn', $phn, PDO::PARAM_INT);
            $stmt->execute();
            $phn_row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($email_row['email_count'] > 0) {
                $errmsg = '<p class="text-danger">Email already exists. Please choose a different email.</p>';
            } elseif ($phn_row['phn_count'] > 0) {
                $phnerrmsg = '<p class="text-danger">Phone number already exists. Please choose a different phone number.</p>';
            } else {
                $sql = 'INSERT INTO org (premail, orguser, prphone, pass, created) VALUES (:email, :fname, :phn, :hashedpass, :membersince)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
                $stmt->bindParam(':hashedpass', $hashedpass, PDO::PARAM_STR);
                $stmt->bindParam(':phn', $phn, PDO::PARAM_INT);
                $stmt->bindParam(':membersince', $membersince, PDO::PARAM_STR);

                try {
                    $pdo->beginTransaction();
                    $stmt->execute();
                    $orgIndex = $pdo->lastInsertId();
                    $sql = "INSERT INTO resumes (orgindex) VALUES (:orgindex)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":orgindex", $orgIndex, PDO::PARAM_INT);
                    $stmt->execute();
                    $pdo->commit();
                    session_start();
                    $token = randomToken();
                    $_SESSION['token'] = $token;
                    $_SESSION['phnNumber'] = $phn;
                    header("Location: dashboard.php");
                    exit();
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    echo "Error!: " . $e->getMessage() . "</br>";
                }
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        $captchaErr = "<p class='text-danger'>Incorrect Captcha Verification. Please try again.</p>";
    }
}
