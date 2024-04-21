<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class AUTH
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($orgName, $pass)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT pass FROM org WHERE orguser = :orgName");
            $stmt->bindParam(':orgName', $orgName, PDO::PARAM_STR);
            $stmt->execute();
            $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userdata) {
                if (password_verify($pass, $userdata['pass'])) {
                    session_start();
                    $_SESSION['orguser'] = $orgName;
                    return true;
                } else {
                    return false; //Password Doesn't Match
                }
            } else {
                return false; //User Not Found
            }

        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserData ($orgName)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM org WHERE orguser = :orgName");
            $stmt->bindParam(':orgName', $orgName, PDO::PARAM_STR);
            $stmt->execute();
            $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

            return $userdata;

        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

}
