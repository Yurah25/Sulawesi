<?php
include 'config/database.php';

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
                <li><a href="#">Quiz</a></li>
            </ul>
        </nav>
        <a href="login.php">Login</a>
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