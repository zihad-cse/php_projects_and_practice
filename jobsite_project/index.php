<!DOCTYPE html>
<html lang="en">
<?php
include "php/user_data.php";
include "php/db_connection.php";

session_start();

$isIndex = true;
include "php/pagination.php";


if (!isset($_SESSION['search-filter']) && empty($_SESSION['search-filter'])) {
    $_SESSION['search-filter'] = 'job';
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['search-filter']) && !empty($_POST['search-filter'])) {
        $_SESSION['search-filter'] = $_POST['search-filter'];
    }
}

if(isset($_SESSION['phnNumber']) && !empty($_SESSION['phnNumber'])){
    $orgData = getUserData($pdo, $_SESSION['phnNumber']);
    $_SESSION['orgIndex'] = $orgData['orgindex'];
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/landing_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Document</title>
    <style>
        #landing-page-mouse-hover-card {
            box-shadow: 1px 1px 8px #999;
        }


        #landing-page-mouse-hover-card:hover {
            border: var(--bs-card-border-width) solid black;
            box-shadow: 4px 4px 8px #999;
            cursor: pointer;
        }

        #footer {
            box-shadow: -1px -1px 8px #999;
        }

        #header {
            box-shadow: 1px 1px 8px #999;
        }

        #nav-bar {
            box-shadow: 1px 1px 8px #999;
        }

        #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }

        #clear-button {
            background-color: #fff;
            border-color: #fff;
        }

        #clear-button:hover {
            background-color: #fff;
            border-color: #fff;
        }
    </style>
</head>

