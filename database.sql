-- CARA PENGGUNAAN:
-- Masuk ke phpMyAdmin, buat database baru, lalu klik menu 'SQL' dan tempelkan (paste) semua teks ini di sana.

-- 1. Membuat Rumah Data (Database) untuk aplikasi BPR
CREATE DATABASE IF NOT EXISTS db_nasabah_bpr;
USE db_nasabah_bpr;

-- 2. Membuat Tabel 'User' (Daftar Pengguna Aplikasi)
-- Ini berisi daftar siapa saja yang boleh login ke sistem.
CREATE TABLE IF NOT EXISTS user (
    id       INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50)  NOT NULL UNIQUE, -- Nama unik untuk login
    password VARCHAR(255) NOT NULL,        -- Kata sandi (disimpan rahasia)
    nama     VARCHAR(100) NOT NULL,        -- Nama asli pengguna
    role     ENUM('admin','cs') DEFAULT 'cs' -- Jabatan (admin atau CS)
);

-- Menambahkan akun awal (default) agar bisa langsung digunakan
-- Username: admin / Password: admin123
INSERT INTO user (username, password, nama, role) VALUES
('admin', MD5('admin123'), 'Administrator', 'admin'),
('cs1',   MD5('cs123'),    'Petugas CS',    'cs');

-- 3. Membuat Tabel 'Nasabah' (Daftar Informasi Nasabah)
-- Ini berisi semua data lengkap tentang nasabah bank.
CREATE TABLE IF NOT EXISTS nasabah (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    no_rekening     VARCHAR(20)    NOT NULL UNIQUE, -- Nomor rekening bank
    nama_nasabah    VARCHAR(100)   NOT NULL,        -- Nama lengkap nasabah
    nik             VARCHAR(20)    NOT NULL,        -- Nomor KTP (NIK)
    alamat          TEXT,                           -- Tempat tinggal
    no_telepon      VARCHAR(15),                    -- Nomor HP/WA
    tanggal_daftar  DATE           DEFAULT (CURRENT_DATE), -- Kapan mulai jadi nasabah
    saldo           DECIMAL(15,2)  DEFAULT 0.00     -- Jumlah tabungan saat ini
);

-- Menambahkan beberapa contoh data nasabah untuk latihan
INSERT INTO nasabah (no_rekening, nama_nasabah, nik, alamat, no_telepon, saldo) VALUES
('2026-001', 'Siti Rahayu',    '3204010101900001', 'Jl. Manonjaya No. 12', '081234567890', 5000000.00),
('2026-002', 'Budi Santoso',   '3204010202850002', 'Jl. Tasik Raya No. 5', '082345678901', 12500000.00),
('2026-003', 'Dewi Lestari',   '3204010303950003', 'Jl. Ciawi Km 3',       '083456789012', 800000.00);
