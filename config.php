<?php
$host = "localhost:3307";
$user = "root";
$pass = "";
$dbname = "cattletrade_db";

// Kutengeneza connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Kuangalia kama imekubali
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
