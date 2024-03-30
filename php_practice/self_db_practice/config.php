<?php 
include_once 'db_conn.php';

$db = new Database();
$query = "SELECT * FROM customers";
$read = $db->select($query);