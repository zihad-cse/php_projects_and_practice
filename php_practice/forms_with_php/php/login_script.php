<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_conn.php';

$host = 'localhost';
$user = 'huda';
$pass = 'huda123';
$database = 'user_info';

$db = new DatabaseConnection($host, $user, $pass, $database);

$email = $password = $errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $sql = 'SELECT COUNT(*) AS count FROM user_info WHERE user_email = ? AND user_password = ?';
    $stmt = $db->dbLink->prepare($sql);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row['count'] > 0){
        header('Location: signin_success.html');
    } else {
        $errorMessage = "<p class='text-danger'>Email or Password does not match.";
    }
}
