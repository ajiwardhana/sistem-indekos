<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikosan - Login & Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --accent-color: #f8f9fc;
            --text-color: #5a5c69;
        }

        body {
            background: linear-gradient(135deg, #f5f7ff 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Nunito', sans-serif;
        }

        .welcome-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1000px;
            margin: 20px auto;
        }

        .welcome-left {
            background: linear-gradient(to bottom right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .welcome-right {
            padding: 40px;
            background-color: white;
        }

        .app-logo img {
            width: 100%;
            max-width: 800px; /* ukuran logo proporsional */
            height: auto;
            display: block;
            margin-bottom: 30px;
        }

        .app-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .feature-list {
            list-style-type: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .feature-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-list i {
            background-color: rgba(255, 255, 255, 0.2);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .feature-list li:hover i {
            transform: scale(1.2);
        }

        .auth-option {
            border: 2px solid #e3e6f0;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            cursor: pointer;
            background-color: #f8f9fc;
        }

        .auth-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .auth-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .auth-option:hover .auth-icon {
            transform: rotate(10deg);
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }

        .auth-description {
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .btn-auth {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .welcome-left, .welcome-right {
                padding: 30px 20px;
            }

            .app-logo img {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-container">
            <div class="row g-0">
                <!-- Left Side (Logo & Features) -->
                <div class="col-md-6 welcome-left">
                    <div class="app-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Sikosan">
                    </div>
                    <p class="app-description">
                        Kelola bisnis indekos Anda dengan mudah. Sistem terintegrasi untuk manajemen kamar, penghuni, dan keuangan.
                    </p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Kelola data kamar dan fasilitas</li>
                        <li><i class="fas fa-check"></i> Pantau pembayaran dan keuangan</li>
                        <li><i class="fas fa-check"></i> Kelola data penghuni</li>
                        <li><i class="fas fa-check"></i> Laporan bulanan otomatis</li>
                    </ul>
                </div>

                <!-- Right Side (Login & Register) -->
                <div class="col-md-6 welcome-right">
                    <h2 class="text-center mb-5">Selamat Datang</h2>

                    <div class="auth-option" onclick="location.href='{{ route('login') }}';">
                        <div class="text-center">
                            <div class="auth-icon"><i class="fas fa-sign-in-alt"></i></div>
                            <h3 class="auth-title">Login</h3>
                            <p class="auth-description">Masuk ke akun Anda untuk mengelola sistem indekos</p>
                            <button class="btn btn-auth">Login Sekarang</button>
                        </div>
                    </div>

                    <div class="auth-option" onclick="location.href='{{ route('register') }}';">
                        <div class="text-center">
                            <div class="auth-icon"><i class="fas fa-user-plus"></i></div>
                            <h3 class="auth-title">Registrasi</h3>
                            <p class="auth-description">Daftar akun baru untuk mulai menggunakan sistem</p>
                            <button class="btn btn-auth">Daftar Sekarang</button>
                        </div>
                    </div>

                    <div class="footer">
                        <p>&copy; 2025 Sikosan. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
