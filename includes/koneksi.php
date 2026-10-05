<?php
$host = "sql12.freesqldatabase.com";
$user = "sql12838360";
$pass = "UtwsLQVgTJ";
$db   = "sql12838360";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) { 
    die("Koneksi gagal: " . mysqli_connect_error()); 
}

// Aktifkan laporan error agar tidak blank page
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>