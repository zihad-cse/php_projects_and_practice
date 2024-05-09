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

$orgindex = $userData['orgindex'];
$jobCatData = getJobCategories($pdo);
$jobData = getPostedJobData($pdo, $phnNumber);

$allJobsData = getAllPostedJobs($pdo, $orgindex);

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
    <title>Posted Circulars
    </title>
</head>

<body class="bg-light">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="landing_page.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
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
                                    <li><a href="#" class="btn btn-secondary-outline">Overview</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Weekly</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Monthly</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Annually</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Jobs
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
                    <h3>Posted Jobs</h3>
                    <div class="row">
                        <div class="col-2">
                            <b>Circular ID</b>
                        </div>
                        <div class="col-4">
                            <b>Title</b>
                        </div>
                        <div class="col-2">
                            <b>Deadline</b>
                        </div>
                        <div class="col-2">

                        </div>
                    </div>
                    <?php foreach ($allJobsData as $aJob) { ?>
                        <div class="row my-3">
                            <div class="col-2">
                                <p><?php echo $aJob['jindex'] ?></p>
                            </div>
                            <div class="col-4">
                                <p><?php echo $aJob['jobtitle'] ?></p>
                            </div>
                            <div class="col-2">
                                <p><?php echo $aJob['enddate'] ?></p>
                            </div>
                            <div class="col-2">
                                <a href="job.php?view&id=<?php echo $aJob['jindex'] ?>">View</a>
                            </div>
                        </div>
                    <?php } ?>
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