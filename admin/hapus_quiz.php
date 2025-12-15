<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $q_img = mysqli_query($conn, "SELECT gambar FROM daftar_quiz WHERE id='$id'");
    $row = mysqli_fetch_assoc($q_img);
    if($row && $row['gambar'] != ""){
        $path = "../assets/img/" . $row['gambar'];
        if(file_exists($path)) unlink($path);
    }

    mysqli_query($conn, "DELETE FROM soal_quiz WHERE quiz_id='$id'");
    mysqli_query($conn, "DELETE FROM scores WHERE quiz_id='$id'");
    
    if (mysqli_query($conn, "DELETE FROM daftar_quiz WHERE id='$id'")) {
        echo "<script>alert('Quiz berhasil dihapus!'); window.location='kelola_quiz.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus.'); window.location='kelola_quiz.php';</script>";
    }
}
?>