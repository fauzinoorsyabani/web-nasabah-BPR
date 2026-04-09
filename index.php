<?php
/**
 * HALAMAN LOGIN (PINTU MASUK)
 * File ini mengatur siapa saja yang boleh masuk ke sistem.
 * Hanya pengguna terdaftar (admin) yang bisa mengakses data nasabah.
 */

session_start();

// Jika pengguna sudah login sebelumnya, langsung arahkan ke Dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// Jika tombol 'Masuk' ditekan, lakukan proses pengecekan
if (isset($_POST['login'])) {
    require "koneksi.php";
    
    // Ambil data dari formulir dan bersihkan dari spasi berlebih
    $username = trim($_POST['username']);
    $password = MD5(trim($_POST['password'])); // Ubah password jadi kode rahasia (MD5)

    // Cari di database apakah ada username dan password yang cocok
    $sql    = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    // Jika ditemukan kecocokan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Simpan data login ke memori (Sesi) agar bisa digunakan di halaman lain
        $_SESSION['user'] = $row['username'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];
        
        // Masuk ke halaman Dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Jika tidak cocok, siapkan pesan error
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Web Nasabah BPR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f4f8; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .card { border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); }
    .btn-primary { background: #1d4ed8; border-color: #1d4ed8; }
    .logo-text { font-size: 1.3rem; font-weight: 700; color: #1d4ed8; }
  </style>
</head>
<body>
  <div class="card p-4" style="width: 380px;">
    <div class="text-center mb-4">
      <div class="logo-text">BPR Mitra Kopjaya</div>
      <p class="text-muted small">Sistem Pengelolaan Data Nasabah</p>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label small fw-semibold">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label small fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
    </form>
    <p class="text-center text-muted mt-3 small">Default: admin / admin123</p>
  </div>
</body>
</html>
