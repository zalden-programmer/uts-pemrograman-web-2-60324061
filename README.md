# uts-pemrograman-web-2-60324061
# Sistem Manajemen Kategori Buku Perpustakaan
Nama: Meiffio Hasanain Mayzaldin
NIM: 60324061

## Deskripsi Aplikasi
Aplikasi web berbasis PHP untuk mengelola kategori buku 
perpustakaan. Aplikasi memiliki fitur CRUD lengkap yaitu 
Create, Read, Update, dan Delete untuk data kategori buku.

### Fitur Utama
- **READ**   : Menampilkan daftar semua kategori buku
- **CREATE** : Menambah kategori buku baru dengan validasi lengkap
- **UPDATE** : Mengubah data kategori yang sudah ada
- **DELETE** : Menghapus kategori dengan konfirmasi

## Cara Instalasi dan Menjalankan Aplikasi

Pastikan sudah terinstall:
- XAMPP (Apache + MySQL)
- Browser (Chrome/Firefox)

### Langkah Instalasi
1. **Clone atau download repository ini**
2. **Copy folder ke htdocs XAMPP**
   contoh: C:\xampp\htdocs\uts_perpustakaan_60324061
   3. **Import database**
   - Buka phpMyAdmin di browser: `localhost/phpmyadmin`
   - Klik **"New"** untuk membuat database baru
   - Beri nama: `uts_perpustakaan_60324061`
   - Klik tab **"Import"**
   - Pilih file `database/uts_perpustakaan_60324061.sql`
   - Klik **"Go"**
4. **Jalankan XAMPP**
   - Start **Apache**
   - Start **MySQL**
5. **Buka aplikasi di browser**
   ketik di browser: localhost/uts_60324061
   
   ## Struktur Folder
   uts_60324061/
├── config/
│   └── database.php
├── database/
│   └── uts_perpustakaan_60324061.sql
├── index.php            # Halaman daftar kategori (READ)
├── create.php           # Halaman tambah kategori (CREATE)
├── edit.php             # Halaman edit kategori (UPDATE)
├── delete.php           # Proses hapus kategori (DELETE)
└── README.md            # Dokumentasi aplikasi
