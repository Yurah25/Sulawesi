<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

$id = $_GET['id'];
$quiz_id = $_GET['quiz_id']; 
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM soal_quiz WHERE id='$id'"));

if (isset($_POST['simpan'])) {
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $opsi_a = mysqli_real_escape_string($conn, $_POST['opsi_a']);
    $opsi_b = mysqli_real_escape_string($conn, $_POST['opsi_b']);
    $opsi_c = mysqli_real_escape_string($conn, $_POST['opsi_c']);
    $opsi_d = mysqli_real_escape_string($conn, $_POST['opsi_d']);
    $jawaban = $_POST['jawaban_benar'];

    $query = "UPDATE soal_quiz SET 
              pertanyaan='$pertanyaan', 
              opsi_a='$opsi_a', opsi_b='$opsi_b', opsi_c='$opsi_c', opsi_d='$opsi_d', 
              jawaban_benar='$jawaban' 
              WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_soal.php?id=$quiz_id");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Soal</title>
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
        <h1>Edit Soal</h1>
        
        <form action="" method="post" class="form-card">
            
            <label class="form-label">Pertanyaan</label>
            <textarea name="pertanyaan" class="form-input" style="height: 100px;" required><?php echo $data['pertanyaan']; ?></textarea>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label class="form-label">Opsi A</label>
                    <input type="text" name="opsi_a" class="form-input" value="<?php echo $data['opsi_a']; ?>" required>
                </div>
                <div>
                    <label class="form-label">Opsi B</label>
                    <input type="text" name="opsi_b" class="form-input" value="<?php echo $data['opsi_b']; ?>" required>
                </div>
                <div>
                    <label class="form-label">Opsi C</label>
                    <input type="text" name="opsi_c" class="form-input" value="<?php echo $data['opsi_c']; ?>" required>
                </div>
                <div>
                    <label class="form-label">Opsi D</label>
                    <input type="text" name="opsi_d" class="form-input" value="<?php echo $data['opsi_d']; ?>" required>
                </div>
            </div>

            <label class="form-label" style="margin-top: 20px;">Kunci Jawaban</label>
            <select name="jawaban_benar" class="form-input" required>
                <option value="A" <?php if($data['jawaban_benar']=='A') echo 'selected'; ?>>A</option>
                <option value="B" <?php if($data['jawaban_benar']=='B') echo 'selected'; ?>>B</option>
                <option value="C" <?php if($data['jawaban_benar']=='C') echo 'selected'; ?>>C</option>
                <option value="D" <?php if($data['jawaban_benar']=='D') echo 'selected'; ?>>D</option>
            </select>

            <div class="form-buttons">
                <a href="kelola_soal.php?id=<?php echo $quiz_id; ?>" class="btn-cancel">Batal</a>
                <button type="submit" name="simpan" class="btn-save">Simpan Perubahan</button>
            </div>

        </form>
    </main>
</div>
</body>
</html>