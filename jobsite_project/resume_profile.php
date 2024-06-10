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

$appliedJobs = appliedJobs($pdo, $userData['orgindex']);


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
                                    <li><a href="dashboard.php" class="btn btn-secondary-outline">Home</a></li>
                                    <li><a href="org_profile.php" class="btn btn-secondary-outline">Org Profile</a></li>
                                    <li><a href="resume_profile.php" class="btn btn-secondary-outline">Resume List</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Jobs
                            </button>
                            <div class="collapse" id="orders-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="job.php?new-post" class="btn btn-secondary-outline">New</a></li>
                                    <li><a href="posted_jobs.php" class="btn btn-secondary-outline">Posted Jobs</a></li>
                                    <li><a href="?applied-jobs" class="btn btn-secondary-outline">Applied Jobs</a></li>
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
                                                <li><a class="dropdown-item" href="dashboard.php?edit">Edit Account Info</a></li>
                                                <li><a class="dropdown-item" href="org_profile.php?edit">Edit Org Profile</a></li>
                                                <li><a class="dropdown-item" href="resume_profile.php">Edit Resume Profile</a></li>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="container px-0 ">
                                <div class="">
                                    <?php if (!isset($_GET['applied-jobs'])) { ?>
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
                                        <h3 class="text-center">Applications</h3>
                                        <?php if (!empty($appliedJobs)) {
                                            foreach ($appliedJobs as $row) {
                                                $job_img_src = "uploads/job/placeholder-company.png";
                                                if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                                    $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                                } ?>
                                                <a id="landing-page-mouse-hover-card" style="max-height: 400px;" href="job.php?view&id=<?php echo $row['jindex'] ?>" class="text-start my-4 mx-0 card text-decoration-none">
                                                    <div class="card-body">
                                                        <div class="row text-lg-start text-md-start text-sm-center text-center">
                                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                                                <img style="height: 100px; width: 100px; object-fit: cover; object-position: 25% 25%" src="<?php echo $job_img_src ?>" alt="">
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
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
                                                        </div>
                                                    </div>
                                                </a>
                                    <?php }
                                        } else {echo "<b>None found</b>";}
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <?php if ($pag_invis == false) { ?>
                        <div class="d-lg-block d-md-block d-sm-none d-none">
                            <nav aria-label="Page navigation">
                                <ul class="pagination mt-3 justify-content-center">
                                    <form method="post">
                                        <select onchange="this.form.submit()" class="form-select bg-primary text-light" name="resumes-pagination-limit" id="">
                                            <option <?= ($_SESSION["resumes-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10</option>
                                            <option <?= ($_SESSION["resumes-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20</option>
                                            <option <?= ($_SESSION["resumes-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50</option>
                                        </select>
                                    </form>
                                    <?php if ($resume_current_page > 1) {
                                        $resumePrevPage = $resume_current_page - 1;
                                    ?>
                                        <li class="page-item"><a class="page-link" href="?resumepage=<?php echo $resumePrevPage; ?><?php if (isset($_GET['search']) && isset($_GET['search-submit'])) { ?>&search=<?= $_GET['search'] ?>&search-submit=<?= $_GET['search-submit'];
                                                                                                                                                                                                                                                    } ?>">Previous</a></li>
                                    <?php } else { ?>
                                        <li class="page-item disabled"><a class="page-link" href="">Previous</a></li>
                                    <?php } ?>
                                    <?php foreach (range($resumePagination_rangeFirstNumber, $resumePagination_rangeLastNumber) as $resume_page_number) { ?>
                                        <li class="page-item <?= ($resume_current_page == $resume_page_number ? "active" : "");  ?>">
                                            <a class="page-link" href="?resumepage=<?php echo $resume_page_number ?><?php if (isset($_GET['search']) && isset($_GET['search-submit'])) { ?>&search=<?= $_GET['search'] ?>&search-submit=<?= $_GET['search-submit'];
                                                                                                                                                                                                                                    } ?>"><?php echo $resume_page_number ?></a>
                                        </li>
                                    <?php } ?>

                                    <?php if ($resume_current_page < $resume_total_pages) {
                                        $resumeNextPage = $resume_current_page + 1;
                                    ?>
                                        <li class="page-item"><a class="page-link" href="?resumepage=<?php echo $resumeNextPage ?><?php if (isset($_GET['search']) && isset($_GET['search-submit'])) { ?>&search=<?= $_GET['search'];
                                                                                                                                                                                                                    ?>&search-submit=<?= $_GET['search-submit'];
                                                                                                                                                                                                                                    } ?>">Next</a></li>
                                    <?php } else { ?>
                                        <li class="page-item disabled"><a class="page-link" href="">Next</a></li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="my-3 d-lg-none d-md-none d-sm-block d-block">
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-6 ">
                                            <form method="post">
                                                <div class="col-6">
                                                    <select onchange="this.form.submit()" class="form-select bg-primary text-light" name="resumes-pagination-limit" id="pageLimit">
                                                        <option <?= ($_SESSION["resumes-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10 Per Page</option>
                                                        <option <?= ($_SESSION["resumes-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20 Per Page</option>
                                                        <option <?= ($_SESSION["resumes-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50 Per Page</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <label for="pageSelect" class="input-group-text">Page</label>
                                                <select class="p-2 form-select" name="" id="pageSelect">
                                                    <?php foreach (range($resumePagination_rangeFirstNumber, $resumePagination_rangeLastNumber) as $resume_page_number) { ?>
                                                        <option <?php if (isset($_GET['resumepage'])) {
                                                                    if ($_GET['resumepage'] == $resume_page_number) {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                } ?> value="<?= $resume_page_number; ?>"><?= $resume_page_number; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </div>
                    <?php } else if ($pag_invis == true) {
                                echo '';
                            } ?> -->
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