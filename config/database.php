<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sulawesi";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo ("Koneksi gagal: " );
}
?>