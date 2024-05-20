<!DOCTYPE html>
<html lang="en">
<?php
include 'php/registration.php';

session_start();
if (isset($_SESSION['token'])) {
    header("Location: ");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Register</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
            </a>
        </div>
    </nav>
    <section id="registration-form">
        <div class="p-lg-5 p-md-3 p-sm-1 p-1">
            <div class="container card" id="form-card">
                <div class="row" id="signincontent">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="row m-lg-5 m-md-0 m-sm-0 m-0">
                            <div class="col p-0">
                                <div class="mb-5 pt-lg-0 pt-md-0 pt-sm-0 pt-5">
                                    <h2 class="mb-3">
                                        Sign Up
                                    </h2>
                                    <p class="fw-light text-secondary">Find the perfect employment for you, or the perfect employee!</p>
                                </div>
                                <form id="registration" action="" method="post">
                                    <div class="mb-3">
                                        <label for="user" class="form-label">Username</label>
                                        <input name="fname" type="text" class="form-control" id="user" required>
                                        <p id="userError" class="text-danger"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input name="email" type="email" class="form-control" id="email" placeholder="example@example.com" required>
                                        <p id="emailError" class="text-danger"> <?php echo $errmsg; ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phn" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="addon">+880</span>
                                            <input name="phn" type="text" class="form-control" id="phn" required>
                                        </div>
                                        <p id="phnError" class="text-danger"><?php echo $phnerrmsg; ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signInPass" class="form-label">Password</label>
                                        <input name="pass1" type="password" class="form-control" id="pass1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signInPass" class="form-label">Repeat Password</label>
                                        <input name="pass2" type="password" class="form-control" id="pass2" required>
                                        <p id="passError" class="text-danger"></p>
                                    </div>
                                    <div class="d-flex justify-content-between mb-5">
                                        <div class="form-check mt-3">
                                            <input type="checkbox" class="form-check-input" id="tosCheck">
                                            <label for="tosCheck" class="form-label">I have read the <a href="#">Terms and
                                                    Conditions</a></label>
                                        </div>
                                    </div>
                                    <div class="mt-lg-5 mt-md-5 mt-sm-3 mt-3 row justify-content-center">
                                        <button type="submit" class=" col-11 btn p-3 btn-primary">
                                            <h3>Sign Up</h3>
                                        </button>
                                    </div>
                                </form>
                                <div class="d-flex justify-content-between mt-4">
                                    <div>
                                        <p>Already Have An Account? <i class="fa-solid fa-arrow-right"></i></p>
                                    </div>
                                    <div>
                                        <a class="link-dark" href="login_page.php">Sign in</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-md-none d-sm-none d-none d-lg-block d-md-block">
                        <img class="img-fluid m-5" src="img/undraw_join_re_w1lh.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/regis_valid.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>