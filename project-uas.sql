-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jan 2024 pada 22.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pengembalian`
--

CREATE TABLE `data_pengembalian` (
  `id_barang` int(11) NOT NULL,
  `plat_nomor` varchar(30) NOT NULL,
  `nama_penyewa` varchar(50) NOT NULL,
  `durasi_sewa` varchar(15) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tanggal_kembali` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pengembalian`
--

INSERT INTO `data_pengembalian` (`id_barang`, `plat_nomor`, `nama_penyewa`, `durasi_sewa`, `kategori`, `status`, `tanggal_kembali`, `foto`) VALUES
(1, 'B 12345 APB', 'Aditya Pratama Werdana', '2 hari', 'Toyota Fortuner', 'Selesai', '2024-01-02 13:26:27', '659f0dcf7cc89.jpg'),
(2, 'B 54321 APB', 'Muazmar SB', '3 hari', 'Toyota Avanza', 'On Process', '2024-01-10 20:06:03', '659f0de25c6c6.jpg'),
(3, 'B 23478 APB', 'Mia Larasati Mukti', '1 hari', 'Toyota Pajero', 'Selesai', '2024-01-10 20:05:56', '659f0dfe7012f.jpg'),
(4, 'B 2609 BAA', 'Aditya Pratama Werdana', '3 Hari', 'Toyota Agya', 'On Process', '2024-01-08 20:54:00', '659f0e21d7431.jpg'),
(5, 'B 2456 DAB', 'Muazmar SB', '2 Hari', 'Honda Jazz', 'Selesai', '2024-01-10 20:47:00', '659f0dc7bc799.jpg'),
(7, 'B 2456 DAB', 'Mia Larasakti Mukti', '3 Hari', 'Honda Jazz', 'On Process', '2024-01-10 21:30:00', '659f0d7d5f556.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_user`
--

INSERT INTO `data_user` (`id_user`, `nama`, `user_name`, `password`) VALUES
(1, 'Aditya Pratama Werdana', 'adityapw', '202cb962ac59075b964b07152d234b70'),
(2, 'Mia Larasati Mukti', 'mialaras', '202cb962ac59075b964b07152d234b70'),
(3, 'Muazmar SB', 'muazmar', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_pengembalian`
--
ALTER TABLE `data_pengembalian`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_pengembalian`
--
ALTER TABLE `data_pengembalian`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
