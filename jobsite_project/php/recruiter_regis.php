<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

$userName =
$pass = 
$passConfirm = 
$cName =
$cYear = 
$cSize =
$cCategory = 
$cAddCountry = 
$cAddDistrict = 
$cAddThana =
$cAddDetails =
$cAddDetailsBD =
$cUrl =
$cCode =
$contactName =
$contactNumber =
$contactEmail = 
$errMessage = 
$hashedPass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userName = $_POST['recruitUsername'];
    $pass = $_POST['pass'];
    $passConfirm = $_POST['passConfirm'];
    $cName = $_POST['companyName'];
    $cYear = $_POST['companyYear'];
    $cSize = $_POST['companySize'];
    $cCategory = $_POST['companyCategory'];
    $cAddCountry = $_POST['companyAddCountry'];
    $cAddDistrict = $_POST['companyAddDistrict'];
    $cAddThana = $_POST['companyAddThana'];
    $cAddDetails = $_POST['companyAddDetails'];
    $cAddDetailsBD = $_POST['companyAddDetailsBD'];
    $cUrl = filter_var($_POST['companyUrl'], FILTER_SANITIZE_URL);
    $cCode = $_POST['companyCode'];
    $contactName = $_POST['contactPersonName'];
    $contactNumber = $_POST['contactPersonNumber'];
    $contactEmail = filter_var($_POST['contactPersonEmail'], FILTER_SANITIZE_EMAIL);
    $creationDate = date('y-m-d');

    // file_put_contents('hashed_pass.log', $hashedPass . PHP_EOL, FILE_APPEND);
    // file_put_contents('hashed_pass.log', $pass . PHP_EOL, FILE_APPEND);
    // file_put_contents('hashed_pass.log', $passConfirm . PHP_EOL, FILE_APPEND);

    if($pass !== $passConfirm) {
        $errMessage = "<p class='text-danger'>Passwords do not match </p>";
    } else {
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
    }

    try {

        $stmt = $pdo->prepare("SELECT COUNT(*) AS org_code_count FROM org WHERE orgcode = :cCode");
        $stmt->bindParam(':cCode', $cCode, PDO::PARAM_STR);
        $stmt->execute();
        $org_code_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($org_code_row['org_code_count'] > 0) {
            $errMessage = '<p class="text-danger">An Account already exists with this Business / Trade License Number.</p>';
        } else {
            $sql = 'INSERT INTO org (orgcode, orguser, prphone, premail, created, pass) VALUES (:cCode, :userName, :contactNumber, :contactEmail, :creationDate, :hashedPass)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cCode', $cCode, PDO::PARAM_STR);
            $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
            $stmt->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);
            $stmt->bindParam(':contactEmail', $contactEmail, PDO::PARAM_STR);
            $stmt->bindParam(':creationDate', $creationDate, PDO::PARAM_STR);
            $stmt->bindParam(':hashedPass', $hashedPass, PDO::PARAM_STR);

            if($stmt->execute()){
                header('Location: #');
                exit;
            }

        }

    } catch (PDOException $e) {
        echo 'Error: ', $e->getMessage();
    }
    
}