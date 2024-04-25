<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include 'db_connection.php';
    function getUserData($pdo, $phnNumber){
        try {
            $stmt = $pdo->prepare("SELECT org.*, orgcat.ocategory FROM org LEFT JOIN orgcat ON org.ocatindex = orgcat.ocatindex WHERE prphone = :phnNumber");
            $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    };
?>