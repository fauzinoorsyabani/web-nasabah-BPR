<?php
/**
 * HALAMAN PENGELOLAAN DATA NASABAH
 * Halaman ini digunakan untuk melihat daftar, mencari, dan menghapus data nasabah.
 * Data ditampilkan dalam bentuk tabel agar mudah dibaca.
 */

session_start();

// Cek apakah user sudah login, jika belum kembalikan ke pintu login
if (!isset($_SESSION['user'])) { 
    header("Location: index.php"); 
    exit; 
}

require "koneksi.php";

/**
 * PROSES MENGHAPUS DATA
 * Jika admin menekan tombol 'Hapus', data akan dihapus dari pusat data selamanya.
 */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM nasabah WHERE id=$id");
    
    // Kembali ke halaman ini dan tampilkan pesan bahwa data berhasil dihapus
    header("Location: data_nasabah.php?pesan=hapus");
    exit;
}

/**
 * PROSES PENCARIAN
 * Memungkinkan admin mencari nasabah berdasarkan Nama, No. Rekening, atau NIK.
 */
$cari = "";
$where = "";
if (isset($_GET['cari']) && $_GET['cari'] !== "") {
    $cari  = mysqli_real_escape_string($conn, trim($_GET['cari']));
    $where = "WHERE nama_nasabah LIKE '%$cari%' OR no_rekening LIKE '%$cari%' OR nik LIKE '%$cari%'";
}

// Mengambil data dari pusat data (nasabah) dan mengurutkannya dari yang terbaru
$data = mysqli_query($conn, "SELECT * FROM nasabah $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Nasabah - BPR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f4f8; }
    .sidebar { background: #1d4ed8; min-height: 100vh; width: 220px; position: fixed; }
    .sidebar a { color: #bfdbfe; text-decoration: none; display: block; padding: 10px 20px; border-radius: 8px; margin: 4px 8px; font-size: 0.9rem; }
    .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.15); color: #fff; }
    .main-content { margin-left: 220px; padding: 24px; }
    .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
    .brand { color: #fff; font-weight: 700; font-size: 1.1rem; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.15); }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="brand">BPR Mitra Kopjaya</div>
    <nav class="mt-3">
      <a href="dashboard.php">&#9632; Dashboard</a>
      <a href="data_nasabah.php" class="active">&#9632; Data Nasabah</a>
      <a href="tambah.php">&#9632; Tambah Nasabah</a>
      <a href="logout.php" style="position:absolute; bottom:20px; left:0; right:0; color:#fca5a5;">&#9632; Logout</a>
    </nav>
  </div>

  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="fw-bold mb-0">Data Nasabah</h5>
      <a href="tambah.php" class="btn btn-primary btn-sm">+ Tambah Nasabah</a>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
      <div class="alert alert-<?= $_GET['pesan']=='hapus'?'warning':($_GET['pesan']=='tambah'?'success':'info') ?> alert-dismissible small py-2">
        <?= $_GET['pesan']=='hapus'?'Data nasabah berhasil dihapus.':($_GET['pesan']=='tambah'?'Nasabah baru berhasil ditambahkan.':'Data berhasil diperbarui.') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="card p-3">
      <!-- Form cari -->
      <form method="GET" class="d-flex gap-2 mb-3">
        <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari nama, rekening, atau NIK..." value="<?= htmlspecialchars($cari) ?>">
        <button class="btn btn-outline-primary btn-sm px-3">Cari</button>
        <?php if ($cari): ?>
          <a href="data_nasabah.php" class="btn btn-outline-secondary btn-sm">Reset</a>
        <?php endif; ?>
      </form>

      <div class="table-responsive">
        <table class="table table-hover align-middle small">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>No. Rekening</th>
              <th>Nama Nasabah</th>
              <th>NIK</th>
              <th>Telepon</th>
              <th>Saldo</th>
              <th>Tgl Daftar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
            <tr>
              <td class="text-muted"><?= $no++ ?></td>
              <td><code><?= htmlspecialchars($row['no_rekening']) ?></code></td>
              <td class="fw-semibold"><?= htmlspecialchars($row['nama_nasabah']) ?></td>
              <td><?= htmlspecialchars($row['nik']) ?></td>
              <td><?= htmlspecialchars($row['no_telepon']) ?></td>
              <td class="text-success">Rp <?= number_format($row['saldo'], 0, ',', '.') ?></td>
              <td><?= date('d M Y', strtotime($row['tanggal_daftar'])) ?></td>
              <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning py-0">Edit</a>
                <a href="data_nasabah.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger py-0"
                   onclick="return confirm('Yakin hapus nasabah ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        <?php if (mysqli_num_rows($data) === 0): ?>
          <p class="text-center text-muted py-3">Tidak ada data nasabah ditemukan.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
