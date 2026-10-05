<?php
include 'includes/koneksi.php';
$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_surat FROM surat_masuk WHERE id=$id"));
if(file_exists("uploads/".$d['file_surat'])) { unlink("uploads/".$d['file_surat']); }
mysqli_query($conn, "DELETE FROM surat_masuk WHERE id=$id");
echo "<script>window.location='surat_masuk.php';</script>";
?>