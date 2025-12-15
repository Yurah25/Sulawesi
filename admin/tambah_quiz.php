<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

if (isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $waktu = (int) $_POST['waktu'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $nama_baru = date('dmYHis') . "_" . str_replace(" ", "", $gambar);

    if (move_uploaded_file($tmp, "../assets/img/" . $nama_baru)) {
        $query = "INSERT INTO daftar_quiz (judul, kategori, deskripsi, gambar, waktu_pengerjaan) 
                  VALUES ('$judul', '$kategori', '$deskripsi', '$nama_baru', '$waktu')";
        
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            echo "<script>alert('Quiz berhasil dibuat! Silakan tambahkan soal.'); window.location='kelola_soal.php?id=$last_id';</script>";
        } else {
            echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal upload gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Quiz Baru - Admin</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
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
                <li><a href="kelola_artikel.php" ><i class='bx bxs-file-doc'></i> <span>Kelola Artikel</span></a></li>
                <li><a href="quiz_kelola.php"class="active"><i class='bx bx-clipboard'></i> <span>Kelola Quiz</span></a></li>
                <li><a href="#"><i class='bx bx-group'></i> <span>Peserta Quiz</span></a></li>
            </ul>

            <div class="logout">
                <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')"><i class='bx bx-log-out'></i><span>Logout</span></a>
            </div>
        </aside>

    <main class="main-content">
        <h1 style="margin-bottom: 20px;">Buat Quiz Baru</h1>
        
        <form action="" method="post" enctype="multipart/form-data" class="form-card">
            
            <label class="form-label">Judul Quiz</label>
            <input type="text" name="judul" class="form-input" placeholder="Misal: Quiz Kuliner Khas Makassar" required>

            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-input" placeholder="Contoh: Kuliner, Budaya, Sejarah" required>

            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-input" style="height: 100px;" placeholder="Uji pengetahuan tentang..." required></textarea>
            
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label class="form-label">Waktu Pengerjaan (Menit)</label>
                    <input type="number" name="waktu" class="form-input" value="10" required>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Gambar Sampul</label>
                    <input type="file" name="gambar" class="form-input" required accept="image/*">
                </div>
            </div>

            <div class="form-buttons">
                <a href="kelola_quiz.php" class="btn-cancel">Batal</a>
                <button type="submit" name="tambah" class="btn-save">Simpan & Lanjut ke Soal</button>
            </div>

        </form>
    </main>
</div>
</body>
</html>