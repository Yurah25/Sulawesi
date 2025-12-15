<?php
include 'config/database.php';

if (isset($_POST['register'])) {
    $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
    $email    = htmlspecialchars(stripslashes(trim($_POST['email'])));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password']; 
    $username_safe = mysqli_real_escape_string($conn, $username);
    $email_safe    = mysqli_real_escape_string($conn, $email);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email_safe' OR username = '$username_safe'");
    
    if (mysqli_num_rows($cek) > 0) {
        $row = mysqli_fetch_assoc($cek);
        if ($row['email'] == $email) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else {
            echo "<script>alert('Username sudah digunakan, silakan pilih yang lain!');</script>";
        }
    } 
    elseif (strlen($password) < 8) {
        echo "<script>alert('Password terlalu pendek! Minimal 8 karakter.');</script>";
    }
    elseif ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    } 
    else {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password, role) VALUES ('$username_safe', '$email_safe', '$pass_hash', 'user')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registrasi Sukses! Silakan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
        }
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
    <link rel="stylesheet" type="text/css" href="assets/css/regis.css">
    <title>Registrasi-page</title>
</head>
<body>
    <div class="deskripsi">
    <h1>Join the Journey Across Sulawesi</h1>
    <p>Create your account and explore the culture, cuisine, and tourism of Sulawesi in one platform</p>
    </div>
    <form action="" method="post">
        <a class="kembali" href="index.php">kembali</a>
        <h1>Sign up</h1>
        <label for="email">Username </label>
        <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
        <label for="email">Email </label>
        <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Masukkan Ulang Password" required>
        <input type="submit" id="submit" name="register" value="Create Account">
        <p>Already have an account?<a href="login.php" >Login in</a></p>
    </form>
</body>
</html>