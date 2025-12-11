<?php include("config/database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda-SulaPedia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <Link rel="stylesheet" type="text/css" href="assets/css/indexpage.css">
</head>
<body>
    <div class="body">
    <header>
        <p>SulaPedia</p>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="jelajah.php">Jelajahi</a></li>
                <li><a href="#">quiz</a></li>
            </ul>
        </nav>
        <a href="login.php">Login</a>
    </header>
    <main>
        <section class="hero">
            <div class="pulau">
                <img src="/assets/img/pulau sulawesi.png" alt="pulau k">
                <div class="text-pulau">
                    <h1>Selamat datang di Sulapedia</h1>
                    <P>Hi,</P>
                    <p>Mulai Petualanganmu di Sulawesi</p>
                </div>
            </div>
        </section>
        <section class="artikel">
            <h1>Artikel</h1>
    
             <div class="headerartikel">
                <a href="jelajah.php" class="link-next">Lihat Selanjutnya &rarr;</a>
            </div>

            <div class="artikelkontainernya">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM artikel LIMIT 6");
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){
            ?>
                <div class="card">
                    <img src="assets/img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>">
                
                    <div class="isi_card">
                        <h3><?php echo $row['judul']; ?></h3>
                        <p><?php echo substr($row['deskripsi'], 0, 120) . '...'; ?></p>
                    
                        <a href="detail.php?id=<?php echo $row['id']; ?>" class="detail">Lihat Detail</a>
                    </div>
                </div>
            <?php 
                }
            }
        ?>
    </div>
</section>
        <section class="about">
            <h1>About Us</h1>
            <div class="kontak-all">
                <div class="card-tim">
                    <img src="assets/img/4x6.jpg" alt="yusuf">
                    <h1>Yusuf Rafii Ahmad</h1>
                    <p>H1D024049</p>
                </div>
                <div class="card-tim">
                    <img src="assets/img/pulau sulawesi.png" alt="Nayli">
                    <h1>Nayli Ghassaniy L. N.</h1>
                    <p>H1D024058</p>
                </div>
                <div class="card-tim">
                    <img src="assets/img/pulau sulawesi.png" alt="Inas">
                    <h1>M. Inas Pratama</h1>
                    <p>H1D024063</p>
                </div>
            </div>
        </section>
    </main>
    </div>
    <?php include("includes/footer.php/footer.php") ?>
</body>
</html>