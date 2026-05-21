<?php
session_start();
include 'config.php'; // Hakikisha config.php ina localhost:3307

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Kulinganisha na data tulizoweka phpMyAdmin (admin / admin123)
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin.php"); // Inakupeleka direct Dashboard
        exit();
    } else {
        $error = "Jina au nenosiri si sahihi!";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>CattleTrade | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #0f172a; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif; color: white; }
        .login-card { background: rgba(255,255,255,0.05); padding: 40px; border-radius: 20px; backdrop-filter: blur(10px); width: 380px; text-align: center; border: 1px solid rgba(255,255,255,0.1); }
        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; color: #94a3b8; font-size: 14px; }
        .input-field { width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; outline: none; }
        .login-btn { width: 100%; padding: 12px; background: #ef4444; color: white; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .login-btn:hover { background: #dc2626; }
        .error { color: #f87171; margin-bottom: 15px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 style="color: #22d3ee; margin-bottom: 10px;">CattleTrade</h2>
        <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Ingia kwenye Dashboard</p>
        
        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="POST" action="login.php">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" class="input-field" placeholder="Ingiza username" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" class="input-field" placeholder="Ingiza password" required>
            </div>
            <button type="submit" name="login" class="login-btn">INGIA </button>
        </form>
    </div>
</body>
</html>
