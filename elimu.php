<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Elimu ya Mifugo | CattleTrade</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9fa; margin: 0; }
        nav { background: #fff; padding: 20px 8%; display: flex; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: 700; color: #27ae60; text-decoration: none; }
        .content { width: 80%; margin: 40px auto; }
        .article-card { background: white; padding: 25px; border-radius: 10px; margin-bottom: 20px; border-left: 6px solid #27ae60; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .article-card h2 { color: #2c3e50; margin-top: 0; }
        .tag { background: #e8f5e9; color: #27ae60; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="logo"><i class="fas fa-cow"></i> CATTLETRADE</a>
    <div>
        <a href="index.php" style="text-decoration:none; color:#333; font-weight:bold;">Rudi Nyumbani</a>
    </div>
</nav>

<div class="content">
    <h1 style="text-align: center; color: #2c3e50;">Maktaba ya Elimu ya Mifugo</h1>
    <p style="text-align: center; color: #7f8c8d; margin-bottom: 40px;">Jifunze mbinu bora za ufugaji na biashara ya kisasa.</p>

    <div class="article-card">
        <span class="tag">BIASHARA</span>
        <h2>Mbinu 5 za Kupata Soko la Uhakika</h2>
        <p>Wafugaji wengi hushindwa kupata faida kwa sababu ya kukosa masoko. Katika makala hii, tunaangazia jinsi ya kutumia mitandao ya kijamii na majukwaa kama CattleTrade kupata wateja...</p>
        <a href="#" style="color:#27ae60; font-weight:bold; text-decoration:none;">Soma zaidi -></a>
    </div>

    <div class="article-card">
        <span class="tag">AFYA</span>
        <h2>Ratiba ya Chanjo kwa Ng'ombe wa Maziwa</h2>
        <p>Afya ya mifugo ni mtaji wako. Hakikisha unafuata ratiba ya chanjo dhidi ya magonjwa ya miguu na midomo ili kuepuka hasara...</p>
        <a href="#" style="color:#27ae60; font-weight:bold; text-decoration:none;">Soma zaidi -></a>
    </div>
</div>

</body>
</html>
