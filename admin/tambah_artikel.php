<?php
session_start();
include '../config/database.php';
if ($_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

if(isset($_POST['tambah'])){
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal = date('Y-m-d');

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    
    $nama_baru = date('dmYHis').$gambar;
    $path = "../assets/img/".$nama_baru;

    if(move_uploaded_file($tmp, $path)){
        $query = "INSERT INTO artikel (judul, kategori, deskripsi, gambar, tanggal) 
                  VALUES ('$judul', '$kategori', '$deskripsi', '$nama_baru', '$tanggal')";
        if(mysqli_query($conn, $query)){
            echo "<script>alert('Artikel Berhasil Ditambah!'); window.location='kelola_artikel.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal Upload Gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Artikel</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="container">
    <aside class="sidebar">
            <div class="logo">
                <h2>Sulapedia</h2>
                <span>Dashboard Admin</span>
            </div>

            <ul class="menu">
                <li><a href="dashboard.php"><i class='bx bxs-dashboard'></i> <span>Dashboard</span></a></li>
                <li><a href="kelola_artikel.php" class="active"><i class='bx bxs-file-doc'></i> <span>Kelola Artikel</span></a></li>
                <li><a href="kelola_quiz.php"><i class='bx bx-clipboard'></i> <span>Kelola Quiz</span></a></li>
                <li><a href="peserta_quiz.php"><i class='bx bx-group'></i> <span>Peserta Quiz</span></a></li>
            </ul>

            <div class="logout">
                <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')"><i class='bx bx-log-out'></i><span>Logout</span></a>
            </div>
        </aside>

    <main class="main-content">
        <h1 style="margin-bottom:20px;">Tambah Artikel Baru</h1>
        
        <form action="" method="post" enctype="multipart/form-data" class="form-card">
            
            <label class="form-label">Judul Artikel</label>
            <input type="text" name="judul" class="form-input" placeholder="Masukkan judul artikel" required>

            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-input" placeholder="Contoh: Kuliner, Wisata" required>

            <label class="form-label">Konten Artikel</label>
            <textarea name="deskripsi" class="form-input" style="height:150px;" placeholder="Masukkan konten lengkap artikel" required></textarea>

            <label class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-input" required>

            <div class="form-buttons">
                <a href="kelola_artikel.php" class="btn-cancel">Batal</a>
                <button type="submit" name="tambah" class="btn-save">Tambah Artikel</button>
            </div>

        </form>
    </main>
</div>
</body>
</html>