<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kasir_apotek"; // Sesuai dengan database SQL kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Jakarta');
?>