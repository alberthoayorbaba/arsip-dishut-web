<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'includes/koneksi.php';

if (isset($_POST['simpan'])) {
    $no_agenda  = $_POST['no_agenda'];
    $no_surat   = $_POST['no_surat'];
    $tgl_surat  = $_POST['tgl_surat'];
    $tujuan     = $_POST['tujuan_surat'];
    $perihal    = $_POST['perihal'];

    $file_name  = $_FILES['file_surat']['name'];
    $final_name = "SK_" . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES['file_surat']['tmp_name'], "uploads/" . $final_name)) {
        mysqli_query($conn, "INSERT INTO surat_keluar (no_agenda, no_surat, tgl_surat, tujuan_surat, perihal, file_surat) 
                             VALUES ('$no_agenda', '$no_surat', '$tgl_surat', '$tujuan', '$perihal', '$final_name')");
        echo "<script>alert('Berhasil!'); window.location='surat_keluar.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Surat Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 750px;">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h4 class="fw-bold text-warning mb-0"><i class="fas fa-paper-plane me-2"></i>Tambah Surat Keluar</h4>
                <a href="dashboard.php" class="btn-close"></a>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6"><label class="form-label fw-bold small text-muted">NO. AGENDA</label><input type="text" name="no_agenda" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label fw-bold small text-muted">NO. SURAT</label><input type="text" name="no_surat" class="form-control" required></div>
                </div>
                <div class="mb-3"><label class="form-label fw-bold small text-muted">TANGGAL SURAT</label><input type="date" name="tgl_surat" class="form-control" required></div>
                <div class="mb-3"><label class="form-label fw-bold small text-muted">TUJUAN SURAT</label><input type="text" name="tujuan_surat" class="form-control" placeholder="Contoh: Gubernur" required></div>
                <div class="mb-3"><label class="form-label fw-bold small text-muted">PERIHAL</label><textarea name="perihal" class="form-control" rows="3" required></textarea></div>
                <div class="mb-4 p-3 bg-light rounded border"><label class="form-label fw-bold small text-muted">UPLOAD BERKAS</label><input type="file" name="file_surat" class="form-control" required></div>
                <div class="row g-2">
                    <div class="col-8"><button name="simpan" class="btn btn-warning w-100 fw-bold py-2 rounded-pill shadow text-white">SIMPAN ARSIP</button></div>
                    <div class="col-4"><a href="dashboard.php" class="btn btn-outline-secondary w-100 py-2 rounded-pill">BATAL</a></div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>