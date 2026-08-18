<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa | E-TOOL</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 40px 20px;
            color: #333;
            display: flex;
            justify-content: center;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 900px;
            border: 1px solid #e1e4e8;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 {
            margin: 0;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        .btn-tambah {
            background-color: #333;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-tambah:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #fafafa;
            text-align: left;
            padding: 15px;
            font-size: 13px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 15px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }

        .badge-kelas {
            background-color: #e1e4e8;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #555;
        }

        .btn-aksi {
            color: #888;
            text-decoration: none;
            margin-right: 10px;
            transition: 0.3s;
        }

        .btn-aksi:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Daftar Siswa</h2>
        <a href="form_siswa.php" class="btn-tambah">
            <i class="fas fa-plus me-1"></i> Tambah Siswa
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama ASC");
            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td style="font-weight: 600; color: #333;"><?php echo $data['nis']; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><span class="badge-kelas"><?php echo $data['kelas']; ?></span></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td style="text-align: center;">
                            <a href="#" class="btn-aksi" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn-aksi" title="Hapus" style="color: #ffbaba;" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5' class='no-data'>Belum ada data siswa.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>