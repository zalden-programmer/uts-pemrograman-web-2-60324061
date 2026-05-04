<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    require_once 'config/database.php';

    $errors = [];
    $kode = '';
    $nama = '';
    $deskripsi = '';
    $status = 'Aktif';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // TODO: Ambil dan sanitasi data dari form
        $kode      = trim(htmlspecialchars($_POST['kode']      ?? ''));
        $nama      = trim(htmlspecialchars($_POST['nama']      ?? ''));
        $deskripsi = trim(htmlspecialchars($_POST['deskripsi'] ?? ''));
        $status    = trim(htmlspecialchars($_POST['status']    ?? ''));

        // TODO: Validasi kode kategori
        if (empty($kode)) {
            $errors['kode'] = "Kode kategori wajib diisi";
        } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors['kode'] = "Kode kategori harus 4-10 karakter";
        } elseif (!preg_match('/^KAT-/', $kode)) {
            $errors['kode'] = "Kode kategori harus diawali 'KAT-'";
        }

        // TODO: Validasi nama kategori
        if (empty($nama)) {
            $errors['nama'] = "Nama kategori wajib diisi";
        } elseif (strlen($nama) < 3) {
            $errors['nama'] = "Nama kategori minimal 3 karakter";
        } elseif (strlen($nama) > 50) {
            $errors['nama'] = "Nama kategori maksimal 50 karakter";
        }
        // TODO: Validasi deskripsi
        if (!empty($deskripsi) && strlen($deskripsi) > 200) {
            $errors['deskripsi'] = "Deskripsi maksimal 200 karakter";
        }

        //validasi status
        if (!in_array($status, ['Aktif', 'Nonaktif'])) {
            $errors['status'] = "Status tidak valid";
        }
        // TODO: Cek duplikasi kode
        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ?");
            $stmt->bind_param("s", $kode);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errors['kode'] = "Kode kategori sudah digunakan";
            }
            $stmt->close();
        }
        // TODO: Jika tidak ada error, insert data
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO kategori
                (kode_kategori, nama_kategori, deskripsi, status)
                VALUES (?, ?, ?, ?)");

            $stmt->bind_param("ssss", $kode, $nama, $deskripsi, $status);

        // TODO: Redirect jika berhasil
            if ($stmt->execute()) {
                $stmt->close();
                closeConnection($conn);
                header("Location: index.php?pesan=" . urlencode("Kategori '$nama' berhasil ditambahkan") . "&tipe=sukses");
                exit();
            } else {
                $errors['db'] = "Error database: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Kategori Baru</h4>
                    </div>
                    <div class="card-body">
                        <!-- TODO: Tampilkan error jika ada -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <h6>Terdapat kesalahan:</h6>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <!-- TODO: Form fields -->

                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Kategori<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control <?php echo isset($errors['kode']) ? 'is-invalid' : ''; ?>"
                                    id="kode"
                                    name="kode"
                                    value="<?php echo $kode; ?>"
                                    placeholder="KAT-001"
                                    required>
                                <?php if (isset($errors['kode'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['kode']; ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">Format: KAT-xxx (4-10 karakter)</small>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kategori<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>"
                                    id="nama"
                                    name="nama"
                                    value="<?php echo $nama; ?>"
                                    placeholder="Nama kategori"
                                    maxlength="50"
                                    required>
                                <?php if (isset($errors['nama'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['nama']; ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">3-50 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi<small class="text-muted">(Opsional)</small>
                                </label>
                                <textarea
                                    class="form-control <?php echo isset($errors['deskripsi']) ? 'is-invalid' : ''; ?>"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="3"
                                    maxlength="200"
                                    placeholder="Deskripsi kategori..."><?php echo $deskripsi; ?></textarea>
                                <?php if (isset($errors['deskripsi'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['deskripsi']; ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">Maksimal 200 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"> Status <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="status"
                                            id="aktif"
                                            value="Aktif"
                                            <?php echo ($status == 'Aktif') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="aktif">Aktif</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="status"
                                            id="nonaktif"
                                            value="Nonaktif"
                                            <?php echo ($status == 'Nonaktif') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="nonaktif">Nonaktif</label>
                                    </div>
                                    <?php if (isset($errors['status'])): ?>
                                        <div class="text-danger small mt-1">
                                            <?php echo $errors['status']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>