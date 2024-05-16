<?php
include 'db_connection.php';
$search ="";
if (isset($_GET['search-submit'])) {
     $search = $_GET['search'];
    // exit;
}
include "pagination.php";

