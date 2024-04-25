<!DOCTYPE html>
<html lang="en">
<?php
include '../php/user_data.php';
include '../php/auth.php';
include '../php/db_connection.php';

$errMessage = '';

session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login_page.php");
    exit();
}

if (isset($_GET['phnNumber'])) {
    $phnNumber = $_GET['phnNumber'];
    $userData = getUserData($pdo, $phnNumber);
}
// if ($userData == false){
//     echo 'NO USER DATA FOUND';
//     exit();
// }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/account_dashboard.css">
    <style>
        #logout-button:hover {
            color: #dc3545;
        }
    </style>
    <title>Dashboard</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas"><i class="fa-solid fa-bars"></i></button>

            <a class="navbar-brand" href="landing_page.html">
                Logo
            </a>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item btn" href="#">Edit Profile</a></li>
                    <li><a class="dropdown-item btn" href="#">Settings</a></li>
                    <li>
                        <form action="../php/logout.php" method="post" class="dropdown-item"><input class="btn p-0" type="submit" value="Log Out" id="#logout-button"></form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content" class=>
        <div class="card">


            <div class="offcanvas offcanvas-start" data-bs-scroll="false" data-bs-backdrop="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas with body scrolling</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <p>Try scrolling the rest of the page to see this option in action.</p>
                </div>
            </div>
            <div class="card-body container">
                <h3>Profile</h3>
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
                                <label for="username">Username</label>
                                <input id="recruitUsername" type="text" name="recruitUsername" class="form-control">
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
                                        <label class="my-2" for="companyCode">Business / Trade License  *</label>
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


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>