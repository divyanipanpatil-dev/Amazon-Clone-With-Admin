<?php
session_start();

// Redirect directly to dashboard if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded credentials (No database required)
    $defined_user = "admin";
    $defined_pass = "admin123";

    if ($username === $defined_user && $password === $defined_pass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;

        // Redirect directly to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        .login-card h2 { margin-bottom: 20px; color: #1a1c23; text-align: center; }
        .login-card input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .login-card button { width: 100%; padding: 10px; background: #1a1c23; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .login-card button:hover { background: #333; }
        .error { color: red; font-size: 14px; margin-bottom: 10px; text-align: center; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Admin Login</h2>
    <?php if ($error != "") { echo "<div class='error'>$error</div>"; } ?>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>