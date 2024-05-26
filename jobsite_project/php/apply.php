<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';
include 'user_data.php';

session_start();
$resumeData = getResumeData($pdo, $_SESSION['phnNumber']);

if (!isset($_SESSION['phnNumber']) && empty($_SESSION['phnNumber'])) {
    header("location: ../login_page.php");
} else if (isset($_SESSION['phnNumber']) && !empty($_SESSION['phnNumber'])) {

    $jindex = $_GET['id'];
    $rindex = $resumeData['rindex'];
    $applicationData = appliedJobs($pdo, $rindex, $jindex);
    if ($jindex == $applicationData['jindex'] && $rindex == $applicationData['rindex']) {
        $return_url = urldecode($_GET['return_url']);
        header('location: ' . "$return_url");
    } else if ($jindex !== $applicationData['jindex'] && $rindex !== $applicationData['rindex']) {
        try {
            $query = "INSERT INTO applications(jindex, rindex) VALUES(:jindex, :rindex)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':jindex', $jindex, PDO::PARAM_INT);
            $stmt->bindParam(':rindex', $rindex, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $return_url = urldecode($_GET['return_url']);
                header('location: ' . "$return_url");
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
