<?php
include 'db_connection.php';

if (isset($_GET['search-submit'])) {
    $query = $_GET['search'];
    try {
        $stmt = $pdo->prepare("SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE jobtitle LIKE :query");
        $query = '%' . $query . '%';
        $stmt->bindParam(':query', $query, PDO::PARAM_STR);
        $stmt->execute();
        $queryResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
