
<?php
include 'config/database.php';

$where_clause = "";
$kategori_terpilih = "";

if (isset($_GET['kategori'])) {
    $kategori_terpilih = $_GET['kategori'];
    $kat_safe = mysqli_real_escape_string($koneksi, $kategori_terpilih);
    $where_clause = "WHERE kategori = '$kat_safe'";
}

$query = "SELECT * FROM artikel $where_clause";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajah-page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <Link rel="stylesheet" type="text/css" href="assets/css/jelajah.css">
</head>
<body>
    <div class="body">
    <header>
        <p>SulaPedia</p>
        <nav>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="jelajah.php">Jelajahi</a></li>
                <li><a href="#">quiz</a></li>
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
    <h1 class="page-title">Jelajahi Sulawesi</h1>
    
    <div class="filter-container">
        <form action="" method="GET" class="search-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="keyword" placeholder="Search" autocomplete="off" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword']; } ?>">
        </form>

        <div class="categories">
            <a href="?kategori=Budaya" class="cat-btn">Budaya</a>
            <a href="?kategori=Kuliner" class="cat-btn">Kuliner</a>
            <a href="?kategori=Wisata Alam" class="cat-btn">Wisata Alam</a>
            <a href="?kategori=Sulawesi Utara" class="cat-btn">Sulawesi Utara</a>
            <a href="?kategori=Sulawesi Selatan" class="cat-btn">Sulawesi Selatan</a>
            <a href="?kategori=Sulawesi Tengah" class="cat-btn">Sulawesi Tengah</a>
            <a href="?kategori=Sulawesi Tenggara" class="cat-btn">Sulawesi Tenggara</a>
            <a href="?kategori=Sulawesi Barat" class="cat-btn">Sulawesi Barat</a>
            <a href="?kategori=Gorontalo" class="cat-btn">Gorontalo</a>
        </div>
    </div>

    <div class="artikel-grid">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="card">
                <div class="card-img-wrapper">
                    <img src="assets/img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>">
                </div>
                <div class="card-content">
                    <h3><?php echo $row['judul']; ?></h3>
                    <p><?php echo substr($row['deskripsi'], 0, 90) . '...'; ?></p>
                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<p style='text-align:center; width: 100%; grid-column: 1/-1;'>Data tidak ditemukan.</p>";
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