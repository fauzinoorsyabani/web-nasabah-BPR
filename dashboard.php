<?php
/**
 * HALAMAN UTAMA (DASHBOARD)
 * Halaman ini memberikan ringkasan data penting tentang nasabah.
 * Disini admin bisa melihat total saldo, jumlah nasabah, dan nasabah terbaru.
 */

session_start();

// Cek apakah user sudah login, jika belum kembalikan ke pintu login
if (!isset($_SESSION['user'])) { 
    header("Location: index.php"); 
    exit; 
}

require "koneksi.php";

// Menghitung jumlah keseluruhan nasabah yang terdaftar
$total     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM nasabah"))['total'];

// Menghitung total saldo seluruh nasabah yang ada di bank
$total_sal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(saldo) AS total FROM nasabah"))['total'];

// Menghitung berapa banyak nasabah baru yang mendaftar di bulan ini
$baru      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM nasabah WHERE MONTH(tanggal_daftar)=MONTH(NOW())"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Web Nasabah BPR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f4f8; }
    .sidebar { background: #1d4ed8; min-height: 100vh; width: 220px; position: fixed; }
    .sidebar a { color: #bfdbfe; text-decoration: none; display: block; padding: 10px 20px; border-radius: 8px; margin: 4px 8px; font-size: 0.9rem; }
    .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.15); color: #fff; }
    .main-content { margin-left: 220px; padding: 24px; }
    .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
    .stat-card { border-left: 4px solid; }
    .stat-card.blue { border-color: #3b82f6; }
    .stat-card.green { border-color: #10b981; }
    .stat-card.amber { border-color: #f59e0b; }
    .brand { color: #fff; font-weight: 700; font-size: 1.1rem; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.15); }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="brand">BPR Mitra Kopjaya</div>
    <nav class="mt-3">
      <a href="dashboard.php" class="active">&#9632; Dashboard</a>
      <a href="data_nasabah.php">&#9632; Data Nasabah</a>
      <a href="tambah.php">&#9632; Tambah Nasabah</a>
      <a href="logout.php" style="margin-top:auto; position:absolute; bottom:20px; left:0; right:0; color:#fca5a5;">&#9632; Logout</a>
    </nav>
  </div>

  <!-- Main -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h5 class="fw-bold mb-0">Dashboard</h5>
        <small class="text-muted">Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?></small>
      </div>
      <span class="badge bg-primary"><?= strtoupper($_SESSION['role']) ?></span>
    </div>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card p-3 stat-card blue">
          <div class="text-muted small">Total Nasabah</div>
          <div class="fs-2 fw-bold text-primary"><?= $total ?></div>
          <div class="text-muted small">nasabah terdaftar</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 stat-card green">
          <div class="text-muted small">Total Saldo</div>
          <div class="fs-4 fw-bold text-success">Rp <?= number_format($total_sal, 0, ',', '.') ?></div>
          <div class="text-muted small">keseluruhan nasabah</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 stat-card amber">
          <div class="text-muted small">Nasabah Baru</div>
          <div class="fs-2 fw-bold text-warning"><?= $baru ?></div>
          <div class="text-muted small">bulan ini</div>
        </div>
      </div>
    </div>

    <!-- Tabel ringkasan -->
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-semibold mb-0">Nasabah Terbaru</h6>
        <a href="data_nasabah.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle small">
          <thead class="table-light">
            <tr>
              <th>No. Rekening</th>
              <th>Nama</th>
              <th>Telepon</th>
              <th>Saldo</th>
              <th>Tgl Daftar</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $q = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY id DESC LIMIT 5");
          while ($row = mysqli_fetch_assoc($q)):
          ?>
            <tr>
              <td><code><?= htmlspecialchars($row['no_rekening']) ?></code></td>
              <td><?= htmlspecialchars($row['nama_nasabah']) ?></td>
              <td><?= htmlspecialchars($row['no_telepon']) ?></td>
              <td class="text-success fw-semibold">Rp <?= number_format($row['saldo'], 0, ',', '.') ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal_daftar'])) ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
