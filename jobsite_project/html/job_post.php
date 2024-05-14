<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../php/user_data.php';
include '../php/auth.php';
include '../php/db_connection.php';

session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login_page.php");
    exit();
}

//Fetches User Data (table: org)

if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $userData = getUserData($pdo, $phnNumber);
}

//Fetches Resume Data (table: resumes)

if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $resumeData = getResumeData($pdo, $phnNumber);
}

$jobCatData = getJobCategories($pdo);

$orgindex = $userData['orgindex'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jobCategory = $_POST['jobCategory'];
    $jobTitle = $_POST['jobTitle'];
    $workArea = $_POST['workArea'];
    $dutySkilledUExp = $_POST['dutySkilledUExp'];
    $startDate = date('Y-m-d');
    $endDate = $_POST['endDate'];
    $salary = $_POST['salary'];
    $conEmail = $_POST['conEmail'];
    $conPhone = $_POST['conPhone'];

    if (isset($_POST['visibility'])) {
        $visibility = 1;
    }
    if (!isset($_POST['visibility'])) {
        $visibility = 0;
    }
    try {
        $sql = "INSERT INTO job (orgindex, jobcategory, jobtitle, startdate, enddate, visibility, conemail, conphone, workarea, dutyskilleduexp, salary) VALUES (:orgindex, :jobcategory, :jobtitle, :startdate, :enddate, :visibility, :conemail, :conphone, :workarea, :dutyskilleduexp, :salary)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":orgindex", $orgindex, PDO::PARAM_STR);
        $stmt->bindParam(":jobcategory", $jobCategory, PDO::PARAM_STR);
        $stmt->bindParam(":jobtitle", $jobTitle, PDO::PARAM_STR);
        $stmt->bindParam(":workarea", $workArea, PDO::PARAM_STR);
        $stmt->bindParam(":dutyskilleduexp", $dutySkilledUExp, PDO::PARAM_STR);
        $stmt->bindParam(":salary", $salary, PDO::PARAM_STR);
        $stmt->bindParam(":startdate", $startDate, PDO::PARAM_STR);
        $stmt->bindParam(":enddate", $endDate, PDO::PARAM_STR);
        $stmt->bindParam(":conemail", $conEmail, PDO::PARAM_STR);
        $stmt->bindParam(":conphone", $conPhone, PDO::PARAM_STR);
        $stmt->bindParam(":visibility", $visibility, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: posted_jobs.php");
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

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

        .small-textarea {
            height: 100px;
            resize: none;
        }
    </style>
    <title>Post a circular</title>
</head>

<body class="bg-light">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
            <div class="d-sm-block d-md-block d-lg-none d-block dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="html/dashboard.php">Dashboard</a></li>
                    <li><a class="dropdown-item" href="html/posted_jobs.php">Jobs Posted</a></li>
                    <li><a class="dropdown-item" href="/php_basics/jobsite_project/php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row">
                <div class="d-none d-sm-none d-md-none d-lg-block col-2 p-3 bg-white">
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Dashboard
                            </button>
                            <div class="collapse" id="dashboard-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="#" class="btn btn-secondary-outline">##</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">##</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">##</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">##</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Orders
                            </button>
                            <div class="collapse" id="orders-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="job_post.php" class="btn btn-secondary-outline">New</a></li>
                                    <li><a href="posted_jobs.php" class="btn btn-secondary-outline">Posted</a></li>

                                </ul>
                            </div>
                        </li>
                        <li class="border-top my-3"></li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Account
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="dashboard.php" class="btn btn-secondary-outline">Overview</a></li>
                                    <li>
                                        <form action="../php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" method="post" class="btn btn-secondary-outline">
                                            <input class="btn p-0" type="submit" value="Log Out" id="#logout-button">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-10 col-md-12 col-sm-12 col-12 p-5" style="min-height: 1000px; background-color: #ddd;">
                    <h4 class="mb-3">Post A Circular</h4>
                    <hr>
                    <form method="post" id="job-post">
                        <div style="display: none;" id="error-message-box" class="row my-4">
                            <div class="col-3">
                                <div class="bg-danger rounded p-3">
                                    <p id="error-message" class=" m-0 text-center text-light"></p>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" id="phone-error-message-box" class="row my-4">
                            <div class="col-3">
                                <div class="bg-danger rounded p-3">
                                    <p id="phone-error-message" class=" m-0 text-center text-light"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Job title</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <input id="jobTitle" name="jobTitle" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Job Category</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <select name="jobCategory" id="jobCategory" class="form-control">
                                    <option selected>Select A Category</option>
                                    <?php foreach ($jobCatData as $row) {
                                        echo "<option value='" . $row["jcatindex"] . "'>" . $row["jcategory"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Location</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <input id="workArea" name="workArea" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Responsibilities</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <textarea id="dutySkilledUExp" style="resize: none;" name="dutySkilledUExp" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Salary</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <input id="salary" name="salary" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Deadline</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <input id="endDate" name="endDate" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Contact Email</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <input id="conEmail" name="conEmail" type="email" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <b>Contact Phone Number</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <input id="conPhone" name="conPhone" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                                <b>Visibility</b>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 form-check">
                                <input value="1" type="checkbox" id="visibility" class="form-check-input" name="visibility">
                            </div>
                        </div>
                        <hr>
                        <input id="jobPost" name="jobPost" type="submit" class="btn btn-primary" value="Post">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div id="footer" class="bg-dark text-light" >
        <div class="container">
            <footer class="row py-5">
                <div class="col-6">
                    <img src="../img/logoipsum-248.svg" alt="">
                </div>
                <div class="col-6">
                    <ul class="list-unstyled d-flex justify-content-end">
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">Home</a></li>
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">Terms and Conditions</a></li>
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">FAQs</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../js/job_post_valid.js"></script>
</body>

</html>