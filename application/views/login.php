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
    <style>
        /* General Styling */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: url('<?php echo base_url('images/bg-1.png'); ?>') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .login-bg {
            background-color: rgba(0, 0, 0, 0.6); /* Overlay untuk memperjelas teks */
        }

        .card {
            border: none;
            border-radius: 10px;
            background: #ffffff;
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
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logo {
                width: 80px;
            }

            .app-name {
                font-size: 12px;
            }
        }

        .judul {
            position: absolute;
            top: 20px;
            z-index: 3;
        }

        /* Styling untuk label nama dinas */
        .labelnamadinas {
            font-family: 'Arial', sans-serif;
            font-size: 34px;
            font-weight: bold;
            color: #ffffff; /* Warna biru seperti tema Bootstrap */
            text-shadow: 4px 4px 6px rgba(245, 211, 39, 0.8), 
             -4px -4px 6px rgba(255, 255, 255, 0.5);
            text-align: center;
            margin-top: 20px;
            animation: fadeInDown 1.5s ease-in-out; /* Animasi muncul dari atas */
        }

        /* Styling untuk label nama sistem */
        .labelnamasistem {
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            font-weight: 500;
            color: #ffffff; /* Warna abu-abu gelap */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2); /* Efek shadow lebih halus */
            text-align: center;
            margin-bottom: 20px;
            animation: fadeInUp 1.5s ease-in-out; /* Animasi muncul dari bawah */
        }

        /* Animasi fadeInDown */
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

        /* Animasi fadeInUp */
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
    </style>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100 login-bg">
        <div class="judul">
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
                    <div class="g-recaptcha" data-sitekey="6Lclr9wfAAAAACKIegQtyaCFgj9WrTApK5CPUB1Q"></div>
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
            // Optional: Add custom JavaScript here
            console.log("Halaman login siap digunakan.");
        });
    </script>
</body>
</html>