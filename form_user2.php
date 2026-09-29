<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .form-container { max-width: 400px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); margin: 40px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        .btn-submit { 
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
        .btn-submit:hover { background-color: #0056b3; }

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

<!-- NAVBAR DIPANGGIL DI SINI -->
<?php require_once ('navbar copy.php');?>

<div class="form-container">
    <h2>Form Tambah Data Siswa</h2>
    <form action="proses_simpan.php" method="POST">
        <!-- Input hidden untuk mengirim role otomatis sebagai 'siswa' -->
        <input type="hidden" name="role" value="siswa">

        <div class="form-group">
            <label for="username">Username / Nama Lengkap</label>
            <input type="text" id="username" name="username" required placeholder="Contoh: acep">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Masukkan password akun">
        </div>

        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" id="nis" name="nis" required placeholder="Contoh: 12200341">
        </div>

        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" id="kelas" name="kelas" required placeholder="Contoh: XI-RPL 1">
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L">Laki-laki (L)</option>
                <option value="P">Perempuan (P)</option>
            </select>
        </div>

        <!-- Menambahkan class btn-submit agar styling CSS bekerja -->
        <button type="submit" name="submit" class="btn-submit">Simpan Data</button>
        <a href="tabel copy.php" class="btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>