<?php 
// Memanggil file pustaka/komponen navigasi utama (navbar)
require_once ('navbar.php');

// Memanggil file koneksi untuk menghubungkan script ke database MySQL
require_once ('koneksi.php');

// Query SQL untuk mengambil data khusus pengguna yang memiliki role 'siswa'
// Menggabungkan (LEFT JOIN) tabel 'users' dengan tabel 'siswa' berdasarkan ID
// Data diurutkan dari ID user yang paling terbaru (DESC)
$sql = "SELECT 
            users.id AS user_id, 
            users.username, 
            users.role, 
            siswa.nis, 
            siswa.nama, 
            siswa.jenis_kelamin 
        FROM users 
        LEFT JOIN siswa ON users.id = siswa.user_id 
        WHERE users.role = 'siswa' 
        ORDER BY users.id DESC";

// Menjalankan perintah query ke database
$query = mysqli_query($koneksi, $sql);

// Inisialisasi array kosong untuk menyimpan baris data hasil eksekusi query
$data = []; 
if ($query && mysqli_num_rows($query) > 0) {
    // Memindahkan data hasil query baris demi baris ke dalam variabel array $data
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
}
?>

<!-- Kontainer utama halaman -->
<div class="container mt-4">

    <!-- Header / Judul Halaman -->
    <div class="container center">
        <h1 class="fw-normal display-4">Data Siswa</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center"></div>
    </div>

    <!-- Tabel Bootstrap dengan efek striped dan hover untuk menampilkan data siswa -->
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">NISN</th> 
          <th scope="col">Nama Siswa</th>
          <th scope="col">Jenis Kelamin</th>
          <th scope="col" style="width: 18%;">Actions</th>
        </tr>
      </thead>
      <tbody>
  <?php
  // Memeriksa apakah terdapat data siswa di dalam array $data
  if (!empty($data)) {
      // Inisialisasi nomor urut tabel mulai dari angka 1
      $no = 1; 
      
      // Melakukan perulangan foreach untuk merender baris tabel satu per satu
      foreach ($data as $siswa) {
          // Logika menentukan nama tampilan:
          // Gunakan isi kolom 'nama' siswa jika ada; jika kosong/NULL, gunakan 'username' sebagai cadangan
          $namaTampil = !empty($siswa['nama']) ? $siswa['nama'] : $siswa['username'];
    ?>
    <tr>
      <!-- Menampilkan nomor urut dan menaikkannya secara otomatis ($no++) -->
      <th scope="row"><?php echo $no++; ?></th>
      
      <!-- Menampilkan NISN (Tampilkan tanda '-' jika nilai NIS kosong/null) -->
      <td><?php echo htmlspecialchars($siswa['nis'] ?? '-'); ?></td>
      
      <!-- Menampilkan Nama Siswa atau Username -->
      <td><?php echo htmlspecialchars($namaTampil); ?></td>

      <!-- Menampilkan Jenis Kelamin (Tampilkan tanda '-' jika tidak diisi) -->
      <td><?php echo htmlspecialchars($siswa['jenis_kelamin'] ?? '-'); ?></td>
      
      <!-- Kolom Tombol Aksi (Edit & Delete) -->
      <td>
        <!-- Tombol Edit mengarah ke halaman edit dengan membawa parameter ID dan Role -->
        <a href="edit_user.php?id=<?= $siswa['user_id']; ?>&role=<?= $siswa['role']; ?>" class="btn btn-warning btn-sm">Edit</a>
        
        <!-- Tombol Hapus dengan konfirmasi berupa pop-up alert JavaScript -->
        <a href="delete_user.php?id=<?= $siswa['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
      </td>
    </tr>
  <?php 
      } 
  } else {
      // Tampilan cadangan jika tabel di database belum memiliki data siswa
      echo "<tr><td colspan='5' class='text-center'>Tidak ada data siswa.</td></tr>";
  }
  ?>
</tbody>
    </table>
</div>