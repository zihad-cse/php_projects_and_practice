    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'db_connection.php';
    include 'auth.php';

    $phnNumber = $pass = $errmsg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $phnNumber = $_POST['phn'];
        $pass = $_POST['pass'];
        $user_captcha = $_POST['captcha'];

        $auth = new Auth($pdo);
        if ($user_captcha === $_SESSION['captcha']) {
            if ($auth->login($phnNumber, $pass)) {
                if (isset($_GET['return_url'])) {
                    $return_url = urldecode($_GET['return_url']);
                    header("location: " . $return_url);
                } else {
                    header("location: ./dashboard.php");
                }
                exit();
            } else {
                $errmsg = "<p class='text-danger'>Incorrect credentials. Please try again.</p>";
            }
        } else {
            $errmsg = "<p class='text-danger'>Incorrect Captcha Verification. Please try again.</p>";
        }
    }
