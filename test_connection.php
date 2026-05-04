<?php
// Panggil file koneksi
require_once 'config/database.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika berhasil
echo "<strong>Koneksi ke database berhasil!</strong>";
?>