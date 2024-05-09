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
//Formats Date of Birth for the edit form.
$orgCatData = getOrgCategories($pdo);
$dob = '';
if (isset($reumeData) == true) {
    $dob = $resumeData['dateofbirth'];
}
$formatteddob = date("Y-d-m", strtotime($dob));

//Updates company details (table: org)
if ($userData == true) {
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
} else if ($userData == false) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
        $companyCategory = $_POST['companyCategory'];
        $companyDetails = $_POST['companyDetails'];
        $companyDetailsShow = isset($_POST['companyDetailsShow']) ? 1 : 0;
        $phnNumber = $_SESSION['phnNumber'];

        try {
            $sql = "INSERT INTO org (ocatindex, orgnote, displayunote) VALUES (:orgCat, :orgNote, :displayuNote) WHERE prphone = :phnSession";
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
}

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
                header("Location: dashboard.php");
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
                header("Location: dashboard.php");
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

if (isset($_POST['upload-image'])) {
    if(isset($_FILES['imgUpload']['name']) && !empty($_FILES['imgUpload']['name'])){
        echo "Start";
        $target_dir = "../uploads/resumes/";
        $imgName = $resumeData['rindex'] . ".png";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        //Check if file is image
        if (isset($_POST["upload-image"])) {
            // echo '<pre>';
            var_dump($_FILES["imgUpload"]);
            $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an Image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image. ";
                var_dump($_POST['img-upload']);
                $uploadOk = 0;
            }
        }
    
        // Same File existance check
        if (file_exists($target_file)) {
            unlink($target_file);
        }
    
        // File size check
        if ($_FILES["imgUpload"]["size"] > 500000000) {
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
                echo "Image Uploaded";
            }
        }
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
    <title>Dashboard</title>
</head>

<body class="bg-light">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row" style="max-width: 1920px;">
                <div class="col-3 p-3 bg-white" style="width: 280px;">
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Dashboard
                            </button>
                            <div class="collapse" id="dashboard-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="#" class="btn btn-secondary-outline">###</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">###</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">###</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">###</a></li>
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
                                    <li><a href="?edit" class="btn btn-secondary-outline">Edit Profile</a></li>
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
                <div style="background-color: #eee; min-height: 1000px" class="col-9 p-5 border rounded ">
                    <?php if (!isset($_GET['edit'])) { ?>
                        <?php $resumePfpPath = "../uploads/resumes/" . $resumeData['rindex'] . '.png' ?>
                        <?php if (file_exists($resumePfpPath)) { ?>
                            <div class="row pb-1">
                                <div class="col-6">
                                    <img style="length: 100px; width: 100px;" src="<?php echo $resumePfpPath; ?>" alt="">
                                </div>
                                <div class="col-3">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="row py-3">
                                            <div class="col-3">
                                                <b>Upload An Image</b>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <input name="imgUpload" class="form-control" type="file">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <input name="upload-image" type="submit" class="btn btn-primary" value="Upload">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row pb-1">
                                <div class="col-2">
                                    <img style="height: 100px; width: 100px;" src="../uploads/resumes/placeholder_pfp.svg" alt="">
                                </div>
                                <div class="col-5">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="row py-3">

                                            <div class="col-6">
                                                <div>
                                                    <input name="imgUpload" class="form-control" type="file">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <input name="upload-image" type="submit" class="btn btn-primary" value="Upload">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="mb-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Org Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Resume</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <hr>
                                    <h3>Profile</h3>
                                    <hr>
                                    <div class="row pb-1">
                                        <div class="col-3">
                                            <b>Username</b>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $userData['orguser']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-3">
                                            <b>Email</b>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $userData['premail']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row pb-1">
                                        <div class="col-3">
                                            <b>Phone Number</b>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $userData['prphone']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    <hr>
                                    <h4 class="mb-4">Company Profile</h5>
                                        <hr>
                                        <div class="row pb-1">
                                            <div class="col-3">
                                                <b>Company Category</b>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo $userData['ocategory']; ?></p>
                                            </div>
                                        </div>
                                        <?php if ($userData["displayunote"] == 1) { ?>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Company Details</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $userData['orgnote'] ?? "N/A"; ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                    <?php if (isset($resumeData['visible']) == true) {
                                        if ($resumeData['visible'] == 1) { ?>
                                            <hr>
                                            <h4 class="mb-4">Resume</h4>
                                            <hr>

                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Full Name</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['fullname'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Father's Name</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['fathername'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Mother's Name</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['mothername'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Date of Birth</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['dateofbirth'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Religion</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['religion'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Address</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['homeaddress'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Birth Area</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['birtharea'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row pb-1">
                                                <div class="col-3">
                                                    <b>Skills</b>
                                                </div>
                                                <div class="col-6">
                                                    <p><?php echo $resumeData['skilleduexp'] ?></p>
                                                </div>
                                            </div>
                                    <?php }
                                    } else {
                                        echo "<b>N/A</b>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['edit'])) { ?>
                        <div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-3">
                                        <b>Company Category</b>
                                    </div>
                                    <div class="col-6">
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
                                    <div class="col-3">
                                        <b>Company Details</b>
                                    </div>
                                    <div class="col-6">
                                        <textarea class="mt-3 form-control" style="resize: none;" name="companyDetails" id="companyAddDetails" cols="30" rows="10"><?php echo $userData['orgnote'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <b>Display Company Details</b>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input <?= $userData['displayunote'] == 1 ? "checked" : "" ?> class="form-check-input" type="checkbox" value="1" name="companyDetailsShow" id="flexCheckDefault">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Full Name</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="fullname" class="form-control" type="text" value="<?= isset($resumeData['fullname']) == 1 ?  $resumeData['fullname'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Father's Name</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="fathername" class="form-control" type="text" value="<?= isset($resumeData['fathername']) == 1 ?  $resumeData['fathername'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Mother's Name</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="mothername" class="form-control" type="text" value="<?= isset($resumeData['mothername']) == 1 ?  $resumeData['mothername'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Date of Birth</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="dateofbirth" class="form-control" type="date" value=<?= isset($resumeData['dateofbirth']) == 1 ?  $resumeData['dateofbirth'] : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Religion</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="religion" class="form-control" type="text" value="<?= isset($resumeData['religion']) == 1 ?  $resumeData['religion'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Address</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <textarea class="mt-3 small-textarea form-control" style="resize: none;" name="homeaddress" id="homeAddress" cols="30" rows="10"><?= isset($resumeData['homeaddress']) == 1 ?  $resumeData['homeaddress'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Birth Area</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="birtharea" class="form-control" type="text" value="<?= isset($resumeData['birtharea']) == 1 ?  $resumeData['birtharea'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-3">
                                        <b>Skills</b>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <input name="skilleduexp" class="form-control" type="text" value="<?= isset($resumeData['skilleduexp']) == 1 ?  $resumeData['skilleduexp'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <b>Display Resume Details</b>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input <?php if (isset($resumeData['visible'])) {
                                                        if ($resumeData['visible'] == 1) {
                                                            echo "selected";
                                                        } else {
                                                            echo '';
                                                        }
                                                    } ?> class="form-check-input" type="checkbox" value="1" name="resumeDetailsShow" id="flexCheckDefault">
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="update" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    <?php } else { ?>
                        <hr>
                        <a href="?edit" class="btn btn-primary">Edit</a>
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