<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$where = "";
if(isset($_GET['cari'])){
    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
   
    $where = "WHERE u.username LIKE '%$keyword%' OR u.email LIKE '%$keyword%' OR q.judul LIKE '%$keyword%'";
}


$query = "SELECT s.*, u.username, u.email, q.judul 
          FROM scores s 
          JOIN users u ON s.user_id = u.id 
          JOIN daftar_quiz q ON s.quiz_id = q.id 
          $where 
          ORDER BY s.tanggal_mengerjakan DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peserta Quiz - Admin</title>
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
                <li><a href="kelola_artikel.php"><i class='bx bxs-file-doc'></i> <span>Kelola Artikel</span></a></li>
                <li><a href="kelola_quiz.php"><i class='bx bx-clipboard'></i> <span>Kelola Quiz</span></a></li>
                <li><a href="peserta_quiz.php" class="active"><i class='bx bx-group'></i> <span>Peserta Quiz</span></a></li>
            </ul>

            <div class="logout">
                <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')"><i class='bx bx-log-out'></i><span>Logout</span></a>
            </div>
        </aside>

    <main class="main-content">
        <header>
            <h1>Peserta Quiz</h1>
            <div class="user-wrapper">
                <i class='bx bxs-user-circle icon-profile'></i>
                <div>
                    <h4><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <div class="toolbar" style="margin-bottom: 30px;">
            <form action="" method="GET" style="width: 100%;">
                <div style="position: relative;">
                    <i class='bx bx-search' style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #555;"></i>
                    <input type="text" name="cari" class="search-input" 
                           placeholder="Cari peserta..." 
                           value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>"
                           style="width: 100%; padding-left: 50px; background-color: #EEEAD3; border: 2px solid #000; border-radius: 50px; height: 50px;">
                </div>
            </form>
        </div>

        <div class="table-container" style="padding: 0; overflow: hidden;">
            <table class="styled-table">
                <thead>
                    <tr style="background-color: #96A78D;">
                        <th style="padding-left: 30px;">Peserta</th>
                        <th>Quiz</th>
                        <th>Skor</th>
                        <th>Persentase</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){ 
                            
                            // A. Hitung Total Soal Realtime
                            $quiz_id = $row['quiz_id'];
                            $q_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM soal_quiz WHERE quiz_id='$quiz_id'");
                            $total_soal = mysqli_fetch_assoc($q_total)['total'];
                            
                    
                            if($total_soal == 0) $total_soal = 10; 
                            $persentase = $row['nilai']; 
                        
                            $jawaban_benar = round(($persentase / 100) * $total_soal);
                            $inisial = strtoupper(substr($row['username'], 0, 1));
                            
                            $tanggal = date('d M', strtotime($row['tanggal_mengerjakan']));
                    ?>
                    <tr>
                        <td style="padding-left: 30px;">
                            <div class="user-cell">
                                <div class="avatar-circle"><?php echo $inisial; ?></div>
                                <div class="user-info">
                                    <h4><?php echo htmlspecialchars($row['username']); ?></h4>
                                    <span><?php echo htmlspecialchars($row['email']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="quiz-badge"><?php echo htmlspecialchars($row['judul']); ?></span>
                        </td>
                        <td style="font-weight: 600;">
                            <?php echo $jawaban_benar . "/" . $total_soal; ?>
                        </td>
                        <td>
                            <div class="progress-wrapper">
                                <div class="progress-track-mini">
                                    <div class="progress-fill-mini" style="width: <?php echo $persentase; ?>%;"></div>
                                </div>
                                <span class="percent-text"><?php echo $persentase; ?>%</span>
                            </div>
                        </td>
                        <td style="color: #555; font-weight: 500;">
                            <?php echo $tanggal; ?>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center; padding:30px;'>Belum ada peserta yang mengerjakan quiz.</td></tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>

    </main>
</div>
</body>
</html>