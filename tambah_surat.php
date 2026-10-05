<?php
session_start();
// Proteksi halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }

include 'includes/koneksi.php';

if (isset($_POST['simpan'])) {
    $no_agenda  = $_POST['no_agenda'];
    $no_surat   = $_POST['no_surat'];
    $tgl_surat  = $_POST['tgl_surat'];
    $tgl_terima = $_POST['tgl_terima'];
    $asal       = $_POST['asal_surat'];
    $perihal    = $_POST['perihal'];

    // Proses Upload File
    $file_name  = $_FILES['file_surat']['name'];
    $tmp_name   = $_FILES['file_surat']['tmp_name'];
    $ext        = pathinfo($file_name, PATHINFO_EXTENSION);
    
    // Nama file unik agar tidak bentrok (SM + timestamp + nama asli)
    $final_name = "SM_" . time() . "_" . $file_name;

    if (move_uploaded_file($tmp_name, "uploads/" . $final_name)) {
        $q = "INSERT INTO surat_masuk (no_agenda, no_surat, tgl_surat, tgl_terima, asal_surat, perihal, file_surat) 
              VALUES ('$no_agenda', '$no_surat', '$tgl_surat', '$tgl_terima', '$asal', '$perihal', '$final_name')";
        
        if (mysqli_query($conn, $q)) {
            // Gunakan JS agar tidak blank page setelah simpan
            echo "<script>
                    alert('Surat Berhasil Diarsipkan!'); 
                    window.location.href='surat_masuk.php';
                  </script>";
        } else { 
            echo "Error Database: " . mysqli_error($conn); 
        }
    } else {
        echo "<script>alert('Gagal upload file! Pastikan folder uploads sudah ada.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Masuk | E-Arsip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; }
        .card { border-radius: 20px; }
        .form-control:focus { border-color: #198754; box-shadow: 0 0 0 0.25 cold-purple; }
    </style>
</head>
<body class="py-5">
    <div class="container" style="max-width: 750px;">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h4 class="fw-bold text-success mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Surat Masuk
                </h4>
                <a href="dashboard.php" class="btn-close" aria-label="Close"></a>
            </div>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">No. Agenda</label>
                        <input type="text" name="no_agenda" class="form-control" placeholder="Contoh: 001/SM" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">No. Surat</label>
                        <input type="text" name="no_surat" class="form-control" placeholder="Nomor Resmi Surat" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Surat</label>
                        <input type="date" name="tgl_surat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Terima</label>
                        <input type="date" name="tgl_terima" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Asal Surat</label>
                    <input type="text" name="asal_surat" class="form-control" placeholder="Instansi Pengirim" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Perihal</label>
                    <textarea name="perihal" class="form-control" rows="3" placeholder="Ringkasan isi surat..." required></textarea>
                </div>

                <div class="mb-4 p-3 bg-light rounded border">
                    <label class="form-label fw-bold small text-muted text-uppercase">
                        <i class="fas fa-file-upload me-1"></i>Upload Berkas (PDF/Gambar)
                    </label>
                    <input type="file" name="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    <div class="form-text small text-info italic">Format yang didukung: PDF, JPG, PNG</div>
                </div>

                <div class="row g-2">
                    <div class="col-8">
                        <button name="simpan" class="btn btn-success w-100 fw-bold py-2 rounded-pill shadow">
                            <i class="fas fa-save me-1"></i> SIMPAN ARSIP
                        </button>
                    </div>
                    <div class="col-4">
                        <a href="dashboard.php" class="btn btn-outline-secondary w-100 py-2 rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> BATAL
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>