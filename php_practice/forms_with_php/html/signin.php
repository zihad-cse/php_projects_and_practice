<!DOCTYPE html>
<html lang="en">
<?php
include '../forms_with_php/php/login_script.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../forms_with_php/css/signin.css">
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Sign In</title>
</head>

<body>
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
                                <h2 class="mb-3">
                                    Sign In
                                </h2>
                                <p class="fw-light text-secondary">Lorem ipsum dolor sit amet consectetur adipisicing
                                    elit. Vero,
                                    laboriosam. Dolores veritatis vel quisquam vero.</p>
                            </div>
                            <form id="signin-form" action="" method="post" class="">
                                <div class="mb-3">
                                    <div><?php echo $errorMessage;?></div>
                                    <label for="emailInput" class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="emailInput" placeholder="example@example.com">
                                    <div id="emailError" class="mb-3 text-danger"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="signInPass" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="signInPass" placeholder="Password">
                                    <div id="passError" class="mb-3 text-danger"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-5">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="rememberMeCheck">
                                        <label for="rememberMeCheck" class="form-label">Remember Me</label>
                                    </div>
                                    <div class="fw-light">
                                        <a href="#" class="link-dark">Forgot Password</a>
                                    </div>
                                </div>
                                <div class="mt-lg-5 mt-md-5 mt-sm-3 mt-3 row justify-content-center">
                                    <button type="submit" class=" col-11 btn p-3 btn-primary">
                                        <h3>Login</h3>
                                    </button>
                                </div>
                            </form>
                            <div class="mt-5">
                                <p>-Or login with-</p>
                            </div>
                            <div>
                                <a class="pe-2" href="#"><img src="img/icons8-google-48.png" alt="Google"></a>
                                <a class="px-2" href="#"><img src="img/icons8-facebook-48.png" alt="Facebook"></a>
                                <a class="px-2" href="#"><img src="img/icons8-twitter-48.png" alt="Twitter"></a>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    <p>Don't have an account? <i class="fa-solid fa-arrow-right"></i></p>
                                </div>
                                <div>
                                    <a class="link-dark" href="signup.php">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../forms_with_php/javascript/sign_in_validation.js"></script>
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
</body>

</html>