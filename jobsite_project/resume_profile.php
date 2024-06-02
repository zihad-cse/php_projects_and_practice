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
//Formats Date of Birth for the edit form.
$orgCatData = getOrgCategories($pdo);
$dob = '';
if (isset($reumeData) == true) {
    $dob = $resumeData['dateofbirth'];
}

$formatteddob = date("Y-d-m", strtotime($dob));


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
            $stmt->execute();

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
            $stmt->execute();

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

if (isset($_POST['upload-image'])) {
    if (isset($_FILES['imgUpload']['name']) && !empty($_FILES['imgUpload']['name'])) {
        $target_dir = "uploads/resumes/";
        $imgName = $resumeData['rindex'] . ".png";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (isset($_POST["upload-image"])) {
            $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image. ";
                $uploadOk = 0;
            }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            <div class="d-sm-block d-md-block d-lg-none d-block dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                    <li><a class="dropdown-item" href="posted_jobs.php">Jobs Posted</a></li>
                    <li><a class="dropdown-item" href="/php_basics/jobsite_project/php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                </ul>
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
                                <i class="fa-solid fa-chevron-down pe-2"></i>Dashboard
                            </button>
                            <div class="collapse" id="dashboard-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="#" class="btn btn-secondary-outline">Home</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Applications</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Invitation List</a></li>
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
                                    <li><a href="posted_jobs.php" class="btn btn-secondary-outline">Posted Jobs</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Account
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="dashboard.php" class="btn btn-secondary-outline">Overview</a></li>
                                    <li>
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Edit
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="?edit">Edit Account Info</a></li>
                                                <li><a class="dropdown-item" href="org_profile.php?edit">Edit Org Profile</a></li>
                                                <li><a class="dropdown-item" href="resume_profile.php?edit">Edit Resume Profile</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <form action="php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" method="post" class="btn btn-secondary-outline">
                                            <input class="btn p-0" type="submit" value="Log Out" id="#logout-button">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div style="background-color: #eee; min-height: 1000px" class="col-lg-10 col-md-12 col-sm-12 col-12 p-5 border rounded ">

                    <?php if (!isset($_GET['edit'])) { ?>

                        <ul class="nav nav-tabs" id="dashboard-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="org_profile.php">Org Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="resume_profile.php">Resume</a>
                            </li>

                        </ul>
                        <div class="row">

                            <hr>
                            <h4 class="mb-4">Resume</h4>
                            <hr>
                            <?php if (isset($resumeData['visible']) == true) {
                                if ($resumeData['visible'] == 1) { ?>
                                    <?php if (file_exists($resumePfpPath)) { ?>
                                        <div class="row pb-1">
                                            <div class="col-2">
                                                <img class="img-fluid" style="max-height: 100px; max-width: 100px;" src="<?php echo $resumePfpPath; ?>" alt="">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row pb-1">
                                            <div class="col-2">
                                                <img class="img-fluid" style="max-height: 100px; max-width: 100px;" src="uploads/resumes/placeholder_pfp.svg" alt="">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Full Name</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['fullname'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Father's Name</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['fathername'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Mother's Name</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['mothername'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Date of Birth</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['dateofbirth'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Religion</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['religion'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Address</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['homeaddress'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Birth Area</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['birtharea'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                            <b>Skills</b>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p><?php echo $resumeData['skilleduexp'] ?></p>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <hr class="mb-2">
                                <b>Not Available</b>
                                <hr class="my-2">
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['edit'])) {
                        if (isset($resumeData) && !empty($resumeData)) {
                            $resumePfpPath = "uploads/resumes/" . $resumeData['rindex'] . '.png';
                        } else {
                            $resumePfpPath = '';
                        } ?>

                        <div>
                            <?php if (file_exists($resumePfpPath)) { ?>
                                <div class="row pb-1">
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-12">
                                        <img style="height:100px; width:100px;" src="<?php echo $resumePfpPath; ?>" alt="">
                                    </div>
                                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                                        <form method="post" action="" enctype="multipart/form-data">
                                            <div class="row py-1">
                                                <div class="p-lg-0 pb-md-3 pb-sm-3 pb-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <b>Upload An Image</b>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div>
                                                        <input name="imgUpload" class="form-control" type="file">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                                    <input name="upload-image" type="submit" class="btn btn-primary" value="Upload">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row pb-1">
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-12">
                                        <img style="height: 100px; width: 100px;" src="uploads/resumes/placeholder_pfp.svg" alt="">
                                    </div>
                                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                                        <form method="post" action="" enctype="multipart/form-data">
                                            <div class="row py-1">
                                                <div class="p-lg-0 pb-md-3 pb-sm-3 pb-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <b>Upload An Image</b>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div>
                                                        <input name="imgUpload" class="form-control" type="file">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                                    <input name="upload-image" type="submit" class="btn btn-primary" value="Upload">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Full Name</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <input name="fullname" class="form-control" type="text" value="<?= isset($resumeData['fullname']) == 1 ?  $resumeData['fullname'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Father's Name</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <input name="fathername" class="form-control" type="text" value="<?= isset($resumeData['fathername']) == 1 ?  $resumeData['fathername'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Mother's Name</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <input name="mothername" class="form-control" type="text" value="<?= isset($resumeData['mothername']) == 1 ?  $resumeData['mothername'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Date of Birth</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <input name="dateofbirth" class="form-control" type="date" value=<?= isset($resumeData['dateofbirth']) == 1 ?  $resumeData['dateofbirth'] : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Religion</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <input name="religion" class="form-control" type="text" value="<?= isset($resumeData['religion']) == 1 ?  $resumeData['religion'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Address</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <textarea class="mt-3 small-textarea form-control" style="resize: none;" name="homeaddress" id="homeAddress" cols="30" rows="10"><?= isset($resumeData['homeaddress']) == 1 ?  $resumeData['homeaddress'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Birth Area</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <textarea class="small-textarea form-control" name="birtharea" id="birtharea"><?= isset($resumeData['birtharea']) == 1 ?  $resumeData['birtharea'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Skills</b>
                                    </div>
                                    <script>
                                        tinymce.init({
                                            selector: 'textarea.rte'
                                        });
                                    </script>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div>
                                            <textarea class="rte mt-3 medium-textarea form-control" style="resize: none;" name="skilleduexp" id="skilleduexp" cols="30" rows="10"><?= isset($resumeData['skilleduexp']) == 1 ?  $resumeData['skilleduexp'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Active</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-check">
                                            <input <?php if (isset($resumeData['visible'])) {
                                                        if ($resumeData['visible'] == 1) {
                                                            echo "checked";
                                                        } else {
                                                            echo '';
                                                        }
                                                    } ?> class="form-check-input" type="checkbox" value="1" name="resumeDetailsShow" id="flexCheckDefault">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <input type="submit" name="update" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    <?php } else { ?>
                        <div>
                            <a href="resume.php?view&id=<?= $resumeData['rindex']; ?>&edit" class="btn btn-primary">Edit</a>
                        </div>
                    <?php } ?>
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

</body>

</html>