<?php
include 'koneksi.php';
// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];
// Query untuk mencari pengguna berdasarkan username dan password
$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);
// Periksa hasil query
if ($result->num_rows > 0) {
// Pengguna ditemukan, berikan akses atau alihkan ke halaman lain
header("Location: mobil.php");
exit();
//echo "Login berhasil.";
} else {
// Pengguna tidak ditemukan, kembalikan ke halaman login
echo "Login gagal. Cek kembali username dan password.";
}
?>