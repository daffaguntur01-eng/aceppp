<?php 
// Memanggil file pustaka/komponen header atau bilah navigasi (navbar)
require_once ('navbar copy.php');

// Memanggil file koneksi untuk dapat mengakses database MySQL
require_once ('koneksi.php');

// Menyusun query SQL gabungan (LEFT JOIN) untuk mengambil data utama dari tabel 'users',
// serta mencocokkan data relasi dari tabel 'siswa' atau 'guru' berdasarkan ID user.
// Hasil diurutkan berdasarkan ID terbaru (DESC)
$sql = "SELECT 
            users.id AS user_id, 
            users.username, 
            users.role, 
            users.created_at,
            siswa.nama AS nama_siswa,
            guru.nama AS nama_guru
        FROM users 
        LEFT JOIN siswa ON users.id = siswa.user_id 
        LEFT JOIN guru ON users.id = guru.user_id 
        ORDER BY users.id DESC";

// Eksekusi query SQL ke dalam database
$query = mysqli_query($koneksi, $sql);

// Inisialisasi variabel array kosong untuk menampung seluruh baris data dari database
$data = []; 

// Memeriksa apakah eksekusi query berhasil dan memiliki setidaknya 1 baris data
if ($query && mysqli_num_rows($query) > 0) {
    // Memindahkan data baris demi baris dari MySQL ke dalam array $data
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
}
?>

<!-- Kontainer utama halaman dari framework Bootstrap -->
<div class="container mt-4">

    <!-- Bagian judul halaman -->
    <div class="container center">
        <h1 class="fw-normal display-4">Data User</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center"></div>
    </div>

    <!-- Tabel bootstrap untuk menampilkan daftar penggunanya -->
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama / Username</th> 
          <th scope="col">Role</th>
          <th scope="col">Waktu Dibuat</th>
          <th scope="col" style="width: 15%;">Actions</th>
        </tr>
      </thead>
      <tbody>
  <?php
  // Cek apakah array data berisi data/tidak kosong
  if (!empty($data)) {
      // Inisialisasi nomor urut tabel mulai dari angka 1
      $no = 1; 
      
      // Melakukan perulangan foreach untuk merender baris data satu per satu
      foreach ($data as $user) {
          // Logika menentukan nama yang akan ditampilkan:
          // Default awal diisi username, jika nama siswa/guru ada maka nilainya akan ditimpa
          $namaTampil = $user['username'];
          if (!empty($user['nama_siswa'])) {
              $namaTampil = $user['nama_siswa'];
          } elseif (!empty($user['nama_guru'])) {
              $namaTampil = $user['nama_guru'];
          }
    ?>
    <tr>
      <!-- Menampilkan nomor urut dan menaikkannya secara increment ($no++) -->
      <th scope="row"><?php echo $no++; ?></th>
      
      <!-- Menampilkan Nama Lengkap utama dan Username (@username) di bawahnya jika tersedia -->
      <td>
        <strong><?php echo htmlspecialchars($namaTampil); ?></strong>
        <?php if ($namaTampil !== $user['username']): ?>
            <br><small class="text-muted">@<?php echo htmlspecialchars($user['username']); ?></small>
        <?php endif; ?>
      </td>
      
      <!-- Menampilkan Badge Role dengan warna beda-beda (Admin: Merah, Guru: Biru, Siswa: Hijau) -->
      <td>
        <span class="badge <?php echo ($user['role'] == 'admin') ? 'bg-danger' : (($user['role'] == 'guru') ? 'bg-primary' : 'bg-success'); ?>">
            <?php echo htmlspecialchars(ucfirst($user['role'])); ?>
        </span>
      </td>

      <!-- Menampilkan Waktu Dibuatnya Akun -->
      <td><?php echo htmlspecialchars($user['created_at']); ?></td>
      
      <!-- Tombol Aksi Hapus dan Edit Data -->
      <td>
        <!-- Tombol mengarah ke halaman edit dengan membawa parameter GET ID user -->
        <a href="edit_user.php?id=<?= $user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
        
        <!-- Tombol menghapus data dengan konfirmasi pop-up JavaScript terlebih dahulu -->
        <a href="delete_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Delete</a>
      </td>
    </tr>
  <?php 
      } 
  } else {
      // Tampilan jika data dalam tabel/database dalam keadaan kosong
      echo "<tr><td colspan='5' class='text-center'>Tidak ada data user.</td></tr>";
  }
  ?>
</tbody>
    </table>
</div>