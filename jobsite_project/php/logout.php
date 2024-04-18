<?php

session_start();

$_SESSION = array();

session_destroy();

header("Location: ../html/seeker_login_page.php");
exit();