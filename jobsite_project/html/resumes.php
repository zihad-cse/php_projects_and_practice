<!DOCTYPE html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../php/user_data.php';
include '../php/auth.php';
include '../php/db_connection.php';

session_start();

include '../php/pagination.php';

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
    <title>Posted Circular
    </title>
</head>

<body class="bg-light">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="landing_page.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
            <div>
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
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
                        <li><a class="dropdown-item" href="../php/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
            </dv>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row">
                <div class="col-2 bg-white">
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Dashboard
                            </button>
                            <div class="collapse" id="dashboard-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="#" class="btn btn-secondary-outline">Overview</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Weekly</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Monthly</a></li>
                                    <li><a href="#" class="btn btn-secondary-outline">Annually</a></li>
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
                                    <li><a href="posted_jobs.php" class="btn btn-secondary-outline">Posted</a></li>

                                </ul>
                            </div>
                        </li>
                        <li class="border-top my-3"></li>
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down pe-2"></i>Account
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-3 small">
                                    <li><a href="dashboard.php" class="btn btn-secondary-outline">Overview</a></li>
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
                <div class="col-10 p-5" style="min-height: 1000px; background-color: #ddd;">
                    <div class="col-5">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="text-center mb-5">Available Jobs</h2>
                                </div>
                                <div style="height: 800px; overflow-y: auto;" class="card-body">
                                    <?php foreach ($allresumedetails as $row) { ?>
                                        <div class="container">
                                            <div style="height: 300px; overflow-y: auto;" class="card m-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">

                                                        </div>
                                                        <div class="col-8">
                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <b>Full Name</b>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p><?php echo $row['fullname']; ?> </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <b>Date of Birth</b>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p><?php echo $row['dateofbirth']; ?> </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <b>Skills</b>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p><?php echo $row['skilleduexp']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="#"><button class="btn btn-primary">View</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="card-footer">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mt-3 justify-content-center">
                                            <form method="post">
                                                <select onchange="this.form.submit()" class="btn btn-primary" name="resume-pagination-limit" id="">
                                                    <option <?= ($_SESSION["resumes-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10</option>
                                                    <option <?= ($_SESSION["resumes-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20</option>
                                                    <option <?= ($_SESSION["resumes-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50</option>
                                                </select>
                                            </form>
                                            <!-- Determine Page Number -->

                                            <?php

                                            if ($resume_current_page > 1) {
                                                $resumePrevPage = $resume_current_page - 1;
                                            ?>
                                                <!-- Previous Page -->
                                                <li class="page-item"><a class="page-link" href="?jobpage=<?php echo $job_current_page; ?>&?resumepage<?php echo $resumePrevPage; ?>">Previous</a></li>
                                            <?php } else { ?>
                                                <li class="page-item disabled"><a class="page-link" href="">Previous</a></li>
                                            <?php } ?>
                                            <!-- All Pages -->
                                            <?php foreach (range($resumePagination_rangeFirstNumber, $resumePagination_rangeLastNumber) as $resume_page_number) { ?>
                                                <li class="page-item <?= ($resume_current_page == $resume_page_number ? "active" : "");  ?>">
                                                    <a class="page-link" href="?jobpage=<?php echo $job_current_page; ?>&?resumepage<?php echo $resume_page_number; ?>"><?php echo $resume_page_number ?></a>
                                                </li>
                                            <?php } ?>
                                            <!-- Next Page -->
                                            <?php if ($resume_current_page < $resume_total_pages) {
                                                $resumeNextPage = $resume_current_page + 1;
                                            ?>
                                                <li class="page-item"><a class="page-link" href="?jobpage=<?php echo $job_current_page; ?>&?resumepage<?php echo $resumeNextPage; ?>">Next</a></li>
                                            <?php } else { ?>
                                                <li class="page-item disabled"><a class="page-link" href="">Next</a></li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
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