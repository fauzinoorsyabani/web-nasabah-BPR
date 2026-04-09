# README - Web Pengelolaan Nasabah BPR (PKL Project)

## 1. Ringkasan Proyek
Web Pengelolaan Nasabah BPR adalah aplikasi berbasis **PHP + MySQL** yang dibuat untuk memenuhi tugas Praktik Kerja Lapangan (PKL) jurusan Rekayasa Perangkat Lunak (RPL) SMK Negeri Manonjaya. Aplikasi ini memungkinkan petugas bank (admin & CS) untuk mengelola data nasabah secara CRUD, melihat statistik dasar, dan melakukan autentikasi berbasis session.

---

## 2. Arsitektur & Infrastruktur

### 2.1. Komponen Utama
1. **Web Server** – Apache (disediakan oleh XAMPP)
2. **Bahasa Pemrograman** – PHP 8.x (modul Apache)
3. **Database** – MySQL / MariaDB (XAMPP)
4. **Frontend** – HTML5, CSS3 (custom glassmorphism), Bootstrap 5, JavaScript vanilla
5. **Versi Kontrol** – Git (GitHub remote repository)

### 2.2. Diagram Arsitektur (teks)
```
+-------------------+        +-------------------+        +-------------------+
|   Browser (Client)|<------>|   Apache (XAMPP)  |<------>|   MySQL Server    |
+-------------------+        +-------------------+        +-------------------+
        |                               |                         |
        |   HTTP Request (PHP)          |   SQL Queries           |
        |                               |                         |
        v                               v                         v
+-------------------+        +-------------------+        +-------------------+
|  index.php (login)|        |  koneksi.php      |        |  database.sql     |
+-------------------+        +-------------------+        +-------------------+
        |                               |                         |
        |   Session Management          |   DB Connection         |
        v                               v                         v
+-------------------+        +-------------------+        +-------------------+
|  nasabah/ (CRUD)  |        |  user/ (auth)    |        |  Tables: user,   |
|  dashboard/       |        |                  |        |  nasabah         |
+-------------------+        +-------------------+        +-------------------+
```

### 2.3. Infrastruktur Lokal (XAMPP)
- **Folder Root**: `C:\xampp\htdocs\web_nasabah_BPR`
- **Apache Port**: 80 (default)
- **MySQL Port**: 3306 (default)
- **Database Name**: `db_nasabah_bpr`
- **PHP Extensions**: `mysqli`, `session`

---

## 3. Struktur Direktori Proyek
```
web_nasabah_BPR/
│   README.txt                # Dokumen ini (plain text)
│   database.sql              # Skrip SQL untuk membuat DB & seed data
│   koneksi.php               # Helper koneksi MySQL
│   index.php                 # Halaman login utama
│   .git/                     # Repository Git
│   .agents/                  # Workflow (push_to_github.md)
│
├─ assets/                    # Gambar, logo, screenshot
│   └─ screenshot.png
│
├─ nasabah/                   # Modul CRUD nasabah
│   ├─ list.php
│   ├─ add.php
│   ├─ edit.php
│   └─ delete.php
│
├─ user/                      # Modul autentikasi & manajemen user
│   ├─ login.php
│   └─ register.php
│
└─ CARA_JALANKAN_WEBSITE.md   # Panduan instalasi (dihapus, dapat dibuat kembali)
```

---

## 4. Langkah Instalasi & Menjalankan Aplikasi
1. **Instal XAMPP**
   - Unduh dari https://www.apachefriends.org
   - Jalankan *XAMPP Control Panel* → Start **Apache** & **MySQL**
2. **Import Database**
   - Buka `http://localhost/phpmyadmin`
   - Pilih tab **Import**, pilih file `database.sql` di folder proyek, klik **Go**
   - Database `db_nasabah_bpr` beserta tabel `user` & `nasabah` akan terbentuk otomatis
3. **Letakkan File Proyek**
   - Salin seluruh folder `web_nasabah_BPR` ke `C:\xampp\htdocs\`
4. **Akses Aplikasi**
   - Buka browser dan ketik `http://localhost/web_nasabah_BPR/`
   - Login dengan akun default:
     - **Admin**: `admin / admin123`
     - **CS**   : `cs1   / cs123`
5. **Verifikasi**
   - Setelah login, Anda akan diarahkan ke dashboard yang menampilkan statistik nasabah.
   - Coba tambah, edit, atau hapus data nasabah untuk memastikan CRUD berfungsi.

---

## 5. Fitur Utama
- **Autentikasi Session** (login/logout)
- **Dashboard** dengan ringkasan jumlah nasabah & total saldo
- **CRUD Nasabah** (tambah, lihat, edit, hapus, pencarian, pagination)
- **Manajemen User** (admin dapat menambah CS baru)
- **Responsive UI** – tampilan menyesuaikan layar desktop & mobile (Bootstrap 5)
- **Export Data** (opsional, dapat ditambahkan dengan query SELECT ke CSV)

---

## 6. Catatan Keamanan (untuk produksi)
1. Ganti penggunaan `MD5` pada password dengan `password_hash()` & `password_verify()`.
2. Aktifkan **HTTPS** pada server Apache.
3. Batasi akses folder `web_nasabah_BPR` hanya untuk localhost atau IP yang di‑whitelist.
4. Terapkan **prepared statements** untuk semua query SQL guna mencegah SQL Injection.
5. Simpan kredensial DB di file terpisah yang tidak di‑commit ke Git (mis. `.env`).

---

## 7. Penggunaan Git & Deploy ke GitHub
```bash
# Inisialisasi repo (jika belum)
git init
# Tambah semua file
git add .
# Commit pertama
git commit -m "Initial commit - PKL Web Nasabah BPR"
# Tambah remote
git remote add origin https://github.com/fauzinoorsyabani/web-nasabah-BPR.git
# Ganti nama branch ke main
git branch -M main
# Push ke GitHub
git push -u origin main
```

---

## 8. Lisensi
Proyek ini dilisensikan di bawah **MIT License**. Lihat file `LICENSE` untuk detail lengkap.

---

*Dokumen ini disusun untuk keperluan Praktik Kerja Lapangan (PKL) SMK Negeri Manonjaya – Jurusan Rekayasa Perangkat Lunak.*
