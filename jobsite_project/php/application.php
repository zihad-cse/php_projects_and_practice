<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

session_start();
echo "<pre>";
var_dump($_GET);
echo "</pre>";

if (isset($_GET['apply']) && isset($_SESSION['orgIndex']) && !empty($_SESSION['orgIndex'])) {

    if (!empty($_POST['apprindex']) && !empty($_GET['id'])) {
        echo "wooooo";
        exit;
        $rindex = $_GET['rindex'];
        $jindex = $_GET['id'];

        try {
            $sql = "INSERT INTO applications (jindex, rindex) VALUES (:jindex, :rindex)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":jindex", $jindex, PDO::PARAM_INT);
            $stmt->bindParam(":rindex", $rindex, PDO::PARAM_INT);
            $stmt->execute();
            header("location: dashboard.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    echo "wa";
}