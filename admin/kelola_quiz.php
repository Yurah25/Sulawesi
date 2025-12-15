<?php
session_start();
include '../config/database.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Pencarian
$where = "";
if(isset($_GET['cari'])){
    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
    $where = "WHERE judul LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
}

$query = mysqli_query($conn, "SELECT * FROM daftar_quiz $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Quiz - Admin</title>
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
        <header>
            <h1>Kelola Quiz</h1>
            <div class="user-wrapper">
                <i class='bx bxs-user-circle icon-profile'></i>
                <div>
                    <h4><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <div class="toolbar">
            <form action="" method="GET" style="flex: 1; display:flex;">
                <input type="text" name="cari" class="search-input" placeholder="Cari quiz..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
            </form>
            <a href="tambah_quiz.php" class="btn-add" style="background-color: #3A4D39;">
                <i class='bx bx-plus'></i> Buat Quiz Baru
            </a>
        </div>

        <div class="quiz-grid">
            <?php 
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){ 
                    $quiz_id = $row['id'];
                    
                    // Hitung Jumlah Soal
                    $q_soal = mysqli_query($conn, "SELECT COUNT(*) as total FROM soal_quiz WHERE quiz_id='$quiz_id'");
                    $jml_soal = mysqli_fetch_assoc($q_soal)['total'];

                    // Hitung Jumlah Pemain (Dari tabel scores)
                    $q_pemain = mysqli_query($conn, "SELECT COUNT(DISTINCT user_id) as total FROM scores WHERE quiz_id='$quiz_id'");
                    $jml_pemain = mysqli_fetch_assoc($q_pemain)['total'];
            ?>
            
            <div class="quiz-card">
                <div class="quiz-header">
                    <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 80) . '...'; ?></p>
                </div>
                
                <div class="quiz-img-wrapper">
                    <img src="../assets/img/<?php echo $row['gambar']; ?>" alt="Cover Quiz">
                </div>

                <div class="quiz-meta">
                    <span><i class='bx bx-list-ul'></i> <?php echo $jml_soal; ?> Soal</span>
                    <span><i class='bx bx-user'></i> <?php echo $jml_pemain; ?> Pemain</span>
                </div>

                <div class="quiz-actions">
                    <a href="kelola_soal.php?id=<?php echo $row['id']; ?>" class="btn-atur-soal">
                        <i class='bx bx-slider-alt'></i> Atur Soal
                    </a>
                    
                    <a href="edit_quiz.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit" title="Edit Quiz">
                        <i class='bx bx-edit'></i>
                    </a>
                    
                    <a href="hapus_quiz.php?id=<?php echo $row['id']; ?>&gambar=<?php echo $row['gambar']; ?>" 
                       class="action-btn btn-del" onclick="return confirm('Hapus Quiz ini beserta seluruh soalnya?')" title="Hapus">
                        <i class='bx bx-trash'></i>
                    </a>
                </div>
            </div>

            <?php 
                }
            } else {
                echo "<p style='grid-column: 1/-1; text-align:center;'>Belum ada quiz yang dibuat.</p>";
            } 
            ?>
        </div>

    </main>
</div>

</body>
</html>