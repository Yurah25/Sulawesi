<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$where_clause = "";
if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
    $where_clause = "WHERE judul LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
}
$query = mysqli_query($conn, "SELECT * FROM artikel $where_clause ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Artikel - Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="container">
    
    <main class="main-content">
        <header>
            <h1>Kelola Artikel</h1>
            <div class="user-wrapper">
                <i class='bx bxs-user-circle icon-profile'></i>
                <div>
                    <h4><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>
        <aside class="sidebar">
            <div class="logo">
                <h2>Sulapedia</h2>
                <span>Dashboard Admin</span>
            </div>

            <ul class="menu">
                <li><a href="dashboard.php"><i class='bx bxs-dashboard'></i> <span>Dashboard</span></a></li>
                <li><a href="kelola_artikel.php" class="active"><i class='bx bxs-file-doc'></i> <span>Kelola Artikel</span></a></li>
                <li><a href="#"><i class='bx bx-clipboard'></i> <span>Kelola Quiz</span></a></li>
                <li><a href="#"><i class='bx bx-group'></i> <span>Peserta Quiz</span></a></li>
            </ul>

            <div class="logout">
                <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')"><i class='bx bx-log-out'></i><span>Logout</span></a>
            </div>
        </aside>

        <div class="toolbar">
            <form action="" method="GET" style="flex: 1; display: flex;">
                <input type="text" name="cari" class="search-input" placeholder="Cari artikel..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
            </form>
            <a href="tambah_artikel.php" class="btn-add">
                <i class='bx bx-plus'></i> Tambah Artikel
            </a>
        </div>

        <div class="table-container">
            <h2 class="table-title">Daftar Artikel</h2>
            
            <table class="styled-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if(mysqli_num_rows($query) > 0){
                        while($row = mysqli_fetch_assoc($query)){ 
                            $tanggal = $row['tanggal'] ? date('d-m-Y', strtotime($row['tanggal'])) : '-';
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                        <td><?php echo $tanggal; ?></td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="../detail.php?id=<?php echo $row['id']; ?>" target="_blank" class="action-btn btn-view" title="Lihat"><i class='bx bx-show'></i></a>
                                <a href="edit_artikel.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit" title="Edit"><i class='bx bx-edit'></i></a>
                                <a href="hapus_Artikel.php?id=<?php echo $row['id']; ?>&gambar=<?php echo $row['gambar']; ?>" 
                                   class="action-btn btn-del" 
                                   onclick="return confirm('Yakin ingin menghapus artikel ini?')" title="Hapus">
                                    <i class='bx bx-trash'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center; padding: 20px;'>Tidak ada data artikel.</td></tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

</body>
</html>