<?php
session_start();
include 'config/database.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        if (password_verify($password, $data['password'])) {
            
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['status'] = "login";

            if ($data['role'] == "admin") {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;

        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Email tidak terdaftar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
    <title>Login page</title>
</head>
<body>
    <div class="login-container">
        <a class="kembali" href="index.php">kembali</a>
    <header>
    <h1>Sulapedia</h1> 
    <p>Access cultural, culinary, and tourism information from all around Sulawesi</p>    
    </header>

    <main>
    <form action="" method="post" class="login-box">
        <h1>Login</h1>
        <label for="email">Email </label>
        <input type="email" id="email" name="email" placeholder="Masukkan Email">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan Password">
        <a href="" class="forgot">forgot password?</a>
        <input type="submit" id="login" name="login" value="Login">
        <p>dont have an account yet?<a href="regis.php"> Regist here</a></p>
    </form>
    </main>
    </div>
</body>
</html>