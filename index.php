<?php

include 'koneksi.php';

session_start();

//membatasi halaman sebelum login
if (!isset($_SESSION["user_name"])){
  echo "<script>
          document.location.href = 'login.php'
        </script>";
    exit;
}
// Filter Cari
$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

//Ambil Total Data
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM data_pengembalian WHERE plat_nomor LIKE '%$keyword%' OR nama_penyewa LIKE '%$keyword%' OR kategori LIKE '%$keyword%' OR status LIKE '%$keyword%'");
$row = mysqli_fetch_assoc($result);
$totalData = $row['total'];

// Tentukan jumlah data per halaman
$dataPerPage = 4;
$totalPages = ceil($totalData / $dataPerPage);

// Tentukan halaman saat ini
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $dataPerPage;

// Ambil data sesuai halaman
$tampil = mysqli_query($koneksi, "SELECT * FROM data_pengembalian WHERE plat_nomor LIKE '%$keyword%' OR nama_penyewa LIKE '%$keyword%' OR kategori LIKE '%$keyword%' OR status LIKE '%$keyword%' ORDER BY id_barang ASC LIMIT $offset, $dataPerPage");

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
              <a class="nav-link text-white" href="logout.php">Logout</a>
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
        <h4 class="ms-3 mb-5">Data Pengembalian Rental Mobil</h4>
        <div class="mx-3">
          <div class="d-flex justify-content-between">
            <a href="" type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahData"
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
                <th style="font-size: 15px;">Plat Nomor</th>
                <th style="font-size: 15px;">Nama Penyewa</th>
                <th style="font-size: 15px;">Durasi Sewa</th>
                <th style="font-size: 15px;">Kategori</th>
                <th style="font-size: 15px;">Status</th>
                <th style="font-size: 15px;">Tanggal Kembali</th>
                <th style="font-size: 15px;" class="text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php
                //menampilkan data
                while ($data = mysqli_fetch_array($tampil)) :
                $tanggal_kembali = date('d-m-Y / H:i', strtotime($data['tanggal_kembali']));
              ?>
              <tr>
                <td style="font-size: 15px;"><?= $data['id_barang'] ?></td>
                <td style="font-size: 15px;"><?= $data['plat_nomor'] ?></td>
                <td style="font-size: 15px;"><?= $data['nama_penyewa'] ?></td>
                <td style="font-size: 15px;"><?= $data['durasi_sewa'] ?></td>
                <td style="font-size: 15px;"><?= $data['kategori'] ?></td>
                <td style="font-size: 15px;"><?= $data['status'] ?></td>
                <td style="font-size: 15px;"><?= $tanggal_kembali ?></td>
                <td>
                  <div class="d-flex justify-content-evenly">
                    <a href="" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detail<?= $data['id_barang'] ?>" 
                      >Detail</a
                    >
                    <a href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubah<?= $data['id_barang'] ?>">Ubah</a>
                    <a
                      href=""
                      type="button"
                      class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $data['id_barang'] ?>"
                      >Hapus</a
                    >
                  </div>
                </td>
              </tr>

              <!-- Modal ubah -->
                <div class="modal fade" id="ubah<?= $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <form method="POST" action="aksi-crud.php" enctype="multipart/form-data">
                        <input type="hidden" name="currentPage" value="<?= $currentPage ?>">
                        <input type="hidden" name="idBarang" value="<?= $data['id_barang'] ?>">
                        <div class="modal-body">
                            <div class="mb-3">
                              <label class="form-label">Plat Nomor</label>
                              <input type="text" class="form-control" name="editPlatNomor" 
                              value="<?= $data['plat_nomor'] ?>" 
                              placeholder="Masukan Plat Nomor">
                            </div>

                            <div class="mb-3">
                              <label class="form-label">Nama Penyewa</label>
                              <input type="text" class="form-control" name="editNama"
                              value="<?= $data['nama_penyewa'] ?>"
                              placeholder="Masukan Nama Penyewa">
                            </div>

                            <div class="d-flex justify-content-between">
                              <div class="mb-3">
                                <label class="form-label">Durasi Sewa</label>
                                <input type="text" class="form-control" name="editDurasi"
                                value="<?= $data['durasi_sewa'] ?>" 
                                placeholder="Masukan Durasi Sewa">
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="editKategori"
                                value="<?= $data['kategori'] ?>"
                                placeholder="Masukan Jenis Mobil">
                              </div>
                            </div>

                            <div class="d-flex justify-content-between">
                              <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" name="editStatus">
                                <?php

                                // Daftar status
                                $daftarStatus = array("Selesai", "On Process");
                                foreach ($daftarStatus as $statusOption) {
                                    $isSelected = ($data['status'] == $statusOption);
                                    echo "<option value='$statusOption' ".($isSelected ? "selected" : "").">$statusOption</option>";
                                }
                                ?>
                                </select>
                              </div>

                              <div class="mb-3">
                                <label class="form-label">Tanggal Kembali</label>
                                <input type="datetime-local" class="form-control" name="editTanggal" value="<?= $data['tanggal_kembali'] ?>">
                              </div>
                            </div>
                              <div class="mb-3">
                                <label for="formFile" class="form-label">Tambahkan Foto</label>
                                <input class="form-control" type="file" id="formFile" name="editFoto">
                              </div>
                        </div>

                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                        </div>
                      </form>>
                    </div>
                  </div>
                </div>
                <!-- End Modal Ubah -->

                <!-- Modal hapus -->
                <div class="modal fade" id="hapus<?= $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <form method="POST" action="aksi-crud.php" enctype="multipart/form-data">
                      <input type="hidden" name="currentPage" value="<?= $currentPage ?>">
                      <input type="hidden" name="idBarang" value="<?= $data['id_barang'] ?>">
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


                <!-- Modal Detial-->
                <div class="modal fade" id="detail<?= $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Detail Data Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <form method="POST" action="aksi-crud.php" enctype="multipart/form-data">
                        <input type="hidden" name="idBarang" value="<?= $data['id_barang'] ?>">
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-4">
                                  <h6>Plat Nomor</h6>
                              </div>
                              <div class="col d-flex">
                                  <h6>:</h6>
                                  <h6 class="ms-3"><?= $data['plat_nomor'] ?></h6>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-4">
                                  <h6>Nama Penyewa</h6>
                              </div>
                              <div class="col d-flex">
                                  <h6>:</h6>
                                  <h6 class="ms-3"><?= $data['nama_penyewa'] ?></h6>
                              </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <h6>Durasi Sewa</h6>
                                </div>
                                <div class="col d-flex">
                                    <h6>:</h6>
                                    <h6 class="ms-3"><?= $data['durasi_sewa'] ?></h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <h6>Kategori</h6>
                                </div>
                                <div class="col d-flex">
                                    <h6>:</h6>
                                    <h6 class="ms-3"><?= $data['kategori'] ?></h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <h6>Status</h6>
                                </div>
                                <div class="col d-flex">
                                    <h6>:</h6>
                                    <h6 class="ms-3"><?= $data['status'] ?></h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <h6>Tanggal Kembali</h6>
                                </div>
                                <div class="col d-flex">
                                    <h6>:</h6>
                                    <h6 class="ms-3"><?= $tanggal_kembali ?></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-3 text-center">
                                    <img src="asset/<?= $data['foto'] ?>" alt="" style="max-width: 250px; height: auto; object-fit: cover;">
                                </div>
                            </div>
                          </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal Detial-->


              <?php endwhile; ?>
            </tbody>
          </table>

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

