<?php
session_start();
include '../config/database.php';

if (isset($_GET['id']) && $_SESSION['role'] == 'admin') {
    $id = $_GET['id'];
    $quiz_id = $_GET['quiz_id'];

    mysqli_query($conn, "DELETE FROM soal_quiz WHERE id='$id'");
    
    header("Location: kelola_soal.php?id=$quiz_id");
} else {
    header("Location: kelola_quiz.php");
}
?>