<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_conn.php';

// Sets up database connection

$host = 'localhost';
$user = 'huda';
$pass = 'huda123';
$database = 'user_info';

$db = new DatabaseConnection($host, $user, $pass, $database);

$email = $password1 = $password2 = $toscheck = $finalpassword = $errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Checks if the same email was used in the database.

    $sql = "SELECT COUNT(*) AS count FROM user_info WHERE user_email = ?"; //In here. COUNT(*) means how many rows that match the condition, and AS count means an alias by the name of "count" has been set.
    $stmt = $db->dbLink->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) { // Error message if there are any existing rows with the email in it.
        $errorMessage = '<p class="text-danger">Email already exists. Please choose a different email.</p>';
    } else {

        // Code continues after checking if the email exists.

        if ($_POST['password1'] == $_POST['password2']) {
            $finalpassword = $_POST['password1'];
        }
        $toscheck = $_POST["tAndCCheck"];

        $sql = 'INSERT INTO user_info (user_email, user_password) VALUES (?, ?)';
        $stmt = $db->dbLink->prepare($sql);
        $stmt->bind_param('ss', $email, $finalpassword);  // Inserts the value into the Table.

        if ($stmt->execute()) {
            header('Location: signin_success.html');    // If code execution is complete, Redirects to a different page and exits the script
            exit();
        }
        $stmt->close();
    }
    $db->close();   // Closes the Database.
}
