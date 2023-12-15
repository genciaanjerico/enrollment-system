<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "system_enrollment1_db";

$con = mysqli_connect($host, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
