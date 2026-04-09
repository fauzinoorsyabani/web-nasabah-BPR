==============================================
CARA MENJALANKAN WEBSITE PENGELOLAAN NASABAH
SMK NEGERI MANONJAYA - JURUSAN RPL
==============================================

LANGKAH 1: INSTALL XAMPP
-------------------------
- Download XAMPP dari: https://www.apachefriends.org
- Install dan jalankan Apache + MySQL dari XAMPP Control Panel

LANGKAH 2: BUAT DATABASE
-------------------------
1. Buka browser, ketik: http://localhost/phpmyadmin
2. Klik "Import" (tab atas)
3. Pilih file "database.sql" dari folder ini
4. Klik "Go" / Impor
(Database db_nasabah_bpr akan otomatis dibuat)

LANGKAH 3: TARUH FILE WEBSITE
------------------------------
1. Copy seluruh folder "web_nasabah" ini
2. Paste ke: C:\xampp\htdocs\
   (Hasilnya: C:\xampp\htdocs\web_nasabah\)

LANGKAH 4: BUKA DI BROWSER
----------------------------
Ketik di browser: http://localhost/web_nasabah/

LOGIN DEFAULT:
- Username: admin  | Password: admin123
- Username: cs1    | Password: cs123

==============================================
FITUR WEBSITE:
- Login dengan autentikasi session
- Dashboard dengan statistik nasabah
- Lihat, cari, tambah, edit, hapus data nasabah
- Tampilan responsif dengan Bootstrap 5
==============================================
