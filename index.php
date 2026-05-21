<?php 
include 'config.php'; 
// Hii ni Logic ya Search Bar
$search_query = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = " WHERE aina LIKE '%$search%' OR mahali LIKE '%$search%' ";
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CattleTrade | Soko la Kisasa la Mifugo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fa; color: #333; scroll-behavior: smooth; }

        /* Navigation */
        nav {
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 8%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo { font-size: 24px; font-weight: 700; color: #27ae60; text-decoration: none; }
        .nav-links { list-style: none; display: flex; }
        .nav-links li { margin-left: 30px; }
        .nav-links a { text-decoration: none; color: #2c3e50; font-weight: 500; transition: 0.3s; }
        .nav-links a:hover { color: #27ae60; }

        /* Hero Section */
        .hero {
            height: 70vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1547496502-affa22d38842?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 0 20px;
        }
        .hero h1 { font-size: clamp(30px, 5vw, 48px); margin-bottom: 10px; }
        
        /* Search Bar Style */
        .hero form {
            display: flex;
            background: white;
            padding: 5px;
            border-radius: 50px;
            width: 100%;
            max-width: 550px;
            margin: 25px 0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .hero form input {
            flex: 1;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            outline: none;
            font-size: 16px;
        }
        .hero form button {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        .hero form button:hover { background: #219150; }

        /* Section Titles */
        .section-title { text-align: center; margin: 60px 0 40px; }
        .section-title h2 { font-size: 32px; color: #2c3e50; }
        .section-title div { width: 60px; height: 4px; background: #27ae60; margin: 10px auto; }

        /* Livestock Grid */
        .container { width: 85%; margin: auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; padding-bottom: 60px; }
        .card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card:hover { transform: translateY(-10px); }
        .card img { width: 100%; height: 220px; object-fit: cover; }
        .card-content { padding: 20px; }
        .price { color: #27ae60; font-weight: 700; font-size: 20px; display: block; margin-bottom: 10px; }
        
        /* WhatsApp Button */
        .btn-wa {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #25D366;
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.3s;
        }
        .btn-wa:hover { background: #1ebd5a; }

        /* Footer */
        footer { background: #2c3e50; color: white; padding: 60px 8% 20px; margin-top: 50px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; }
        footer a { color: #bdc3c7; text-decoration: none; transition: 0.3s; }
        footer a:hover { color: #27ae60; }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="logo"><i class="fas fa-cow"></i> CATTLETRADE</a>
    <ul class="nav-links">
        <li><a href="index.php">Nyumbani</a></li>
        <li><a href="elimu.php">Elimu</a></li>
        <li><a href="login.php" style="background: #27ae60; color: white; padding: 8px 20px; border-radius: 20px;">Weka Mfugo</a></li>
    </ul>
</nav>

<section class="hero">
    <h1>Soko la Uhakika la Mifugo</h1>
    <p> Pata bei halisi ya mifugo bila kupitia madalali Nunua na uza mifugo kwa urahisi  popote ulipo,
    <p> Unganishwa moja kwa moja na wafugajiwanaoaminika Tanzania, 
    <p> Biashara ya mifugo sasa imekuwa rahisi na ya kisasa.
</p>
    
    <form action="index.php" method="GET">
        <input type="text" name="search" placeholder="Tafuta (mf. Ng'ombe, Arusha, Mbuzi...)" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit"><i class="fas fa-search"></i> Tafuta</button>
    </form>
</section>

<div class="section-title" id="soko">
    <h2><?php echo isset($_GET['search']) ? "Matokeo ya: ".$_GET['search'] : "Mifugo Inayouzwa"; ?></h2>
    <div></div>
</div>

<div class="container">
    <?php
    $sql = "SELECT * FROM livestock" . $search_query . " ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="card">
                <img src="uploads/<?php echo $row['picha']; ?>" alt="Mfugo">
                <div class="card-content">
                    <span class="price">TSh <?php echo number_format($row['bei']); ?></span>
                    <h3><?php echo $row['aina']; ?></h3>
                    <p style="font-size: 14px; color: #7f8c8d; margin: 5px 0 15px;">
                        <i class="fas fa-map-marker-alt"></i> <?php echo $row['mahali']; ?>
                    </p>
                    <p style="font-size: 13px; color: #666; line-height: 1.5;"><?php echo $row['maelezo']; ?></p>
                    
                    <a href="https://wa.me/255700000000?text=Habari, nahitaji maelezo zaidi kuhusu <?php echo $row['aina']; ?> anayeuzwa TSh <?php echo number_format($row['bei']); ?> iliyopo <?php echo $row['mahali']; ?>" 
                       class="btn-wa" target="_blank">
                        <i class="fab fa-whatsapp"></i> Wasiliana Sasa
                    </a>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div style='grid-column: 1/-1; text-align: center; padding: 50px;'>
                <i class='fas fa-search' style='font-size: 50px; color: #ccc;'></i>
                <p style='margin-top: 15px; color: #666;'>Samahani, hatujapata ulichotafuta kwa sasa.</p>
                <a href='index.php' style='color: #27ae60;'>Onyesha Mifugo Yote</a>
              </div>";
    }
    ?>
</div>

<footer>
    <div class="footer-grid">
        <div>
            <h3 style="color: #27ae60; margin-bottom: 20px;">CATTLETRADE</h3>
            <p style="font-size: 14px; line-height: 1.8; color: #bdc3c7;">
                Karibu CattleTrade, kitovu cha biashara ya mifugo inayozingatia ufanisi na tija. Tunatumia teknolojia kurahisisha mchakato wa ununuzi na uuzaji wa mifugo nchi nzima. Kwa kupitia mfumo wetu, tunapunguza gharama zisizo za lazima na kuongeza usalama wa miamala, huku tukikuhakikishia upatikanaji wa mifugo iliyohakikiwa kwa vigezo vyote vya ubora na afya."
            </p>
        </div>
        <div>
            <h4 style="margin-bottom: 20px;">Viungo</h4>
            <ul style="list-style: none; font-size: 14px; line-height: 2.5;">
                <li><a href="index.php">Nyumbani</a></li>
                <li><a href="elimu.php">Elimu ya Mifugo</a></li>
                <li><a href="login.php">Admin Panel</a></li>
            </ul>
        </div>
        <div>
            <h4 style="margin-bottom: 20px;">Mawasiliano</h4>
            <p style="font-size: 14px; color: #bdc3c7; line-height: 2;">
                <i class="fas fa-phone-alt" style="color: #27ae60;"></i> +255 745 110 910<br>
                <i class="fas fa-envelope" style="color: #27ae60;"></i> info@cattletrade.co.tz<br>
                <i class="fas fa-map-marker-alt" style="color: #27ae60;"></i> Arusha, Tanzania
            </p>
        </div>
    </div>
    <p style="text-align: center; margin-top: 40px; font-size: 13px; color: #7f8c8d; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
        &copy; 2026 CattleTrade Project. Imetengenezwa na **KP** 🚀
    </p>
</footer>

</body>
</html>
