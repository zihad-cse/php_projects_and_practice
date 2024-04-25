<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'utility.php';
class Auth
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function login($phnNumber, $pass)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT pass FROM org WHERE prphone = :phnNumber");
            $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($pass, $user['pass'])) {
                    session_start();
                    $token = randomToken();
                    $_SESSION['phnNumber'] = $phnNumber;
                    $_SESSION['token'] = $token;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
