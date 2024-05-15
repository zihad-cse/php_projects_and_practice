<?php
include 'db_connection.php';

if (isset($_GET['search-submit'])) {
    $query = $_GET['search'];
    try {

        $stmt = $pdo->prepare("SELECT resumes.*, org.orgindex FROM resumes LEFT JOIN org ON org.orgindex = resumes.orgindex WHERE skilleduexp LIKE :query");
        $query = '%' . $query . '%';
        $stmt->bindParam(':query', $query, PDO::PARAM_STR);
        $stmt->execute();
        $queryResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
