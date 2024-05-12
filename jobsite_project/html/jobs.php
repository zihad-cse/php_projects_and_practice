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
        
        #landing-page-mouse-hover-card {
            box-shadow: 1px 1px 8px #999;
        }


        #landing-page-mouse-hover-card:hover {
            border: var(--bs-card-border-width) solid black;
            box-shadow: 4px 4px 8px #999;
        }
    </style>
    <title>Jobs</title>
</head>

<body class="bg-light">
    <nav class="navbar p-3 bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../">
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
                        <li><a class="dropdown-item" href="../php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']);?>">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
            </dv>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row">
                <div class="col-12 p-5" style="min-height: 1000px; background-color: #ddd;">
                    <div class="">
                        <div class="container">
                            <div class="">
                                <div class="">
                                    <h2 class="text-center mb-5">Available Jobs</h2>
                                </div>
                                <div class="row">
                                    <div class="col-1">
                                    </div>
                                    <div class="col-12">
                                        <div class="container">
                                            <div class="">

                                                <div class="row">
                                                    <?php foreach ($allJobDetails as $row) {
                                                        $job_img_src = "../uploads/job/placeholder-company.png";
                                                        if (file_exists("../uploads/job/" . $row['jindex'] . ".png")) {
                                                            $job_img_src = "../uploads/job/" . $row['jindex'] . ".png";
                                                        }
                                                    ?>
                                                        <div class="container">
                                                            <div class="col-12">
                                                                <a id="landing-page-mouse-hover-card" style="max-height: 150px;" href="../html/job.php?view&id=<?php echo $row['jindex'] ?>" class="text-start m-4 card text-decoration-none">
                                                                    <div class="card-body">
                                                                        <div class="row ">
                                                                            <div class="col-3">
                                                                                <img style="height:100px; width: 100px;" src="<?php echo $job_img_src ?>" alt="">
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
                                                                                        <p><?php echo $row['categoryName']; ?> </p>
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
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                    </div>
                                </div>
                                <div class="">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mt-3 justify-content-center">
                                            <form method="post">
                                                <select onchange="this.form.submit()" class="btn btn-primary" name="jobs-pagination-limit" id="">
                                                    <option <?= ($_SESSION["jobs-pagination-limit"] == 10 ? "selected" : "") ?> value="10">10</option>
                                                    <option <?= ($_SESSION["jobs-pagination-limit"] == 20 ? "selected" : "") ?> value="20">20</option>
                                                    <option <?= ($_SESSION["jobs-pagination-limit"] == 50 ? "selected" : "") ?> value="50">50</option>
                                                </select>
                                            </form>
                                            <?php if ($job_current_page > 1) {
                                                $jobPrevPage = $job_current_page - 1;
                                            ?>
                                                <li class="page-item"><a class="page-link" href="?jobpage=<?php echo $jobPrevPage; ?>">Previous</a></li>
                                            <?php } else { ?>
                                                <li class="page-item disabled"><a class="page-link" href="">Previous</a></li>
                                            <?php } ?>
                                            <?php foreach (range($jobsPagination_rangeFirstNumber, $jobsPagination_rangeLastNumber) as $job_page_number) { ?>
                                                <li class="page-item <?= ($job_current_page == $job_page_number ? "active" : "");  ?>">
                                                    <a class="page-link" href="?jobpage=<?php echo $job_page_number ?>"><?php echo $job_page_number ?></a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($job_current_page < $job_total_pages) {
                                                $jobNextPage = $job_current_page + 1;
                                            ?>
                                                <li class="page-item"><a class="page-link" href="?jobpage=<?php echo $jobNextPage ?>">Next</a></li>
                                            <?php } else { ?>
                                                <li class="page-item disabled"><a class="page-link" href="">Next</a></li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
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