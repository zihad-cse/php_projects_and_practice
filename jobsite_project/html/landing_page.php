<!DOCTYPE html>
<html lang="en">
<?php
include "../php/user_data.php";
include "../php/db_connection.php";

$allJobsNumber = postedJobsNumber($pdo);
session_start();

$limit = 3;

if (!isset($_GET['page'])) {
    $page_number = 1;
} elseif (isset($_GET['page'])) {
    $page_number = $_GET['page'];
}


$initial_page = ($page_number - 1) * $limit;


$numberofjobs = pageination_alljobrows($pdo);


$total_pages = ceil($numberofjobs / $limit);


$allJobDetails = pageination_alljobdetails($pdo, $initial_page, $limit);


$alljobcategories = getJobCategories($pdo);





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
            <a class="navbar-brand" href="landing_page.html">
                Logo
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
    <section class="bg-dark" id="header">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-5">
                            <img src="../img/undraw_stars_re_6je7.svg" alt="">
                        </div>
                        <div class="col-7 d-flex justify-content-center align-items-center text-light">
                            <div class="row">
                                <div class="col-12 my-3">
                                    <h3>Find your Next Job Now</h3>
                                    <b>Search among <?php echo $allJobsNumber ?> job listings</b>
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
    </section>
    <section class="bg-light" id="">
        <div>
            <?php foreach ($allJobDetails as $row) { ?>
                <div class="row">
                    <div class="col-4">
                        <p><?php echo $row['jobtitle']; ?> </p>
                    </div>
                    <div class="col-4">
                        <?php $jobcategory =  getJobCategory($pdo, $row['jobcategory']) ?>
                        <p><?php echo $jobcategory['jcategory']; ?> </p>
                    </div>
                    <div class="col-4">
                        <p><?php echo $row['salary']; ?> </p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <?php foreach (range(1, $total_pages) as $page_number) { ?>
                    <li class="page-item"><a class="page-link" href="?page= <?php echo $page_number ?>"><?php echo $page_number ?></a></li>
                <?php } ?>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>