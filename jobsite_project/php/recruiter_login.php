<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

include 'db_connection.php';
include 'recruiter_auth.php';

$userName = $pass = $errmsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orgName = $_POST['userName'];
    $pass = $_POST['pass'];

    $auth = new Auth($pdo);

    if ($auth->login($orgName, $pass)) {
        header('location: ../html/recruiter_dashboard.php');
        exit();
    } else {
        $errmsg = "<p class='text-danger'>Incorrect credentials. Please try again.</p>";
    }
}
