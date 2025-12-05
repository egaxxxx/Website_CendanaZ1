<?php
/**
 * File Login dan Logout Admin
 * Dibuat oleh: Mahasiswa Informatika Unmul
 * Untuk: Tugas Pemrograman Web
 */

// Hubungkan ke database
require_once 'config/database.php';

// Mulai session
startSecureSession();

// PENTING: Proses logout HARUS dijalankan SEBELUM check login
// Cek jika ada parameter logout di URL (GET request)
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    prosesLogout();
    exit(); // Stop execution setelah logout
}

# Cek apakah ada form yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['action'] ?? '';
    
    // Kalau aksinya logout
    if ($aksi === 'logout') {
        prosesLogout();
        exit(); // Stop execution setelah logout
    }
    // Kalau aksinya login
    elseif ($aksi === 'login') {
        prosesLogin($conn);
    }
}

// Jika sudah login, redirect ke admin.php
if (isAdminLoggedIn()) {
    header('Location: admin.php');
    exit();
}

/**
 * Fungsi untuk proses login admin
 */
function prosesLogin($conn) {
    // Ambil password dari form
    $password = $_POST['password'] ?? '';
    
    // Cek apakah password diisi
    if (empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Password tidak boleh kosong'
        ]);
        exit();
    }
    
    // Password admin (bisa diganti sesuai kebutuhan)
    $passwordBenar = 'admin123';
    
    // Cek apakah password cocok
    if ($password === $passwordBenar) {
        // Simpan data login ke session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        $_SESSION['admin_id'] = 1;
        $_SESSION['login_time'] = time();
        
        // Kirim response sukses
        echo json_encode([
            'success' => true,
            'message' => 'Login berhasil!',
            'redirect' => 'admin.php'
        ]);
    } else {
        // Kirim response gagal
        echo json_encode([
            'success' => false,
            'message' => 'Password salah. Silakan coba lagi.'
        ]);
    }
    exit();
}

/**
 * Fungsi untuk proses logout admin
 */
function prosesLogout() {
    // Hapus semua session
    destroyAdminSession();
    
    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Redirect ke halaman utama (index.php)
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CV. Cendana Travel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Login Page - Professional Minimalist Design */
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3a2f28 0%, #2d241e 100%);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Subtle Background Pattern */
        .login-page::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(212, 149, 110, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(212, 149, 110, 0.03) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Login Card - Clean White Container */
        .login-container {
            background: #FFFFFF;
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25), 
                        0 10px 30px rgba(0, 0, 0, 0.15);
            max-width: 380px;
            width: 100%;
            overflow: hidden;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        /* Login Body - Main Content Area */
        .login-body {
            padding: 3rem 2.5rem 2.5rem 2.5rem;
            text-align: center;
        }

        /* Lock Icon - Minimalist Circle */
        .login-icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem auto;
            background: linear-gradient(135deg, #F5F5F5 0%, #ECECEC 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .login-icon {
            width: 32px;
            height: 32px;
            color: #9CA3AF;
        }

        /* Heading - Thin & Professional */
        .login-heading {
            font-size: 1.75rem;
            font-weight: 400;
            color: #1F2937;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: #9CA3AF;
            font-weight: 400;
            margin: 0 0 2.5rem 0;
        }

        /* Form Styles */
        .login-form-group {
            margin-bottom: 1.75rem;
            text-align: left;
        }

        .login-form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4B5563;
            margin-bottom: 0.625rem;
        }

        /* Input Field - Soft & Clean */
        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .login-form-group input {
            width: 100%;
            padding: 0.875rem 3rem 0.875rem 1rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1F2937;
            transition: all 0.3s ease;
            background: #F9FAFB;
            box-sizing: border-box;
        }

        .login-form-group input::placeholder {
            color: #D1D5DB;
        }

        .login-form-group input:focus {
            outline: none;
            border-color: #A8825E;
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(168, 130, 94, 0.08);
        }

        /* Eye Icon Toggle */
        .password-toggle-btn {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }

        .password-toggle-btn:hover {
            color: #6B7280;
        }

        .password-toggle-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Login Button - Premium Brown */
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #A8825E 0%, #8B6F47 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            box-shadow: 0 4px 12px rgba(168, 130, 94, 0.25);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 130, 94, 0.35);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Messages */
        .login-alert {
            padding: 0.875rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: none;
            text-align: left;
        }

        .login-alert.show {
            display: block;
        }

        .login-alert.error {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .login-alert.success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        /* Footer Link */
        .login-footer {
            padding: 1.5rem 2.5rem 2rem 2.5rem;
            text-align: center;
        }

        .login-footer a {
            color: #A8825E;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .login-footer a:hover {
            color: #8B6F47;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-page {
                padding: 1.25rem;
            }

            .login-container {
                max-width: 100%;
            }

            .login-body {
                padding: 2.5rem 2rem 2rem 2rem;
            }

            .login-heading {
                font-size: 1.5rem;
            }

            .login-icon-wrapper {
                width: 70px;
                height: 70px;
                margin-bottom: 1.5rem;
            }

            .login-icon {
                width: 28px;
                height: 28px;
            }

            .login-footer {
                padding: 1.25rem 2rem 1.75rem 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <!-- Login Body -->
            <div class="login-body">
                <!-- Lock Icon - Minimalist Circle -->
                <div class="login-icon-wrapper">
                    <svg class="login-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>

                <!-- Heading & Subtitle -->
                <h1 class="login-heading">Admin Login</h1>
                <p class="login-subtitle">CV. Cendana Travel</p>

                <!-- Alert Message -->
                <div id="loginAlert" class="login-alert"></div>

                <!-- Login Form -->
                <form id="loginForm" onsubmit="handleLogin(event)">
                    <input type="hidden" name="action" value="login">
                    
                    <div class="login-form-group">
                        <label for="password">Masukkan Password</label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="•••••••"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="password-toggle-btn" onclick="togglePassword()" aria-label="Toggle password visibility">
                                <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">
                        Masuk Dashboard
                    </button>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="login-footer">
                <a href="index.php">
                    <span>←</span>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Change to eye-off icon
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passwordInput.type = 'password';
                // Change back to eye icon
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // Show Alert
        function showAlert(message, type = 'error') {
            const alert = document.getElementById('loginAlert');
            alert.textContent = message;
            alert.className = 'login-alert ' + type + ' show';
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                alert.classList.remove('show');
            }, 5000);
        }

        // Handle Login Form
        async function handleLogin(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = form.querySelector('.login-btn');
            const originalText = submitBtn.textContent;
            
            // Disable button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Memproses...';
            
            try {
                const formData = new FormData(form);
                const response = await fetch('auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message, 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showAlert(result.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            } catch (error) {
                showAlert('Terjadi kesalahan. Silakan coba lagi.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        }

        // Focus on password field on load
        window.addEventListener('load', () => {
            document.getElementById('password').focus();
        });

        // Add subtle entrance animation
        window.addEventListener('load', () => {
            const container = document.querySelector('.login-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
