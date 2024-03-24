<?php
require_once 'db_connection.php';
require_once 'simple_form2.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //recieves input from form

    if(empty($_POST['fullName'])){
        $infoStatus = "Please Fill Out Fields";
    } else {
        $name = $_POST['fullName'];
    }
    if(empty($_POST['eMail'])){
        $infoStatus = "Please Fill Out Fields";
    } else {
        $email = filter_var($_POST["eMail"], FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $infoStatus = 'Enter a Valid Email';
        }
    }
    //checks if the exact data exists.

    $sqlCheck = "SELECT * FROM customers WHERE customer_name = ? OR email = ?";
    $stmtCheck = $link->prepare($sqlCheck);
    $stmtCheck->bind_param("ss", $name, $email);
    $stmtCheck->execute();

    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        $credStatus = "Data Already Exists";
    } else {
        $credStatus = "Couldn't Find Credentials <br> <a href='simple_form.php'>Sign Up</a>";
    }
    $stmtCheck->close();
}