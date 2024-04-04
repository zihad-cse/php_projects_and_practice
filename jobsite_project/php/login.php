    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'db_connection.php';

    $phn = $pass = $errmsg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $phn = $_POST['phn'];
        $pass = $_POST['pass'];

        try {
            $stmt = $pdo->prepare("SELECT user_password FROM users WHERE phn_number = :phn");
            $stmt->bindParam(':phn', $phn, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($pass, $user['user_password'])) {
                    header('Location: loggedin.php');
                    exit();
                } else {
                    $errmsg = "<p class='text-danger'>Password does not match</p>";
                }
            } else {
                $errmsg = "<p class='text-danger'>User not found.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
