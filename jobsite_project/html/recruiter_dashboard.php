<!DOCTYPE html>
<html lang="en">
<?php
    
    include '../php/recruiter_auth.php';
    include '../php/db_connection.php';
    
    session_start();
    
    if (!isset($_SESSION['orguser'])) {
        header("Location: recruiter_login_page.php");
        exit();
    }
    
    $auth = new Auth($pdo);
    
    $userData = $auth->getUserData($_SESSION['orguser']);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/account_dashboard.css">
    <style>
        #logout-button:hover {
            color: #dc3545;
        }
    </style>
    <title>Dashboard</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="landing_page.html">
                Logo
            </a>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item btn" href="#">Edit Profile</a></li>
                    <li><a class="dropdown-item btn" href="#">Settings</a></li>
                    <li>
                        <form action="../php/recruiter_logout.php" method="post" class="dropdown-item"><input class="btn p-0"
                                type="submit" value="Log Out" id="#logout-button"></form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-5 bg-light">
                    <div class="row">
                        <div class="col-5">
                            <h3>Dashboard</h3>
                            <table class="table">
                                <tr>
                                    <th scope="row">Organization Name</th>
                                    <td><?php echo $userData['orguser']; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-7">
                            <h3>Posted Jobs</h3>
                            <table class="table table-bordered">
                                <tr>
                                    <th scope="row">#jobID</th>
                                    <td><a href="#">#jobtitle</a></td>
                                    <td>#status</td>
                                    <td><a href="#" class="btn btn-primary">Edit</a></td>
                                </tr>
                            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>

</html>