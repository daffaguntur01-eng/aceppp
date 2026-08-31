<?php 
require_once ('navbar copy.php');
require_once ('koneksi copy.php');

// 1. Cek otomatis nama variabel koneksi dari file 'koneksicopy.php'
if (!isset($koneksi) && isset($koneksicopy)) {
    $koneksi = $koneksicopy;
}

// 2. QUERY FINAL: Menyesuaikan seluruh nama tabel sesuai database Anda
$sql = "SELECT db_siacad_smk_users.*,
        COALESCE(db_siacad_smk_siswa.nama, db_siacad_smk_guru.nama) AS nama_asli
        FROM db_siacad_smk_users
        LEFT JOIN db_siacad_smk_siswa ON db_siacad_smk_users.id = db_siacad_smk_siswa.user_id
        LEFT JOIN db_siacad_smk_guru ON db_siacad_smk_users.id = db_siacad_smk_guru.user_id
        ORDER BY db_siacad_smk_users.id DESC";

// 3. Jalankan query
$query = mysqli_query($koneksi, $sql);

// 4. Wadah penampung data
$data = [];

// 5. Masukkan hasil database ke dalam array jika data ditemukan
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
}
?>

<!-- awal container -->
<div class="container mt-4">
    <div class="container center">
        <h1 class="fw-normal display-4">Data Users</h1>
        <hr class="border border-dark border-2 opacity-100">
    </div>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Username</th>
          <th scope="col">Role</th>
          <th scope="col">Nama</th>
          <th scope="col" style="width: 15%;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // 6. Tampilkan data jika array $data tidak kosong
        if (!empty($data)) {
            $no = 1; 
            foreach ($data as $user) {
          ?>
          <tr>
            <th scope="row"><?php echo $no++; ?></th>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td><?php echo htmlspecialchars($user['nama_asli'] ?? '-'); ?></td>
            <td>
              <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
            </td>
          </tr>
        <?php 
            } 
        } else {
            echo "<tr><td colspan='5' class='text-center'>Tidak ada data ditemukan.</td></tr>";
        }
        ?>
      </tbody>
    </table>
</div>