<body class="bg-light">
    <nav id="nav-bar" class="p-3 navbar bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
            </a>
            <?php if (!isset($_SESSION['token']) && !isset($_SESSION['phnNumber'])) { ?>
                <div>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Log in or Sign up
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
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
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" href="posted_jobs.php">Jobs Posted</a></li>
                        <li><a class="dropdown-item" href="/php_basics/jobsite_project/php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>
    <section style="height: max-content;" id="header">
        <div style="background-image: url('img/vagaro-g6i6NlucLYc-unsplash.jpg'); background-size: cover; background-position: top;" class="row">
            <div style="background-color: rgba(0, 0, 0, 0.75);" class="col-1"></div>
            <div style="background-color: rgba(0, 0, 0, 0.5);" class="col-10">
                <div class="container">
                    <div style="background-color: rgba(0, 0, 0, 0.7);" class="border border-0 rounded my-4 p-4">
                        <div class="row">
                            <div class="col-lg-12 col-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center text-light">
                                <div class="p-md-3 p-sm-2 p-2 p-lg-5">
                                    <div class="row">

                                        <div class="col-lg-12 col-md-12 col-sm-0 col-0 d-lg-block d-md-block d-sm-none d-none my-3">
                                            <h3>Find your Next Job Now</h3>
                                            <b>Search among <?php echo $allJobsNumber ?> job listings and </b> </br> <b> <?php echo $allResumesNumber; ?> Potential employees!</b>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <?php
                                            $queryPath = 'jobs.php';
                                            if (isset($_SESSION['search-filter'])) {
                                                if ($_SESSION['search-filter'] == 'resume') {
                                                    $queryPath = 'resumes.php';
                                                } else if ($_SESSION['search-filter'] == 'job') {
                                                    $queryPath = 'jobs.php';
                                                }
                                            } ?>
                                            <form method="get" action="<?php echo $queryPath; ?>">
                                                <div class="input-group">
                                                    <input id="search-field" type="search" name="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                                    <input id="clear-button" class="btn btn-light" value="&times;" type="button">
                                                    <input onclick="if(document.getElementById('search-field').value.trim() === '') {event.preventDefault();}" type="submit" class="btn btn-outline-light" value="Search">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="pt-lg-2 pt-md-0 pt-sm-0 pt-0 col-12">
                                                <form method="post" id="search-filter" action="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="search-filter" <?php if (isset($_SESSION['search-filter'])) {
                                                                                                                                echo $_SESSION['search-filter'] == 'job' ? 'checked' : '';
                                                                                                                            } ?> id="search-filter-job" value="job">
                                                        <label class="form-check-label" for="search-filter-job">
                                                            Jobs
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="search-filter" <?php if (isset($_SESSION['search-filter'])) {
                                                                                                                                echo $_SESSION['search-filter'] == 'resume' ? 'checked' : '';
                                                                                                                            } ?> id="search-filter-resume" value="resume">
                                                        <label class="form-check-label" for="search-filter-resume">
                                                            Resumes
                                                        </label>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background-color: rgba(0, 0, 0, 0.75);" class="col-1"></div>
        </div>
    </section>
    <section class="my-5 bg-light" id="jobs-and-resumes">
        <button type="button" class="d-sm-none d-none d-md-block d-lg-block btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div class="container">
            <div class="row">
                <div class="mb-5 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="container">
                        <div class="">
                            <div class="">
                                <h2 class="text-center mb-5"><a class="text-decoration-none text-dark" href="jobs.php">Available Jobs</a></h2>
                            </div>
                            <div class="row">
                                <?php foreach ($landingpage_allJobDetails as $row) {
                                    $job_img_src = "uploads/job/placeholder-company.png";
                                    if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                        $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                    }
                                ?>
                                    <div class="container px-0">
                                        <div class="col-12">
                                            <div id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 190px;" onclick="location.href='job.php?view&id=<?= $row['jindex'] ?>'" class="text-start my-4 card text-decoration-none">
                                                <div class="card-body">
                                                    <div class="row text-sm-center text-md-center text-lg-start text-center">
                                                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                            <img class="img-fluid" style="max-height: 100px;" src="<?php echo $job_img_src ?>" alt="">
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <b class="m-0 p-2"><?php echo $row['jobtitle']; ?> </b>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="p-2">
                                                                        <?php if (strlen($row['dutyskilleduexp']) > 100) {
                                                                            $maxLength = 99;
                                                                            $row['dutyskilleduexp'] = substr($row['dutyskilleduexp'], 0, $maxLength);
                                                                        } ?>
                                                                        <p class="mb-0"><?= $row['dutyskilleduexp']; ?>...</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="m-0 p-2"><i class="fa-solid fa-dollar-sign"></i> <?php echo $row['salary']; ?> </p>
                                                                </div>
                                                            </div>
                                                            <div class=" row">
                                                                <div class="col-6">
                                                                    <span class="p-2"><i class="fa-solid fa-location-dot"></i> <?= $row['workarea'] ?></span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <b><i class="fa-solid fa-calendar-day"></i> <?= $row['enddate'] ?></b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-5 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="container">
                        <div class="">
                            <div class="">
                                <h2 class="text-center mb-5"><a class="text-decoration-none text-dark" href="resumes.php">Available Resumes</a></h2>
                            </div>
                            <div class="row">
                                <?php foreach ($allresumedetails as $row) {
                                    $resume_img_src = "uploads/resumes/placeholder_pfp.svg";
                                    if (file_exists("uploads/resumes/" . $row['rindex'] . ".png")) {
                                        $resume_img_src = "uploads/resumes/" . $row['rindex'] . ".png";
                                    }
                                ?>
                                    <div class="container px-0">
                                        <div class="col-12">
                                            <a href="resume.php?view&id=<?php echo $row['rindex'] ?>" id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 190px;" class="card text-decoration-none text-start my-4">
                                                <div class="card-body">
                                                    <div class="row text-center text-sm-center text-lg-start text-md-center">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                                            <img class="img-fluid" style="max-height: 100px;" src="<?php echo $resume_img_src; ?>" alt="">
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                                                            <div class="row py-2 py-sm-2 py-md-2 py-lg-1">
                                                                <div class="col-12">
                                                                    <b><?php echo $row['fullname']; ?> </b>
                                                                </div>
                                                            </div>
                                                            <div class="row py-2 py-sm-2 py-md-2 py-lg-1">
                                                                <div class="col-12">
                                                                    <b><i class="fa-solid fa-cake-candles"></i> <?php echo $row['dateofbirth']; ?> </b>
                                                                </div>
                                                            </div>
                                                            <div class="row py-2 py-sm-2 py-md-2 py-lg-1">
                                                            <?php if (strlen($row['skilleduexp']) > 100) {
                                                                            $maxLength = 99;
                                                                            $row['skilleduexp'] = substr($row['skilleduexp'], 0, $maxLength);
                                                                        } ?>
                                                                        <p class="mb-0"><?= $row['skilleduexp']; ?>...</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
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
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">Home</a></li>
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">Terms and Conditions</a></li>
                        <li class="ms-3"><a class="text-decoration-none text-light" href="#">FAQs</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <script>
        var form = document.getElementById('search-filter');
        var radioButtons = document.querySelectorAll('input[name="search-filter"]');

        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                form.submit();
            });
        });

        let mybutton = document.getElementById("btn-back-to-top");

        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>