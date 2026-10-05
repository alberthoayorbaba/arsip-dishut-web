<?php
session_start();
include 'includes/koneksi.php';

// 1. Ambil ID dari URL
if (!isset($_GET['id'])) { header("Location: surat_masuk.php"); exit; }
$id = $_GET['id'];

// 2. Ambil data lama dari database
$query = mysqli_query($conn, "SELECT * FROM surat_masuk WHERE id=$id");
$d = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$d) { echo "Data tidak ditemukan!"; exit; }

// 3. Proses Update saat tombol diklik
if (isset($_POST['update'])) {
    $no_agenda  = $_POST['no_agenda'];
    $no_surat   = $_POST['no_surat'];
    $tgl_surat  = $_POST['tgl_surat'];
    $tgl_terima = $_POST['tgl_terima'];
    $asal       = $_POST['asal_surat'];
    $perihal    = $_POST['perihal'];

    // Logika Ganti File
    if ($_FILES['file_surat']['name'] != "") {
        // Hapus file lama jika ada
        if (file_exists("uploads/" . $d['file_surat'])) {
            unlink("uploads/" . $d['file_surat']);
        }
        // Upload file baru
        $final_name = "SM_" . time() . "_" . $_FILES['file_surat']['name'];
        move_uploaded_file($_FILES['file_surat']['tmp_name'], "uploads/" . $final_name);
    } else {
        // Tetap pakai file lama
        $final_name = $d['file_surat'];
    }

    // Query Update semua kolom
    $update = mysqli_query($conn, "UPDATE surat_masuk SET 
                no_agenda='$no_agenda', 
                no_surat='$no_surat', 
                tgl_surat='$tgl_surat', 
                tgl_terima='$tgl_terima', 
                asal_surat='$asal', 
                perihal='$perihal', 
                file_surat='$final_name' 
                WHERE id=$id");

    if ($update) {
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='surat_masuk.php';</script>";
    } else {
        echo "Gagal Update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Surat Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container bg-white p-4 shadow-sm rounded" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-success">Edit Data Surat Masuk</h4>
            <a href="surat_masuk.php" class="btn btn-secondary btn-sm">Batal</a>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">No. Agenda</label>
                    <input type="text" name="no_agenda" class="form-control" value="<?= $d['no_agenda']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">No. Surat</label>
                    <input type="text" name="no_surat" class="form-control" value="<?= $d['no_surat']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal Surat</label>
                    <input type="date" name="tgl_surat" class="form-control" value="<?= $d['tgl_surat']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal Terima</label>
                    <input type="date" name="tgl_terima" class="form-control" value="<?= $d['tgl_terima']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Asal Surat</label>
                <input type="text" name="asal_surat" class="form-control" value="<?= $d['asal_surat']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Perihal</label>
                <textarea name="perihal" class="form-control" rows="3"><?= $d['perihal']; ?></textarea>
            </div>

            <div class="mb-4 p-3 border rounded bg-light">
                <label class="form-label d-block fw-bold">Berkas (PDF/Gambar)</label>
                <small class="text-muted">File saat ini: <a href="uploads/<?= $d['file_surat']; ?>" target="_blank"><?= $d['file_surat']; ?></a></small>
                <input type="file" name="file_surat" class="form-control mt-2">
                <small class="text-danger">*Kosongkan jika tidak ingin mengganti file.</small>
            </div>

            <button name="update" class="btn btn-success w-100 fw-bold">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</body>
</html>