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

if (isset($_GET['id'])) {
    $jobId = $_GET['id'];
} else {
    echo 'Job Data Not Found';
    exit;
}

$jobData = getJob($pdo, $jobId);

$jobPicFilePath = "uploads/job/" . $jobData['jindex'] . '.png';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/account_dashboard.css">
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
    <title><?php echo $jobData['jobtitle'] ?></title>
</head>

<body class="bg-light">
    <nav class="navbar p-3 bg-light sticky-top">
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
                        <li><a class="dropdown-item" href="/dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" href="/posted_jobs.php">Jobs Posted</a></li>
                        <li><a class="dropdown-item" href="php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>
    <section style="min-height: 100vh;" class="" id="dashboard-main-content">
        <div class="bg-light p-lg-5 p-md-4 p-sm-3 p-3 container">
            <div class="row p-3">
                <div class="col-10">
                    <div class="row">
                        <h2>Org Name</h2>
                    </div>
                    <div class="row">
                        <h2 class="text-primary"><?php echo $jobData['jobtitle'] ?></h2>
                    </div>
                </div>
                <div class=" col-lg-2 col-md-2 col-sm-12 col-12">
                    <?php if (file_exists($jobPicFilePath)) { ?>
                        <img class="img-normal" src="<?php echo $jobPicFilePath ?>" alt="">
                    <?php } else { ?>
                        <img class="img-normal" src="uploads/job/placeholder-company.png" alt="">
                    <?php } ?>
                </div>
            </div>
            <div class="row p-3">
                <b class="col-12">Deadline: <?php echo $jobData['enddate'] ?></b>
            </div>
            <div>
                <h3>Responsibilities</h3>
                <p><?= $jobData['dutyskilleduexp'] ?></p>
            </div>
            <div class="row p-3">
                <div class="border border-top border-dark"></div>
            </div>
            <div class="row p-3">
                <h4>Salary: <?php echo $jobData['salary'] ?></h4>
            </div>
            <div class="row p-3">
                <div class="col-4">
                    <b>Contact Phone: <?php echo $jobData['conphone'] ?></b>
                </div>
                <div class="col-4">
                    <b>Contact Email: <?php echo $jobData['conemail'] ?></b>
                </div>
                <div class="col-4 text-end">
                    <a href="php/apply.php?id=<?= $jobData['jindex'] ?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="btn btn-primary">Apply</a>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>