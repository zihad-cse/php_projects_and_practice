<!DOCTYPE html>
<html lang="en">
<?php
include '../php/user_data.php';
include '../php/auth.php';
include '../php/db_connection.php';

session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login_page.php");
    exit();
}

if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $userData = getUserData($pdo, $phnNumber);
}



if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $resumeData = getResumeData($pdo, $phnNumber);
}

$dob = $resumeData['dateofbirth'];


$formatteddob = date("Y-d-m", strtotime($dob));


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
    $companyCategory = $_POST['companyCategory'];
    $companyDetails = $_POST['companyDetails'];
    $companyDetailsShow = $_POST['companyDetailsShow'];
    $phnNumber = $_SESSION['phnNumber'];
    try {
        $sql = "UPDATE org SET ocatindex = :orgCat, orgnote = :orgNote, displayunote = :displayuNote WHERE prphone = :phnSession";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":orgCat", $companyCategory, PDO::PARAM_STR);
        $stmt->bindParam(":orgNote", $companyDetails, PDO::PARAM_STR);
        $stmt->bindParam(":displayuNote", $companyDetailsShow, PDO::PARAM_BOOL);
        $stmt->bindParam(":phnSession", $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])) {
    $fullName = $_POST['fullname'];
    $fatherName = $_POST['fathername'];
    $motherName = $_POST['mothername'];
    $dateOfBirth = $_POST['dateofbirth'];
    $religion = $_POST['religion'];
    $homeAddress = $_POST['homeaddress'];
    $birthArea = $_POST['birtharea'];
    $skills = $_POST['skilleduexp'];
    $resumeDetailsShow = $_POST['resumeDetailsShow'];
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
    </style>
    <title>Dashboard</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas"><i class="fa-solid fa-bars"></i></button>

            <a class="navbar-brand" href="landing_page.html">Logo</a>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item btn" href="account_edit_page.php">Edit Profile</a></li>
                    <li><a class="dropdown-item btn" href="#">Settings</a></li>
                    <li>
                        <form action="../php/logout.php" method="post" class="dropdown-item">
                            <input class="btn p-0" type="submit" value="Log Out" id="#logout-button">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="card">
            <div class="offcanvas offcanvas-start" data-bs-scroll="false" data-bs-backdrop="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas with body scrolling</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <p>Try scrolling the rest of the page to see this option in action.</p>
                </div>
            </div>
            <div class="card-body container">
                <h3>Profile</h3>
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
                <?php if (!isset($_GET['edit'])) { ?>
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
                    <?php if ($resumeData['visible'] == 1) { ?>
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
                    <?php } ?>
                <?php } ?>
                <?php if (isset($_GET['edit'])) { ?>
                    <div>
                        <form action="dashboard.php" method="post">
                            <div class="row">
                                <div class="col-3">
                                    <b>Company Category</b>
                                </div>
                                <div class="col-6">
                                    <select class="form-select" name="companyCategory" id="companyCategory">
                                        <option >Select a category</option>
                                        <option <?= $userData['ocatindex'] == 1 ? "selected" : "" ?> value="1">NGO</option>
                                        <option <?= $userData['ocatindex'] == 2 ? "selected" : "" ?> value="2">Tech</option>
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
                                        <input name="fullname" class="form-control" type="text" value = <?php echo $resumeData['fullname']?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Father's Name</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <input name="fathername" class="form-control" type="text" value = <?php echo $resumeData['fathername']?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Mother's Name</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <input name="mothername" class="form-control" type="text" value = <?php echo $resumeData['mothername']?>> 
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Date of Birth</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <input name="dateofbirth" class="form-control" type="date" value=<?php echo $formatteddob?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Religion</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <input name="religion" class="form-control" type="text" value = <?php echo $resumeData['religion']?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Address</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <textarea class="mt-3 form-control" style="resize: none;" name="homeaddress" id="homeAddress" cols="30" rows="10"><?php echo $resumeData['homeaddress']?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Birth Area</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <input name="birtharea" class="form-control" type="text" value = <?php echo $resumeData['birtharea']?> >
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-3">
                                    <b>Skills</b>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <input name="skilleduexp" class="form-control" type="text" value = <?php echo $resumeData['skilleduexp']?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <b>Display Resume Details</b>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input <?= $resumeData['visible'] == 1 ? "checked" : "" ?> class="form-check-input" type="checkbox" value="1" name="resumeDetailsShow" id="flexCheckDefault">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="update" class="btn btn-primary" value="Update">
                        </form>
                    </div>
                <?php } else { ?>
                    <a href="?edit" class="btn btn-primary">Edit</a>
                <?php } ?>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>