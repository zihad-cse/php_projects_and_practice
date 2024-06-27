<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "googlelogintestdb.php";

if(isset($_SESSION['token'])){
    echo "Already Logged in";
    exit;
}

include "google-api/google-api-php-client-2.4.0/vendor/autoload.php";

$client = new Google_Client();
$client->setClientId("580518976492-dqfihoi0bp1ek8es6t5347k4s3u7n3n4.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/php_basics/jobsite_project/googlelogintestpage.php");
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])){
        $client->setAccessToken($token['access_token']);
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $id = $google_account_info->id;

        $email = $google_account_info->email;
        if(isset($id)){
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
            
        } else {
            echo "Id not set";
            exit;
        }
        if ($rowCount > 0){
            $_SESSION['login_token'] = $id;
            header("Location: http://localhost/php_basics/jobsite_project/googlelogintesthomepage.php");
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (auth_key) VALUES (:id)");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            if($stmt->execute()){
                $_SESSION['login_token'] = $id;
                header("Location: http://localhost/php_basics/jobsite_project/googlelogintesthomepage.php");
                exit;
            }
            
        }
        
    }
}
?>