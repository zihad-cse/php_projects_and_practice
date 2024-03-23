
<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $erremail = $errpass = $errpassrepeat = $errtos = $errpasslen = '';
    $password_min_length = 6;
    $password_max_length = 32;
    $email = $password1 = $password2 = $toscheck = '';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty($_POST["email"])) {
            $erremail = "Email is needed";
        } else { //checks if the email field has any white spaces and slashes and also if it's a valid email or not.
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erremail = "Invalid email format";
            }
        }
        if (empty($_POST["password1"])) {
            $errpass = "Password is needed";
        } else { //checks if the password is within char limit.
            $password1 = trim($_POST["password1"]);
            $password_length = strlen($password1);
            if ($password_length < $password_min_length || $password_length > $password_max_length) {
                $errpasslen = "Password must be between $password_min_length-$password_max_length characters";
            }
        }
        if (empty($_POST["password2"])) {
            $errpass = "Password is needed";
        } else {
            $password2 = trim($_POST["password2"]);
        }
        if (empty($_POST["tAndCCheck"])) {
            $errtos = "Need to agree to Terms and Conditions";
        } else {
            $toscheck = $_POST["tAndCCheck"];
        }
        if ($password1 !== $password2) {
            $errpassrepeat = "Passwords don't match";
        }
    }

?>