<?php
session_start();
include 'config/database.php';

$query = "SELECT * FROM daftar_quiz";
$result = mysqli_query($conn, $query);
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
        
        <a href="#" class="user-btn">
            <img src="assets/img/user-icon.svg" alt="" style="width:20px; vertical-align:middle; margin-right:5px;"> User
        </a>

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
                    $persen = ($row['skor_user'] / $row['total_soal']) * 100;
            ?>
            <div class="quiz-card">
                <div class="card-top">
                    <h2>Quiz <?php echo $row['skor_user']; ?>/<?php echo $row['total_soal']; ?></h2>
                </div>
                
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?php echo $persen; ?>%;"></div>
                </div>

                <div class="card-bottom">
                    <span class="category-pill"><?php echo $row['kategori']; ?></span>
                    <a href="play_quiz.php?id=<?php echo $row['id']; ?>" class="start-btn">Mulai</a>
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