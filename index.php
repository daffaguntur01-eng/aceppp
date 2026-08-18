<?php
include 'koneksi.php';

$pesan = ""; // Untuk menampung notifikasi

if (isset($_POST['simpan'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis'");
    
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "<div class='alert error'>Gagal: NIS <b>$nis</b> sudah terdaftar!</div>";
    } else {
        $input = mysqli_query($koneksi, "INSERT INTO siswa (nis, nama, kelas, alamat) VALUES('$nis', '$nama', '$kelas', '$alamat')");
        
        if ($input) {
            $pesan = "<div class='alert success'>Berhasil! Data siswa telah disimpan.</div>";
        } else {
            $pesan = "<div class='alert error'>Gagal: " . mysqli_error($koneksi) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5; /* Abu-abu sangat terang */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            border: 1px solid #e1e4e8;
        }

        h2 {
            margin-top: 0;
            font-weight: 600;
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 25px;
            font-size: 22px;
            letter-spacing: -0.5px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        input[type="text"], 
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #999;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.05);
        }

        textarea {
            height: 80px;
            resize: none;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        button[name="simpan"] {
            background-color: #333; /* Abu-abu Tua / Hitam */
            color: white;
        }

        button[name="simpan"]:hover {
            background-color: #555;
        }

        button[type="reset"] {
            background-color: #e1e4e8;
            color: #555;
        }

        button[type="reset"]:hover {
            background-color: #d1d4d8;
        }

        .link-tampil {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #888;
            font-size: 14px;
        }

        .link-tampil:hover {
            color: #333;
            text-decoration: underline;
        }

        /* Styling Notifikasi */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Data Siswa</h2>
    
    <?php echo $pesan; ?>

    <form method="post" action="">
        <label>NIS</label>
        <input type="text" name="nis" placeholder="Contoh: 12345" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" placeholder="Nama Siswa" required>

        <label>Kelas</label>
        <input type="text" name="kelas" placeholder="Contoh: XII RPL 1">

        <label>Alamat</label>
        <textarea name="alamat" placeholder="Alamat lengkap..."></textarea>
        
        <div class="btn-group">
            <button type="submit" name="simpan">Simpan Data</button>
            <button type="reset">Batal</button>
        </div>
    </form>

    <a href="tampil_siswa.php" class="link-tampil">← Lihat Daftar Siswa</a>
</div>

</body>
</html>