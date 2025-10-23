<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barang Habis Pakai</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Gradient biru modern */
            color: #fff;
            overflow: hidden;
        }

        .login-bg {
            background-color: rgba(0, 0, 0, 0.4); /* Overlay gelap untuk kontras */
            height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.9); /* Transparan putih */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .app-name {
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }

        /* Form Styling */
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
        }

        label {
            font-weight: 500;
            color: #333;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Gradient biru */
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.5);
        }

        /* Label Styling */
        .labelnamadinas {
            font-size: 34px;
            font-weight: bold;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeInDown 1.5s ease-in-out;
        }

        .labelnamasistem {
            font-size: 18px;
            font-weight: 500;
            color: #ffffff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeInUp 1.5s ease-in-out;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logo {
                width: 80px;
            }

            .labelnamadinas {
                font-size: 28px;
            }

            .labelnamasistem {
                font-size: 16px;
            }
        }

        /* Google reCAPTCHA Styling */
        .g-recaptcha {
            margin-bottom: 15px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100 login-bg">
        <div class="judul text-center mb-4">
            <h3 class="labelnamadinas">DINAS PENDIDIKAN KABUPATEN DELI SERDANG</h3>
            <h5 class="labelnamasistem">SISTEM INFORMASI BARANG HABIS PAKAI SEKOLAH</h5>
        </div>
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <img src="<?php echo base_url('images/tutwurihandayani.png'); ?>" alt="Logo Aplikasi" class="logo">
            </div>

            <!-- Flashdata Error -->
            <?php if ($this->session->flashdata('pesan')) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $this->session->flashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo site_url('Login/cek_login'); ?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="mb-3">
                    <label for="tahunanggaran" class="form-label">Tahun Anggaran</label>
                    <input type="number" class="form-control" id="tahunanggaran" name="tahunanggaran" min="2025" max="2100" value="<?php echo date('Y') ?>" required>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="6LcE3MkrAAAAAI9sZwJw6Ziy1RuWw4kKZcYx2Ldh"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("Halaman login siap digunakan.");
        });
    </script>
</body>
</html>