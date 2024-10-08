<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';

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

$allJobsData = getAllPostedJobs($pdo, $orgindex);
$filter = '';
if (!empty($_GET['filter']) && isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}

$inviteList = resumeInvitations($pdo, $userData['orgindex'], $filter);


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/account_dashboard.css">
    <link rel="stylesheet" href="css/landing_page.css">
    <style>
        #logout-button:hover {
            color: #dc3545;
        }

        .small-textarea {
            height: 100px;
            resize: none;
        }

        #landing-page-mouse-hover-card {
            box-shadow: 1px 1px 8px #999;
        }


        #landing-page-mouse-hover-card:hover {
            border: var(--bs-card-border-width) solid black;
            box-shadow: 4px 4px 8px #999;
        }
    </style>
    <title>Posted Listings
    </title>
</head>

<body class="bg-light">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo.png" alt="">
            </a>
            <div class="dropdown d-sm-block d-md-block d-lg-none d-block">
                <div class="btn-group">
                    <button class="btn btn-outline-dark" disabled><?= $userData['orguser'] ?></button>
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><strong class="dropdown-header">Employer Menu</strong></li>
                        <li><a class="dropdown-item" href="posted_jobs.php">All Jobs Posted</a></li>
                        <li><a class="dropdown-item" href="posted_jobs.php?invitations&sent" class="btn btn-secondary-outline">Invitations Sent</a></li>
                        <li><a class="dropdown-item" href="resume_profile.php?applied-jobs&received" class="btn btn-secondary-outline">Applications Received</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><strong class="dropdown-header">Seeker Menu</strong></li>
                        <li><a class="dropdown-item" href="resume_profile.php">All Posted Resumes</a></li>
                        <li><a class="dropdown-item" href="posted_jobs.php?invitations&received" class="btn btn-secondary-outline">Invitations Received</a></li>
                        <li><a class="dropdown-item" href="resume_profile.php?applied-jobs&sent" class="btn btn-secondary-outline">Applications Sent</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="text-danger dropdown-item" href="/php_basics/jobsite_project/php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row">
                <div class="col-lg-2 d-lg-block d-md-none d-sm-none d-none col-3 p-3 bg-white">
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Account
                            </button>
                            <div class="collapse" id="dashboard-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="dashboard.php" class="btn btn-secondary-outline">Home</a></li>
                                    <li><a href="org_profile.php" class="btn btn-secondary-outline">Org Profile</a></li>
                                    <li><a href="resume_profile.php" class="btn btn-secondary-outline">Resume List</a></li>
                                    <li>
                                        <form action="php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" method="post" class="btn btn-secondary-outline">
                                            <input class="btn p-0 text-danger" type="submit" value="Log Out" id="#logout-button">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#employer-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Employer Menu
                            </button>
                            <div class="collapse" id="employer-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="job.php?new-post" class="btn btn-secondary-outline">Post New Job Offer</a></li>
                                    <li><a href="posted_jobs.php" class="btn btn-secondary-outline">Posted Jobs</a></li>
                                    <li><a href="posted_jobs.php?invitations&sent" class="btn btn-secondary-outline">Job Invitations Sent</a></li>
                                    <li><a href="resume_profile.php?applied-jobs&received" class="btn btn-secondary-outline">Received Applications</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#seeker-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Job Seeker Menu
                            </button>
                            <div class="collapse" id="seeker-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="resume.php?new-resume" class="btn btn-secondary-outline">Post a Resume</a></li>
                                    <li><a href="resume_profile.php" class="btn btn-secondary-outline">All Posted Resumes</a></li>
                                    <li><a href="resume_profile.php?applied-jobs&sent" class="btn btn-secondary-outline">Sent Applications</a></li>
                                    <li><a href="posted_jobs.php?invitations&received" class="btn btn-secondary-outline">Received Invitations</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-10 col-md-12 col-sm-12 col-12 p-5" style="min-height: 100vh; background-color: #ddd;">
                    <?php if (!isset($_GET['invitations'])) { ?>
                        <hr>
                        <div class="row border">
                            <div class="col-2">
                                <h3>Posted Jobs</h3>
                            </div>
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <a class="btn btn-primary" href="job.php?new-post"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <?php if (!empty($allJobsData)) {
                                foreach ($allJobsData as $row) {
                                    $job_img_src = "uploads/job/placeholder-company.png";
                                    if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                        $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                    }
                            ?>
                                    <div class="container">
                                        <div class="col-12 mx-0">
                                            <div id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 170px;" onclick="location.href='job.php?view&id=<?= $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                <div class="card-body">
                                                    <div class="row text-sm-center text-md-center text-lg-start text-center">
                                                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                            <img class="img-fluid" style="max-height: 100px;" src="<?php echo $job_img_src ?>" alt="">
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <b class="m-0 p-2"><?php echo $row['jobtitle']; ?> </b>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="p-2">
                                                                        <?php if (strlen($row['dutyskilleduexp']) > 100) {
                                                                            $maxLength = 99;
                                                                            $row['dutyskilleduexp'] = substr($row['dutyskilleduexp'], 0, $maxLength);
                                                                        } ?>
                                                                        <p class="mb-0"><?= $row['dutyskilleduexp']; ?>...</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="m-0 p-2"><i class="fa-solid fa-dollar-sign"></i> <?php echo $row['salary']; ?> </p>
                                                                </div>
                                                            </div>
                                                            <div class=" row">
                                                                <div class="col-6">
                                                                    <span class="p-2"><i class="fa-solid fa-location-dot"></i> <?= $row['workarea'] ?></span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <b><i class="fa-solid fa-calendar-day"></i> <?= $row['enddate'] ?></b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>

                                <div class="text-center">
                                    <b>None Posted</b>
                                </div>

                            <?php } ?>
                        </div>
                    <?php } else if (isset($_GET['invitations'])) { ?>
                        <div class="row">
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                        <i class="fa-solid fa-filter"></i> Filter
                                    </button>
                                    <div class="dropdown-menu">
                                        <h6 class="dropdown-header">Type</h6>
                                        <div class="p-2">
                                            <div class="dropdown-item <?php if ($_GET['filter'] == 2) {
                                                                            echo "active";
                                                                        } ?> ">
                                                <a class="text-decoration-none <?php if ($_GET['filter'] == 2) {
                                                                                    echo "text-light";
                                                                                } else {
                                                                                    echo "text-success";
                                                                                } ?> " href="?invitations&filter=2<?php if (isset($_GET['sent'])) {
                                                                                                                        echo "&sent";
                                                                                                                    } else if (isset($_GET['received'])) {
                                                                                                                        echo "&received";
                                                                                                                    } ?>">Accepted</a>
                                            </div>
                                            <div class="dropdown-item">
                                                <a class="text-decoration-none <?php if ($_GET['filter'] == 3) {
                                                                                    echo "text-light";
                                                                                } else {
                                                                                    echo "text-danger";
                                                                                } ?> " href="?invitations&filter=3<?php if (isset($_GET['sent'])) {
                                                                                                                        echo "&sent";
                                                                                                                    } else if (isset($_GET['received'])) {
                                                                                                                        echo "&received";
                                                                                                                    } ?>">Rejected</a>
                                            </div>
                                            <div class="dropdown-item">
                                                <a class="text-decoration-none <?php if ($_GET['filter'] == 1) {
                                                                                    echo "text-light";
                                                                                } else {
                                                                                    echo "text-warning";
                                                                                } ?> " href="?invitations&filter=1<?php if (isset($_GET['sent'])) {
                                                                                                                        echo "&sent";
                                                                                                                    } else if (isset($_GET['received'])) {
                                                                                                                        echo "&received";
                                                                                                                    } ?>">Pending</a>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <div class="p-2">
                                            <div class="dropdown-item <?php if (isset($_GET['sent'])) {
                                                                            echo "active";
                                                                        } ?>">
                                                <a href="?invitations<?php if (isset($_GET['filter'])) {
                                                                            echo "&filter=" . $_GET['filter'];
                                                                        } ?>&sent" class="text-decoration-none <?php if (isset($_GET['sent'])) {
                                                                                                                    echo "text-light";
                                                                                                                } else {
                                                                                                                    echo "text-dark";
                                                                                                                } ?>">Sent</a>
                                            </div>
                                            <div class="dropdown-item <?php if (isset($_GET['received'])) {
                                                                            echo "active";
                                                                        } ?>">
                                                <a href="?invitations<?php if (isset($_GET['filter'])) {
                                                                            echo "&filter=" . $_GET['filter'];
                                                                        } ?>&received" class="text-decoration-none <?php if (isset($_GET['received'])) {
                                                                                                                        echo "text-light";
                                                                                                                    } else {
                                                                                                                        echo "text-dark";
                                                                                                                    } ?>">Received</a>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <div class="p-2">
                                            <div class="dropdown-item">
                                                <a href="?invitations" class="text-decoration-none text-dark">Reset Filters</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <h3>Invitations Sent/Recieved</h3>
                            </div>
                            <div class="col-4"></div>
                        </div>
                        <div class="row">
                            <?php if (!empty($inviteList)) { ?>
                                <?php if (!isset($_GET['sent']) && !isset($_GET['received'])) { ?>
                                    <?php foreach ($inviteList as $row) {
                                        $job_img_src = "uploads/job/placeholder-company.png";
                                        if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                            $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                        } ?>
                                        <div class="container row">
                                            <div class="col-12 mx-0">
                                                <div id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 170px;" onclick="location.href='job.php?view&id=<?= $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                    <div class="card-body">
                                                        <div class="row text-sm-center text-md-center text-lg-start text-center">
                                                            <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                                <img class="img-fluid" style="max-height: 100px;" src="<?php echo $job_img_src ?>" alt="">
                                                            </div>
                                                            <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <b class="m-0 p-2"><?php echo $row['jobtitle']; ?> </b>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="p-2">
                                                                            <p class="mb-0">For: <b><?= $row['fullname'] ?></b></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="m-0 p-2"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <span class="p-2"><i class="fa-solid fa-location-dot"></i> <?= $row['workarea'] ?></span>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <b><i class="fa-solid fa-calendar-day"></i> <?= $row['enddate'] ?></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <?php if ($row['jobOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                    <strong>Type: Invitation Sent<br></strong>
                                                                    <strong>Status: </strong>
                                                                    <?php if ($row['appinvtype'] == 1) { ?>
                                                                        <strong class='text-success'>Pending</strong>
                                                                    <?php } else if ($row['appinvtype'] == 2) { ?>
                                                                        <strong class='text-success'>Accepted</strong>
                                                                    <?php } else if ($row['appinvtype'] == 3) { ?>
                                                                        <strong class='text-danger'>Rejected</strong>
                                                                    <?php }
                                                                } else if ($row['resumeOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                    <strong>Type: Invitation Received <br></strong>
                                                                    <strong>Status: </strong>
                                                                    <?php if ($row['appinvtype'] == 1) { ?>
                                                                        <a class="btn btn-success" href="php/application.php?acceptinv&jobid=<?= $row['jindex'] ?>&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Accept</a>
                                                                        <a class="btn btn-danger" href="php/application.php?rejectinv&jobid=<?= $row['jindex'] ?>&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Reject</a>
                                                                    <?php } else if ($row['appinvtype'] == 2) { ?>
                                                                        <strong class="text-success">Accepted</strong>
                                                                    <?php } else if ($row['appinvtype'] == 3) { ?>
                                                                        <strong class="text-danger">Rejected</strong>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php }
                                if (isset($_GET['sent'])) { ?>
                                    <?php foreach ($inviteList as $row) {
                                        $job_img_src = "uploads/job/placeholder-company.png";
                                        if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                            $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                        } ?>
                                        <?php if ($row['jobOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                            <div class="container row">
                                                <div class="col-12 mx-0">
                                                    <div id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 170px;" onclick="location.href='job.php?view&id=<?= $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                        <div class="card-body">
                                                            <div class="row text-sm-center text-md-center text-lg-start text-center">
                                                                <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                                    <img class="img-fluid" style="max-height: 100px;" src="<?php echo $job_img_src ?>" alt="">
                                                                </div>
                                                                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <b class="m-0 p-2"><?php echo $row['jobtitle']; ?> </b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="p-2">
                                                                                <p class="mb-0">For: <b><?= $row['fullname'] ?></b></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <p class="m-0 p-2"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <span class="p-2"><i class="fa-solid fa-location-dot"></i> <?= $row['workarea'] ?></span>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <b><i class="fa-solid fa-calendar-day"></i> <?= $row['enddate'] ?></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <?php if ($row['jobOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                        <strong>Type: Invitation Sent<br></strong>
                                                                        <strong>Status: </strong>
                                                                        <?php if ($row['appinvtype'] == 1) { ?>
                                                                            <strong class='text-success'>Pending</strong>
                                                                        <?php } else if ($row['appinvtype'] == 2) { ?>
                                                                            <strong class='text-success'>Accepted</strong>
                                                                        <?php } else if ($row['appinvtype'] == 3) { ?>
                                                                            <strong class='text-danger'>Rejected</strong>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php }
                                if (isset($_GET['received'])) { ?>
                                    <?php foreach ($inviteList as $row) {
                                        $job_img_src = "uploads/job/placeholder-company.png";
                                        if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                            $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                        } ?>
                                        <?php if ($row['resumeOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                            <div class="container row">
                                                <div class="col-12 mx-0">
                                                    <div id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 170px;" onclick="location.href='job.php?view&id=<?= $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                        <div class="card-body">
                                                            <div class="row text-sm-center text-md-center text-lg-start text-center">
                                                                <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                                    <img class="img-fluid" style="max-height: 100px;" src="<?php echo $job_img_src ?>" alt="">
                                                                </div>
                                                                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <b class="m-0 p-2"><?php echo $row['jobtitle']; ?> </b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="p-2">
                                                                                <p class="mb-0">For: <b><?= $row['fullname'] ?></b></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <p class="m-0 p-2"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <span class="p-2"><i class="fa-solid fa-location-dot"></i> <?= $row['workarea'] ?></span>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <b><i class="fa-solid fa-calendar-day"></i> <?= $row['enddate'] ?></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <?php if ($row['resumeOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                        <strong>Type: Invitation Received <br></strong>
                                                                        <strong>Status: </strong>
                                                                        <?php if ($row['appinvtype'] == 1) { ?>
                                                                            <a class="btn btn-success" href="php/application.php?acceptinv&jobid=<?= $row['jindex'] ?>&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Accept</a>
                                                                            <a class="btn btn-danger" href="php/application.php?rejectinv&jobid=<?= $row['jindex'] ?>&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Reject</a>
                                                                        <?php } else if ($row['appinvtype'] == 2) { ?>
                                                                            <strong class="text-success">Accepted</strong>
                                                                        <?php } else if ($row['appinvtype'] == 3) { ?>
                                                                            <strong class="text-danger">Rejected</strong>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>

                                <div class="text-center">
                                    <b>None Posted</b>
                                </div>

                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <div id="footer" class="bg-dark text-light">
        <div class="container">
            <footer class="row py-5 footer-icon">
                <div class="col-6">
                    <img src="img/icon.png" alt="">
                </div>
                <div class="col-6">
                    <ul class="list-unstyled d-flex justify-content-end">
                        <li class="ms-3"><a class="text-decoration-none text-light" href="index.php">Home</a></li>
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">Terms and Conditions</a></li>
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">FAQs</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <script>
        document.getElementById('goBackButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>