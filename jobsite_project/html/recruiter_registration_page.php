<!DOCTYPE html>
<html lang="en">
<?php include '../php/recruiter_regis.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/recruiter_regis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Recruiter: Register</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="landing_page.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
            <div class="btn-group">
                <div class="btn btn-outline-dark disabled">Already have an account?</div>
                <a href="recruiter_login_page.php" class="btn btn-primary">Sign In</a>
            </div>
        </div>
    </nav>
    <section id="registration-form">
        <div class="container">
            <div class="card my-5">
                <div class="card-header">
                    <h2 class="text-center">Register as a Recruiter</h2>
                </div>
                <form id="recruitRegistration" action="" method="post">
                    <div id="cardBody" class="card-body row" style="padding: 0px 100px;">
                        <div>
                            <?php echo $errMessage; ?>
                        </div>
                        <div id="errorMessage" class="text-danger">
                        </div>
                        <div id="passError" class="text-danger">
                        </div>
                        <div id="phnError" class="text-danger">

                        </div>
                        <div class="col-12 row p-3">
                            <h3>Account Information</h3>
                            <div class="col-4">
                                <label for="username">Username *</label>
                                <input id="recruitUsername" type="text" name="recruitUsername" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="password">Password *</label>
                                <input id="pass" type="password" name="pass" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="passConfirm">Confirm Password *</label>
                                <input id="passRepeat" type="password" name="passConfirm" class="form-control">
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="col-12 row p-3">
                            <h3>Company Information</h3>
                            <div class="col-3">
                                <label for="companyName">Company Name *</label>
                                <input id="companyName" type="text" name="companyName" class="form-control">
                            </div>
                            <div class="col-3">
                                <label for="companyYear">Year of Establishment *</label>
                                <input id="companyYear" type="text" name="companyYear" class="form-control">
                            </div>
                            <div class="col-3">
                                <label for="companyCategory">Company Category *</label>
                                <select class="form-select" name="companyCategory" id="companyCategory">
                                    <option selected>Select a category</option>
                                    <option value="1">Placeholder 1</option>
                                    <option value="2">Placeholder 2</option>
                                    <option value="3">Placeholder 3</option>
                                    <option value="4">Placeholder 4</option>
                                    <option value="5">Placeholder 5</option>
                                    <option value="6">Placeholder 6</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="companySize">Company Size</label>
                                <select class="form-select" name="companySize" id="companySize">
                                    <option selected>Select</option>
                                    <option value="1">1-50 Employees</option>
                                    <option value="2">50-150 Employees</option>
                                    <option value="3">150-300 Employees</option>
                                    <option value="4">300-500 Employees</option>
                                    <option value="5">500-1000 Employees</option>
                                    <option value="6">1000+ Employees</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 row p-3">
                            <div class="col-12">
                                <label for="companyAdd">Company Address *</label>
                                <select class="form-select" name="companyAddCountry" id="companyAddCountry">
                                    <option selected>Select Country</option>
                                    <option value="1">Placeholder 1</option>
                                    <option value="2">Placeholder 2</option>
                                    <option value="3">Placeholder 3</option>
                                    <option value="4">Placeholder 4</option>
                                    <option value="5">Placeholder 5</option>
                                    <option value="6">Placeholder 6</option>
                                    <option value="7">Placeholder 7</option>
                                    <option value="8">Placeholder 8</option>
                                    <option value="9">Placeholder 9</option>
                                    <option value="10">Placeholder 10</option>
                                </select>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-select mt-3" name="companyAddDistrict" id="companyAddDistrict">
                                            <option selected>Select District</option>
                                            <option value="1">Placeholder 1</option>
                                            <option value="2">Placeholder 2</option>
                                            <option value="3">Placeholder 3</option>
                                            <option value="4">Placeholder 4</option>
                                            <option value="5">Placeholder 5</option>
                                            <option value="6">Placeholder 6</option>
                                            <option value="7">Placeholder 7</option>
                                            <option value="8">Placeholder 8</option>
                                            <option value="9">Placeholder 9</option>
                                            <option value="10">Placeholder 10</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select mt-3" name="companyAddThana" id="companyAddThana">
                                            <option selected>Select Thana</option>
                                            <option value="1">Placeholder 1</option>
                                            <option value="2">Placeholder 2</option>
                                            <option value="3">Placeholder 3</option>
                                            <option value="4">Placeholder 4</option>
                                            <option value="5">Placeholder 5</option>
                                            <option value="6">Placeholder 6</option>
                                            <option value="7">Placeholder 7</option>
                                            <option value="8">Placeholder 8</option>
                                            <option value="9">Placeholder 9</option>
                                            <option value="10">Placeholder 10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <textarea class="mt-3 form-control" style="resize: none;" name="companyAddDetails" id="companyAddDetails" cols="30" rows="10" placeholder="Write company address *"></textarea>
                                    </div>
                                    <div class="col-6">
                                        <textarea class="mt-3 form-control" style="resize: none;" name="companyAddDetailsBD" id="companyAddDetailsBD" cols="30" rows="10" placeholder="Write company address in Bangla"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="my-2" for="companyUrl">Company Website</label>
                                        <input id="companyUrl" type="url" class="form-control" name="companyUrl">
                                    </div>
                                    <div class="col-6">
                                        <label class="my-2" for="companyCode">Business / Trade License *</label>
                                        <input id="companyCode" type="text" class="form-control" name="companyCode">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="col-12 row">
                            <h3 class="mt-2">Contact</h3>
                            <div class="my-2 col-4">
                                <label for="contactPersonName">Contact Person's Name *</label>
                                <input id="contactPersonName" type="text" name="contactPersonName" class="form-control mb-3">
                            </div>
                            <div class="my-2 col-4">
                                <label for="contactPersonNumber">Contact Person's Phone Number *</label>
                                <input id="contactPersonNumber" type="text" name="contactPersonNumber" class="form-control mb-3">
                            </div>
                            <div class="my-2 col-4">
                                <label for="contactPersonEmail">Contact Person's Email</label>
                                <input id="contactPersonEmail" type="email" name="contactPersonEmail" class="form-control mb-3">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <p class="float-end">* Required Fields</p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../js/recruiter_regis_validation.js"></script>
</body>

</html>