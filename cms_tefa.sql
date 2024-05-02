-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 05:02 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_tefa`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `idakun` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`idakun`, `username`, `password`, `role`) VALUES
(1, 'mahasiswa', '$2y$10$T143jtbQBxHygdOmstrvV.VBFyzVgaXcXJ7K6WB3x51LbSnM9LMcy', 'mahasiswa'),
(2, 'admincms', '$2y$10$E6BJPYxsAKVpGo0DOXPJKOFhSKjXQYfr1qGL/RLsjl.fwGrZxi34G', 'admincms'),
(3, 'admin', '$2y$10$nvTfdonT.RkmVBnld/xAUePvtKhqV4KzXumJ1rMJMfV8oAYFPt3WG', 'admin'),
(4, 'operator', '$2y$10$zQRChmOFN8IWk1AXZ91ToOKiC2PW0hMh9nfzOBHJc91J9YivsanAC', 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `idfoto` int(11) NOT NULL,
  `idportofolio` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`idfoto`, `idportofolio`, `foto`) VALUES
(7, 1, '1714532466_aaa412a2cf4ba909b723.png'),
(8, 1, '1714532471_cc635dcb0c6c1d519844.png'),
(9, 2, '1714544298_a8d8905385a4e85b0bd2.png');

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `idklien` int(11) NOT NULL,
  `namaklien` varchar(255) NOT NULL,
  `logoklien` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klien`
--

INSERT INTO `klien` (`idklien`, `namaklien`, `logoklien`) VALUES
(11, 'Bekantan Jantan', '1714539657_e063a3696cbfadc97362.png'),
(12, 'Tarkiz', '1714539669_2c1acb8f8f8dc66a2bcb.png');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `idkontak` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `telpon` varchar(255) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`idkontak`, `nama`, `subjek`, `telpon`, `pesan`) VALUES
(24, 'Harlan', 'Testing', '0841232881', 'Halo semuanya'),
(25, 'Harlan', 'Testing2', '0841232881', 'Halo semuanya2');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `idlayanan` int(11) NOT NULL,
  `namalayanan` varchar(255) NOT NULL,
  `deskripsilayanan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`idlayanan`, `namalayanan`, `deskripsilayanan`) VALUES
(1, 'Pembuatan Software', 'Kami menghadirkan solusi perangkat lunak yang disesuaikan dengan kebutuhan unik Anda. Tim pengembangan kami terdiri dari para ahli yang berpengalaman dalam berbagai bahasa pemrograman dan platform. Dari pengembangan aplikasi web hingga perangkat lunak desktop dan mobile, kami siap membantu Anda mewujudkan visi teknologi Anda menjadi produk yang fungsional dan berkualitas.'),
(2, 'Konsultasi Teknologi', 'Kami menyediakan layanan konsultasi teknologi untuk membantu Anda mengatasi tantangan dan mengoptimalkan potensi teknologi informasi dalam bisnis Anda. Tim konsultan kami akan bekerja sama dengan Anda untuk menganalisis kebutuhan Anda, mengevaluasi solusi yang tepat, dan merancang strategi implementasi yang efektif. Dengan pendekatan yang berorientasi pada solusi, kami akan membantu Anda mencapai tujuan bisnis Anda melalui penerapan '),
(3, 'Analisis Data', 'Data adalah aset berharga dalam dunia bisnis modern, dan kami membantu Anda menggali wawasan berharga dari data Anda. Melalui analisis data yang cermat, kami membantu Anda memahami tren, pola, dan peluang yang tersembunyi dalam data Anda. Tim analis data kami menggunakan berbagai teknik analisis, termasuk machine learning dan data mining, untuk memberikan wawasan yang mendalam yang dapat mendukung pengambilan keputusan yang lebih baik dan strategi bisnis yang lebih efektif.');

-- --------------------------------------------------------

--
-- Table structure for table `portofolio`
--

CREATE TABLE `portofolio` (
  `idportofolio` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `namawebsite` varchar(255) NOT NULL,
  `deskripsiwebsite` text DEFAULT NULL,
  `linkwebsite` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portofolio`
--

INSERT INTO `portofolio` (`idportofolio`, `foto`, `namawebsite`, `deskripsiwebsite`, `linkwebsite`, `tanggal`) VALUES
(1, '1714532400_6bd8042215ae4f9c07a3.png', 'Contoh Website', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'https://google.com', '2024-04-24 16:57:28'),
(2, '1714532492_57217feda56fd1bf1c2e.png', 'Bekantan Jantan', 'asdf', 'https://google.com', '2024-05-01 03:01:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`idakun`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`idfoto`),
  ADD KEY `idportofolio` (`idportofolio`);

--
-- Indexes for table `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`idklien`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`idkontak`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`idlayanan`);

--
-- Indexes for table `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`idportofolio`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `idakun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `klien`
--
ALTER TABLE `klien`
  MODIFY `idklien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `idkontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `idlayanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `portofolio`
--
ALTER TABLE `portofolio`
  MODIFY `idportofolio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`idportofolio`) REFERENCES `portofolio` (`idportofolio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
