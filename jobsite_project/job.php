<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';
include 'php/job_search_query.php';

session_start();

if (isset($_GET['new-post'])) {
    if (!isset($_SESSION['token'])) {
        header("Location: login_page.php");
        exit();
    }
}

if (isset($_GET['id'])) {
    $jobId = $_GET['id'];
    $jobData = getJob($pdo, $jobId);
    $jobPicFilePath = "uploads/job/" . $jobData['jindex'] . '.png';
}
$jobCatData = getJobCategories($pdo);
if (isset($_SESSION['orgIndex']) && isset($jobId)) {
    $resumeData = getAllPostedResumes($pdo, $_SESSION['orgIndex'], $jobId);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update']) && !empty($_POST['update'])) {
        $jobtitle = $_POST['jobtitle'];
        $deadline = $_POST['enddate'];
        $dutyskilleduexp = $_POST['dutyskilleduexp'];
        $salary = $_POST['salary'];
        $workarea = $_POST['workarea'];
        $conphone = $_POST['conphone'];
        $conemail = $_POST['conemail'];
        $jindex = $jobId;

        try {
            $sql = "UPDATE job SET jobtitle = :jobtitle, enddate = :enddate, dutyskilleduexp = :dutyskilleduexp, salary = :salary, workarea = :workarea, conphone = :conphone, conemail = :conemail WHERE jindex = :jindex";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':jobtitle', $jobtitle, PDO::PARAM_STR);
            $stmt->bindParam(':enddate', $deadline, PDO::PARAM_STR);
            $stmt->bindParam(':dutyskilleduexp', $dutyskilleduexp, PDO::PARAM_STR);
            $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
            $stmt->bindParam(':workarea', $workarea, PDO::PARAM_STR);
            $stmt->bindParam(':conphone', $conphone, PDO::PARAM_STR);
            $stmt->bindParam(':conemail', $conemail, PDO::PARAM_STR);
            $stmt->bindParam(':jindex', $jindex, PDO::PARAM_STR);
            if ($stmt->execute()) {
                header("location: job.php?view&id=" . $jobData['jindex']);
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    if (isset($_POST['post']) && !empty($_POST['post'])) {
        $jobtitle = $_POST['jobtitle'];
        $jobcategory = $_POST['jobcategory'];
        $deadline = $_POST['enddate'];
        $startDate = date('Y-m-d');
        $dutyskilleduexp = $_POST['dutyskilleduexp'];
        $salary = $_POST['salary'];
        $workarea = $_POST['workarea'];
        $conphone = $_POST['conphone'];
        $conemail = $_POST['conemail'];
        $orgindex = $_SESSION['orgIndex'];
        $visibility = 1;

        try {
            $sql = "INSERT INTO job (jobtitle, jobcategory, startdate, enddate, dutyskilleduexp, salary, workarea, conphone, conemail, orgindex, visibility) VALUES (:jobtitle, :jobcategory, :startdate, :enddate, :dutyskilleduexp, :salary, :workarea, :conphone, :conemail, :orgindex, :visibility)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':jobtitle', $jobtitle, PDO::PARAM_STR);
            $stmt->bindParam(':jobcategory', $jobcategory, PDO::PARAM_STR);
            $stmt->bindParam(':startdate', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':enddate', $deadline, PDO::PARAM_STR);
            $stmt->bindParam(':dutyskilleduexp', $dutyskilleduexp, PDO::PARAM_STR);
            $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
            $stmt->bindParam(':workarea', $workarea, PDO::PARAM_STR);
            $stmt->bindParam(':conphone', $conphone, PDO::PARAM_STR);
            $stmt->bindParam(':conemail', $conemail, PDO::PARAM_STR);
            $stmt->bindParam(':orgindex', $orgindex, PDO::PARAM_STR);
            $stmt->bindParam(':visibility', $visibility, PDO::PARAM_STR);
            if ($stmt->execute()) {
                header("location: posted_jobs.php");
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

if (!isset($_SESSION['orgIndex']) || empty($_SESSION['orgIndex'])) {
    $_SESSION['orgIndex'] = '';
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/account_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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

        .img-normal {
            height: 100px;
            width: 100px;
        }

        #nav-bar {
            box-shadow: 1px 1px 8px #999;
        }
    </style>
    <title><?php if (isset($jobData)) {
                echo $jobData['jobtitle'];
            } else if (isset($_GET['new-post'])) {
                echo "New Post";
            } ?></title>
</head>

<body class="bg-light">
    <nav id="nav-bar" class="navbar p-3 bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
            </a>
            <div class="d-lg-block d-md-block d-sm-none d-none">
                <?php
                $queryPath = 'jobs.php'
                ?>
                <form action="<?= $queryPath; ?>" method="get">
                    <div class="input-group mb-3">
                        <input name="search" id="search-field" type="search" class="form-control border-dark" placeholder="Search Job Listings" aria-label="Job Listing Search Bar" aria-describedby="search-button">
                        <input id="clear-button" class="btn btn-outline-dark" value="&times;" type="button">
                        <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            <?php if (!isset($_SESSION['token']) && !isset($_SESSION['phnNumber'])) { ?>
                <div>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Log in or Sign up
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="login_page.php">Log In</a></li>
                            <li><a class="dropdown-item" href="registration_page.php">Sign Up</a></li>
                        </ul>
                    </div>
                </div>
            <?php } else if (isset($_SESSION['token']) && isset($_SESSION['phnNumber'])) { ?>
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-user"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" href="posted_jobs.php">Jobs Posted</a></li>
                        <li><a class="dropdown-item" href="php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="d-lg-none d-md-none d-sm-block d-block container d-flex justify-content-center mt-4">
            <?php
            $queryPath = 'jobs.php'
            ?>
            <form action="<?= $queryPath; ?>" method="get">
                <div class="input-group mb-3">
                    <input value="<?php if (isset($search)) {
                                        echo $search;
                                    } ?>" name="search" id="second-search-field" type="search" class="form-control border-dark" placeholder="Search Job Listings" aria-label="Job Listing Search Bar" aria-describedby="search-button">
                    <input id="second-clear-button" class="btn btn-outline-dark" value="&times;" type="button">
                    <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
    </nav>
    <section style="min-height: 100vh;" class="" id="dashboard-main-content">
        <div class="modal fade" id="applymodal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="applyModalLabel">Pick a Resume to apply with</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div style="height: 500px;" class="modal-body">
                        <?php foreach ($resumeData as $row) { ?>
                            <div id="landing-page-mouse-hover-card" class="card my-2 ">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="my-3 form-check">
                                                <p><?= $row['fullname'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <?php $resume_img_src = "uploads/resumes/placeholder_pfp.svg";
                                            if (file_exists("uploads/resumes/" . $row['rindex'] . ".png")) {
                                                $resume_img_src = "uploads/resumes/" . $row['rindex'] . ".png";
                                            } ?>
                                            <img class="img-fluid img-thumbnail" style="height: 75px; width: 75px; object-fit: cover; object-position: 25% 25%" src="<?= $resume_img_src ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <?php if ($row['appinvtype'] == 0) { ?>
                                        <a class="btn btn-primary <?= ($row['appindex'] > 0 ? "disabled" : "") ?>" href="php/application.php?id=<?= $jobData['jindex'] ?>&apply&rindex=<?= $row['rindex'] ?>">Apply</a>
                                    <?php } else if ($row['appinvtype'] == 1) { ?>
                                        <a class="btn btn-success" href="php/application.php?jobid=<?= $jobData['jindex'] ?>&acceptinv&rindex=<?= $row['rindex'] ?>">Accept</a> <a class="btn btn-danger" href="php/application.php?jobid=<?= $jobData['jindex'] ?>&rejectinv&rindex=<?= $row['rindex'] ?>">Reject</a>
                                    <?php } else if ($row['appinvtype'] == 2) { ?>
                                        <strong class="text-success"><i class="fa-solid fa-check-double"></i></strong>
                                    <?php } else if ($row['appinvtype'] == 3) { ?>
                                        <strong class="text-danger">You Rejected This</strong>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!isset($_GET['edit']) && !isset($_GET['new-post'])) { ?>
            <div class="bg-light py-lg-5 py-md-4 py-sm-3 py-3 container">
                <div>
                    <button id="goBackButton" class="mb-3 btn btn-danger"><i class="fa-solid fa-arrow-left-long"></i></button>
                </div>
                <div class="row py-3">
                    <div class="text-start d-lg-none d-md-none d-sm-block d-block col-lg-2 col-md-2 col-sm-12 col-12">
                        <?php if (file_exists($jobPicFilePath)) { ?>
                            <img style="height: 100px; width: 100px; object-fit: cover; object-position: 25% 25%" class="img-normal img-thumbnail" src="<?php echo $jobPicFilePath ?>" alt="">
                        <?php } else { ?>
                            <img class="img-normal" src="uploads/job/placeholder-company.png" alt="">
                        <?php } ?>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 mt-4">
                        <div class="row">
                            <h2 class="text-primary"><?php echo $jobData['jobtitle'] ?></h2>
                        </div>
                    </div>
                    <div class="text-end d-lg-block d-md-block d-sm-none d-none col-lg-2 col-md-2">
                        <?php if (file_exists($jobPicFilePath)) { ?>
                            <img class="img-normal" src="<?php echo $jobPicFilePath ?>" alt="">
                        <?php } else { ?>
                            <img class="img-normal" src="uploads/job/placeholder-company.png" alt="">
                        <?php } ?>
                    </div>
                </div>
                <div class="row py-3">
                    <b class="col-12">Application Deadline: <br></b>
                    <p><?= $jobData['enddate'] ?></p>
                </div>
                <div>
                    <h4>Responsibilities/Roles/Requirements</h4>
                    <p><?= $jobData['dutyskilleduexp'] ?></p>
                </div>
                <div class="row p-3">
                    <div class="border border-top border-dark"></div>
                </div>
                <div class="row py-3">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <h5>Salary: <br></h5>
                        <p><?php echo $jobData['salary'] ?></p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <h5>Location: <br></h5>
                        <p> <?= $jobData['workarea'] ?></p>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <b>Contact Phone: <br></b>
                        <p><?php echo $jobData['conphone'] ?></p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <b>Contact Email: <br></b>
                        <p><?= $jobData['conemail'] ?></p>
                    </div>
                            
                    <?php if (isset($_SESSION['token']) && !empty($_SESSION['token'])){
                     if ($_SESSION['orgIndex'] !== $jobData['orgindex']) { ?>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pe-lg-0 pe-md-0 pe-sm-2 pe-2 mb-sm-2 mb-2 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applymodal">Apply</button>
                        </div>
                    <?php } else if ($_SESSION['orgIndex'] == $jobData['orgindex']) { ?>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pe-lg-0 pe-md-0 pe-sm-2 pe-2 mb-sm-2 mb-2 text-end">
                            <a href="?view&id=<?= $jobData['jindex'] ?>&edit" class="btn btn-primary">Edit</a>
                        </div>
                    <?php } } else { ?>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pe-lg-0 pe-md-0 pe-sm-2 pe-2 mb-sm-2 mb-2 text-end">
                            <a href="login_page" class="btn btn-primary">Login to Apply</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($_GET['edit'])) { ?>
            <form action="" method="post">
                <div class="bg-light py-lg-5 py-md-4 py-sm-3 py-3 container">
                    <div class="mb-3">
                        <button id="goBackButton" class=" btn btn-danger"><i class="fa-solid fa-arrow-left-long"></i></button>
                    </div>
                    <div class="row py-3">
                        <div class="text-start d-lg-none d-md-none d-sm-block d-block col-lg-2 col-md-2 col-sm-12 col-12">
                            <?php if (file_exists($jobPicFilePath)) { ?>
                                <img class="img-normal" src="<?php echo $jobPicFilePath ?>" alt="">
                            <?php } else { ?>
                                <img class="img-normal" src="uploads/job/placeholder-company.png" alt="">
                            <?php } ?>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                            <div class="row">
                                <label for="jobtitle">
                                    <h4>Job Title</h4>
                                </label>
                                <input id="jobtitle" name="jobtitle" type="text" class="form-control" value="<?= $jobData['jobtitle'] ?>">
                            </div>
                        </div>
                        <div class="text-end d-lg-block d-md-block d-sm-none d-none col-lg-2 col-md-2 col-sm-12 col-12">
                            <?php if (file_exists($jobPicFilePath)) { ?>
                                <img class="img-normal" src="<?php echo $jobPicFilePath ?>" alt="">
                            <?php } else { ?>
                                <img class="img-normal" src="uploads/job/placeholder-company.png" alt="">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <label for="enddate">Deadline:</label>
                        <input id="enddate" name="enddate" type="date" class="form-control" value="<?= $jobData['enddate'] ?>">
                    </div>

                    <div class="row py-3">
                        <h3>Responsibilities/Roles/Requirements</h3>
                        <textarea id="dutyskilleduexp" style="resize: none;" name="dutyskilleduexp" class="rte form-control" cols="30" rows="10"><?= $jobData['dutyskilleduexp'] ?></textarea>

                    </div>
                    <div class="row py-3">
                        <div class="border border-top border-dark"></div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="salary">
                                <h5>Salary</h5>
                            </label>
                            <input id="salary" name="salary" type="text" class="form-control" value="<?= $jobData['salary'] ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="workarea">
                                <h5>Location</h5>
                            </label>
                            <input id="workarea" name="workarea" type="text" class="form-control" value="<?= $jobData['workarea'] ?>">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="conphone">
                                <h5>Contact Phone</h5>
                            </label>
                            <input id="conphone" name="conphone" type="text" class="form-control" value="<?= $jobData['conphone'] ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="">
                                <h5>Contact Email</h5>
                            </label>
                            <input id="conemail" name="conemail" type="email" class="form-control" value="<?= $jobData['conemail'] ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 pe-0 me-0 mt-sm-3 mt-3 row">
                            <div class="col-lg-6 col-md-6 col-sm-0 col-0">

                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 pe-0 mb-sm-2 mb-2 text-end">
                                <input type="submit" value="Post" class="btn btn-primary" name="post">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 text-end pe-sm-0 pe-0">
                                <a class="btn btn-danger" href="?view&id=<?= $jobData['jindex'] ?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
        <?php if (isset($_GET['new-post'])) { ?>
            <form action="" method="post">
                <div class="bg-light py-lg-5 py-md-4 py-sm-3 py-3 container">
                    <div class="row py-3">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-6">
                                    <label for="jobtitle">
                                        <h4>Job Title</h4>
                                    </label>
                                    <input id="jobtitle" name="jobtitle" type="text" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="jobcategory">
                                        <h4>Job Category</h4>
                                    </label>
                                    <select name="jobcategory" id="jobcategory" class="form-control">
                                        <option selected>Select A Category</option>
                                        <?php foreach ($jobCatData as $row) {
                                            echo "<option value='" . $row["jcatindex"] . "'>" . $row["jcategory"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-end col-lg-2 col-md-2 col-sm-12 col-12">
                            <?php if (!isset($jobPicFilePath)) {
                                $jobPicFilePath = '';
                            }
                            if (file_exists($jobPicFilePath)) { ?>
                                <img class="img-normal" src="<?php echo $jobPicFilePath ?>" alt="">
                            <?php } else { ?>
                                <img class="img-normal" src="uploads/job/placeholder-company.png" alt="">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <label for="enddate">Deadline:</label>
                        <input id="enddate" name="enddate" type="date" class="form-control">
                    </div>

                    <div class="row py-3">
                        <h3>Responsibilities/Roles/Requirements</h3>
                        <textarea id="dutyskilleduexp" style="resize: none;" name="dutyskilleduexp" class="rte form-control" cols="30" rows="10"></textarea>

                    </div>
                    <div class="row py-3">
                        <div class="border border-top border-dark"></div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="salary">
                                <h5>Salary</h5>
                            </label>
                            <input id="salary" name="salary" type="text" class="form-control">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="workarea">
                                <h5>Location</h5>
                            </label>
                            <input id="workarea" name="workarea" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="conphone">
                                <h5>Contact Phone</h5>
                            </label>
                            <input id="conphone" name="conphone" type="text" class="form-control">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <label for="">
                                <h5>Contact Email</h5>
                            </label>
                            <input id="conemail" name="conemail" type="email" class="form-control">
                        </div>
                        <div class="col-4 pe-0 me-0 row">
                            <div class="col-lg-6 col-md-6 col-sm-0 col-0">

                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                <a class="btn btn-danger" href="posted_jobs.php">Cancel</a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6 pe-0 text-end">
                                <input type="submit" value="Post" class="btn btn-primary" name="post">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
    </section>
    <div id="footer" class="bg-dark text-light">
        <div class="container">
            <footer class="row py-5">
                <div class="col-6">
                    <img src="img/logoipsum-248.svg" alt="">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var clearButton = document.getElementById('clear-button');
            var searchField = document.getElementById('search-field');

            clearButton.addEventListener('click', function() {
                searchField.value = '';
                searchField.focus();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var clearButton = document.getElementById('second-clear-button');
            var searchField = document.getElementById('second-search-field');

            clearButton.addEventListener('click', function() {
                searchField.value = '';
                searchField.focus();
            });
        });
    </script>
    <script>
        document.getElementById('goBackButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.rte').summernote({
                height: 300
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>