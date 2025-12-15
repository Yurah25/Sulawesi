<?php
session_start();
include 'config/database.php';

$query = "SELECT * FROM daftar_quiz ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$user_id = null;
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    $sess_username = $_SESSION['username'];
    $q_user = mysqli_query($conn, "SELECT id FROM users WHERE username = '$sess_username'");
    if($row_u = mysqli_fetch_assoc($q_user)){
        $user_id = $row_u['id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - SulaPedia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/jelajah.css">
    <link rel="stylesheet" href="assets/css/quiz.css">
</head>
<body>
    <div class="body">
    <header>
        <p>SulaPedia</p>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="jelajah.php">Jelajahi</a></li>
                <li><a href="quiz.php">Quiz</a></li>
            </ul>
        </nav>
        
        <div class="auth-buttons">
            <?php if(isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
                <span style="margin-right: 10px; font-weight: 500;">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" style="background-color: #8B0000; color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 14px;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="background-color: #49574A; color: #FEFAE0; padding: 8px 20px; border-radius: 20px; text-decoration: none; font-weight: bold;">Login</a>
            <?php endif; ?>
            </div>

        <div class="hamburger-menu" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <main class="quiz-page">
        <div class="quiz-header-text">
            <h1>Ayo Mulai Quiz</h1>
            <p>Tingkatkan Pemahamanmu Tentang Sulawesi!</p>
        </div>

        <div class="quiz-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $quiz_id = $row['id'];
        
                    $q_soal = mysqli_query($conn, "SELECT count(*) as total FROM soal_quiz WHERE quiz_id='$quiz_id'");
                    $total_soal = mysqli_fetch_assoc($q_soal)['total'];
                    if($total_soal == 0) $total_soal = 1; 
                        $persen = 0;
                        $status_main = "Mulai";
        
                    if($user_id != null){
                        $q_skor = mysqli_query($conn, "SELECT nilai FROM scores WHERE quiz_id='$quiz_id' AND user_id='$user_id' ORDER BY id DESC LIMIT 1");
                            if(mysqli_num_rows($q_skor) > 0){
                                $d_skor = mysqli_fetch_assoc($q_skor);
                                $persen = $d_skor['nilai'];
                                $status_main = "Main Lagi";
            }
        }
        ?>
            <div class="quiz-card">
            <div class="card-top">
                <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                <p style="font-size: 12px; color: #fff; margin-top: 5px;">
                    <?php echo $row['waktu_pengerjaan']; ?> Menit | <?php echo $total_soal; ?> Soal
                </p>
            </div>
            
            <div class="progress-container">
                <div class="progress-bar" style="width: <?php echo $persen; ?>%;"></div>
            </div>

            <div class="card-bottom">
                <span class="category-pill"><?php echo $row['kategori']; ?></span>
                
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
                    <a href="play_quiz.php?id=<?php echo $row['id']; ?>" class="start-btn"><?php echo $status_main; ?></a>
                <?php else: ?>
                    <a href="login.php" onclick="return confirm('Silakan login dulu!')" class="start-btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
        <?php 
                } 
            } else {
                echo "<p style='text-align:center;'>Belum ada quiz tersedia.</p>";
            }
            ?>
        </div>
    </main>
   </div>
    <?php include("includes/footer.php/footer.php"); ?>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.nav-links');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>