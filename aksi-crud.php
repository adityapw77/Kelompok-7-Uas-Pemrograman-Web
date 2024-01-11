<?php

// Panggil Koneksi Database
include "koneksi.php";

// Function Tambah Baru
if (isset($_POST['tambahBaru'])) {

  $gambar = '';
  
  if (isset($_FILES['tambahFoto']) && $_FILES['tambahFoto']['error'] == UPLOAD_ERR_OK) {
    $split = explode('.', $_FILES['tambahFoto']['name']);
    $ekstensi = strtolower(end($split));
    
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($ekstensi, $allowedExtensions)) {
      $dir = "asset/";

      $gambar = uniqid() . '.' . $ekstensi;

      $tmpFile = $_FILES['tambahFoto']['tmp_name'];

      move_uploaded_file($tmpFile, $dir . $gambar);
    } else {
      echo "Tipe file tidak valid.";
      exit;
    }
  }

  $tambah = mysqli_query($koneksi, "INSERT INTO data_pengembalian (plat_nomor,nama_penyewa,durasi_sewa,kategori,status,tanggal_kembali,foto) VALUES ('$_POST[tambahPlatNomor]','$_POST[tambahNama]','$_POST[tambahDurasi]','$_POST[tambahKategori]','$_POST[tambahStatus]','$_POST[tambahTanggal]','$gambar')");
  $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;

  if ($tambah) {
    header("Location: index.php?page=$currentPage&cari=$keyword");
  } else {
    echo $tambah;
  }
}

// Update Data
if (isset($_POST['ubah'])) {
  
  $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
  $idBarang = $_POST['idBarang'];
  $result = mysqli_query($koneksi, "SELECT foto FROM data_pengembalian WHERE id_barang = '$idBarang'");
  

  if ($result) {
    $data = mysqli_fetch_assoc($result);

    
    $gambar = isset($data['foto']) ? $data['foto'] : '';
    
    
    $edit = false;

    if (isset($_FILES['editFoto']) && $_FILES['editFoto']['error'] == UPLOAD_ERR_OK) {
      $split = explode('.', $_FILES['editFoto']['name']);
      $ekstensi = strtolower(end($split));

      $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
      if (in_array($ekstensi, $allowedExtensions)) {
        $dir = "asset/";
        $gambar = uniqid() . '.' . $ekstensi;
        move_uploaded_file($_FILES['editFoto']['tmp_name'], $dir . $gambar);

        // Hapus file lama jika ada
        if (!empty($data['foto'])) {
          unlink("asset/" . $data['foto']);
        }
      } else {
        echo "Invalid file type.";
        exit;
      }

      $edit = true;
    }

    // Lanjut proses UPDATE
    $queryUpdate = "UPDATE data_pengembalian SET plat_nomor = '$_POST[editPlatNomor]', nama_penyewa = '$_POST[editNama]', durasi_sewa = '$_POST[editDurasi]', kategori = '$_POST[editKategori]', status = '$_POST[editStatus]', tanggal_kembali = '$_POST[editTanggal]', foto = '$gambar' WHERE id_barang = '$_POST[idBarang]'";
    
    $edit = mysqli_query($koneksi, $queryUpdate);

    if ($edit) {
      header("Location: index.php?page=$currentPage&cari=$keyword");
    } else {
      echo $edit;
    }
  } else {
    echo "Error in fetching data: " . mysqli_error($koneksi);
  }
}

// Hapus Data
if (isset($_POST['hapus'])) {
  $idBarangHapus = $_POST['idBarang'];
  // Ambil nama file gambar yang akan dihapus
  $result = mysqli_query($koneksi, "SELECT foto FROM data_pengembalian WHERE id_barang = '$idBarangHapus'");
  $data = mysqli_fetch_assoc($result);
  $gambarHapus = $data['foto'];

   // Hapus gambar dari folder
  $dir = "asset/";
  unlink($dir . $gambarHapus);

  // Hapus data dari database
  $hapus = mysqli_query($koneksi, "DELETE FROM data_pengembalian WHERE id_barang = '$idBarangHapus'");
  if ($hapus) {
      // Memperbarui indeks setelah penghapusan
      $updateIndex = mysqli_query($koneksi, "ALTER TABLE data_pengembalian AUTO_INCREMENT = 1");
      $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
      
      if ($updateIndex) {
        header("Location: index.php?page=$currentPage&cari=$keyword");
      } else {
          echo "Gagal melakukan pengaturan ulang indeks.";
      }
  } else {
      echo "Gagal menghapus data.";
  }
}
