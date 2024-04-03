<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// include 'db_conn.php';

// $email = $password = $errorMessage = '';

// if ($_SERVER['REQUEST_METHOD'] == "POST") {

//     $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
//     $password = $_POST['password'];

//     $sql = 'SELECT COUNT(*) AS count FROM user_info WHERE user_email = ? AND user_password = ?';
//     $stmt = $db->dbLink->prepare($sql);
//     $stmt->bind_param('ss', $email, $password);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();

//     if($row['count'] > 0){
//         header('Location: signin_success.html');
//     } else {
//         $errorMessage = "<p class='text-danger'>Email or Password does not match.";
//     }
// }


error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_conn.php';

$email = $password = $errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    try {
        $stmt = $pdo->prepare("SELECT user_password FROM user_info WHERE user_email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $hashedpassword = $stmt->fetchColumn();

        echo $password. "<br>". $hashedpassword. "<br>";

        if ($hashedpassword !== false && password_verify($password, $hashedpassword)) {
            header('Location: signin_success.html');
        } else {
            $errorMessage = "<p class='text-danger'>Email or Password does not match.</p>";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
