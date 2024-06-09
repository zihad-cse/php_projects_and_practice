<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

session_start();

include 'user_data.php';


if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $userData = getUserData($pdo, $phnNumber);
}


if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $resumeData = getAllPostedResumes($pdo, $userData['orgindex']);
}



$countedResumeData = count($resumeData);

if($countedResumeData === 1 && (empty($resumeData[0]['fullname']))){
    header("location: ../resume.php?first-resume");
} else {
    header("location: ../resume.php?new-resume");
}
