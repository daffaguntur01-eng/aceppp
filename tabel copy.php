<?php 
require_once ('navbar.php');
require_once ('koneksi.php');

// 1. PERBAIKAN: Query langsung ke tabel siswa
$sql = "SELECT * FROM db_siacad_smk_siswa ORDER BY id DESC";

// 2. PERBAIKAN: Jalankan variabel $sql yang berisi query siswa
$query = mysqli_query($koneksi, $sql);

// Inisialisasi array kosong agar tidak error jika database kosong
$data = []; 

if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
}
?>

<!-- awal container -->
<div class="container mt-4">

    <!-- awal -->
    <div class="container center">
        <h1 class="fw-normal display-4">Data Siswa</h1>
        <hr class="border border-dark border-2 opacity-100">
        <div class="row align-items-center"></div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">No</th>
          <!-- Sesuaikan header ini dengan kolom yang ada di tabel siswa Anda -->
          <th scope="col">NISN </th> 
          <th scope="col">Nama Siswa</th>
          <th scope="col" style="width: 15%;">Actions</th>
        </tr>
      </thead>
      <tbody>
  <?php
  if (!empty($data)) {
      $no = 1; 
      foreach ($data as $siswa) {
    ?>
    <tr>
      <th scope="row"><?php echo $no++; ?></th>
      
      <!-- PERBAIKAN: Menampilkan NISN dari database -->
      <td><?php echo htmlspecialchars($siswa['nis']); ?></td>
      
      <!-- Menampilkan Nama Siswa -->
      <td><?php echo htmlspecialchars($siswa['nama']); ?></td>
      
      <td>
        <a href="edit_siswa.php?id=<?php echo $siswa['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
        <a href="delete_siswa.php?id=<?php echo $siswa['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
      </td>
    </tr>
  <?php 
      } 
  } else {
      echo "<tr><td colspan='4' class='text-center'>Tidak ada data siswa.</td></tr>";
  }
  ?>
</tbody>

    </table>
</div>
