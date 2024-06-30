<!DOCTYPE html>
<html lang="en">
<?php
session_start();

include 'php/login.php';
include 'php/oauthlogin.php';
if (isset($_SESSION['token'])) {
    header("Location: /");
    exit();
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <title>Log in</title>
    <style>
        #form-card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
</head>

<body class="">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
            </a>

        </div>
    </nav>
    <section id="login-form">
        <div class="p-lg-5 p-md-3 p-sm-1 p-1">
            <div class="container card" id="form-card">
                <div class="row" id="signincontent">
                    <div class="col-lg-6 d-md-none d-sm-none d-none d-lg-block d-md-block">
                        <img class="img-fluid" src="https://preview.colorlib.com/theme/bootstrap/login-form-07/images/undraw_remotely_2j6y.svg" alt="">
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="row m-lg-5 m-md-0 m-sm-0 m-0">
                            <div class="col p-0">
                                <div class="mb-5 pt-lg-0 pt-md-0 pt-sm-0 pt-5">
                                    <h2 class="m-0">
                                        Sign In
                                    </h2>
                                </div>
                                <form id="login" method="post">
                                    <label for="phnNumber" class="form-label">Phone Number</label>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text" id="addon">+880</span>
                                        <input name="phn" type="text" class="form-control" id="phn" required>
                                        <p id="phnError" class="text-danger"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signInPass" class="form-label">Password</label>
                                        <input name="pass" type="password" class="form-control" id="pass" placeholder="Password" required>
                                    </div>
                                    <span id="passError" class="text-danger"><?php echo $errmsg ?></span>
                                    <div class="d-flex justify-content-between mb-5">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberMeCheck">
                                            <label for="rememberMeCheck" class="form-label">Remember Me</label>
                                        </div>
                                        <div class="fw-light">
                                            <a href="#" class="link-dark">Forgot Password</a>
                                        </div>
                                    </div>
                                    <div class="mb-5 d-flex justify-content-between">
                                        <span>Or, Login with: </span>
                                        <a class="btn btn-outline-dark" href="<?php echo $client->createAuthUrl();?>"><img style="max-height: 25px;" src="img/icons8-google-48.png" alt=""></a>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>Captcha Verification</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <img class="" src="php/captcha.php" alt="CAPTCHA">
                                                </div>
                                                <div class="col-9">
                                                    <input class="form-control" type="text" name="captcha" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-lg-5 mt-md-5 mt-sm-3 mt-3 row justify-content-center">
                                        <input type="submit" value="Log In" class="col-11 btn p-3 btn-primary">
                                    </div>
                                </form>

                                <div class="d-flex justify-content-between mt-4">
                                    <div>
                                        <p>Don't have an account? <i class="fa-solid fa-arrow-right"></i></p>
                                    </div>
                                    <div>
                                        <a class="link-dark" href="registration_page.php">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/seeker_login_validation.js"></script>
</body>

</html>