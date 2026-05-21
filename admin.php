<?php
session_start();

// 1. DATABASE CONNECTION (Hakikisha Port ni 3307)
$host = "localhost:3307"; 
$user = "root";
$pass = "";
$dbname = "cattletrade_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("<div style='color:white; background:red; padding:10px;'>Server haipatikani! Hakikisha MySQL Port 3307 imewaka.</div>");
}

// 2. LOGIC: KUFUTA MFUGO
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // Futa picha kwanza ili isibaki kwenye server
    $res = mysqli_query($conn, "SELECT picha FROM livestock WHERE id = $id");
    $data = mysqli_fetch_assoc($res);
    if($data) { unlink("uploads/" . $data['picha']); }

    mysqli_query($conn, "DELETE FROM livestock WHERE id = $id");
    header("Location: delete.php?success=1");
}

// 3. LOGIC: KUINGIZA BIDHAA MPYA
if (isset($_POST['post_bidhaa'])) {
    $aina = mysqli_real_escape_string($conn, $_POST['aina']);
    $bei = mysqli_real_escape_string($conn, $_POST['bei']);
    $mahali = mysqli_real_escape_string($conn, $_POST['mahali']);
    $hali = mysqli_real_escape_string($conn, $_POST['hali']);
    $locations = mysqli_real_escape_string($conn, $_POST['locations']);
    
    $picha_jina = $_FILES['picha']['name'];
    $picha_temp = $_FILES['picha']['tmp_name'];
    $folder = "uploads/";

    if (!is_dir($folder)) { mkdir($folder, 0777, true); }

    $sql = "INSERT INTO livestock (aina, bei, mahali, picha, hali, locations) VALUES ('$aina', '$bei', '$mahali', '$picha_jina', '$hali', 'locations')";
    
    if (mysqli_query($conn, $sql)) {
        move_uploaded_file($picha_temp, $folder . $picha_jina);
        header("Location: admin.php?posted=1");
    }
}

