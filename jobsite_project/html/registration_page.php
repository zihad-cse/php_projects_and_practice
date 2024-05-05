<!DOCTYPE html>
<html lang="en">
<?php
include '../php/registration.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Register</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="landing_page.php">
                Logo
            </a>
            <div class="btn-group">
                <div class="btn btn-outline-dark disabled">Already have an account?</div>
                <a href="login_page.php" class="btn btn-primary">Sign In</a>
            </div>
        </div>
    </nav>
    <section id="registration-form">
        <div class="container">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="text-center">Register</h2>
                </div>
                <form id="registration" action="" method="post">
                    <div id="cardBody" class="card-body row" style="padding: 0px 100px;">
                        <div class="container">

                            <label for="name">Username</label>
                            <input id="user" name="fname" type="text" class="form-control my-2">
                            <p id="userError" class="text-danger"></p>

                            <label for="email" class="form-label">Valid E-mail</label>
                            <input id="email" name="email" type="email" class="form-control my-2">
                            <p id="emailError" class="text-danger"> <?php echo $errmsg; ?></p>

                            <label for="phn">Valid Phone Number</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="addon">+880</span>
                                <input id="phn" name="phn" type="text" class="form-control" aria-label="phn" aria-describedby="addon">
                            </div>
                            <p id="phnError" class="text-danger"><?php echo $phnerrmsg; ?></p>

                            <label for="pass1">Enter a Password</label>
                            <input id="pass1" name="pass1" type="password" class="form-control my-2">

                            <label for="pass2">Repeat Password</label>
                            <input id="pass2" name="pass2" type="password" class="form-control my-2">
                            <p id="passError" class="text-danger"></p>
                          
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../js/regis_valid.js"></script>
</body>

</html>