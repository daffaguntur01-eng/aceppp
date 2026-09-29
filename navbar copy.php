<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar</title>
  
  <!-- Import Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Header / Navbar -->
  <header class="bg-white border-bottom border-light-subtle">
    <div class="container-xl d-flex align-items-center justify-content-between" style="height: 64px;">
      
      <!-- Bagian Kiri: Logo & Menu Desktop -->
      <div class="d-flex align-items-center gap-4 w-100">
        
        <!-- Logo -->
        <a class="text-primary fw-bold fs-5 text-decoration-none" href="index.php">
          Navbar
        </a>

        <!-- Navigasi Desktop -->
        <nav aria-label="Global" class="d-none d-md-block w-100">
          <ul class="d-flex align-items-center justify-content-end justify-content-md-between gap-4 mb-0 list-unstyled w-100">
            <div class="d-flex align-items-center gap-4">
              <li>
                <a class="text-secondary text-decoration-none fw-medium" href="#">About</a>
              </li>
              <li>
                <select 
                  onchange="if(this.value) location.href = this.value;" 
                  class="form-select form-select-sm text-secondary shadow-none cursor-pointer"
                  style="width: auto;"
                >
                  <option value="" disabled selected>Pilih Menu User</option>
                  <option value="tabel copy.php">Daftar User</option>
                  <option value="tabel.php">Siswa</option>
                  <option value="mapel.php">Mapel</option>
                  <option value="form_user1.php">Tambahkan user1</option>
                  <option value="form_user2.php">Tambahkan user2</option>
                  <option value="form_user.php">Tambahkan user3</option>
                  <option value="form_mapel.php">Tambahkan mapel</option>
                </select>
              </li>
            </div>
          </ul>
        </nav>

      </div>

      <!-- Bagian Kanan: Tombol Auth & Mobile Button -->
      <div class="d-flex align-items-center gap-3 ms-4">
        
        <div class="d-flex gap-2">
          <!-- Mengarah ke login_user.php -->
          <a class="btn btn-primary px-4 py-2 fw-medium" style="font-size: 0.875rem;" href="login_user.php">
            Login
          </a>
          <a class="btn btn-light text-primary px-4 py-2 fw-medium d-none d-sm-block" style="font-size: 0.875rem; background-color: #f3f4f6; border: none;" href="registasi.php">
            Register
          </a>
        </div>

        <button class="btn btn-light d-md-none p-2 border-0" aria-label="Toggle menu" style="background-color: #f3f4f6;">
          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

      </div>
    </div>
  </header>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>