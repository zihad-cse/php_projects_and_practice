<?php
require_once 'db_connection.php';
require_once 'simple_form.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if fields are empty
    if(empty($_POST['fullName']) || empty($_POST['eMail'])) {
        $infoStatus = "Please Fill Out Fields";
    } else {
        // Receive input from form
        $name = $_POST['fullName'];
        $email = filter_var($_POST["eMail"], FILTER_SANITIZE_EMAIL);
        
        // Validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $infoStatus = 'Enter a Valid Email';
        } else {
            // Check if exact data exists
            $sqlCheck = "SELECT * FROM customers WHERE customer_name = ? OR email = ?";
            $stmtCheck = $link->prepare($sqlCheck);
            $stmtCheck->bind_param("ss", $name, $email);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                $infoStatus = "Account already exists <br> <a href='simple_form2.php'>Sign In</a>";
            } else {
                // Insert data into the table
                $sqlInsert = "INSERT INTO customers (customer_name, email) VALUES (?, ?)";
                $stmt = $link->prepare($sqlInsert);
                $stmt->bind_param("ss", $name, $email);

                if ($stmt->execute()) {
                    $infoStatus = "Input Taken";
                } else {
                    $infoStatus = "Error " . $sqlInsert . "<br>" . $link->error;
                }

                $stmt->close();
            }

            $stmtCheck->close();
        }
    }
}
?>
