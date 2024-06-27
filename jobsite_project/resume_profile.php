<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';
include 'php/pagination.php';

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
    $resumeData = getAllPostedResumes($pdo, $userData['orgindex']);
}

$countedRows = count($resumeData);

$filter = '';
if (!empty($_GET['filter']) && isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}

$appliedJobs = appliedJobs($pdo, $userData['orgindex'], $filter);


//Updates resume details (table: resumes)

if ($resumeData == true) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
        $fullName = $_POST['fullname'];
        $fatherName = $_POST['fathername'];
        $motherName = $_POST['mothername'];
        $dateOfBirth = $_POST['dateofbirth'];
        $religion = $_POST['religion'];
        $homeAddress = $_POST['homeaddress'];
        $birthArea = $_POST['birtharea'];
        $skills = $_POST['skilleduexp'];
        $resumeDetailsShow = isset($_POST['resumeDetailsShow']) ? 1 : 0;
        $userIndex = $userData['orgindex'];

        try {
            $sql = 'UPDATE resumes SET visible = :resumeDataShow, fullname = :fullName, fathername = :fatherName, mothername = :motherName, dateofbirth = :dateOfBirth, religion = :religion, homeaddress = :homeAddress, birtharea = :birthArea, skilleduexp = :skills WHERE orgindex = :userIndex';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":fullName", $fullName, PDO::PARAM_STR);
            $stmt->bindParam(":fatherName", $fatherName, PDO::PARAM_STR);
            $stmt->bindParam(":motherName", $motherName, PDO::PARAM_STR);
            $stmt->bindParam(":dateOfBirth", $dateOfBirth, PDO::PARAM_STR);
            $stmt->bindParam(":religion", $religion, PDO::PARAM_STR);
            $stmt->bindParam(":homeAddress", $homeAddress, PDO::PARAM_STR);
            $stmt->bindParam(":birthArea", $birthArea, PDO::PARAM_STR);
            $stmt->bindParam(":skills", $skills, PDO::PARAM_STR);
            $stmt->bindParam(":resumeDataShow", $resumeDetailsShow, PDO::PARAM_BOOL);
            $stmt->bindParam(":userIndex", $userIndex, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: resume_profile.php");
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
} else if ($resumeData == false) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
        $fullName = $_POST['fullname'];
        $fatherName = $_POST['fathername'];
        $motherName = $_POST['mothername'];
        $dateOfBirth = $_POST['dateofbirth'];
        $religion = $_POST['religion'];
        $homeAddress = $_POST['homeaddress'];
        $birthArea = $_POST['birtharea'];
        $skills = $_POST['skilleduexp'];
        $resumeDetailsShow = isset($_POST['resumeDetailsShow']) ? 1 : 0;
        $userIndex = $userData['orgindex'];

        try {
            $sql = 'INSERT INTO resumes (fullname, fathername, mothername, dateofbirth, religion, homeaddress, birtharea, skilleduexp, visible, orgindex) VALUES (:fullName, :fatherName, :motherName, :dateOfBirth, :religion, :homeAddress, :birthArea, :skills, :resumeDataShow, :userIndex)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":fullName", $fullName, PDO::PARAM_STR);
            $stmt->bindParam(":fatherName", $fatherName, PDO::PARAM_STR);
            $stmt->bindParam(":motherName", $motherName, PDO::PARAM_STR);
            $stmt->bindParam(":dateOfBirth", $dateOfBirth, PDO::PARAM_STR);
            $stmt->bindParam(":religion", $religion, PDO::PARAM_STR);
            $stmt->bindParam(":homeAddress", $homeAddress, PDO::PARAM_STR);
            $stmt->bindParam(":birthArea", $birthArea, PDO::PARAM_STR);
            $stmt->bindParam(":skills", $skills, PDO::PARAM_STR);
            $stmt->bindParam(":resumeDataShow", $resumeDetailsShow, PDO::PARAM_BOOL);
            $stmt->bindParam(":userIndex", $userIndex, PDO::PARAM_STR);
            if ($stmt->execute()) {
                header("Location: resume_profile.php");
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

if (isset($resumeData['rindex']) && !empty($resumeData['rindex'])) {
    $resumePfpPath = "uploads/resumes/" . $resumeData['rindex'] . '.png';
}



if (isset($_POST['update'])) {
    if (isset($_FILES['imgUpload']['name']) && !empty($_FILES['imgUpload']['name'])) {
        $target_dir = "uploads/resumes/";
        $imgName = $resumeData['rindex'] . ".png";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image. ";
            $uploadOk = 0;
        }


        if (file_exists($target_file)) {
            unlink($target_file);
        }

        if ($_FILES["imgUpload"]["size"] > 500000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (
            $imageFileType != "png"
        ) {
            echo "Sorry, only PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
            }
        }
    }
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/account_dashboard.css">
    <script src="js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        #logout-button:hover {
            color: #dc3545;
        }

        .small-textarea {
            height: 100px;
            resize: none;
        }

        .medium-textarea {
            height: 150px;
            resize: none;
        }
    </style>
    <title>Dashboard</title>
</head>

<body class="bg-light">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
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
            <div class="row" style="max-width: 1920px;">
                <div class="col-lg-2 d-md-none d-sm-none d-none d-lg-block p-3 bg-white">
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
                <div style="background-color: #eee; min-height: 1000px" class="col-lg-10 col-md-12 col-sm-12 col-12 p-5 border rounded ">
                    <div class="row">
                        <div class="col-12">
                            <div class="container px-0 ">
                                <div class="">
                                    <?php if (!isset($_GET['applied-jobs']) && !isset($_GET['invitations-received'])) { ?>
                                        <div class="mt-3">
                                            <a href="php/add_resume.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Resume</a>
                                        </div>
                                        <div class="row">
                                            <?php
                                            if (isset($resumeData) && !empty($resumeData)) {

                                                foreach ($resumeData as $row) {

                                                    if (empty($resumeData[0]['fullname'])) {
                                                        echo '';
                                                    } else {
                                                        $resume_img_src = "uploads/resumes/placeholder_pfp.svg";
                                                        if (file_exists("uploads/resumes/" . $row['rindex'] . ".png")) {
                                                            $resume_img_src = "uploads/resumes/" . $row['rindex'] . ".png";
                                                        }
                                            ?>
                                                        <div class="container">
                                                            <div class="col-12">
                                                                <a id="landing-page-mouse-hover-card" style="max-height: 400px;" href="resume.php?view&id=<?php echo $row['rindex'] ?>" class="text-start my-4 mx-0 card text-decoration-none">
                                                                    <div class="card-body">
                                                                        <div class="row text-lg-start text-md-start text-sm-center text-center">
                                                                            <div class="col-1 row">
                                                                                <div class="row">

                                                                                </div>
                                                                                <div class="row">
                                                                                    <?php if ($row['rdefault'] == 1) { ?>
                                                                                        <div class="d-flex justify-content-center align-items-center">
                                                                                            <i class="fa-solid fa-crown"></i>
                                                                                        </div>
                                                                                    <?php } else {
                                                                                        echo '';
                                                                                    } ?>
                                                                                </div>
                                                                                <div class="row">

                                                                                </div>

                                                                            </div>
                                                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                                                                <img style="height: 100px; width: 100px; object-fit: cover; object-position: 25% 25%" src="<?php echo $resume_img_src ?>" alt="">
                                                                            </div>
                                                                            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                                                <div class="row">
                                                                                    <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                        <b>Full Name</b>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                        <b><?php echo $row['fullname']; ?> </b>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                        <b>Date Of Birth</b>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                        <div>
                                                                                            <b><?php echo $row['dateofbirth']; ?> </b>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                        <b>Skills</b>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                        <?php if (strlen($row['skilleduexp']) > 100) {
                                                                                            $maxLength = 99;
                                                                                            $row['skilleduexp'] = substr($row['skilleduexp'], 0, $maxLength);
                                                                                        } ?>
                                                                                        <p class="mb-0"><?= $row['skilleduexp']; ?>...</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                            <?php }
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php } else if (isset($_GET['applied-jobs'])) { ?>
                                        <h3 class="text-center">Job Applications Sent/Received</h3>
                                        <div class="col-2">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                    <i class="fa-solid fa-filter"></i> Filter
                                                </button>
                                                <div class="dropdown-menu">
                                                    <h6 class="dropdown-header">Type</h6>
                                                    <div class="p-2">
                                                        <div class="<?php if (isset($_GET['sent'])) {
                                                                        echo 'active';
                                                                    } ?> dropdown-item">
                                                            <a class="text-decoration-none <?php if (isset($_GET['sent'])) {
                                                                                                echo 'text-light';
                                                                                            } else {
                                                                                                echo 'text-dark';
                                                                                            } ?> " href="?applied-jobs&<?php if (isset($_GET['filter'])) {
                                                                                                                            echo "&filter=" . $_GET['filter'];
                                                                                                                        } ?>&sent">Sent</a>
                                                        </div>
                                                        <div class="<?php if (isset($_GET['received'])) {
                                                                        echo 'active';
                                                                    } ?> dropdown-item">
                                                            <a class="text-decoration-none <?php if (isset($_GET['received'])) {
                                                                                                echo 'text-light';
                                                                                            } else {
                                                                                                echo 'text-dark';
                                                                                            } ?>" href="?applied-jobs&<?php if (isset($_GET['filter'])) {
                                                                                                                            echo "&filter=" . $_GET['filter'];
                                                                                                                        } ?>&received">Received</a>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-divider"></div>
                                                    <div class="p-2">
                                                        <div class="<?php if ($_GET['filter'] == 4) {
                                                                        echo 'active';
                                                                    } ?> dropdown-item">
                                                            <a class="text-decoration-none <?php if ($_GET['filter'] == 4) {
                                                                                                echo 'text-light';
                                                                                            } ?> text-success" href="?applied-jobs&filter=4<?php if (isset($_GET['sent'])) {
                                                                                                                                                echo "&sent";
                                                                                                                                            } else if (isset($_GET['received'])) {
                                                                                                                                                echo "&received";
                                                                                                                                            } ?>">Accepted</a>
                                                        </div>
                                                        <div class="<?php if ($_GET['filter'] == 5) {
                                                                        echo 'active';
                                                                    } ?> dropdown-item">
                                                            <a class="text-decoration-none <?php if ($_GET['filter'] == 5) {
                                                                                                echo 'text-light';
                                                                                            } ?> text-danger" href="?applied-jobs&filter=5<?php if (isset($_GET['sent'])) {
                                                                                                                                                echo "&sent";
                                                                                                                                            } else if (isset($_GET['received'])) {
                                                                                                                                                echo "&received";
                                                                                                                                            } ?>">Rejected</a>
                                                        </div>
                                                        <div class="<?php if ($_GET['filter'] == 1) {
                                                                        echo 'active';
                                                                    } ?> dropdown-item">
                                                            <a class="text-decoration-none <?php if ($_GET['filter'] == 1) {
                                                                                                echo 'text-light';
                                                                                            } ?> text-warning" href="?applied-jobs&filter=1<?php if (isset($_GET['sent'])) {
                                                                                                                                                echo "&sent";
                                                                                                                                            } else if (isset($_GET['received'])) {
                                                                                                                                                echo "&received";
                                                                                                                                            } ?>">Pending</a>
                                                        </div>
                                                    </div>


                                                    <div class="dropdown-divider"></div>
                                                    <div class="p-2">
                                                        <div class="dropdown-item">
                                                            <a href="?applied-jobs" class="text-decoration-none">Reset All Filters</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (!empty($appliedJobs)) {
                                            if (!isset($_GET['sent']) && !isset($_GET['received'])) {
                                                foreach ($appliedJobs as $row) {
                                                    $job_img_src = "uploads/job/placeholder-company.png";
                                                    if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                                        $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                                    } ?>
                                                    <div id="landing-page-mouse-hover-card" style="max-height: 400px;" onclick="location.href='job.php?view&id=<?php echo $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                        <div class="card-body">
                                                            <div class="row text-lg-start text-md-start text-sm-center text-center">
                                                                <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                                                    <img style="height: 100px; width: 100px; object-fit: cover; object-position: 25% 25%" src="<?php echo $job_img_src ?>" alt="">
                                                                </div>
                                                                <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                            <b>Job Title</b>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                            <b><?php echo $row['jobtitle']; ?> </b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                            <b>Category</b>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                            <div>
                                                                                <b><?php echo $row['jcategory']; ?> </b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                            <b>Resume Name</b>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                            <b><?= $row['fullname'] ?></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div>
                                                                        <?php if ($row['resumeOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                            <strong>Type: Sent Application <br></strong>
                                                                            <strong>Status: <br></strong>
                                                                            <?php if ($row['appinvtype'] == 0) { ?>
                                                                                <strong class="text-warning">Pending</strong>
                                                                            <?php } else if ($row['appinvtype'] == 4) { ?>
                                                                                <strong class="text-success">Accepted!</strong>
                                                                            <?php } else if ($row['appinvtype'] == 5) { ?>
                                                                                <strong class="text-danger">Rejected</strong>
                                                                            <?php } ?>
                                                                        <?php } else if ($row['jobOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                            <strong>Type: Received Application <br></strong>
                                                                            <strong>Status: <br></strong>
                                                                            <?php if ($row['appinvtype'] == 0) { ?>
                                                                                <a class="btn btn-success" href="php/application.php?jobid=<?= $row['jindex'] ?>&acceptapp&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Accept</a>
                                                                                <a class="btn btn-danger" href="php/application.php?jobid=<?= $row['jindex'] ?>&rejectapp&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Reject</a>
                                                                            <?php } else if ($row['appinvtype'] == 4) { ?>
                                                                                <strong class="text-success">Accepted!</strong>
                                                                            <?php } else if ($row['appinvtype'] == 5) { ?>
                                                                                <strong class="text-danger">Rejected</strong>
                                                                            <?php } ?>
                                                                        <?php  } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if (isset($_GET['sent'])) { ?>
                                                <?php foreach ($appliedJobs as $row) {
                                                    $job_img_src = "uploads/job/placeholder-company.png";
                                                    if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                                        $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                                    } ?>
                                                    <?php if ($row['resumeOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                        <div id="landing-page-mouse-hover-card" style="max-height: 400px;" onclick="location.href='job.php?view&id=<?php echo $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                            <div class="card-body">
                                                                <div class="row text-lg-start text-md-start text-sm-center text-center">
                                                                    <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                                                        <img style="height: 100px; width: 100px; object-fit: cover; object-position: 25% 25%" src="<?php echo $job_img_src ?>" alt="">
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                <b>Job Title</b>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <b><?php echo $row['jobtitle']; ?> </b>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                <b>Category</b>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <div>
                                                                                    <b><?php echo $row['jcategory']; ?> </b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                <b>Resume Name</b>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <b><?= $row['fullname'] ?></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div>
                                                                            <?php if ($row['resumeOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                                <strong>Type: Sent Application <br></strong>
                                                                                <strong>Status: <br></strong>
                                                                                <?php if ($row['appinvtype'] == 0) { ?>
                                                                                    <strong class="text-warning">Pending</strong>
                                                                                <?php } else if ($row['appinvtype'] == 4) { ?>
                                                                                    <strong class="text-success">Accepted!</strong>
                                                                                <?php } else if ($row['appinvtype'] == 5) { ?>
                                                                                    <strong class="text-danger">Rejected</strong>
                                                                                <?php } ?>
                                                                            <?php  } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php  }  ?>
                                            <?php } else if (isset($_GET['received'])) { ?>
                                                <?php foreach ($appliedJobs as $row) {
                                                    $job_img_src = "uploads/job/placeholder-company.png";
                                                    if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                                        $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                                    } ?>
                                                    <?php if ($row['jobOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                        <div id="landing-page-mouse-hover-card" style="max-height: 400px;" onclick="location.href='job.php?view&id=<?php echo $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
                                                            <div class="card-body">
                                                                <div class="row text-lg-start text-md-start text-sm-center text-center">
                                                                    <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                                                        <img style="height: 100px; width: 100px; object-fit: cover; object-position: 25% 25%" src="<?php echo $job_img_src ?>" alt="">
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                <b>Job Title</b>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <b><?php echo $row['jobtitle']; ?> </b>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                <b>Category</b>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <div>
                                                                                    <b><?php echo $row['jcategory']; ?> </b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 d-md-block d-lg-block d-sm-none d-none">
                                                                                <b>Resume Name</b>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <b><?= $row['fullname'] ?></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div>
                                                                            <?php if ($row['jobOrgIndex'] === $_SESSION['orgIndex']) { ?>
                                                                                <strong>Type: Received Application <br></strong>
                                                                                <strong>Status: <br></strong>
                                                                                <?php if ($row['appinvtype'] == 0) { ?>
                                                                                    <a class="btn btn-success" href="php/application.php?jobid=<?= $row['jindex'] ?>&acceptapp&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Accept</a>
                                                                                    <a class="btn btn-danger" href="php/application.php?jobid=<?= $row['jindex'] ?>&rejectapp&rindex=<?= $row['rindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Reject</a>
                                                                                <?php } else if ($row['appinvtype'] == 4) { ?>
                                                                                    <strong class="text-success">Accepted!</strong>
                                                                                <?php } else if ($row['appinvtype'] == 5) { ?>
                                                                                    <strong class="text-danger">Rejected</strong>
                                                                                <?php } ?>
                                                                            <?php  } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php  }  ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <b>None found</b>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="footer" class="bg-dark text-light">
        <div class="container">
            <footer class="row py-5">
                <div class="col-6">
                    <img src="img/logoipsum-248.svg" alt="">
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        document.getElementById('goBackButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>