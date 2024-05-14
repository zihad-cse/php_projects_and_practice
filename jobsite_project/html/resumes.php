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
            <div class="d-lg-block d-md-block d-sm-none d-none">
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
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
                        <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" href="posted_jobs.php">Jobs Posted</a></li>
                        <li><a class="dropdown-item" href="../php/logout.php?return_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="bg-light">
            <div class="row">
                <div class="col-12 p-lg-5 p-md-4 p-sm-2 p-2" style="min-height: 1000px; background-color: #ddd;">
                    <div class="">
                        <div class="container">
                            <div class="">
                                <div class="">
                                    <h2 class="text-center mb-5">Available Resumes</h2>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="container">
                                            <div class="">
                                                <div class="row">
                                                    <?php foreach ($allresumedetails as $row) {
                                                        $resume_img_src = "../uploads/resumes/placeholder_pfp.svg";
                                                        if (file_exists("../uploads/resumes/" . $row['rindex'] . ".png")) {
                                                            $resume_img_src = "../uploads/resumes/" . $row['rindex'] . ".png";
                                                        }
                                                    ?>
                                                        <div class="container">
                                                            <div class="col-12">
                                                                <a id="landing-page-mouse-hover-card" style="max-height: 400px;" href="../html/resume.php?view&id=<?php echo $row['rindex'] ?>" class="text-start m-4 card text-decoration-none">
                                                                    <div class="card-body">
                                                                        <div class="row text-lg-start text-md-start text-sm-center text-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                                                <img style="height:100px; width: 100px;" src="<?php echo $resume_img_src ?>" alt="">
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
                                                                                        <p><?php echo $row['skilleduexp']; ?></p>
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
                                                <li class="page-item"><a class="page-link" href="?resumepage=<?php echo $resumePrevPage; ?>">Previous</a></li>
                                            <?php } else { ?>
                                                <li class="page-item disabled"><a class="page-link" href="">Previous</a></li>
                                            <?php } ?>
                                            <?php foreach (range($resumePagination_rangeFirstNumber, $resumePagination_rangeLastNumber) as $resume_page_number) { ?>
                                                <li class="page-item <?= ($resume_current_page == $resume_page_number ? "active" : "");  ?>">
                                                    <a class="page-link" href="?resumepage=<?php echo $resume_page_number ?>"><?php echo $resume_page_number ?></a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($resume_current_page < $resume_total_pages) {
                                                $resumeNextPage = $resume_current_page + 1;
                                            ?>
                                                <li class="page-item"><a class="page-link" href="?resumepage=<?php echo $resumeNextPage ?>">Next</a></li>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="footer" class="bg-dark text-light" >
        <div class="container">
            <footer class="row py-5">
                <div class="col-6">
                    <img src="../img/logoipsum-248.svg" alt="">
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
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>