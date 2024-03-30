<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
error_reporting();
include 'db_conn.php';
if(isset($_POST['submit'])){
    $name = ($_POST['fullName']);
    $pass = ($_POST['eMail']);

    $secureName = mysqli_real_escape_string($db->link, $fullName);
    $secureEmail = mysqli_real_escape_string($db->link, $eMail);

    if(!$name){
        $error = "Fill all the fields please";
    } else {
        $query = "INSERT INTO customers(customer_name, email) VALUES('$name', '$pass')";
        $create = $db->create($query);
    }
}

if(isset($_GET['msg'])){
    echo "<span>".$_GET['msg']."</span>";
};
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body class="bg-dark">
    <div class="container bg-light">
        <form action="create.php" method="post">
            <label for="name">Full Name</label>
            <input class="form-control" type="text" name="fullName">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="eMail">
            <input type="submit" class="btn btn-success" value="submit">
            <input type="reset" value="Reset" class="btn btn-danger">
            <a href="read.php">Table of Users</a>
        </form>
    </div>
</body>

</html>