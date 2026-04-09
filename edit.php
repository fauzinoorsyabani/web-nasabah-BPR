<?php
/**
 * HALAMAN UBAH DATA (EDIT)
 * Halaman ini digunakan untuk memperbaiki atau memperbarui data nasabah yang sudah ada.
 * Contohnya jika nasabah pindah alamat atau ganti nomor telepon.
 */

session_start();

// Cek apakah user sudah login, jika belum kembalikan ke pintu login
if (!isset($_SESSION['user'])) { 
    header("Location: index.php"); 
    exit; 
}

require "koneksi.php";

// Ambil nomor pengenal (ID) nasabah yang akan diedit dari URL
$id = (int)($_GET['id'] ?? 0);

// Cari data nasabah di pusat data berdasarkan ID
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM nasabah WHERE id=$id"));

// Jika data tidak ditemukan, kembali ke daftar nasabah
if (!$row) { 
    header("Location: data_nasabah.php"); 
    exit; 
}

$error = "";

/**
 * PROSES MEMPERBARUI DATA
 * Jika tombol 'Simpan Perubahan' ditekan, sistem akan memperbarui data lama dengan yang baru.
 */
if (isset($_POST['update'])) {
    // Ambil data baru dari formulir
    $no_rek  = mysqli_real_escape_string($conn, trim($_POST['no_rekening']));
    $nama    = mysqli_real_escape_string($conn, trim($_POST['nama_nasabah']));
    $nik     = mysqli_real_escape_string($conn, trim($_POST['nik']));
    $alamat  = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $telp    = mysqli_real_escape_string($conn, trim($_POST['no_telepon']));
    $saldo   = (float)$_POST['saldo'];
    $tgl     = $_POST['tanggal_daftar'];

    // Jalankan perintah pembaruan (Update) di pusat data
    $sql = "UPDATE nasabah SET
                no_rekening='$no_rek', nama_nasabah='$nama', nik='$nik',
                alamat='$alamat', no_telepon='$telp', saldo=$saldo, tanggal_daftar='$tgl'
            WHERE id=$id";
    mysqli_query($conn, $sql);
    
    // Setelah selesai, kembali ke daftar nasabah dan tampilkan pesan sukses
    header("Location: data_nasabah.php?pesan=edit");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Nasabah - BPR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f4f8; }
    .sidebar { background: #1d4ed8; min-height: 100vh; width: 220px; position: fixed; }
    .sidebar a { color: #bfdbfe; text-decoration: none; display: block; padding: 10px 20px; border-radius: 8px; margin: 4px 8px; font-size: 0.9rem; }
    .sidebar a:hover { background: rgba(255,255,255,0.15); color: #fff; }
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
    <div class="d-flex align-items-center gap-2 mb-4">
      <a href="data_nasabah.php" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
      <h5 class="fw-bold mb-0">Edit Data Nasabah</h5>
    </div>

    <div class="card p-4" style="max-width:640px;">
      <div class="alert alert-info small py-2 mb-3">Mengedit: <strong><?= htmlspecialchars($row['nama_nasabah']) ?></strong></div>
      <form method="POST">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-semibold">No. Rekening</label>
            <input type="text" name="no_rekening" class="form-control" value="<?= htmlspecialchars($row['no_rekening']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">Nama Nasabah</label>
            <input type="text" name="nama_nasabah" class="form-control" value="<?= htmlspecialchars($row['nama_nasabah']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">NIK (KTP)</label>
            <input type="text" name="nik" class="form-control" value="<?= htmlspecialchars($row['nik']) ?>" maxlength="16">
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">No. Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="<?= htmlspecialchars($row['no_telepon']) ?>">
          </div>
          <div class="col-12">
            <label class="form-label small fw-semibold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($row['alamat']) ?></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">Saldo (Rp)</label>
            <input type="number" name="saldo" class="form-control" value="<?= $row['saldo'] ?>" min="0">
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" value="<?= $row['tanggal_daftar'] ?>">
          </div>
        </div>
        <div class="mt-4 d-flex gap-2">
          <button type="submit" name="update" class="btn btn-warning">Simpan Perubahan</button>
          <a href="data_nasabah.php" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
