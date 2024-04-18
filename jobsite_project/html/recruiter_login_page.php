<!DOCTYPE html>
<html lang="en">
<?php
include '../php/recruiter_login.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Recruiter: Login</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="landing_page.html">
                Logo
            </a>
            <div class="btn-group">
                <div class="btn btn-outline-dark disabled">Don't have an account?</div>
                <a href="recruiter_registration_page.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>
    <section id="login-form">
        <div class="container">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="text-center">Recruiter Login</h2>
                </div>
                <form id="recruit_login" action="" method="post">
                    <div id="cardBody" class="card-body row" style="padding: 0px 100px;">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <div id="userName_error" class="text-danger"></div>
                            <div id="passError" class="text-danger"><?php echo $errorMessage?></div>
                            <label class="mt-2 form-label" for="userName">Username</label>
                            <input class="form-control" type="text" id="userName" name="userName">
                            <label class="form-label" for="password">Password</label>
                            <input id="pass" name="pass" class="mb-3 form-control" type="password">
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../js/recruiter_login_validation.js"></script>
</body>

</html>