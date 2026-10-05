<?php
session_start();
include 'includes/koneksi.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user' AND password = '$pass'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $data['nama_lengkap'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Arsip Digital Dishut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            /* Background foto hutan agar tema Kehutanan terasa kuat */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px); /* Efek blur kaca */
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #004d40 0%, #00796b 100%);
            padding: 30px;
            color: white;
            text-align: center;
        }

        .btn-success {
            background-color: #004d40;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-success:hover {
            background-color: #00695c;
            transform: translateY(-2px);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 77, 64, 0.25);
            border-color: #004d40;
        }

        .logo-img { width: 70px; margin-bottom: 15px; }

        /* Animasi berdenyut untuk peringatan hosting */
        @keyframes denyut {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
            50% { transform: scale(1.02); box-shadow: 0 0 0 8px rgba(255, 193, 7, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
        }

        .alert-animasi {
            animation: denyut 2s infinite ease-in-out;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card">
                <div class="login-header">
                    <img src="assets/logo.png" class="logo-img" alt="Logo Papua Barat">
                    <h4 class="fw-bold mb-0">E-ARSIP DIGITAL</h4>
                    <small class="opacity-75">Dinas Kehutanan Prov. Papua Barat</small>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <!-- Peringatan InfinityFree dengan Animasi Berdenyut -->
                    <div class="alert alert-warning alert-animasi text-center py-2 mb-4 small" style="border-radius: 10px;">
                        <i class="fas fa-exclamation-triangle me-1"></i> 
                        <b>Perhatian:</b> Harap rutin akses web ini agar tidak di-suspend/delete oleh sistem InfinityFree!
                    </div>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger text-center py-2 mb-4 small" style="border-radius: 10px;">
                            <i class="fas fa-exclamation-circle me-1"></i> Username atau Password Salah!
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="username" class="form-control border-start-0" placeholder="Masukkan username" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <button name="login" class="btn btn-success w-100 shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i>MASUK KE SISTEM
                        </button>
                    </form>
                </div>
                
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <small class="text-muted d-block mb-1">&copy; 2026 E-Arsip Dishut PB</small>
                    <small class="text-muted">
                        Created with <i class="fas fa-code text-success"></i> by 
                        <a href="https://instagram.com/ayrbb___" target="_blank" class="text-decoration-none fw-bold text-success">@ayrbb___</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>