// 4. TAKWIMU ZA HARAKA (STATS)
$q_total = mysqli_query($conn, "SELECT COUNT(*) as t FROM livestock");
$q_sold = mysqli_query($conn, "SELECT COUNT(*) as s FROM livestock WHERE hali = 'imenunuliwa'");
$total = mysqli_fetch_assoc($q_total)['t'];
$sold = mysqli_fetch_assoc($q_sold)['s'];
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CattleTrade Admin — Enterprise Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --earth: #080808; --glass: rgba(255, 255, 255, 0.03); --border: rgba(201, 125, 42, 0.2);
            --gold: #e8a83e; --amber: #c97d2a; --cream: #fdf6e3; --red: #ff4d4d; --green: #2ecc71;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--earth); color: var(--cream); min-height: 100vh; }

        /* Sidebar */
        .sidebar { position: fixed; width: 260px; height: 100vh; background: rgba(15, 15, 15, 0.95); border-right: 1px solid var(--border); backdrop-filter: blur(10px); }
        .brand { padding: 35px 25px; font-family: 'Syne'; color: var(--gold); font-size: 24px; font-weight: 800; border-bottom: 1px solid var(--border); }
        .nav-item { padding: 16px 25px; display: flex; align-items: center; gap: 15px; color: rgba(255,255,255,0.5); text-decoration: none; font-size: 14px; transition: 0.3s; }
        .nav-item:hover, .nav-item.active { background: rgba(201, 125, 42, 0.1); color: var(--gold); border-left: 4px solid var(--amber); }

        /* Main Content */
        .main { margin-left: 260px; padding: 40px; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        
        /* KPI Cards */
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .kpi-card { background: var(--glass); padding: 30px; border-radius: 20px; border: 1px solid var(--border); backdrop-filter: blur(15px); position: relative; overflow: hidden; }
        .kpi-card::before { content: ""; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--amber); }
        .kpi-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #8a7a62; }
        .kpi-value { font-family: 'Syne'; font-size: 32px; font-weight: 700; color: var(--gold); margin-top: 5px; }

        /* Dashboard Layout */
        .dashboard-grid { display: grid; grid-template-columns: 380px 1fr; gap: 35px; }

        /* Control Panel Form */
        .control-panel { background: var(--glass); padding: 30px; border-radius: 20px; border: 1px solid var(--border); height: fit-content; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 11px; color: #8a7a62; margin-bottom: 10px; font-weight: 700; text-transform: uppercase; }
        .form-control { width: 100%; padding: 14px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 12px; color: white; outline: none; transition: 0.3s; }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 15px rgba(232, 168, 62, 0.1); }
        .btn-submit { width: 100%; padding: 15px; background: linear-gradient(135deg, var(--amber), var(--gold)); border: none; border-radius: 12px; color: #000; font-weight: 800; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; }

        /* Data Table */
        .table-container { background: var(--glass); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 18px 20px; text-align: left; background: rgba(201, 125, 42, 0.08); color: var(--gold); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .data-table td { padding: 18px 20px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
        .picha-box { width: 50px; height: 50px; border-radius: 10px; object-fit: cover; border: 1px solid var(--border); }
        
        /* Badges */
        .badge { padding: 6px 12px; border-radius: 30px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .badge-sokoni { background: rgba(46, 204, 113, 0.15); color: var(--green); }
        .badge-umeuzwa { background: rgba(255, 77, 77, 0.15); color: var(--red); }

        .btn-del { color: var(--red); font-size: 16px; transition: 0.3s; }
        .btn-del:hover { transform: scale(1.2); }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fas fa-crown"></i> BIDHAA SITE</div>
        <nav style="margin-top: 30px;">
            <a href="admin.php" class="nav-item active"><i class="fas fa-layer-group"></i> Dashibodi</a>
            <a href="index.php" class="nav-item"><i class="fas fa-external-link-alt"></i> Fungua Site</a>
            <a href="#" class="nav-item"><i class="fas fa-users-cog"></i> Watumiaji</a>
            <a href="#" class="nav-item" style="margin-top: 100px; color: var(--red);"><i class="fas fa-sign-out-alt"></i> Toka</a>
        </nav>
    </div>

    <div class="main">
        <header>
            <div>
                <h1 style="font-family: 'Syne'; font-size: 28px;">Control Site</h1>
                <p style="font-size: 13px; color: #8a7a62;">Karibu tena, KP Admin</p>
            </div>
            <div style="text-align: right;">
                <span style="color: var(--green); font-size: 12px;"><i class="fas fa-database"></i> Database Connected (3307)</span>
                <p style="font-size: 11px; color: #8a7a62;"><?php echo date('l, d F Y'); ?></p>
            </div>
        </header>

        <div class="kpi-grid">
            <div class="kpi-card">
                <p class="kpi-label">Jumla ya Bidhaa</p>
                <h2 class="kpi-value"><?php echo $total; ?></h2>
            </div>
            <div class="kpi-card">
                <p class="kpi-label">Bidhaa zilizouzwa</p>
                <h2 class="kpi-value" style="color: var(--red);"><?php echo $sold; ?></h2>
            </div>
            <div class="kpi-card">
                <p class="kpi-label">Bidhaa sokoni</p>
                <h2 class="kpi-value" style="color: var(--green);"><?php echo ($total - $sold); ?></h2>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="control-panel">
                <h3 style="font-family: 'Syne'; font-size: 18px; margin-bottom: 25px; color: var(--gold);">Ongeza Mfugo Sokoni</h3>
                <form action="admin.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label">Aina ya Mfugo</label>
                        <input type="text" name="aina" class="form-control" placeholder="mf. Mbuzi wa Kisasa" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bei (TZS)</label>
                        <input type="number" name="bei" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mahali</label>
                        <input type="text" name="mahali" class="form-control" placeholder="mf. Arusha, Njiro" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hali ya Sasa</label>
                        <select name="hali" class="form-control">
                            <option value="Sokoni">Ipo Sokoni</option>
                            <option value="umenunuliwa">Imeuzwa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Picha ya Bidhaa</label>
                        <input type="file" name="picha" class="form-control" required style="padding: 8px;">
                    </div>
                    <button type="submit" name="post_mfugo" class="btn-submit">POST KWENYE SITE</button>
                </form>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Picha</th>
                            <th>Aina</th>
                            <th>Bei</th>
                            <th>Hali</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM livestock ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($query)) {
                            $hali_badge = ($row['hali'] == 'Umeuzwa') ? 'badge-umeuzwa' : 'badge-sokoni';
                            echo "<tr>";
                            echo "<td><img src='uploads/".$row['picha']."' class='picha-box'></td>";
                            echo "<td style='font-weight:700;'>".$row['aina']."</td>";
                            echo "<td style='color:var(--gold); font-weight:700;'>".number_format($row['bei'])." TZS</td>";
                            echo "<td><span class='badge $hali_badge'>".$row['hali']."</span></td>";
                            echo "<td>
                                    <a href='admin.php?delete_id=".$row['id']."' 
                                       onclick='return confirm(\"Je, una uhakika wa kufuta bidhaa hii?\")' 
                                       class='btn-del'>
                                       <i class='fas fa-trash-alt'></i>
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
