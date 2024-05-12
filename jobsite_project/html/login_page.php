<!DOCTYPE html>
<html lang="en">
<?php
session_start();

include '../php/login.php';

if (isset($_SESSION['token'])) {
    header("Location: ../");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Login</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
            <div class="btn-group">
                <div class="btn btn-outline-dark disabled">Not a member?</div>
                <a href="registration_page.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>
    <section id="login-form">
        <div class="container">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="text-center">Login</h2>
                </div>
                <form id="login" action="" method="post">
                    <div id="cardBody" class="card-body row" style="padding: 0px 100px;">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <label class="mt-2 form-label" for="phn">Phone Number</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="addon">+880</span>
                                <input id="phn" name="phn" type="text" class="form-control" aria-label="phn" aria-describedby="addon">
                            </div>
                            <div id="phnError" class="text-danger"></div>
                            <label class="form-label" for="password">Password</label>
                            <input id="pass" name="pass" class="mb-3 form-control" type="password">
                            <div id="passError" class="text-danger"><?php echo $errmsg ?></div>
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../js/seeker_login_validation.js"></script>
</body>

</html>