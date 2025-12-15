<?php
include 'config/database.php';
session_start();

$id = isset($_GET['id']) ? $_GET['id'] : '';

if(!$id) {
    header("Location: jelajah.php");
    exit;
}

$query = "SELECT * FROM artikel WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if(!$row) {
    echo "Artikel tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail - <?php echo $row['judul']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/jelajah.css">
    <link rel="stylesheet" href="assets/css/detail.css">
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
    <main>
        <div class="title-container">
            <h1><?php echo $row['judul']; ?></h1>
        </div>

        <div class="content-card">
            <div class="content-img">
                <img src="assets/img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>">
            </div>
            <div class="content-text">
                <p>
                    <strong><?php echo $row['judul']; ?></strong> 
                    <?php echo nl2br($row['deskripsi']); ?>
                </p>
            </div>
        </div>

        <div class="related-section">
            <div class="related-header">
                <a href="jelajah.php" class="see-more">Lihat Lainnya &rarr;</a>
            </div>
            
            <div class="related-grid">
                <?php
                $query_lain = "SELECT * FROM artikel WHERE id != '$id' LIMIT 4";
                $result_lain = mysqli_query($conn, $query_lain);
                
                while($other = mysqli_fetch_assoc($result_lain)) {
                ?>
                <div class="related-card">
                    <div class="related-img">
                        <img src="assets/img/<?php echo $other['gambar']; ?>" alt="<?php echo $other['judul']; ?>">
                    </div>
                    <div class="related-content">
                        <h3><?php echo $other['judul']; ?></h3>
                        <p><?php echo substr($other['deskripsi'], 0, 90) . '...'; ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
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