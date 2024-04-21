<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
            $stmt = $this->pdo->prepare("SELECT user_password FROM users WHERE phn_number = :phnNumber");
            $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($pass, $user['user_password'])) {
                    session_start();
                    $_SESSION['phnNumber'] = $phnNumber;
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

    public function getUserData($phnNumber)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE phn_number = :phnNumber");
            $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Return the user data
            return $user;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
