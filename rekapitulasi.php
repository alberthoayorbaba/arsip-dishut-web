<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'includes/koneksi.php';

$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$where_masuk = "WHERE YEAR(tgl_surat) = '$filter_tahun'";
$where_keluar = "WHERE YEAR(tgl_surat) = '$filter_tahun'";

if ($filter_bulan != '') {
    $where_masuk .= " AND MONTH(tgl_surat) = '$filter_bulan'";
    $where_keluar .= " AND MONTH(tgl_surat) = '$filter_bulan'";
}

$query = mysqli_query($conn, "
    (SELECT no_agenda, no_surat, tgl_surat, asal_surat AS sumber_tujuan, perihal, 'Surat Masuk' AS tipe 
     FROM surat_masuk $where_masuk)
    UNION
    (SELECT no_agenda, no_surat, tgl_surat, tujuan_surat AS sumber_tujuan, perihal, 'Surat Keluar' AS tipe 
     FROM surat_keluar $where_keluar)
    ORDER BY tgl_surat DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Arsip Resmi | E-Arsip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Mengubah background body menjadi lebih gelap agar kertas putih terlihat "kontras" */
        body { 
            background-color: #d1d8e0; 
            font-family: 'Inter', sans-serif; 
            padding-top: 30px;
        }
        
        /* Filter Card dengan Shadow lebih kuat */
        .filter-card { 
            border-radius: 15px; 
            border: none; 
            background: #ffffff; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            margin-bottom: 40px;
        }
        
        /* Paper/Kertas Laporan dengan border tipis dan shadow dalam */
        .paper { 
            background: white; 
            padding: 60px; 
            border-radius: 4px; 
            box-shadow: 0 15px 50px rgba(0,0,0,0.2); 
            margin-bottom: 50px;
            border: 1px solid #c2c2c2;
        }

        /* KOP SURAT */
        .kop-surat { border-bottom: 4px double #000; margin-bottom: 30px; padding-bottom: 10px; }
        .logo-provinsi { width: 85px; height: auto; }
        
        /* Tabel: Membuat Header berwarna Gelap agar tidak menyatu dengan isi */
        .table-resmi { border: 1.5px solid #000; }
        .table-resmi thead th { 
            background-color: #2d3436 !important; 
            color: #ffffff !important; 
            border: 1px solid #000 !important; 
            font-size: 12px; 
            text-transform: uppercase; 
            padding: 12px;
            text-align: center;
        }
        .table-resmi td { 
            border: 1px solid #000 !important; 
            font-size: 13px; 
            color: #000; 
            padding: 10px 8px !important;
            font-family: 'Times New Roman', serif;
        }

        /* Badge warna lebih solid */
        .badge-tipe { font-weight: 800; padding: 4px 10px; border-radius: 6px; font-size: 10px; letter-spacing: 0.5px; }
        .bg-masuk { background-color: #2ecc71; color: #ffffff; }
        .bg-keluar { background-color: #f1c40f; color: #000000; }

        @media print {
            body { background: white; padding: 0; }
            .no-print { display: none !important; }
            .paper { box-shadow: none; border: none; padding: 0; margin: 0; }
            .table-resmi thead th { background-color: #f8f9fa !important; color: #000 !important; }
            .badge-tipe { border: 1px solid #000; background: transparent !important; color: #000 !important; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="no-print card filter-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-sliders me-2"></i>Pengaturan Laporan</h5>
            <div class="btn-group shadow-sm">
                <a href="dashboard.php" class="btn btn-outline-dark btn-sm px-4">Kembali</a>
                <button onclick="window.print()" class="btn btn-dark btn-sm px-4">
                    <i class="fas fa-print me-2"></i> Cetak Sekarang
                </button>
            </div>
        </div>
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <label class="small fw-bold text-muted mb-1">BULAN</label>
                <select name="bulan" class="form-select bg-light border-0">
                    <option value="">Semua Bulan</option>
                    <?php
                    $bln = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    foreach($bln as $k => $v) {
                        $m = $k + 1;
                        $s = ($filter_bulan == $m) ? 'selected' : '';
                        echo "<option value='$m' $s>$v</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="small fw-bold text-muted mb-1">TAHUN</label>
                <input type="number" name="tahun" class="form-control bg-light border-0" value="<?= $filter_tahun; ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 fw-bold">TERAPKAN FILTER</button>
            </div>
        </form>
    </div>

    <div class="paper">
        <div class="kop-surat d-flex align-items-center justify-content-center text-center">
            <img src="assets/logo.png" class="logo-provinsi me-4">
            <div>
                <h5 class="mb-0 fw-bold">PEMERINTAH PROVINSI PAPUA BARAT</h5>
                <h3 class="mb-0 fw-bold">DINAS KEHUTANAN</h3>
                <p class="mb-0 fw-bold small" style="font-size: 11px;">Jl. Brigjen Marinir (Purn) Abraham O. Atururi, Arfai, Distrik Manokwari Selatan (Anday), Kabupaten Manokwari, Papua</p>
                <p class="mb-0 small" style="font-size: 11px;">Laman: dishut.papuabaratprov.go.id | Email: dishut@papuabaratprov.go.id | Kode Pos: 98315</p>
            </div>
        </div>

        <h5 class="text-center fw-bold mb-4 mt-2" style="text-decoration: underline;">REKAPITULASI SURAT MASUK DAN SURAT KELUAR</h5>

        <table class="table table-resmi align-middle">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Jenis Surat</th>
                    <th width="20%">No. Agenda & Surat</th>
                    <th width="12%">Tanggal</th>
                    <th width="18%">Asal / Tujuan</th>
                    <th>Perihal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center">
                        <span class="badge-tipe <?= ($row['tipe'] == 'Surat Masuk') ? 'bg-masuk' : 'bg-keluar'; ?>">
                            <?= strtoupper($row['tipe']); ?>
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold" style="font-size: 13px;"><?= $row['no_agenda']; ?></div>
                        <div class="text-muted" style="font-size: 11px;"><?= $row['no_surat']; ?></div>
                    </td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($row['tgl_surat'])); ?></td>
                    <td class="fw-bold"><?= $row['sumber_tujuan']; ?></td>
                    <td><?= $row['perihal']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="row mt-5">
            <div class="col-7"></div>
            <div class="col-5 text-center">
                <p class="mb-0" style="font-size: 14px;">Manokwari, <?= date('d F Y'); ?></p>
                <p class="fw-bold mb-5 pb-3" style="font-size: 14px;">Sekretaris Dinas Kehutanan,</p>
                <p class="mb-0 fw-bold text-decoration-underline" style="font-size: 14px;">SANDI IRYAWATI, SP</p>
                <p class="small mb-0" style="font-size: 13px;">NIP. 19740413 200112 2 002</p>
                <p class="small" style="font-size: 13px;">Pembina / IVa</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>