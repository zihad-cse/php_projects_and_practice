<!DOCTYPE html>
<html lang="en">
<?php
include "../php/user_data.php";
include "../php/db_connection.php";

session_start();

include "../php/pagination.php"


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/landing_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Document</title>
</head>

<body class="bg-light">
    <nav class="p-3 navbar bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="landing_page.php">
                <img src="../img/logoipsum-248.svg" alt="">
            </a>
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
        </div>
    </nav>
    <section style="height: max-content;" id="header">
        <div style="background-image: url('../img/vagaro-g6i6NlucLYc-unsplash.jpg'); background-size: cover; background-position: top;" class="row">
            <div style="background-color: rgba(0, 0, 0, 0.5);" class="col-12">
                <div class="container">
                    <div style="background-color: rgba(0, 0, 0, 0.7);" class="border border-0 rounded m-4 p-4">
                        <div class="row">
                            <div class="col-5">
                                <img src="../img/undraw_stars_re_6je7.svg" alt="">
                            </div>
                            <div class="col-7 d-flex justify-content-center align-items-center text-light">
                                <div class="p-5">
                                    <div class="row">
                                        <div class="col-12 my-3">
                                            <h3>Find your Next Job Now</h3>
                                            <b>Search among <?php echo $allJobsNumber ?> job listings and </b> </br> <b> <?php echo $allResumesNumber; ?> Potential employees!</b>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                                <span class="input-group-text border-0" id="search-addon">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="my-5 bg-light" id="jobs-and-resumes">
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-5">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-center mb-5">Available Jobs</h2>
                        </div>
                        <div  class="card-body">
                            <?php foreach ($landingpage_allJobDetails as $row) { ?>
                                <div class="container">
                                    <div style="height: 300px; overflow-y: auto;" class="m-4 card">
                                        <div class="card-body">
                                            <div class="row ">
                                                <div class="col-3">

                                                </div>
                                                <div class="col-8">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <b>Title</b>
                                                        </div>
                                                        <div class="col-6">
                                                            <p><?php echo $row['jobtitle']; ?> </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <b>Category</b>
                                                        </div>
                                                        <div class="col-6">
                                                            <?php $jobcategory =  getJobCategory($pdo, $row['jobcategory']) ?>
                                                            <p><?php echo $jobcategory['jcategory']; ?> </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <b>Salary</b>
                                                        </div>
                                                        <div class="col-6">
                                                            <p><?php echo $row['salary']; ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12">
                                                    <a class="btn btn-primary" href="job.php?view&id=<?php echo $row['jindex'] ?>">View</a>
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
            <div class="col-1">
            </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>