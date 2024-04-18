<!DOCTYPE html>
<html lang="en">
<?php
include '../php/seeker_regis.php';
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
            <a class="navbar-brand" href="landing_page.html">
                Logo
            </a>
            <div class="btn-group">
                <div class="btn btn-outline-dark disabled">Already have an account?</div>
                <a href="seeker_login_page.php" class="btn btn-primary">Sign In</a>
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

                            <label for="email" class="mt-3 form-label">Valid E-mail</label>
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

                            <label for="name">Full Name</label>
                            <input id="fname" name="fname" type="text" class="form-control my-2">
                            <p id="fnameError" class="text-danger"></p>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-select my-2" id="gender">
                                        <option selected>Select an option</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <p id="genderError" class="text-danger"></p>
                                </div>
                                <div class="col-6">
                                    <label for="dob">Date of Birth</label>
                                    <input name="dob" class="form-control my-2" type="date" id="dob">
                                    <p id="dobError" class="text-danger"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../js/seeker_regis_validation.js"></script>
</body>

</html>