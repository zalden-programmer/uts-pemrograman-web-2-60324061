<?php
require_once 'config/database.php';

// TODO: Validasi ID dari GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?pesan=ID tidak valid&tipe=error");
    exit();
}

$id_kategori = (int)$_GET['id'];

// TODO: Cek keberadaan data
$stmt = $conn->prepare("SELECT nama_kategori FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id_kategori);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    closeConnection($conn);
    header("Location: index.php?pesan=Kategori tidak ditemukan&tipe=error");
    exit();
}

$kategori      = $result->fetch_assoc();
$nama_kategori = $kategori['nama_kategori'];
$stmt->close();

// TODO: Delete data
// TODO: Redirect dengan pesan
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id_kategori);

if ($stmt->execute()) {
    
    // Cek affected_rows untuk memastikan berhasil
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        closeConnection($conn);
        header("Location: index.php?pesan=" . urlencode("Kategori '$nama_kategori' berhasil dihapus") . "&tipe=sukses");
        exit();
    } else {
        $stmt->close();
        closeConnection($conn);
        header("Location: index.php?pesan=Gagal menghapus data&tipe=error");
        exit();
    }
} else {
    $error = $stmt->error;
    $stmt->close();
    closeConnection($conn);
    header("Location: index.php?pesan=" . urlencode("Error: $error") . "&tipe=error");
    exit();
}