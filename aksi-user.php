<?php

// Panggil Koneksi Database
include "koneksi.php";

// Function Tambah Baru
if (isset($_POST['tambahUser'])) {
  $tambah = mysqli_query($koneksi,"INSERT INTO data_user (nama,user_name,password) VALUES ('$_POST[namaLengkap]','$_POST[userName]','$_POST[passwordUser]')");
  $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;

  if ($tambah) {
    header("Location: user.php?page=$currentPage&cari=$keyword");
  } else {
    echo $tambah;
  }
}

// Update Data
if (isset($_POST['ubah'])) {
  $edit = mysqli_query($koneksi,"UPDATE data_user SET nama = '$_POST[namaLengkap]',user_name = '$_POST[userName]',password = '$_POST[passwordUser]' WHERE id_user = '$_POST[idUser]'");
  $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;

  if ($edit) {
    header("Location: user.php?page=$currentPage&cari=$keyword");
  } else {
    echo $edit;
  }
}

// Hapus Data
if (isset($_POST['hapus'])) {
  $idUserHapus = $_POST['idUser'];
  $hapus = mysqli_query($koneksi, "DELETE FROM data_user WHERE id_user = '$idUserHapus'");

  if ($hapus) {
      // Memperbarui indeks setelah penghapusan
      $updateIndex = mysqli_query($koneksi, "ALTER TABLE data_user AUTO_INCREMENT = 1");
      $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
      
      if ($updateIndex) {
          header("Location: user.php?page=$currentPage&cari=$keyword");
      } else {
          echo "Gagal melakukan pengaturan ulang indeks.";
      }
  } else {
      echo "Gagal menghapus data.";
  }
}
