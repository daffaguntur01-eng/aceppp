<?php
session_start();

// Connect ke database
require_once ('koneksi.php');

$error = false;
$success = false;
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Sesuai dengan pilihan role pada tabel Anda (Admin, Siswa, Guru)

    // Validasi input
    if (empty($username) || empty($password) || empty($role)) {
        $error = true;
        $message = 'Semua field wajib diisi!';
    } elseif ($password !== $confirm_password) {
        $error = true;
        $message = 'Konfirmasi password tidak cocok!';
    } else {
        // Cek apakah username sudah terdaftar
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $error = true;
            $message = 'Username sudah digunakan, silakan pilih username lain!';
        } else {
            // Hash password untuk keamanan (atau gunakan $password jika database Anda masih plain text)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $waktu_dibuat = date('Y-m-d H:i:s');

            // Insert ke database (Sesuaikan nama tabel 'users' & kolom jika berbeda)
            $insert_query = "INSERT INTO users (username, password, role, waktu_dibuat) VALUES ('$username', '$hashed_password', '$role', '$waktu_dibuat')";

            if (mysqli_query($conn, $insert_query)) {
                $success = true;
                $message = 'Pendaftaran berhasil! Silakan login.';
            } else {
                $error = true;
                $message = 'Gagal mendaftar: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Data User</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-register {
            max-width: 450px;
            margin: 40px auto;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<?php require_once ('navbar.php'); ?>

<div class="container">
    <div class="card card-register p-4">
        <h3 class="text-center mb-4 font-weight-bold">Daftar Akun Baru</h3>

        <?php if ($error) : ?>
            <div class="alert alert-danger text-center p-2" role="alert">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($success) : ?>
            <div class="alert alert-success text-center p-2" role="alert">
                <?= $message; ?> <br>
                <a href="login_user.php" class="fw-bold alert-link">Klik di sini untuk Login</a>
            </div>
        <?php endif; ?>
        <?php require_once ('navbar.php'); ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username / Nama</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role / Peran</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Siswa">Siswa</option>
                    <option value="Guru">Guru</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
            </div>
        </form>
        
        <div class="text-center mt-3">
            <small class="text-muted">Sudah punya akun? <a href="login_user.php">Login di sini</a></small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>