<?php
/**
 * HALAMAN TAMBAH NASABAH
 * Halaman ini digunakan untuk memasukkan data nasabah baru ke sistem.
 * Setiap data harus diisi dengan lengkap dan benar.
 */

session_start();

// Cek apakah user sudah login, jika belum kembalikan ke pintu login
if (!isset($_SESSION['user'])) { 
    header("Location: index.php"); 
    exit; 
}

require "koneksi.php";

$error = "";

/**
 * PROSES MENYIMPAN DATA
 * Menjalankan perintah simpan data saat tombol 'Simpan' ditekan.
 */
if (isset($_POST['simpan'])) {
    // Ambil semua data dari formulir (form)
    $no_rek  = mysqli_real_escape_string($conn, trim($_POST['no_rekening']));
    $nama    = mysqli_real_escape_string($conn, trim($_POST['nama_nasabah']));
    $nik     = mysqli_real_escape_string($conn, trim($_POST['nik']));
    $alamat  = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $telp    = mysqli_real_escape_string($conn, trim($_POST['no_telepon']));
    $saldo   = (float)$_POST['saldo'];
    $tgl     = $_POST['tanggal_daftar'];

    /**
     * CEK NOMOR REKENING
     * Memastikan satu nomor rekening hanya digunakan untuk satu orang saja.
     */
    $cek = mysqli_query($conn, "SELECT id FROM nasabah WHERE no_rekening='$no_rek'");
    if (mysqli_num_rows($cek) > 0) {
        // Tampilkan pesan kesalahan jika nomor rekening sudah ada
        $error = "Nomor rekening sudah digunakan!";
    } else {
        // Simpan data ke pusat data (database) jika tidak ada duplikat
        $sql = "INSERT INTO nasabah (no_rekening, nama_nasabah, nik, alamat, no_telepon, saldo, tanggal_daftar)
                VALUES ('$no_rek','$nama','$nik','$alamat','$telp',$saldo,'$tgl')";
        mysqli_query($conn, $sql);
        
        // Setelah berhasil simpan, pindahkan ke daftar nasabah
        header("Location: data_nasabah.php?pesan=tambah");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Nasabah - BPR</title>
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
      <a href="data_nasabah.php">&#9632; Data Nasabah</a>
      <a href="tambah.php" class="active">&#9632; Tambah Nasabah</a>
      <a href="logout.php" style="position:absolute; bottom:20px; left:0; right:0; color:#fca5a5;">&#9632; Logout</a>
    </nav>
  </div>

  <div class="main-content">
    <div class="d-flex align-items-center gap-2 mb-4">
      <a href="data_nasabah.php" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
      <h5 class="fw-bold mb-0">Tambah Nasabah Baru</h5>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger small py-2"><?= $error ?></div>
    <?php endif; ?>

    <div class="card p-4" style="max-width:640px;">
      <form method="POST">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-semibold">No. Rekening <span class="text-danger">*</span></label>
            <input type="text" name="no_rekening" class="form-control" placeholder="Contoh: 2026-004" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">Nama Nasabah <span class="text-danger">*</span></label>
            <input type="text" name="nama_nasabah" class="form-control" placeholder="Nama lengkap" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">NIK (KTP) <span class="text-danger">*</span></label>
            <input type="text" name="nik" class="form-control" placeholder="16 digit NIK" maxlength="16" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">No. Telepon</label>
            <input type="text" name="no_telepon" class="form-control" placeholder="08xxxxxxxxxx">
          </div>
          <div class="col-12">
            <label class="form-label small fw-semibold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap nasabah"></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">Saldo Awal (Rp)</label>
            <input type="number" name="saldo" class="form-control" placeholder="0" min="0" value="0">
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-semibold">Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" value="<?= date('Y-m-d') ?>">
          </div>
        </div>
        <div class="mt-4 d-flex gap-2">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
          <a href="data_nasabah.php" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
