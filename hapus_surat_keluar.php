<?php
include 'includes/koneksi.php';
$id = $_GET['id'];

// Ambil nama file dari DB
$query = mysqli_query($conn, "SELECT file_surat FROM surat_keluar WHERE id = $id");
$data = mysqli_fetch_assoc($query);
$nama_file = $data['file_surat'];

// Hapus file fisik
if (file_exists("uploads/" . $nama_file)) {
    unlink("uploads/" . $nama_file);
}

// Hapus data dari database
mysqli_query($conn, "DELETE FROM surat_keluar WHERE id = $id");

header("Location: surat_keluar.php");
?>