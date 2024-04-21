<?php

session_start();

$_SESSION = array();

session_destroy();

header("Location: ../html/recruiter_login_page.php");
exit();