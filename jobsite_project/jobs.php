<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';

session_start();

include 'php/job_search_query.php';
if (!empty($_GET['area-division']) == true) {
    exit;
}

$jobAllRows = $jobCategories = getJobCategories($pdo);

if ($jobNumber <= 10) {
    $pag_invis = true;
} else {
    $pag_invis = false;
}
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


        #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }

        #secondary-nav {
            top: 55px;
        }

        #primary-nav {
            top: 0px;
        }
    </style>
    <title>All Jobs</title>
</head>

<body class="bg-light">
    <nav id="primary-nav" class="navbar p-3 bg-light sticky-top">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="index.php">
                <img src="img/logoipsum-248.svg" alt="">
            </a>
            <div class="d-lg-block d-md-block d-sm-none d-none">
                <?php
                $queryPath = 'jobs.php'
                ?>
                <form action="<?= $queryPath; ?>" method="get">
                    <div class="input-group mb-3">
                        <input value="<?php if (isset($search)) {
                                            echo $search;
                                        } ?>" name="search" id="search-field" type="search" class="form-control border-dark" placeholder="Search Job Listings" aria-label="Job Listing Search Bar" aria-describedby="search-button">
                        <input id="clear-button" class="btn btn-outline-dark" value="&times;" type="button">
                        <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
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
        </div>
    </nav>
    <nav id="secondary-nav" class="d-block d-lg-none d-md-none d-sm-block navbar sticky-top p-3 bg-light">
        <div class="container d-flex justify-content-center">
            <?php
            $queryPath = 'jobs.php'
            ?>
            <form action="<?= $queryPath; ?>" method="get">
                <div class="input-group mb-3">
                    <input value="<?php if (isset($search)) {
                                        echo $search;
                                    } ?>" name="search" id="search-field" type="search" class="form-control border-dark" placeholder="Search Job Listings" aria-label="Job Listing Search Bar" aria-describedby="search-button">
                    <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div class="bg-light">
            <div class="row">
                <div class="col-12 p-lg-5 p-md-4 p-sm-2 p-2" style="min-height: 1000px; background-color: #ddd;">
                    <div class="">
                        <div class="container">

                            <div class="">
                                <div class="mb-5">
                                    <div class="text-center">
                                        <h2>Available Jobs</h2>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                            <i class="fa-solid fa-filter"></i> Filter
                                        </button>
                                        <form action="" class="" method="get">
                                            <div class="dropdown-menu">
                                                <h6 class="dropdown-header">Category</h6>
                                                <?php foreach ($jobCategories as $jobcat) {
                                                    $isChecked = "";
                                                    if (isset($_GET['cat']) && !empty($_GET['cat'])) {
                                                        if (isset($_GET['cat'][$jobcat['jcatindex']]) && !empty($_GET['cat'][$jobcat['jcatindex']])) {
                                                            $isChecked = "checked";
                                                        }
                                                    } ?>

                                                    <div class=" p-2">
                                                        <label class="" for="<?= $jobcat['jcategory'] ?>">
                                                            <input class="form-check-input" id="<?= $jobcat['jcategory'] ?>" name="cat[<?= $jobcat['jcatindex'] ?>]" value="<?= $jobcat['jcatindex'] ?>" <?= $isChecked ?> type="checkbox"> <?= $jobcat['jcategory'] ?>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                                <div class="dropdown-divider"></div>
                                                <h6 class="dropdown-header">Work Area</h6>
                                                <div class="p-2">
                                                    <label for="area-division">Division</label>
                                                    <input class="form-control" id="area-division" name="area" type="text">
                                                </div>
                                                <div class="dropdown-divider"></div>
                                                <button type="submit" class="dropdown-item btn">Apply</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="px-0 container">
                                            <div class="">
                                                <div class="row">

                                                    <?php if (!empty($landingpage_allJobDetails)) {
                                                        foreach ($landingpage_allJobDetails as $row) {
                                                            $job_img_src = "uploads/job/placeholder-company.png";
                                                            if (file_exists("uploads/job/" . $row['jindex'] . ".png")) {
                                                                $job_img_src = "uploads/job/" . $row['jindex'] . ".png";
                                                            }
                                                    ?>
                                                            <div class="container">
                                                                <div class="col-12 mx-0">
                                                                    <div id="landing-page-mouse-hover-card" style="max-height: 400px; min-height: 170px;" onclick="location.href='job.php?view&id=<?= $row['jindex'] ?>'" class="text-start my-4 mx-0 card text-decoration-none">
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
                                                        <?php }
                                                    } else { ?>

                                                        <div class="text-center">
                                                            <b>None Found</b>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($pag_invis == false) { ?>
                                    <div class="d-lg-block d-md-block d-sm-none d-none">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mt-3 justify-content-center">
                                                <form method="post">
                                                    <select onchange="this.form.submit()" class="form-select bg-primary text-light" name="jobs-pagination-limit" id="">
                                                        <option <?= ($_SESSION["jobs-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10</option>
                                                        <option <?= ($_SESSION["jobs-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20</option>
                                                        <option <?= ($_SESSION["jobs-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50</option>
                                                    </select>
                                                </form>
                                                <?php if ($job_current_page > 1) {
                                                    $jobPrevPage = $job_current_page - 1;
                                                ?>
                                                    <li class="page-item"><a class="page-link" href="?jobpage=<?php echo $jobPrevPage; ?><?= (isset($_GET['search']) ? "&search=" . $_GET['search'] : "") ?><?php if (isset($_GET['cat'])) {
                                                                                                                                                                                                                foreach ($_GET['cat'] as $cat) {
                                                                                                                                                                                                                    echo "&cat[" . $cat . "]=" . $cat;
                                                                                                                                                                                                                }
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                '';
                                                                                                                                                                                                            } ?><?php if (isset($_GET['area']) && !empty($_GET['area'])) {
                                                                                                                                                                                                                    echo "&area=" . $_GET['area'];
                                                                                                                                                                                                                } ?>">Previous</a></li>
                                                <?php } else { ?>
                                                    <li class="page-item disabled"><a class="page-link" href="">Previous</a></li>
                                                <?php } ?>
                                                <?php foreach (range($jobsPagination_rangeFirstNumber, $jobsPagination_rangeLastNumber) as $job_page_number) { ?>
                                                    <li class="page-item <?= ($job_current_page == $job_page_number ? "active" : "");  ?>">
                                                        <a class="page-link" href="?jobpage=<?php echo $job_page_number ?><?= (isset($_GET['search']) ? "&search=" . $_GET['search'] : "") ?><?php if (isset($_GET['cat'])) {
                                                                                                                                                                                                    foreach ($_GET['cat'] as $cat) {
                                                                                                                                                                                                        echo "&cat[" . $cat . "]=" . $cat;
                                                                                                                                                                                                    }
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    '';
                                                                                                                                                                                                } ?><?php if (isset($_GET['area']) && !empty($_GET['area'])) {
                                                                                                                                                                                                        echo "&area=" . $_GET['area'];
                                                                                                                                                                                                    } ?>"><?php echo $job_page_number ?></a>
                                                    </li>
                                                <?php } ?>

                                                <?php if ($job_current_page < $job_total_pages) {
                                                    $jobNextPage = $job_current_page + 1;
                                                ?>
                                                    <li class="page-item"><a class="page-link" href="?jobpage=<?php echo $jobNextPage ?><?= (isset($_GET['search']) ? "&search=" . $_GET['search'] : "") ?><?php if (isset($_GET['cat'])) {
                                                                                                                                                                                                                foreach ($_GET['cat'] as $cat) {
                                                                                                                                                                                                                    echo "&cat[" . $cat . "]=" . $cat;
                                                                                                                                                                                                                }
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                '';
                                                                                                                                                                                                            } ?><?php if (isset($_GET['area']) && !empty($_GET['area'])) {
                                                                                                                                                                                                                    echo "&area=" . $_GET['area'];
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
                                                    <div class="col-6">
                                                        <form method="post">
                                                            <select onchange="this.form.submit()" class="form-select bg-primary text-light" name="jobs-pagination-limit" id="">
                                                                <option <?= ($_SESSION["jobs-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10</option>
                                                                <option <?= ($_SESSION["jobs-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20</option>
                                                                <option <?= ($_SESSION["jobs-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group">
                                                            <label for="pageSelect" class="input-group-text">Page</label>
                                                            <select class="p-2 form-select" name="" id="pageSelect">
                                                                <?php foreach (range($jobsPagination_rangeFirstNumber, $jobsPagination_rangeLastNumber) as $job_page_number) { ?>
                                                                    <option <?php if (isset($_GET['jobpage'])) {
                                                                                if ($_GET['jobpage'] == $job_page_number) {
                                                                                    echo 'selected';
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                            } ?> value="<?= $job_page_number; ?>"><?= $job_page_number; ?></option>
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
                                } ?>
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
        document.getElementById("pageSelect").addEventListener('change', function() {
            var selectedPage = this.value;
            window.location.href = '?jobpage=' + selectedPage;
        })


        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
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
        // When the user clicks on the button, scroll to the top of the document
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>