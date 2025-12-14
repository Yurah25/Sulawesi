<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_sulapedia";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo ("Koneksi gagal: " );
}
?>