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

//Updates company details (table: org)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
    $companyCategory = $_POST['companyCategory'];
    $companyDetails = $_POST['companyDetails'];
    $companyDetailsShow = isset($_POST['companyDetailsShow']) ? 1 : 0;
    $phnNumber = $_SESSION['phnNumber'];

    try {
        $sql = "UPDATE org SET ocatindex = :orgCat, orgnote = :orgNote, displayunote = :displayuNote WHERE prphone = :phnSession";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":orgCat", $companyCategory, PDO::PARAM_STR);
        $stmt->bindParam(":orgNote", $companyDetails, PDO::PARAM_STR);
        $stmt->bindParam(":displayuNote", $companyDetailsShow, PDO::PARAM_BOOL);
        $stmt->bindParam(":phnSession", $phnNumber, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->execute()) {
            header("Location: dashboard.php");
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if (isset($_POST['upload-image'])) {
    if (isset($_FILES['imgUpload']['name']) && !empty($_FILES['imgUpload']['name'])) {
        // echo "Start";
        $target_dir = "uploads/org/";
        $imgName = $userData['orgindex'] . ".png";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //Check if file is image
        if (isset($_POST["upload-image"])) {
            // echo '<pre>';
            // var_dump($_FILES["imgUpload"]);
            $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
            if ($check !== false) {
                // echo "File is an Image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image. ";
                // var_dump($_POST['img-upload']);
                $uploadOk = 0;
            }
        }

        // Same File existance check
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        // File size check
        if ($_FILES["imgUpload"]["size"] > 700000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        //Allowing only a few formats
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
                // echo "Image Uploaded";
            }
        }
    }
}

$orgPfpPath = "uploads/org/" . $userData['orgindex'] . '.png';


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
                <div class="col-lg-2 d-lg-block d-md-none d-sm-none d-none p-3 bg-white">
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

                        <div class="mb-4">
                            <ul class="nav nav-tabs" id="dashboard-tabs">
                                <li class="nav-item">
                                    <div class="mb-3">
                                        <button id="goBackButton" class="nav-link"><i class="fa-solid fa-arrow-left-long"></i></button>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="dashboard.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="org_profile.php">Org Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="resume_profile.php">Resumes</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div>
                                    <hr>
                                    <h4 class="mb-4">Company Profile</h4>
                                    <hr>

                                    <?php if (isset($userData['orgnote']) && isset($userData['ocatindex'])) { ?>
                                        <?php $orgPfpPath = "uploads/org/" . $userData['orgindex'] . '.png' ?>
                                        <?php if (file_exists($orgPfpPath)) { ?>
                                            <div class="row pb-1">
                                                <div class="col-2">
                                                    <img class="img-fluid" style="max-height:100px; max-width:100px;" src="<?php echo $orgPfpPath; ?>" alt="">
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row pb-1">
                                                <div class="col-2">
                                                    <img class="img-fluid" style="max-height:100px; max-width:100px;" src="uploads/job/placeholder-company.png" alt="">
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row pb-1">
                                            <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                <b>Company Category</b>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <p><?php echo $userData['ocategory']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row pb-1">
                                            <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                <b>Company Details</b>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                <p><?php echo $userData['orgnote'] ?? "N/A"; ?></p>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <a href="?edit" class="btn btn-primary">Set up</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['edit'])) { ?>
                        <div>
                            <div class="row">
                                <div>
                                    <?php if (file_exists($orgPfpPath)) { ?>
                                        <div class="row pb-1">
                                            <div class="col-lg-2 col-md-12 col-sm-12 col-12">
                                                <img class="img-fluid" style="max-height:100px; max-width:100px;" src="<?php echo $orgPfpPath; ?>" alt="">
                                            </div>
                                            <div class="py-lg-0 py-md-2 py-sm-2 py-2 col-lg-5 col-md-12 col-sm-12 col-12">
                                                <form method="post" action="" enctype="multipart/form-data">
                                                    <div class="row py-3">
                                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                            <b>Upload An Image</b>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                            <div>
                                                                <input name="imgUpload" class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                                            <input name="upload-image" type="submit" class="btn btn-primary" value="Upload">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row pb-1">
                                            <div class="col-lg-2 col-md-12 col-sm-12 col-12">
                                                <img class="img-fluid" style="max-height:100px; max-width:100px;" src="uploads/resumes/placeholder_pfp.svg" alt="">
                                            </div>
                                            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                                                <form method="post" action="" enctype="multipart/form-data">
                                                    <div class="row py-3">
                                                        <div class="py-lg-0 py-md-2 py-sm-2 py-2 col-lg-3 col-md-12 col-sm-12 col-12">
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
                                </div>
                            </div>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="py-lg-0 py-md-2 py-sm-2 py-2 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Company Category</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <select class="form-select" name="companyCategory" id="companyCategory">
                                            <option>Select a category</option>
                                            <?php foreach ($orgCatData as $orgCatData) {
                                                $selected = ($userData['ocatindex'] == $orgCatData['ocatindex']) ? "selected" : "";
                                                echo "<option value='" . $orgCatData["ocatindex"] . "' $selected>" . $orgCatData["ocategory"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="py-lg-0 py-md-2 py-sm-2 py-2 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Company Details</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <textarea class="rte mt-3 form-control" style="resize: none;" name="companyDetails" id="companyAddDetails" cols="30" rows="10"><?php echo $userData['orgnote'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="py-lg-0 py-md-2 py-sm-2 py-2 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <b>Display Company Details</b>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-check">
                                            <input <?= $userData['displayunote'] == 1 ? "checked" : "" ?> class="form-check-input" type="checkbox" value="1" name="companyDetailsShow" id="flexCheckDefault">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <input type="submit" name="update" class="btn btn-primary" value="Update">
                            </form>

                        </div>
                    <?php } else { ?>
                        <hr>
                        <?php if (!isset($userData['orgnote']) && !isset($userData['ocatindex'])) {
                            echo '';
                        } else {  ?>
                            <a href="?edit" class="btn btn-primary">Edit</a>
                    <?php }
                    } ?>
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
    <!-- <script>
        document.getElementById('goBackButton').addEventListener('click', function() {
            window.history.back();
        });
    </script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.rte').summernote();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>