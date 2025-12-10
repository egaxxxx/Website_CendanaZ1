<?php
/**
 * Test Koneksi Database untuk XAMPP
 * File ini untuk memverifikasi koneksi database berhasil
 */

// Include file konfigurasi database
require_once 'config/database.php';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Koneksi Database - Cendana Travel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .status {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .success {
            background: #d4edda;
            border-left: 5px solid #28a745;
            color: #155724;
        }
        
        .error {
            background: #f8d7da;
            border-left: 5px solid #dc3545;
            color: #721c24;
        }
        
        .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        
        .table-list {
            max-height: 300px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .table-item {
            padding: 8px 12px;
            background: white;
            margin-bottom: 5px;
            border-radius: 5px;
            font-size: 14px;
            border-left: 3px solid #667eea;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔌 Test Koneksi Database</h1>
        <p class="subtitle">CV. Cendana Travel - XAMPP Configuration</p>
        
        <?php if ($conn && !$conn->connect_error): ?>
            <!-- KONEKSI BERHASIL -->
            <div class="status success">
                <div class="icon">✅</div>
                <h2>Koneksi Database Berhasil!</h2>
                <p>Database terhubung dengan sempurna</p>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Host</div>
                    <div class="info-value"><?php echo DB_HOST; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Database</div>
                    <div class="info-value"><?php echo DB_NAME; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?php echo DB_USER; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Charset</div>
                    <div class="info-value"><?php echo $conn->character_set_name(); ?></div>
                </div>
            </div>
            
            <?php
            // Cek tabel yang ada
            $tables = [];
            $result = $conn->query("SHOW TABLES");
            if ($result) {
                while ($row = $result->fetch_array()) {
                    $tables[] = $row[0];
                }
            }
            ?>
            
            <div class="table-list">
                <div class="info-label" style="margin-bottom: 10px;">
                    📊 Daftar Tabel (<?php echo count($tables); ?> tabel)
                </div>
                <?php if (count($tables) > 0): ?>
                    <?php foreach ($tables as $table): ?>
                        <div class="table-item">✓ <?php echo htmlspecialchars($table); ?></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="info-value" style="color: #dc3545;">
                        ⚠️ Database kosong! Silakan import file SQL terlebih dahulu.
                    </div>
                <?php endif; ?>
            </div>
            
            <a href="index.php" class="btn">🏠 Ke Halaman Utama</a>
            <a href="admin.php" class="btn" style="background: #28a745;">🔐 Ke Admin Panel</a>
            
        <?php else: ?>
            <!-- KONEKSI GAGAL -->
            <div class="status error">
                <div class="icon">❌</div>
                <h2>Koneksi Database Gagal!</h2>
                <p><strong>Error:</strong> <?php echo $conn ? $conn->connect_error : 'Tidak dapat membuat koneksi'; ?></p>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Host</div>
                    <div class="info-value"><?php echo DB_HOST; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Database</div>
                    <div class="info-value"><?php echo DB_NAME; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?php echo DB_USER; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Password</div>
                    <div class="info-value"><?php echo empty(DB_PASS) ? '(kosong)' : '********'; ?></div>
                </div>
            </div>
            
            <div style="background: #fff3cd; padding: 20px; border-radius: 8px; margin-top: 20px; border-left: 5px solid #ffc107;">
                <h3 style="color: #856404; margin-bottom: 10px;">💡 Cara Memperbaiki:</h3>
                <ol style="color: #856404; margin-left: 20px;">
                    <li>Pastikan MySQL di XAMPP sudah running (hijau)</li>
                    <li>Buka XAMPP Control Panel dan klik Start pada MySQL</li>
                    <li>Pastikan password MySQL kosong (default XAMPP)</li>
                    <li>Import database melalui phpMyAdmin</li>
                    <li>Refresh halaman ini setelah database diimport</li>
                </ol>
            </div>
            
            <a href="http://localhost/phpmyadmin" class="btn" target="_blank">📊 Buka phpMyAdmin</a>
            
        <?php endif; ?>
    </div>
</body>
</html>
