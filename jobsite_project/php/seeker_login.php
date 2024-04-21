    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'db_connection.php';
    include 'seeker_auth.php';

    $phn = $pass = $errmsg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $phn = $_POST['phn'];
        $pass = $_POST['pass'];

        $auth = new Auth($pdo);

        if($auth->login($phn, $pass)){
            header('location: seeker_dashboard.php');
            exit();
        } else {
            $errmsg = "<p class='text-danger'>Incorrect credentials. Please try again.</p>";
        }
    }
