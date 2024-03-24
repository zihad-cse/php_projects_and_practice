<?php
include 'db_conn.php';
include 'db_const.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $db = new Database();
        $query = "SELECT * FROM customers";
        $read = $db->select($query);


        
    ?>
</body>
</html>