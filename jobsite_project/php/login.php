    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'db_connection.php';
    include 'auth.php';

    $phnNumber = $pass = $errmsg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $phnNumber = $_POST['phn'];
        $pass = $_POST['pass'];

        $auth = new Auth($pdo);

        if ($auth->login($phnNumber, $pass)) {
            header("location: account_dashboard.php?phnNumber=$phnNumber");
            exit();
        } else {
            $errmsg = "<p class='text-danger'>Incorrect credentials. Please try again.</p>";
        }
    }

