<?php 
// Memanggil navbar dan koneksi
require_once ('navbar.php');
require_once ('koneksi.php');

// LOGIKA PROSES SIMPAN (AKSI)
if (isset($_POST['submit'])) {
    // Escape input untuk mencegah SQL Injection
    $kode_mapel = mysqli_real_escape_string($koneksi, trim($_POST['kode_mapel']));
    $nama_mapel = mysqli_real_escape_string($koneksi, trim($_POST['nama_mapel']));
    $guru_id    = mysqli_real_escape_string($koneksi, $_POST['guru_id']);

    // 1. Cek apakah kode_mapel sudah ada di database
    $cek_kode = mysqli_query($koneksi, "SELECT kode_mapel FROM mapel WHERE kode_mapel = '$kode_mapel'");

    if ($cek_kode && mysqli_num_rows($cek_kode) > 0) {
        // Jika kode mapel sudah ada, tampilkan peringatan tanpa merusak halaman
        echo "<script>
                alert('Gagal! Kode Mapel \"$kode_mapel\" sudah digunakan. Gunakan kode lain.');
                window.history.back();
              </script>";
        exit();
    } else {
        // 2. Jika kode mapel belum ada, jalankan query INSERT
        try {
            $sql = "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id) VALUES ('$kode_mapel', '$nama_mapel', '$guru_id')";
            $query = mysqli_query($koneksi, $sql);

            if ($query) {
                echo "<script>
                        alert('Data mata pelajaran berhasil disimpan!');
                        window.location.href = 'mapel.php'; 
                      </script>";
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            echo "<script>
                    alert('Gagal menyimpan data: " . addslashes($e->getMessage()) . "');
                    window.history.back();
                  </script>";
            exit();
        }
    }
}

// Ambil data guru untuk pilihan dropdown Guru Pengampu
$query_guru = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Mapel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .form-container { max-width: 400px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); margin: 40px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        /* Style Tombol Simpan */
        button { 
            background-color: #007bff; 
            color: white; 
            padding: 10px 15px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            width: 100%; 
            margin-top: 10px; 
            font-size: 14px;
        }
        button:hover { background-color: #0056b3; }
        
        /* Style Tombol Kembali */
        .btn-secondary { 
            display: block;
            text-align: center;
            background-color: #6c757d; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 4px; 
            text-decoration: none; 
            width: 100%; 
            margin-top: 10px; 
            box-sizing: border-box;
            font-size: 14px;
        }
        .btn-secondary:hover { background-color: #5a6268; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Form Tambah Mapel</h2>
    
    <form action="" method="POST">
        <div class="form-group">
            <label for="kode_mapel">Kode Mapel</label>
            <input type="text" id="kode_mapel" name="kode_mapel" required placeholder="Contoh: MP001">
        </div>

        <div class="form-group">
            <label for="nama_mapel">Nama Mata Pelajaran</label>
            <input type="text" id="nama_mapel" name="nama_mapel" required placeholder="Contoh: Pemrograman Web">
        </div>

        <div class="form-group">
            <label for="guru_id">Guru Mapel</label>
            <select id="guru_id" name="guru_id" required>
                <option value="">-- Pilih Guru --</option>
                <?php 
                if ($query_guru && mysqli_num_rows($query_guru) > 0) {
                    while ($guru = mysqli_fetch_assoc($query_guru)) {
                        echo "<option value='".htmlspecialchars($guru['id'])."'>".htmlspecialchars($guru['nama'])."</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit" name="submit">Simpan Data</button>
        <a href="mapel.php" class="btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>