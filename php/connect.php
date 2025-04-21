<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "manajemen_modul";

$conn = mysqli_connect($host, $user, $password, $db);
// Check connection
if (!$conn) {
    die("Connection failed: ");
    exit();
}
