<?php
// Membuka koneksi ke database MySQL (host, username, password, nama_database)
$koneksi = mysqli_connect("localhost", "root", "", "acep");

// Memeriksa apakah koneksi ke database berhasil atau gagal
if (!$koneksi) {
    // Jika gagal, hentikan eksekusi script dan tampilkan pesan kesalahan
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil ID dari parameter URL ($_GET['id'])
// Menggunakan null coalescing operator (??) dan type casting (int) untuk keamanan dari SQL Injection sederhana
$id = (int)($_GET['id'] ?? 0);

// Memvalidasi apakah ID yang diterima layak (harus lebih besar dari 0)
if ($id <= 0) {
    die("ID user tidak valid.");
}

// Mengambil data pengguna dari tabel 'users' berdasarkan ID yang dikirim
$queryUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id");

// Memeriksa apakah query berhasil dan apakah data user ditemukan di database
if (!$queryUser || mysqli_num_rows($queryUser) == 0) {
    die("Data user tidak ditemukan.");
}

// Mengubah hasil query user menjadi array asosiatif
$user = mysqli_fetch_assoc($queryUser);

// Mengambil nilai 'role', mengubah ke huruf kecil, dan menghapus spasi di awal/akhir
$role = strtolower(trim($user['role'] ?? ''));

// Inisialisasi array kosong untuk menyimpan data siswa
$siswa = [];
// Jika role pengguna adalah 'siswa', ambil data detailnya dari tabel 'siswa'
if ($role == 'siswa') {
    $querySiswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE user_id = $id");
    // Jika data siswa ditemukan, simpan ke variabel $siswa
    if ($querySiswa && mysqli_num_rows($querySiswa) > 0) {
        $siswa = mysqli_fetch_assoc($querySiswa);
    }
}

// Inisialisasi array kosong untuk menyimpan data guru
$guru = [];
// Jika role pengguna adalah 'guru', ambil data detailnya dari tabel 'guru'
if ($role == 'guru') {
    $queryGuru = mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id = $id");
    // Jika data guru ditemukan, simpan ke variabel $guru
    if ($queryGuru && mysqli_num_rows($queryGuru) > 0) {
        $guru = mysqli_fetch_assoc($queryGuru);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <!-- Memanggil CSS Bootstrap 5 melalui CDN untuk styling antarmuka -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <!-- Kartu pembungkus form -->
            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <h3 class="fw-bold mb-4">Edit Data</h3>

                    <!-- Tampilan Role (Disabled/Tidak bisa diubah langsung oleh pengguna) -->
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control text-capitalize" value="<?= htmlspecialchars($role); ?>" disabled>
                    </div>

                    <!-- ========================================== -->
                    <!-- FORM EDIT DATA SISWA                      -->
                    <!-- Ditampilkan hanya jika role == 'siswa'    -->
                    <!-- ========================================== -->
                    <?php if ($role == 'siswa'): ?>
                        <hr>
                        <h5 class="fw-bold mb-3">Data Siswa</h5>
                        <form method="POST" action="aksi_edit.php">
                            <!-- Input tersembunyi untuk mengirimkan ID user ke aksi_edit.php -->
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            
                            <!-- Input NIS -->
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($siswa['nis'] ?? ''); ?>" required>
                            </div>

                            <!-- Input Nama Siswa -->
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama_siswa" class="form-control" value="<?= htmlspecialchars($siswa['nama'] ?? $siswa['nama_siswa'] ?? ''); ?>" required>
                            </div>

                            <!-- Input Kelas -->
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="<?= htmlspecialchars($siswa['kelas'] ?? ''); ?>" required>
                            </div>

                            <!-- Pilihan Jenis Kelamin -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <!-- Menandai opsi terpilih berdasarkan data di database -->
                                    <option value="L" <?= ($siswa['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="P" <?= ($siswa['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>

                            <!-- Tombol Aksi Form Siswa -->
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="tabel copy.php" class="btn btn-secondary">Batal</a>
                        </form>

                    <!-- ========================================== -->
                    <!-- FORM EDIT DATA GURU                       -->
                    <!-- Ditampilkan hanya jika role == 'guru'     -->
                    <!-- ========================================== -->
                    <?php elseif ($role == 'guru'): ?>
                        <hr>
                        <h5 class="fw-bold mb-3">Data Guru</h5>
                        <form method="POST" action="aksi_edit.php">
                            <!-- Input tersembunyi untuk mengirimkan ID user -->
                            <input type="hidden" name="id" value="<?= $id; ?>">

                            <!-- Input NIP -->
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" value="<?= htmlspecialchars($guru['nip'] ?? ''); ?>" required>
                            </div>

                            <!-- Input Nama Guru -->
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($guru['nama'] ?? $guru['nama_guru'] ?? ''); ?>" required>
                            </div>

                            <!-- Pilihan Jenis Kelamin -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <!-- Menandai opsi terpilih berdasarkan data di database -->
                                    <option value="L" <?= ($guru['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="P" <?= ($guru['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>

                            <!-- Tombol Aksi Form Guru -->
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="tabel copy.php" class="btn btn-secondary">Batal</a>
                        </form>

                    <!-- ========================================== -->
                    <!-- FORM EDIT DATA ADMIN                      -->
                    <!-- Ditampilkan hanya jika role == 'admin'    -->
                    <!-- ========================================== -->
                    <?php elseif ($role == 'admin'): ?>
                        <hr>
                        <h5 class="fw-bold mb-3">Data Admin</h5>
                        <form method="POST" action="aksi_edit.php">
                            <!-- Input tersembunyi untuk mengirimkan ID user -->
                            <input type="hidden" name="id" value="<?= $id; ?>">

                            <!-- Input Username -->
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? ''); ?>" required>
                            </div>

                            <!-- Input Password Baru (Opsional) -->
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                                <small class="text-muted">Kosongkan jika password lama tetap digunakan.</small>
                            </div>

                            <!-- Tombol Aksi Form Admin -->
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="tabel copy.php" class="btn btn-secondary">Batal</a>
                        </form>

                    <!-- ========================================== -->
                    <!-- TAMPILAN JIKA ROLE TIDAK DIKENALI         -->
                    <!-- ========================================== -->
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Role '<?= htmlspecialchars($role); ?>' tidak dikenali.
                        </div>
                        <a href="tabel copy.php" class="btn btn-secondary">Kembali</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>