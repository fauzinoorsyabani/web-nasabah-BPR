<?php
/**
 * PENGATURAN KONEKSI DATABASE
 * File ini berfungsi untuk menghubungkan aplikasi dengan pusat data (database).
 * Tanpa file ini, aplikasi tidak bisa mengambil atau menyimpan data nasabah.
 */

// Informasi identitas server database
$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_nasabah_bpr";

// Proses membuka pintu koneksi ke database
$conn = mysqli_connect($host, $user, $password, $database);

// Jika gagal terhubung, tampilkan pesan kesalahan agar admin tahu
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
