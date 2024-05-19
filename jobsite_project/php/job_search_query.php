<?php
include 'db_connection.php';
$search ="";
if (isset($_GET['search'])) {
     $search = $_GET['search'];
    // exit;
}
include "pagination.php";

