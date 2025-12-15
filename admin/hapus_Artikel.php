<?php
session_start();
include '../config/database.php';

if($_SESSION['role'] == 'admin' && isset($_GET['id'])){
    $id = $_GET['id'];
    $gambar = $_GET['gambar'];

    if(file_exists("../assets/img/".$gambar)){
        unlink("../assets/img/".$gambar);
    }
    mysqli_query($conn, "DELETE FROM artikel WHERE id='$id'");
    
    header("Location: kelola_artikel.php");
} else {
    header("Location: ../index.php");
}
?>