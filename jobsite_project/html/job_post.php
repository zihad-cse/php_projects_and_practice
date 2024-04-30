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
    $salary = $_POST['salary'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
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
            <a class="navbar-brand" href="landing_page.html">Logo</a>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row">
                <div class="col-3 p-3 bg-white" style="width: 280px;">
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
                                        <form action="../php/logout.php" method="post" class="btn btn-secondary-outline">
                                            <input class="btn p-0" type="submit" value="Log Out" id="#logout-button">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-9 p-5" style="min-height: 1000px; background-color: #ddd;">
                    <h4 class="mb-3">Post A Circular</h4>
                    <hr>
                    <form method="post">
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Job title</b>
                            </div>
                            <div class="col-6">
                                <input name="jobTitle" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Job Category</b>
                            </div>
                            <div class="col-6">
                                <select name="jobCategory" id="" class="form-control">
                                    <option selected>Select A Category</option>
                                    <?php foreach ($jobCatData as $row) {
                                        echo "<option value='" . $row["jcatindex"] . "'>" . $row["jcategory"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <b>Location</b>
                            </div>
                            <div class="col-6">
                                <input name="workArea" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Responsibilities</b>
                            </div>
                            <div class="col-6">
                                <textarea style="resize: none;" name="dutySkilledUExp" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Salary</b>
                            </div>
                            <div class="col-6">
                                <input name="salary" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Start Date</b>
                            </div>
                            <div class="col-6">
                                <input name="startDate" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Deadline</b>
                            </div>
                            <div class="col-6">
                                <input name="endDate" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Contact Email</b>
                            </div>
                            <div class="col-6">
                                <input name="conEmail" type="email" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Contact Phone Number</b>
                            </div>
                            <div class="col-6">
                                <input name="conPhone" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2">
                                <b>Visibility</b>
                            </div>
                            <div class="col-6 form-check">
                                <input value="1" type="checkbox" id="visibility" class="form-check-input" name="visibility">
                            </div>
                        </div>
                        <hr>
                        <input name="jobPost" type="submit" class="btn btn-primary" value="Post">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>