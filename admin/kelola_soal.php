<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

if (!isset($_GET['id'])) { header("Location: kelola_quiz.php"); exit; }
$quiz_id = $_GET['id'];

$q_info = mysqli_query($conn, "SELECT * FROM daftar_quiz WHERE id='$quiz_id'");
$info = mysqli_fetch_assoc($q_info);

$q_soal = mysqli_query($conn, "SELECT * FROM soal_quiz WHERE quiz_id='$quiz_id' ORDER BY id ASC");
$total_soal = mysqli_num_rows($q_soal);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Atur Soal - <?php echo $info['judul']; ?></title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
        <div style="margin-bottom: 20px;">
            <a href="kelola_quiz.php" class="btn-cancel" style="display:inline-block; width:auto; padding: 8px 20px;">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>

        <header>
            <h1>Kelola Soal</h1>
        </header>

        <div class="split-layout">
            
            <div class="quiz-info-card">
                <h3>Informasi Quiz</h3>
                
                <div class="info-group">
                    <label>Judul Quiz</label>
                    <p><?php echo $info['judul']; ?></p>
                </div>
                
                <div class="info-group">
                    <label>Kategori</label>
                    <p><?php echo $info['kategori']; ?></p>
                </div>

                <div class="info-group">
                    <label>Waktu Pengerjaan</label>
                    <p><?php echo $info['waktu_pengerjaan']; ?> Menit</p>
                </div>

                <div class="info-group">
                    <label>Total Soal</label>
                    <p style="font-size: 32px; font-weight: 700;"><?php echo $total_soal; ?></p>
                </div>

                <div style="margin-top:20px;">
                    <img src="../assets/img/<?php echo $info['gambar']; ?>" style="width:100%; border-radius:10px; border:1px solid #000;">
                </div>
            </div>

            <div class="soal-list-container">
                <div class="soal-header">
                    <h2>Daftar Pertanyaan</h2>
                    <a href="tambah_soal.php?quiz_id=<?php echo $quiz_id; ?>" class="btn-add" style="background-color: #3A4D39;">
                        <i class='bx bx-plus'></i> Tambah Soal Baru
                    </a>
                </div>

                <?php 
                if($total_soal > 0){
                    $no = 1;
                    while($soal = mysqli_fetch_assoc($q_soal)){ 
                ?>
                <div class="soal-card">
                    <div class="soal-card-header">
                        <span><i class='bx bx-grid-vertical'></i> Soal <?php echo $no++; ?></span>
                        <div style="display:flex; gap:5px;">
                            <a href="edit_soal.php?id=<?php echo $soal['id']; ?>&quiz_id=<?php echo $quiz_id; ?>" class="action-btn btn-edit"><i class='bx bx-edit'></i></a>
                            <a href="hapus_soal.php?id=<?php echo $soal['id']; ?>&quiz_id=<?php echo $quiz_id; ?>" class="action-btn btn-del" onclick="return confirm('Hapus soal ini?')"><i class='bx bx-trash'></i></a>
                        </div>
                    </div>
                    <div class="soal-body">
                        <p class="pertanyaan-text"><?php echo $soal['pertanyaan']; ?></p>
                        
                        <div class="opsi-list">
                            <div class="opsi-item <?php echo ($soal['jawaban_benar'] == 'A') ? 'benar' : ''; ?>">
                                <span class="opsi-label">A</span>
                                <span><?php echo $soal['opsi_a']; ?></span>
                                <?php if($soal['jawaban_benar'] == 'A') echo "<i class='bx bx-check-circle' style='margin-left:auto;'></i>"; ?>
                            </div>
                            <div class="opsi-item <?php echo ($soal['jawaban_benar'] == 'B') ? 'benar' : ''; ?>">
                                <span class="opsi-label">B</span>
                                <span><?php echo $soal['opsi_b']; ?></span>
                                <?php if($soal['jawaban_benar'] == 'B') echo "<i class='bx bx-check-circle' style='margin-left:auto;'></i>"; ?>
                            </div>
                            <div class="opsi-item <?php echo ($soal['jawaban_benar'] == 'C') ? 'benar' : ''; ?>">
                                <span class="opsi-label">C</span>
                                <span><?php echo $soal['opsi_c']; ?></span>
                                <?php if($soal['jawaban_benar'] == 'C') echo "<i class='bx bx-check-circle' style='margin-left:auto;'></i>"; ?>
                            </div>
                            <div class="opsi-item <?php echo ($soal['jawaban_benar'] == 'D') ? 'benar' : ''; ?>">
                                <span class="opsi-label">D</span>
                                <span><?php echo $soal['opsi_d']; ?></span>
                                <?php if($soal['jawaban_benar'] == 'D') echo "<i class='bx bx-check-circle' style='margin-left:auto;'></i>"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    echo "<div style='text-align:center; padding:40px; background:#EAE7D6; border-radius:15px; border:1px dashed #000;'>Belum ada soal. Silakan tambah soal baru.</div>";
                }
                ?>

            </div>
        </div>

    </main>
</div>
</body>
</html>