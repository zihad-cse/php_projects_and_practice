<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'php/user_data.php';
include 'php/auth.php';
include 'php/db_connection.php';

session_start();

include 'php/pagination.php';
include 'php/resume_search_query.php';

if (isset($_SESSION['phnNumber'])) {
    $phnNumber = $_SESSION['phnNumber'];
    $userData = getUserData($pdo, $phnNumber);
}



if ($resumeNumber <= 10) {
    $pag_invis = true;
} else {
    $pag_invis = false;
}
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

        .nav-bar-shadow {
            box-shadow: 1px 1px 8px #999;
        }
    </style>
    <title>All Resumes</title>
</head>

<body class="bg-light">
    <nav id="primary-nav" class="navbar nav-bar-shadow p-3 bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo.png" alt="">
            </a>
            <div class="d-lg-block d-md-block d-sm-none d-none">
                <div>
                    <?php
                    $queryPath = 'resumes.php'
                    ?>
                    <form id="nav_search" action="<?= $queryPath; ?>" method="get">
                        <div class="input-group mb-3">
                            <input value="<?php if (isset($search)) {
                                                echo $search;
                                            } ?>" name="search" id="search-field" type="search" class="form-control border-dark" placeholder="Search Resumes" aria-label="Recipient's username" aria-describedby="search-button">
                            <input id="clear-button" class="btn btn-outline-dark" value="&times;" type="button">
                            <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <?php if (!isset($_SESSION['token']) && !isset($_SESSION['phnNumber'])) { ?>
                <div>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle login-signup-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <?php } ?>
        </div>
        <div class="d-block d-lg-none d-md-none d-sm-block">
            <div class="container d-flex justify-content-center">
                <?php
                $queryPath = 'resumes.php'
                ?>
                <form action="<?= $queryPath; ?>" method="get">
                    <div class="input-group mb-3">
                        <input value="<?php if (isset($search)) {
                                            echo $search;
                                        } ?>" name="search" id="search-field" type="search" class="form-control border-dark" placeholder="Search Resumes" aria-label="Job Listing Search Bar" aria-describedby="search-button">
                        <button name="search-submit" value="Search" class="btn btn-outline-dark" type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <button type="button" class="d-lg-block d-md-none d-sm-none d-none btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div class="bg-light">
            <div class="row">
                <div class="col-12 p-lg-5 p-md-4 p-sm-2 p-2" style="min-height: 1000px; background-color: #ddd;">
                    <div class="">
                        <div class="container">
                            <div class="mt-4">
                                <div class="d-flex justify-content-between">

                                    <div class="mb-3">
                                        <button id="goBackButton" class=" btn btn-danger"><i class="fa-solid fa-arrow-left-long"></i></button>
                                    </div>

                                    <div class="d-lg-block d-md-block d-sm-none d-none">
                                        <h2 class="text-center mb-5">Available Resumes</h2>
                                    </div>
                                    <div class="d-lg-none d-md-none d-sm-block d-block">
                                        <h2 class="text-center mb-5">Resumes</h2>
                                    </div>
                                    <!-- <div class="text-end dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                            <i class="fa-solid fa-filter"></i> Filter
                                        </button>
                                        <form action="" class="" method="get">
                                            <div class="dropdown-menu">
                                                <div class="dropdown-divider"></div>
                                                <button type="submit" class="dropdown-item btn">Apply</button>
                                            </div>
                                        </form>
                                    </div> -->
                                    <div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="container px-0 ">
                                            <div class="">

                                                <div class="row">
                                                    <?php foreach ($allresumedetails as $row) {
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
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
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
                                                    <select onchange="this.form.submit()" class="form-select bg-primary text-light" name="resumes-pagination-limit" id="">
                                                        <option <?= ($_SESSION["resumes-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10</option>
                                                        <option <?= ($_SESSION["resumes-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20</option>
                                                        <option <?= ($_SESSION["resumes-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50</option>
                                                    </select>
                                                </form>
                                                <?php if ($resume_current_page > 1) {
                                                    $resumePrevPage = $resume_current_page - 1;
                                                ?>
                                                    <li class="page-item"><a class="page-link" href="?resumepage=<?php echo $resumePrevPage; ?><?php if (isset($_GET['search'])) { ?>&search=<?= $_GET['search'];
                                                                                                                                                                                            } ?>">Previous</a></li>
                                                <?php } else { ?>
                                                    <li class="page-item disabled"><a class="page-link" href="">Previous</a></li>
                                                <?php } ?>
                                                <?php foreach (range($resumePagination_rangeFirstNumber, $resumePagination_rangeLastNumber) as $resume_page_number) { ?>
                                                    <li class="page-item <?= ($resume_current_page == $resume_page_number ? "active" : "");  ?>">
                                                        <a class="page-link" href="?resumepage=<?php echo $resume_page_number ?><?php if (isset($_GET['search'])) { ?>&search=<?= $_GET['search'];
                                                                                                                                                                            } ?>"><?php echo $resume_page_number ?></a>
                                                    </li>
                                                <?php } ?>

                                                <?php if ($resume_current_page < $resume_total_pages) {
                                                    $resumeNextPage = $resume_current_page + 1;
                                                ?>
                                                    <li class="page-item"><a class="page-link" href="?resumepage=<?php echo $resumeNextPage ?><?php if (isset($_GET['search'])) { ?>&search=<?= $_GET['search'];
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
    <script>
        document.getElementById("pageSelect").addEventListener('change', function() {
            var selectedPage = this.value;
            window.location.href = '?jobpage=' + selectedPage;
        })

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
    <script>
        document.getElementById('goBackButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>