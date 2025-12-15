<?php
session_start();
include '../config/database.php';
if ($_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM artikel WHERE id='$id'"));

if(isset($_POST['simpan'])){
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if($_FILES['gambar']['name'] != ""){
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $nama_baru = date('dmYHis').$gambar;
        move_uploaded_file($tmp, "../assets/img/".$nama_baru);
        
        unlink("../assets/img/".$data['gambar']);
    } else {
        $nama_baru = $data['gambar'];
    }

    $query = "UPDATE artikel SET judul='$judul', kategori='$kategori', deskripsi='$deskripsi', gambar='$nama_baru' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Perubahan Disimpan!'); window.location='kelola_artikel.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
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
                <li><a href="dashboard.php" ><i class='bx bxs-dashboard'></i> <span>Dashboard</span></a></li>
                <li><a href="kelola_artikel.php" class="active"><i class='bx bxs-file-doc'></i> <span>Kelola Artikel</span></a></li>
                <li><a href="#"><i class='bx bx-clipboard'></i> <span>Kelola Quiz</span></a></li>
                <li><a href="#"><i class='bx bx-group'></i> <span>Peserta Quiz</span></a></li>
            </ul>

            <div class="logout">
                <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')"><i class='bx bx-log-out'></i><span>Logout</span></a>
            </div>
        </aside>
    <main class="main-content">
        <h1 style="margin-bottom:20px;">Edit Artikel</h1>
        
        <form action="" method="post" enctype="multipart/form-data" class="form-card">
            
            <label class="form-label">Judul Artikel</label>
            <input type="text" name="judul" class="form-input" value="<?php echo $data['judul']; ?>" required>

            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-input" value="<?php echo $data['kategori']; ?>" required>

            <label class="form-label">Konten Artikel</label>
            <textarea name="deskripsi" class="form-input" style="height:150px;" required><?php echo $data['deskripsi']; ?></textarea>

            <label class="form-label">Gambar (Biarkan kosong jika tidak diganti)</label>
            <input type="file" name="gambar" class="form-input">
            <small>Gambar saat ini: <?php echo $data['gambar']; ?></small>

            <div class="form-buttons">
                <a href="kelola_artikel.php" class="btn-cancel">Batal</a>
                <button type="submit" name="simpan" class="btn-save">Simpan Perubahan</button>
            </div>

        </form>
    </main>
</div>
</body>
</html>