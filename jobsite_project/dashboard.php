<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';
include 'php/oauthlogin.php';

session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login_page.php");
    exit();
}

//Fetches User Data (table: org)

if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $userData = getUserData($pdo, $phnNumber);
    $_SESSION['orgIndex'] = $userData['orgindex'];
}

//Fetches Resume Data (table: resumes)

if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $resumeData = getResumeData($pdo, $phnNumber);
}

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
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
    </style>
    <title>Dashboard</title>
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
            <div class="row" style="max-width: 1920px;">
                <div class="d-md-none d-sm-none d-none d-lg-block col-2 p-3 bg-white">
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
                    <?php if (!isset($_GET['edit'])) { ?>
                        <div class="mb-4">
                            <ul class="nav nav-tabs" id="dashboard-tabs">
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
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['edit'])) { ?>
                        <div class="my-2">
                            <b>Password and Account details change here.</b><br>
                        </div>
                        <div class="my-2">
                            <?php if(!isset($userData['oauthkey']) && empty($userData['oauthkey'])){ ?>
                                <strong>Connect your google account here: </strong> <a class="btn btn-primary" href="<?php echo $client->createAuthUrl();  ?>"><i class="fa-brands fa-google"></i></a>
                            <?php } if (isset($userData['oauthkey']) && !empty($userData['oauthkey'])){ ?>
                                <strong><i class="fa-brands fa-google"></i> : <?= $userData['oauthemail'] ?></strong>
                            <?php } ?>
                        </div>
                        <div>
                            <a href="dashboard.php" class="btn btn-primary">Back</a>
                        </div>

                    <?php } else { ?>
                        <hr>
                        <a href="?edit" class="btn btn-primary">Edit</a>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>