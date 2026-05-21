<?php
include 'config.php';

if(isset($_POST['submit'])){
    $aina = $_POST['aina'];
    $bei = $_POST['bei'];
    $mahali = $_POST['mahali'];
    $maelezo = $_POST['maelezo'];

    // Kushughulikia Picha
    $picha_jina = $_FILES['picha']['name'];
    $picha_temp = $_FILES['picha']['tmp_name'];
    $folder = "uploads/" . $picha_jina;

    // Hakikisha folder la 'uploads' lipo
    if (!is_dir('uploads')) {
        mkdir('uploads');
    }

    $sql = "INSERT INTO livestock (aina, bei, mahali, maelezo, picha) VALUES ('$aina', '$bei', '$mahali', '$maelezo', '$picha_jina')";

    if(mysqli_query($conn, $sql)){
        move_uploaded_file($picha_temp, $folder);
        echo "<script>alert('Mfugo umewekwa vizuri!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
