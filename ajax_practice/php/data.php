<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $_POST['query'];
    $sql = "SELECT * FROM job WHERE job.jobtitle LIKE '%" . $query . "%'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $returnedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($returnedData as $returnedDataRow) {
        echo "<div class='container'>";
            echo "<div id='landing-page-mouse-hover-card' style='max-height: 400px; min-height: 170px;' onclick='location.href='../jobsite_project/job.php?view&id=". $returnedDataRow['jindex'] ."class='text-start my-4 mx-0 card text-decoration-none'>";
                echo "<div class='col-12'>";
                    echo "<div class='row'>";
                         echo "<div class='col-12'>";
                            echo "<b class='m-0 p-2'>" . $returnedDataRow['jobtitle'] . "</b>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                        echo "<div class='col-12'>";
                            echo "<b class='m-0 p-2'>" . $returnedDataRow['salary'] . "</b>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
}
