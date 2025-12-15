<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

if (!isset($_GET['quiz_id'])) { header("Location: kelola_quiz.php"); exit; }
$quiz_id = $_GET['quiz_id'];
if (isset($_POST['simpan'])) {
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $opsi_a = mysqli_real_escape_string($conn, $_POST['opsi_a']);
    $opsi_b = mysqli_real_escape_string($conn, $_POST['opsi_b']);
    $opsi_c = mysqli_real_escape_string($conn, $_POST['opsi_c']);
    $opsi_d = mysqli_real_escape_string($conn, $_POST['opsi_d']);
    $jawaban = $_POST['jawaban_benar'];

    $query = "INSERT INTO soal_quiz (quiz_id, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) 
              VALUES ('$quiz_id', '$pertanyaan', '$opsi_a', '$opsi_b', '$opsi_c', '$opsi_d', '$jawaban')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: kelola_soal.php?id=$quiz_id");
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal</title>
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
        <h1>Tambah Soal Baru</h1>
        
        <form action="" method="post" class="form-card">
            
            <label class="form-label">Pertanyaan</label>
            <textarea name="pertanyaan" class="form-input" style="height: 100px;" placeholder="Masukkan pertanyaan..." required></textarea>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label class="form-label">Opsi A</label>
                    <input type="text" name="opsi_a" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Opsi B</label>
                    <input type="text" name="opsi_b" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Opsi C</label>
                    <input type="text" name="opsi_c" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Opsi D</label>
                    <input type="text" name="opsi_d" class="form-input" required>
                </div>
            </div>

            <label class="form-label" style="margin-top: 20px;">Kunci Jawaban</label>
            <select name="jawaban_benar" class="form-input" required>
                <option value="">-- Pilih Jawaban Benar --</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <div class="form-buttons">
                <a href="kelola_soal.php?id=<?php echo $quiz_id; ?>" class="btn-cancel">Batal</a>
                <button type="submit" name="simpan" class="btn-save">Simpan Soal</button>
            </div>

        </form>
    </main>
</div>
</body>
</html>