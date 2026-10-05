<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'includes/koneksi.php';

// Ambil jumlah data untuk statistik
$jml_masuk = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM surat_masuk"));
$jml_keluar = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM surat_keluar"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | E-Arsip Digital Dishut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f3; color: #2d3436; }
        
        /* Navbar dengan Gradasi Hijau Hutan & Aksen Kuning */
        .navbar { 
            background: linear-gradient(135deg, #004d40 0%, #00796b 100%) !important; 
            border-bottom: 4px solid #ffc107;
            padding: 15px 0;
        }
        
        /* Card Stats yang Lebih Dinamis */
        .card-stats { 
            border: none; 
            border-radius: 20px; 
            transition: all 0.3s ease; 
            background: #ffffff;
        }
        .card-stats:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        
        /* Icon Box Styles */
        .icon-box { 
            width: 65px; 
            height: 65px; 
            border-radius: 18px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 26px; 
            transition: 0.3s;
        }
        .bg-custom-1 { background-color: #e0f2fe; color: #0369a1; } /* Blue */
        .bg-custom-2 { background-color: #fef3c7; color: #92400e; } /* Orange/Yellow */
        .bg-custom-3 { background-color: #dcfce7; color: #166534; } /* Green */

        /* Jumbotron/Welcome Box */
        .hero-section {
            background: #ffffff;
            border-radius: 25px;
            border-left: 8px solid #004d40;
        }

        .welcome-text { font-weight: 800; letter-spacing: -0.5px; color: #1a1a1a; }
        
        .btn-custom {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-success-custom {
            background-color: #004d40;
            border: none;
            color: white;
        }
        .btn-success-custom:hover {
            background-color: #00695c;
            transform: scale(1.05);
            color: white;
        }

        /* Animasi berdenyut untuk peringatan hosting */
        @keyframes denyut {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
            50% { transform: scale(1.01); box-shadow: 0 0 0 8px rgba(255, 193, 7, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
        }

        .alert-animasi {
            animation: denyut 2s infinite ease-in-out;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/logo.png" alt="Logo" width="45" class="me-3"> 
            <div>
                <span class="d-block fw-bold mb-0" style="letter-spacing: 1px;">E-ARSIP DIGITAL</span>
                <small style="font-size: 10px; opacity: 0.9; text-transform: uppercase;">Dinas Kehutanan Prov. Papua Barat</small>
            </div>
        </a>
        <div class="ms-auto d-flex align-items-center">
            <div class="text-white me-4 d-none d-md-block text-end">
                <small class="d-block opacity-75">Selamat Datang,</small>
                <span class="fw-bold"><?= $_SESSION['nama']; ?></span>
            </div>
            <a href="logout.php" class="btn btn-warning btn-sm rounded-pill px-4 fw-bold shadow-sm" onclick="return confirm('Yakin ingin keluar?')">
                <i class="fas fa-power-off me-2"></i>Keluar
            </a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <!-- Peringatan InfinityFree dengan Animasi Berdenyut di Dashboard -->
    <div class="alert alert-warning alert-animasi alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-radius: 15px;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Perhatian!</strong> Harap rutin akses dan buka website ini secara berkala agar akun tidak otomatis di-suspend atau dihapus oleh sistem InfinityFree karena inaktif.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="welcome-text mb-1">Ringkasan Arsip Hari Ini</h1>
            <p class="text-muted">Pantau data surat masuk dan keluar dengan cepat dalam satu panel kontrol.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-stats shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-custom-1 me-3 shadow-sm">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <h6 class="text-muted fw-bold mb-0">SURAT MASUK</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="display-5 fw-bold mb-0"><?= $jml_masuk; ?></h2>
                        <span class="ms-2 text-muted">Berkas</span>
                    </div>
                    <a href="surat_masuk.php" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stats shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-custom-2 me-3 shadow-sm">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <h6 class="text-muted fw-bold mb-0">SURAT KELUAR</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="display-5 fw-bold mb-0"><?= $jml_keluar; ?></h2>
                        <span class="ms-2 text-muted">Berkas</span>
                    </div>
                    <a href="surat_keluar.php" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stats shadow-sm h-100 border-bottom border-4 border-success">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-custom-3 me-3 shadow-sm">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <h6 class="text-muted fw-bold mb-0">LAPORAN</h6>
                    </div>
                    <h3 class="fw-bold mb-0">Rekapitulasi</h3>
                    <p class="small text-muted mt-2 mb-0">Cetak dokumen laporan gabungan</p>
                    <a href="rekapitulasi.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="hero-section p-5 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold text-dark">Manajemen Arsip Kehutanan</h2>
                        <p class="text-muted fs-5">Sistem ini dirancang untuk mempercepat proses administrasi di lingkungan <strong>Dinas Kehutanan Provinsi Papua Barat</strong>. Silakan gunakan tombol di bawah untuk perekaman data baru.</p>
                        <div class="d-flex gap-3 mt-4">
                            <a href="tambah_surat.php" class="btn btn-success-custom btn-custom shadow">
                                <i class="fas fa-plus-circle me-2"></i>Input Surat Masuk
                            </a>
                            <a href="tambah_surat_keluar.php" class="btn btn-outline-success btn-custom">
                                <i class="fas fa-external-link-alt me-2"></i>Input Surat Keluar
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block text-center opacity-25">
                        <i class="fas fa-tree fa-10x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-5">
    <div class="container">
        <hr class="mb-4" style="opacity: 0.05;">
        <p class="text-muted small mb-1" style="letter-spacing: 1px; opacity: 0.8;">
            &copy; 2026 E-Arsip Digital | Dinas Kehutanan Papua Barat
        </p>
        <div style="font-size: 12px; color: #6c757d; letter-spacing: 1px;">
            <i class="fas fa-code text-success me-1"></i> Developed by 
            <a href="https://instagram.com/ayrbb___" target="_blank" class="text-decoration-none fw-bold text-success">@ayrbb___</a> 
            <span class="mx-2">•</span> Informatics UNIPA
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>