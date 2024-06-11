<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

session_start();


// appinvtype INDEX: 0 = Application, 1 = Invitation, 2 = Acceptance of Invite, 3 = Rejecting of Invite

if (isset($_GET['apply']) && isset($_SESSION['orgIndex']) && !empty($_SESSION['orgIndex'])) {
    if (!empty($_GET['id']) && !empty($_GET['rindex'])) {

        $rindex = $_GET['rindex'];
        $jindex = $_GET['id'];

        try {
            $sql = "INSERT INTO applications (jindex, rindex) VALUES (:jindex, :rindex)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":jindex", $jindex, PDO::PARAM_INT);
            $stmt->bindParam(":rindex", $rindex, PDO::PARAM_INT);
            $stmt->execute();
            header("location: ../resume_profile.php?applied-jobs");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else if (isset($_GET['invite']) && isset($_SESSION['orgIndex']) && !empty($_SESSION['orgIndex'])) {

    if (!empty($_GET['jobid']) && !empty($_GET['rindex'])) {
        $jindex = $_GET['jobid'];
        $rindex = $_GET['rindex'];
        $appinvtype = 1;

        try {
            $sql = "INSERT INTO applications (jindex, rindex, appinvtype) VALUES (:jindex, :rindex, :appinvtype)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":jindex", $jindex, PDO::PARAM_INT);
            $stmt->bindParam(":rindex", $rindex, PDO::PARAM_INT);
            $stmt->bindParam(":appinvtype", $appinvtype, PDO::PARAM_INT);
            $stmt->execute();
            header("location: ../dashboard.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else if (isset($_GET['acceptinv']) && isset($_SESSION['orgIndex']) && !empty($_SESSION['orgIndex'])) {
    if (!empty($_GET['jobid']) && !empty($_GET['rindex'])) {
        $jindex = $_GET['jobid'];
        $rindex = $_GET['rindex'];
        $appinvtype = 2;

        try {
            $sql = "UPDATE applications SET appinvtype = :appinvtype WHERE jindex = :jindex AND rindex = :rindex";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":jindex", $jindex, PDO::PARAM_INT);
            $stmt->bindParam(":rindex", $rindex, PDO::PARAM_INT);
            $stmt->bindParam(":appinvtype", $appinvtype, PDO::PARAM_INT);
            $stmt->execute();
            header("location: ../dashboard.php");
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
} else if (isset($_GET['rejectinv']) && isset($_SESSION['orgIndex']) && !empty($_SESSION['orgIndex'])) {
    if (!empty($_GET['jobid']) && !empty($_GET['rindex'])) {
        $jindex = $_GET['jobid'];
        $rindex = $_GET['rindex'];
        $appinvtype = 3;

        try {
            $sql = "UPDATE applications SET appinvtype = :appinvtype WHERE jindex = :jindex AND rindex = :rindex";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":jindex", $jindex, PDO::PARAM_INT);
            $stmt->bindParam(":rindex", $rindex, PDO::PARAM_INT);
            $stmt->bindParam(":appinvtype", $appinvtype, PDO::PARAM_INT);
            $stmt->execute();
            header("location: ../dashboard.php");
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}
