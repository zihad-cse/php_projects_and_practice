<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';
include 'user_data.php';

session_start();
if (!isset($_SESSION['phnNumber']) && empty($_SESSION['phnNumber'])) {

    header("location: ../login_page.php");
} else if (isset($_SESSION['phnNumber']) && !empty($_SESSION['phnNumber'])) {
    $resumeData = getResumeData($pdo, $_SESSION['phnNumber']);
    $orgData = getUserData($pdo, $_SESSION['phnNumber']);
    $jindex = $_GET['id'];
    $rindex = $resumeData['rindex'];
    if (isset($_GET['invitation'])) {
        $type = 1;
    } else {
        $type = 0;
    }
    $applicationData = appliedJobs($pdo, $rindex, $jindex);
    if ($jindex == $applicationData['jindex'] && $rindex == $applicationData['rindex']) {
        $return_url = urldecode($_GET['return_url']);
        header('location: ' . "$return_url");
    } else if ($jindex !== $applicationData['jindex'] && $rindex !== $applicationData['rindex']) {
        try {
            $query = "INSERT INTO applications(jindex, rindex, appinvtype) VALUES(:jindex, :rindex :appinvtype)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':jindex', $jindex, PDO::PARAM_INT);
            $stmt->bindParam(':rindex', $rindex, PDO::PARAM_INT);
            $stmt->bindParam(':appinvtype', $type, PDO::PARAM_BOOL);
            if ($stmt->execute()) {
                $return_url = urldecode($_GET['return_url']);
                header('location: ' . "$return_url");
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
