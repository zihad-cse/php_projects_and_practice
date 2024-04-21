<!DOCTYPE html>
<html lang="en">
<?php
include '';
include '../php/db_connection.php';
include '../php/seeker_dashboard_edit.php';

//!!!!!!!!!!!!!!FIX THE EDITING FORM!!!!!!!!!!!!!!!!

if (!isset($_SESSION['phnNumber'])) {
    header("Location: seeker_login_page.php");
    exit();
}

$auth = new Auth($pdo);

$userData = $auth->getUserData($_SESSION['phnNumber']);
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
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item btn" href="#">Edit Profile</a></li>
                    <li><a class="dropdown-item btn" href="#">Settings</a></li>
                    <li>
                        <form action="../php/seeker_logout.php" method="post" class="dropdown-item"><input class="btn p-0" type="submit" value="Log Out" id="#logout-button"></form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="dashboard-main-content" class="row">
        <div class="col-1">

        </div>
        <div class="card col-8">
            <div class="card-body">
                <h3>Profile</h3>
                <form action="">
                    <table class="table table-bordered">
                        <tr>
                            <th scope="row">Username</th>
                            <td><input name="userName" class="form-control" type="text" placeholder="<?php echo $userData['user_name']; ?>"></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><input name="eMail" class="form-control" type="email" placeholder="<?php echo $userData['email_add']; ?>"></td>
                        </tr>
                        <tr>
                            <th scope="row">Phone Number</th>
                            <td><input name="phnNumber" class="form-control" type="text" placeholder="<?php echo $userData['phn_number']; ?>"></td>
                        </tr>
                        <tr>
                            <th scope="row">Date of Birth</th>
                            <td><?php echo $userData['dob']; ?></td>
                        </tr>
                    </table>
                    <input class="btn btn-primary" value="Save" type="submit">
                </form>

            </div>
        </div>
        <div class="card col-2">
            <div class="card-body">
                <div id="profile-picture-area" class="border rounded-circle">

                </div>
                <div>
                    <h4 class="text-center pt-3"><?php echo $userData['user_name']; ?></h4>
                    <hr>
                    <h5 class="text-center">Phone:<?php echo $userData['phn_number']; ?></h5>
                    <h5 class="text-center">Email: <?php echo $userData['email_add']; ?></h5>
                    <hr>
                    <h5 class="text-center">Skills:</h5>
                    <ul class="list-inline">
                        <li class="list-inline-item">placeholder1</li>
                        <li class="list-inline-item">placeholder2</li>
                        <li class="list-inline-item">placeholder3</li>
                        <li class="list-inline-item">placeholder4</li>
                        <li class="list-inline-item">placeholder5</li>
                    </ul>
                    <hr>
                    <h5>Status: </h5>
                    <hr>
                    <h5>Member Since: <?php echo $userData['member_since']; ?> </h5>
                    <hr>
                    <div class="text-center">
                        <a href="#"><button class="btn btn-primary">Click to view full profile</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1">

        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>