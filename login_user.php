<?php
session_start();

// Connect ke database
require_once ('koneksi.php');

$error = false;

// Proses saat tombol Login ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query ke tabel user (Sesuaikan nama tabel 'users' & kolom jika berbeda)
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password (gunakan $password == $row['password'] jika belum di-hash)
        if ($password === $row['password'] || password_verify($password, $row['password'])) { 
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            
            header("Location: tabel%20copy.php");
            exit;
        }
    }
    
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Data User</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-login {
            max-width: 400px;
            margin: 60px auto;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<?php require_once ('navbar.php'); ?>

<div class="container">
    <div class="card card-login p-4">
        <h3 class="text-center mb-4 font-weight-bold">Login Sistem</h3>

        <?php if ($error) : ?>
            <div class="alert alert-danger text-center p-2" role="alert">
                Username atau Password salah!
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username / Nama</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        
        <div class="text-center mt-3">
            <small class="text-muted">Belum punya akun? <a href="registasi.php">Register</a></small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>