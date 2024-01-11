<?php

include 'koneksi.php';

session_start();


include 'koneksi.php';
if (!isset($_SESSION["user_name"])){
  echo "<script>
          document.location.href = 'login.php'
        </script>";
    exit;
}
// Filter Cari
$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

//Ambil Total Data
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_user WHERE nama LIKE '%$keyword%' OR user_name LIKE '%$keyword%' OR password LIKE '%$keyword%'");
$row = mysqli_fetch_assoc($result);
$totalData = $row['total'];

// Tentukan jumlah data per halaman
$dataPerPage = 4;
$totalPages = ceil($totalData / $dataPerPage);

// Tentukan halaman saat ini
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $dataPerPage;
$offset = (int) $offset;

// Ambil data sesuai halaman
$tampil = mysqli_query($koneksi, "SELECT * FROM data_user WHERE nama LIKE '%$keyword%' OR user_name LIKE '%$keyword%' OR password LIKE '%$keyword%' ORDER BY id_user ASC LIMIT $offset, $dataPerPage");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Rental Mobil</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg header">
      <div class="container-fluid">
        <a class="navbar-brand text-white ms-3" href="#">Sistem Rental Mobil</a>
        <div>
          <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item">
              <a class="nav-link text-white" href="#">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Side Bar -->
    <div class="main-container d-flex">
      <div class="sidebar" id="side_nav">
        <ul class="list-unstyled px-2 py-3">
          <li class="">
            <a
              href="index.php"
              class="text-decoration-none px-3 py-2 d-block text-white"
            >
              Data Pengembalian</a
            >
          </li>
          <li class="">
            <a
              href="user.php"
              class="text-decoration-none px-3 py-2 d-block text-white"
              >User Aktif</a
            >
          </li>
        </ul>
      </div>
      <div class="judul container mt-5">
        <h4 class="ms-3 mb-5">Data User Aktif</h4>
        <div class="mx-5">
          <div class="d-flex justify-content-between">
            <a href="" type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahUser"
              >Tambah Baru</a
            >
            <form method="GET" action="" class="d-flex mb-3" role="search">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Search..."
                aria-label="Search"
                name="cari"
                value="<?= isset($_GET['cari']) ? $_GET['cari'] : ''?>"
              />
              <button class="btn btn-outline-secondary" type="submit">
                Search
              </button>
            </form>
          </div>
          <table
            class="table table-light table-bordered table-hover table-responsive align-middle px-5"
          >
            <thead class="table-secondary">
              <tr>
                <th style="font-size: 15px;">No</th>
                <th style="font-size: 15px;">Nama Lengkap</th>
                <th style="font-size: 15px;">User Name</th>
                <th style="font-size: 15px;">Password</th>
                <th width="16%" style="font-size: 15px;" class="text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php
                //menampilkan data
                while ($data = mysqli_fetch_array($tampil)) :
              ?>
              <tr>
                <td style="font-size: 15px;"><?= $data['id_user'] ?></td>
                <td style="font-size: 15px;"><?= $data['nama'] ?></td>
                <td style="font-size: 15px;"><?= $data['user_name'] ?></td>
                <td style="font-size: 15px;"><?= $data['password'] ?></td>
                <td>
                  <div class="d-flex justify-content-between">
                    <a href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubah<?= $data['id_user'] ?>">Ubah</a>
                    <a
                      href=""
                      type="button"
                      class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $data['id_user'] ?>"
                      >Hapus</a
                    >
                  </div>
                </td>
              </tr>

              <!-- Modal ubah -->
                <div class="modal fade" id="ubah<?= $data['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data User</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form method="POST" action="aksi-user.php">
                          <input type="hidden" name="currentPage" value="<?= $currentPage ?>">
                          <input type="hidden" name="idUser" value="<?= $data['id_user'] ?>">
                          <div class="modal-body">
                            <div class="mb-3">
                              <label class="form-label">Nama Lengkap</label>
                              <input type="text" class="form-control" name="namaLengkap" value="<?= $data['nama'] ?>" placeholder="Masukan Nama Lengkap">
                            </div>
                              <div class="mb-3">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" name="userName" value="<?= $data['user_name'] ?>" placeholder="Masukan User Name">
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="text" class="form-control" name="passwordUser" value="<?= $data['password'] ?>" placeholder="Masukan Password">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                            </div>
                          </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal Ubah -->

                <!-- Modal hapus -->
                <div class="modal fade" id="hapus<?= $data['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <form method="POST" action="aksi-user.php">
                        <input type="hidden" name="currentPage" value="<?= $currentPage ?>">
                        <input type="hidden" name="idUser" value="<?= $data['id_user'] ?>">
                          <div class="modal-body">
                              <h5 class="text-center">Apakah Anda Ingin Menghapus Data Ini?</h5>
                          </div>

                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="hapus">Ya, Hapus Saja</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal hapus -->

              <?php endwhile; ?>
            </tbody>
          </table>

          <!-- Modal tambah -->
          <div class="modal fade" id="tambahUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title fs-5" id="staticBackdropLabel">Tambah User Aktif</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="register.php">
                  <input type="hidden" name="currentPage" value="<?= $currentPage ?>">
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="namaLengkap" placeholder="Masukan Nama Lengkap">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" name="userName" placeholder="Masukan User Name">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="passwordUser" placeholder="Masukan Password">
                      </div>
                    </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="tambahUser">Tambah</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <nav aria-label="...">
            <div class="d-flex justify-content-end">
              <ul class="pagination">
                <?php
                  // Tampilkan tombol Previous jika bukan halaman pertama
                  if ($currentPage > 1) {
                      $prevPage = $currentPage - 1;
                      echo "<li class='page-item'><a class='page-link' href='?page=$prevPage&cari=$keyword'>Previous</a></li>";
                  }

                  // Tampilkan halaman-halaman
                  for ($i = 1; $i <= $totalPages; $i++) {
                      $activeClass = ($i == $currentPage) ? 'active' : '';
                      echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i&cari=$keyword'>$i</a></li>";
                  }

                  // Tampilkan tombol Next jika bukan halaman terakhir
                  if ($currentPage < $totalPages) {
                      $nextPage = $currentPage + 1;
                      echo "<li class='page-item'><a class='page-link' href='?page=$nextPage&cari=$keyword'>Next</a></li>";
                  }
                ?>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
