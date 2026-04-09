<?php
/**
 * PROSES KELUAR (LOGOUT)
 * File ini digunakan untuk mengeluarkan admin dari sistem dengan aman.
 * Menghapus semua informasi login agar orang lain tidak bisa masuk tanpa izin.
 */

session_start();

// Menghapus (membersihkan) semua data login dari memori (Sesi)
session_destroy();

// Kembali ke halaman Login (pintu masuk)
header("Location: index.php");
exit;
?>
