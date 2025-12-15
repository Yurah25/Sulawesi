<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../login.php?pesan=belum_login");
    exit;
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$query_artikel = mysqli_query($conn, "SELECT * FROM artikel");
$total_artikel = mysqli_num_rows($query_artikel);
$query_quiz = mysqli_query($conn, "SELECT * FROM daftar_quiz"); 
$total_quiz = mysqli_num_rows($query_quiz);

$query_user = mysqli_query($conn, "SELECT * FROM users WHERE role='user'");
$total_user = mysqli_num_rows($query_user);

$user_aktif = $total_user; 

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sulapedia</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <li><a href="dashboard.php" class="active"><i class='bx bxs-dashboard'></i> <span>Dashboard</span></a></li>
                <li><a href="kelola_artikel.php"><i class='bx bxs-file-doc'></i> <span>Kelola Artikel</span></a></li>
                <li><a href="#"><i class='bx bx-clipboard'></i> <span>Kelola Quiz</span></a></li>
                <li><a href="#"><i class='bx bx-group'></i> <span>Peserta Quiz</span></a></li>
            </ul>

            <div class="logout">
                <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')"><i class='bx bx-log-out'></i><span>Logout</span></a>
            </div>
        </aside>

        <main >
        <div class="main-content">
            <header>
                <h1>Dashboard</h1>
                <div class="user-wrapper">
                    <i class='bx bxs-user-circle icon-profile'></i>
                    <div>
                        <h4><?php echo $_SESSION['username']; ?></h4>
                        <small>Admin</small>
                    </div>
                </div>
            </header>

            <div class="cards">
                <div class="card-single">
                    <div class="icon-bg"><i class='bx bxs-file-doc'></i></div>
                    <div class="card-info">
                        <span>Total Artikel</span>
                        <h2><?php echo $total_artikel; ?></h2>
                    </div>
                </div>

                <div class="card-single">
                    <div class="icon-bg"><i class='bx bx-clipboard'></i></div>
                    <div class="card-info">
                        <span>Total Quiz</span>
                        <h2><?php echo $total_quiz; ?></h2>
                    </div>
                </div>

                <div class="card-single">
                    <div class="icon-bg"><i class='bx bx-group'></i></div>
                    <div class="card-info">
                        <span>Total User</span>
                        <h2><?php echo $total_user; ?></h2>
                    </div>
                </div>

                <div class="card-single">
                    <div class="icon-bg"><i class='bx bxs-user-check'></i></div>
                    <div class="card-info">
                        <span>User Aktif</span>
                        <h2><?php echo $user_aktif; ?></h2>
                    </div>
                </div>
            </div>
           </div> 
        </main>
    </div>

</body>
</html>