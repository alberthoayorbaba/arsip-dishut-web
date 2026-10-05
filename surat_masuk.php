<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'includes/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM surat_masuk ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Surat Masuk | E-Arsip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafb; font-family: 'Inter', sans-serif; }
        .navbar-custom { background: linear-gradient(135deg, #198754 0%, #14532d 100%); }
        
        .card-main { border-radius: 20px; border: none; overflow: hidden; }
        
        .table thead { background-color: #f1f5f9; }
        .table thead th { 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em; 
            font-weight: 700; 
            color: #475569; 
            padding: 15px;
        }
        
        .table tbody tr { transition: all 0.2s; border-bottom: 1px solid #f1f5f9; }
        .table tbody tr:hover { background-color: #f0fdf4; transform: scale(1.002); }
        
        .badge-agenda { background-color: #e2e8f0; color: #475569; border-radius: 8px; padding: 5px 10px; font-weight: 600; }
        
        .btn-action { border-radius: 10px; width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; transition: 0.3s; }
        .btn-view { background-color: #ecfdf5; color: #059669; border: none; }
        .btn-edit { background-color: #fffbeb; color: #d97706; border: none; }
        .btn-delete { background-color: #fef2f2; color: #dc2626; border: none; }
        
        .btn-action:hover { transform: translateY(-3px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="fas fa-tree me-2"></i>E-ARSIP DISHUT
        </a>
        <a href="dashboard.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-success">
            <i class="fas fa-home me-1"></i> Dashboard
        </a>
    </div>
</nav>

<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Daftar Surat Masuk</h3>
            <p class="text-muted small mb-0">Kelola berkas masuk dari instansi luar dengan mudah.</p>
        </div>
        <a href="tambah_surat.php" class="btn btn-success rounded-pill px-4 shadow">
            <i class="fas fa-plus me-2"></i> Tambah Surat
        </a>
    </div>

    <div class="card card-main shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Agenda & No. Surat</th>
                            <th>Tanggal</th>
                            <th>Asal & Perihal</th>
                            <th class="text-center">Berkas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($query)) : 
                        ?>
                        <tr>
                            <td class="text-center text-muted small"><?= $no++; ?></td>
                            <td>
                                <div class="badge-agenda small mb-1"><?= $row['no_agenda']; ?></div>
                                <div class="fw-bold text-dark small"><?= $row['no_surat']; ?></div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark"><?= date('d M Y', strtotime($row['tgl_terima'])); ?></div>
                                <div class="text-muted" style="font-size: 11px;">Surat: <?= date('d/m/y', strtotime($row['tgl_surat'])); ?></div>
                            </td>
                            <td>
                                <div class="fw-bold text-success text-uppercase small" style="letter-spacing: 0.5px;"><?= $row['asal_surat']; ?></div>
                                <div class="text-muted small text-truncate" style="max-width: 250px;"><?= $row['perihal']; ?></div>
                            </td>
                            <td class="text-center">
                                <a href="uploads/<?= $row['file_surat']; ?>" target="_blank" class="btn-action btn-view text-decoration-none" title="Lihat Berkas">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="edit_surat.php?id=<?= $row['id']; ?>" class="btn-action btn-edit" title="Edit Data">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <a href="hapus_surat.php?id=<?= $row['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus Data">
                                        <i class="fas fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>