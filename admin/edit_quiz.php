<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM daftar_quiz WHERE id='$id'"));

if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $waktu = (int) $_POST['waktu'];

    $gambar_nama = $_FILES['gambar']['name'];
    
    if ($gambar_nama != "") {
        $nama_baru = date('dmYHis') . "_" . str_replace(" ", "", $gambar_nama);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/img/" . $nama_baru);
        
        if (file_exists("../assets/img/" . $data['gambar'])) {
            unlink("../assets/img/" . $data['gambar']);
        }
        
        $query = "UPDATE daftar_quiz SET judul='$judul', kategori='$kategori', deskripsi='$deskripsi', waktu_pengerjaan='$waktu', gambar='$nama_baru' WHERE id='$id'";
    } else {
        $query = "UPDATE daftar_quiz SET judul='$judul', kategori='$kategori', deskripsi='$deskripsi', waktu_pengerjaan='$waktu' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Quiz berhasil diperbarui!'); window.location='kelola_quiz.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Quiz - Admin</title>
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
        <h1 style="margin-bottom: 20px;">Edit Quiz</h1>
        
        <form action="" method="post" enctype="multipart/form-data" class="form-card">
            
            <label class="form-label">Judul Quiz</label>
            <input type="text" name="judul" class="form-input" value="<?php echo htmlspecialchars($data['judul']); ?>" required>

            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-input" value="<?php echo htmlspecialchars($data['kategori']); ?>" required>

            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-input" style="height: 100px;" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
            
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label class="form-label">Waktu (Menit)</label>
                    <input type="number" name="waktu" class="form-input" value="<?php echo $data['waktu_pengerjaan']; ?>" required>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar" class="form-input" accept="image/*">
                    <small>File saat ini: <?php echo $data['gambar']; ?></small>
                </div>
            </div>

            <div class="form-buttons">
                <a href="kelola_quiz.php" class="btn-cancel">Batal</a>
                <button type="submit" name="simpan" class="btn-save">Simpan Perubahan</button>
            </div>

        </form>
    </main>
</div>
</body>
</html>