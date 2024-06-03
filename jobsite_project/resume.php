<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';
include 'php/resume_search_query.php';


session_start();
if (isset($_GET['id'])) {
    $rindex = $_GET['id'];
} else {
    echo "Could Not Get Resume Data";
    exit;
}
$resumeData = getResumeDataGuest($pdo, $rindex);
if (isset($_POST['update']) && !empty($_POST['update'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $homeaddress = $_POST['homeaddress'];
        $birtharea = $_POST['birtharea'];
        $religion = $_POST['religion'];
        $skilleduexp = $_POST['skilleduexp'];
        $dateofbirth = $_POST['dateofbirth'];
        $visible = isset($_POST['visible']) ? 1 : 0;
        $orgindex = $_SESSION['orgIndex'];

        try {
            $sql = "UPDATE resumes SET fullname = :fullname, homeaddress = :homeaddress, birtharea = :birtharea, religion = :religion, skilleduexp = :skilleduexp, dateofbirth = :dateofbirth, visible = :visible WHERE orgindex = :orgindex";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':homeaddress', $homeaddress, PDO::PARAM_STR);
            $stmt->bindParam(':birtharea', $birtharea, PDO::PARAM_STR);
            $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
            $stmt->bindParam(':skilleduexp', $skilleduexp, PDO::PARAM_STR);
            $stmt->bindParam(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
            $stmt->bindParam(':visible', $visible, PDO::PARAM_INT);
            $stmt->bindParam(':orgindex', $orgindex, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->execute()) {
                header("location: ?view&id=" . $rindex);
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

if (isset($_POST['update'])) {
    if (isset($_FILES['imgUpload']['name']) && !empty($_FILES['imgUpload']['name'])) {
        $target_dir = "uploads/resumes/";
        $imgName = $resumeData['rindex'] . ".png";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        echo "YES";
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
    </style>
    <title><?= $resumeData['fullname'] ?></title>
</head>

<body class="bg-light">
    <nav class="navbar p-3 bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
            </a>
            <div class="d-lg-block d-md-block d-sm-none d-none">
                <?php
                $queryPath = 'resume_search_results.php'
                ?>
                <form action="<?= $queryPath; ?>" method="get">
                    <div class="input-group mb-3">
                        <input name="search" id="search-field" type="search" class="form-control border-dark" placeholder="Search Resumes" aria-label="Recipient's username" aria-describedby="search-button">
                        <input id="clear-button" class="btn btn-outline-dark" value="&times;" type="button">
                        <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            <div class="d-lg-none d-md-none d-sm-block d-block btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
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
            </dv>
    </nav>
    <section style="min-height: 100vh; " id="dashboard-main-content">
        <?php if (!isset($_GET['edit'])) { ?>
            <div class="bg-light px-lg-0 px-md-0 px-sm-0 px-0 p-lg-5 p-md-4 p-sm-3 p-3 container">
                <div class="row p-3">
                    <div class="mb-3">
                        <button id="goBackButton" class=" btn btn-danger"><i class="fa-solid fa-arrow-left-long"></i></button>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <h2 class="mb-4"><?= $resumeData['fullname'] ?></h2>
                            <b>Current Address: <br></b>
                            <p><?= $resumeData['homeaddress'] ?></p>
                            <b>Permanent Address: <br></b>
                            <p><?= $resumeData['birtharea'] ?></p>
                        </div>
                        <div class="row">
                            <b>Date of Birth: <br> </b>
                            <p><?= $resumeData['dateofbirth'] ?></p>
                            <b>Religion: <br></b>
                            <p><?= $resumeData['religion']; ?></p>
                        </div>
                    </div>
                    <div class=" col-lg-2 col-md-2 col-sm-12 col-12">
                        <?php $filePath = "uploads/resumes/" . $rindex . ".png";
                        if (file_exists($filePath)) { ?>
                            <button class="btn">
                                <img class="img-thumbnail img-normal" src="uploads/resumes/<?php echo $rindex ?>.png" alt="">
                            </button>
                        <?php } else { ?>
                            <img class="img-thumbnail img-normal" src="uploads/resumes/placeholder_pfp.svg" alt="">
                        <?php } ?>
                    </div>
                </div>
                <div class="row p-3">
                    <b class="col-12">Availability: <?php if ($resumeData['visible'] == 1) { ?>Active<?php } else { ?> Inactive <?php } ?></b>
                </div>
                <div class="row p-3">
                    <h4 class="text-decoration-underline">Skills/Experiences</h4>
                    <p><?= $resumeData['skilleduexp']; ?></p>
                </div>
                <div class="border border-top border-dark mb-5"></div>
                <?php if (!isset($_SESSION['orgIndex'])) {
                    $_SESSION['orgIndex'] = '';
                } ?>
                <?php if ($resumeData['orgindex'] == $_SESSION['orgIndex']) { ?>
                    <div class="text-end">
                        <a href="?view&id=<?= $resumeData['rindex']; ?>&edit" class="btn btn-primary">Edit</a>
                    </div>
                <?php } else { ?>
                    <div class="text-end">
                        <a href="#" class="btn btn-primary">Invite</a>

                    </div>
                <?php } ?>
            </div>
        <?php } else if (isset($_GET['edit'])) { ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="bg-light px-lg-0 px-md-0 px-sm-0 px-0 p-lg-5 p-md-4 p-sm-3 p-3 container">
                    <div class="row p-3">
                        <div class="col-8">
                            <div class="row">
                                <label for="fullname">Full Name</label>
                                <input name="fullname" class="form-control-lg mb-4" type="text" value="<?= isset($resumeData['fullname']) == 1 ?  $resumeData['fullname'] : ''; ?>">
                                <label for="homeaddress">Current Address</label>
                                <textarea class="form-control mt-3 small-textarea" style="resize: none;" name="homeaddress" id="homeaddress" cols="30" rows="10"><?= isset($resumeData['homeaddress']) == 1 ?  $resumeData['homeaddress'] : ''; ?></textarea>
                                <label for="birtharea">Permanent Address</label>
                                <textarea class="form-control mt-3 small-textarea" style="resize: none;" name="birtharea" id="birtharea" cols="30" rows="10"><?= isset($resumeData['birtharea']) == 1 ?  $resumeData['birtharea'] : ''; ?></textarea>
                            </div>
                            <div class="row">
                                <label for="dateofbirth">Date of Birth</label>
                                <input id="dateofbirth" name="dateofbirth" class="form-control" type="date" value=<?= isset($resumeData['dateofbirth']) == 1 ?  $resumeData['dateofbirth'] : ''; ?>>
                                <label for="religion">Religion</label>
                                <input id="religion" name="religion" class="form-control" type="text" value="<?= isset($resumeData['religion']) == 1 ?  $resumeData['religion'] : ''; ?>">
                            </div>
                        </div>
                        <div class=" col-lg-4 col-md-2 col-sm-12 col-12">
                            <?php if (isset($resumeData) && !empty($resumeData)) {
                                $resumePfpPath = "uploads/resumes/" . $resumeData['rindex'] . '.png';
                            } else {
                                $resumePfpPath = '';
                            }  ?>
                            <?php if (file_exists($resumePfpPath)) { ?>
                                <div class="row pb-1">
                                    <div class="col-12 row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <img style="height:100px; width:100px;" src="<?php echo $resumePfpPath; ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row pb-1">
                                    <div class="col-12 row">
                                        <div class="col-lg-2 col-md-12 col-sm-12 col-12">
                                            <img style="height: 100px; width: 100px;" src="uploads/resumes/placeholder_pfp.svg" alt="">
                                        </div>
                                        <div class="col-2">

                                        </div>
                                        <div class="d-flex align-items-center col-lg-8 col-md-6 col-sm-6 col-6">
                                            <div>
                                                <input name="imgUpload" class="form-control" type="file">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="row py-1">
                                                <div class="col-10 row">
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="p-3 form-check">
                        <input <?php if (isset($resumeData['visible'])) {
                                    if ($resumeData['visible'] == 1) {
                                        echo "checked";
                                    } else {
                                        echo '';
                                    }
                                } ?> class="form-check-input" type="checkbox" value="1" name="visible" id="visible">
                        <label class="form-check-label" for="visible">Availability</label>
                    </div>
                    <div class="row p-3">
                        <div>
                            <label for="skilleduexp">
                                <h4>Skills/Experiences</h4>
                            </label>
                            <textarea class="rte mt-3 medium-textarea" style="resize: none;" name="skilleduexp" id="skilleduexp" cols="30" rows="10"><?= isset($resumeData['skilleduexp']) == 1 ?  $resumeData['skilleduexp'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="border border-top border-dark"></div>
                        <div class="col-6">
                        </div>
                    </div>
                    <div class="text-end">
                        <input name="update" type="submit" value="Update" class="btn btn-primary">
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