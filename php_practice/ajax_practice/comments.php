<?php
include 'db_conn.php';
$commentNewCount = $_POST['commentNewCount'];

$sql = "SELECT * FROM Comments LIMIT $commentNewCount";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>";
        echo $row['id'];
        echo "<br>";
        echo $row['commenter'];
        echo "<br>";
        echo $row['comment'];
        echo "</p>";
    }
} else {
    echo "No Data";
}
