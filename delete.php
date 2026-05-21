<?php
include 'db_connect.php';
$id = $_GET['id'];

// Kwanza, futa picha kwenye folder la uploads
$res = mysqli_query($conn, "SELECT image_path FROM wildlife WHERE id=$id");
$row = mysqli_fetch_assoc($res);
unlink($row['image_path']); // Hii inafuta file lenyewe

// Pili, futa taarifa kwenye database
mysqli_query($conn, "DELETE FROM wildlife WHERE id=$id");
header("Location: dashboard.php?deleted");
?>
