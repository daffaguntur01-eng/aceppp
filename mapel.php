<?php 
// Memanggil file pustaka/komponen navigasi utama (navbar)
require_once ('navbar.php');

// Memanggil file koneksi untuk menghubungkan script ke database MySQL
require_once ('koneksi.php');

// Query SQL untuk mengambil data mapel dan menggabungkan dengan tabel guru
$sql = "SELECT 
            mapel.id AS mapel_id, 
            mapel.kode_mapel, 
            mapel.nama_mapel, 
            mapel.guru_id,
            guru.nama AS nama_guru 
        FROM mapel 
        LEFT JOIN guru ON mapel.guru_id = guru.id 
        ORDER BY mapel.id DESC";

// Menjalankan perintah query ke database
$query = mysqli_query($koneksi, $sql);

// Inisialisasi array kosong untuk menyimpan baris data
$data = []; 
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
}
?>

<!-- Kontainer utama halaman -->
<div class="container mt-4">

    <!-- Header / Judul Halaman -->
    <div class="container center">
        <h1 class="fw-normal display-4">Data Mata Pelajaran</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center"></div>
    </div>

    <!-- Tabel Bootstrap untuk menampilkan data mapel -->
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode Mapel</th> 
          <th scope="col">Nama Mata Pelajaran</th>
          <th scope="col">Guru Mapel</th>
          <th scope="col" style="width: 18%;">Actions</th>
        </tr>
      </thead>
      <tbody>
  <?php
  if (!empty($data)) {
      $no = 1; 
      foreach ($data as $mapel) {
          // Menentukan nama guru yang tampil (jika ada nama guru gunakan nama, jika tidak gunakan guru_id)
          $guruTampil = !empty($mapel['nama_guru']) ? $mapel['nama_guru'] : $mapel['guru_id'];
    ?>
    <tr>
      <!-- Nomor Urut -->
      <th scope="row"><?php echo $no++; ?></th>
      
      <!-- Kode Mapel -->
      <td><?php echo htmlspecialchars($mapel['kode_mapel'] ?? '-'); ?></td>
      
      <!-- Nama Mapel -->
      <td><?php echo htmlspecialchars($mapel['nama_mapel'] ?? '-'); ?></td>

      <!-- Guru Pengampu (ID / Nama Guru) -->
      <td><?php echo htmlspecialchars($guruTampil ?? '-'); ?></td>
      
      <!-- Tombol Aksi -->
      <td>
        <a href="edit_mapel.php?id=<?= $mapel['mapel_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete_mapel.php?id=<?= $mapel['mapel_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
      </td>
    </tr>
  <?php 
      } 
  } else {
      echo "<tr><td colspan='5' class='text-center'>Tidak ada data mata pelajaran.</td></tr>";
  }
  ?>
</tbody>
    </table>
</div>