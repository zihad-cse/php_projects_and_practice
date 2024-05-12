<?php

session_start();
$_SESSION = array();

session_destroy();

if(isset($_GET['return_url'])){
    $return_url = urldecode($_GET['return_url']);
    header('location: '."$return_url");
} else {
    header('location: ../');
}
exit();