<!-- Modal tambah -->
<div class="modal fade" id="tambahData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="aksi-crud.php" enctype="multipart/form-data">
      <input type="hidden" name="currentPage" value="<?= $currentPage ?>">
        <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Plat Nomor</label>
              <input type="text" class="form-control" name="tambahPlatNomor" placeholder="Masukan Plat Nomor" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Penyewa</label>
              <input type="text" class="form-control" name="tambahNama" placeholder="Masukan Nama Penyewa" required>
            </div>
            <div class="d-flex justify-content-between">
              <div class="mb-3">
                <label class="form-label">Durasi Sewa</label>
                <input type="text" class="form-control" name="tambahDurasi" placeholder="Masukan Durasi Sewa" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" class="form-control" name="tambahKategori" placeholder="Masukan Jenis Mobil" required>
              </div>
            </div>

            <div class="d-flex justify-content-between">
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" aria-label="Default select example" name="tambahStatus" required>
                  <option></option>
                  <option value="Selesai">Selesai</option>
                  <option value="On Process">On Process</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Tanggal Kembali</label>
                <input type="datetime-local" class="form-control" name="tambahTanggal" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">Tambahkan Foto</label>
              <input class="form-control" type="file" id="formFile" name="tambahFoto">
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="tambahBaru">Tambah</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
        </div>
      </form>
    </div>
  </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
