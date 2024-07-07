<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db_connection.php";
require_once "/var/www/html/php_basics/jobsite_project/vendor/autoload.php";

$client = new Google\Client();
$client->setClientId("580518976492-dqfihoi0bp1ek8es6t5347k4s3u7n3n4.apps.googleusercontent.com");
$client->setClientSecret("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");
if (isset($_SESSION['token']) && isset($_SESSION['orgIndex'])) {
    $client->setRedirectUri("http://localhost/php_basics/jobsite_project/dashboard.php");
}
if (isset($_SESSION['regoauthredirect'])) {
    $client->setRedirectUri("http://localhost/php_basics/jobsite_project/registration_page.php");
}
if (isset($_SESSION['logoauthredirect'])) {
    $client->setRedirectUri("http://localhost/php_basics/jobsite_project/login_page.php");
}
$client->addScope(Google\Service\Oauth2::USERINFO_PROFILE);
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $oauthkey = $google_account_info->id;
        $oauthemail = $google_account_info->email;
        if (isset($oauthkey) && isset($oauthemail)) {
            $stmt = $pdo->prepare("SELECT * FROM org WHERE oauthkey = :oauthkey");
            $stmt->bindParam(":oauthkey", $oauthkey, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
        } else {
            echo "Account info couldn't be fetched.";
            exit;
        }
        if ($rowCount > 0) {
            $stmt = $pdo->prepare("SELECT * FROM org WHERE oauthkey = :oauthkey");
            $stmt->bindparam(":oauthkey", $oauthkey, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['oauthkey'] == $oauthkey) {
                $sessiontoken = randomToken();
                $_SESSION['token'] = $sessiontoken;
                $_SESSION['phnNumber'] = $result['prphone'];
                header("Location: http://localhost/php_basics/jobsite_project/dashboard.php");
                exit;
            } else {
                echo "no oauthkey found?";
                exit;
            }
        } else if ($rowCount == 0) {
            if (isset($_SESSION['token']) && isset($_SESSION['orgIndex'])) {
                $sessionorgindex = $_SESSION['orgIndex'];
                $stmt = $pdo->prepare("SELECT * FROM org WHERE orgindex = :orgindex");
                $stmt->bindparam(":orgindex", $sessionorgindex, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);;
                if (!empty($result['oauthkey'])) {
                    header("Location: http://localhost/php_basics/jobsite_project/dashboard.php");
                    exit;
                } else if (empty($result['oauthkey'])) {
                    $orgindex = $_SESSION['orgIndex'];
                    $stmt = $pdo->prepare("UPDATE org SET oauthkey = :oauthkey, oauthemail = :oauthemail WHERE orgindex = :orgindex");
                    $stmt->bindparam(":orgindex", $orgindex, PDO::PARAM_STR);
                    $stmt->bindparam(":oauthkey", $oauthkey, PDO::PARAM_STR);
                    $stmt->bindparam(":oauthemail", $oauthemail, PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        header("Location: http://localhost/php_basics/jobsite_project/dashboard.php");
                        exit;
                    }
                } else {
                    echo "inner most loop condition not met";
                    exit;
                }
            } else {
                $_GET['regisemail'] = $oauthemail;
                header("Location: http://localhost/php_basics/jobsite_project/registration_page.php?regisemail=" . $oauthemail . "&oauthkey=" . $oauthkey);
                exit;
            }
        } else {
            echo "rowcount check failed";
            exit;
        }
    } else {
        "Token error";
        exit;
    }
}
