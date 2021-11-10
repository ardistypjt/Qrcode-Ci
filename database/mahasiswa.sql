-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2019 at 08:19 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mahasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(25) NOT NULL,
  `nama_adm` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `id_adm` varchar(12) NOT NULL,
  `role_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `nama_adm`, `password`, `id_adm`, `role_id`) VALUES
('admin', 'admin', '123456', '1990235', 0);

-- --------------------------------------------------------

--
-- Table structure for table `datamhs`
--

CREATE TABLE `datamhs` (
  `npm` varchar(10) NOT NULL,
  `namamhs` text NOT NULL,
  `jeniskelamin` text NOT NULL,
  `alamatmhs` varchar(50) NOT NULL,
  `token` char(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `status` varchar(10) NOT NULL,
  `tgllahir` date NOT NULL,
  `about` varchar(200) NOT NULL,
  `foto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datamhs`
--

INSERT INTO `datamhs` (`npm`, `namamhs`, `jeniskelamin`, `alamatmhs`, `token`, `password`, `username`, `status`, `tgllahir`, `about`, `foto`) VALUES
('1634010066', 'ARDISTY PALVELUS JUMALA', 'P', 'KUTISARI Surabaya', 'MgtVq2jOzN5FXTgANaOa', 'kipasangin', 'ardistypj', '', '1998-10-09', 'aku berumur 21 tahun ', 'ardi2.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `iddos` varchar(15) NOT NULL,
  `namados` varchar(50) NOT NULL,
  `alamatodos` varchar(50) NOT NULL,
  `tokendos` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sifo`
--

CREATE TABLE `sifo` (
  `npms` int(15) NOT NULL,
  `namas` varchar(25) NOT NULL,
  `jenisk` varchar(10) NOT NULL,
  `alamats` varchar(50) NOT NULL,
  `tokens` varchar(20) NOT NULL,
  `role_id` int(1) NOT NULL,
  `password` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `status` varchar(10) NOT NULL,
  `tgllahir` date NOT NULL,
  `about` varchar(250) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sifo`
--

INSERT INTO `sifo` (`npms`, `namas`, `jenisk`, `alamats`, `tokens`, `role_id`, `password`, `username`, `status`, `tgllahir`, `about`, `foto`) VALUES
(1634010050, 'Rizqi Chandra', 'Laki Laki', 'Tuban', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010051, 'Miftakhun Nizar', 'L', 'Surabaya', '', 0, 'kiya', 'kiya', '', '1998-06-09', 'rahasia dong', 'IMG_7452.JPG'),
(1634010058, 'Ahmad Sidqi', 'Laki Laki', 'Darmahusada', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010060, 'Syafril Hidayat', 'Laki Laki', 'Perak', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010067, 'Diky Setya W', 'Laki Laki', 'Ketintang', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010068, 'Ilham Setia R', 'Laki Laki', 'Kediri', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010089, 'Akbar Dasoeki', 'Laki Laki', 'Sidoarjo', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010090, 'Darma Ardiansyah', 'Laki Laki', 'Bekasi', '', 0, '', '', '', '0000-00-00', '', ''),
(1634010091, 'Anita Nusari ', 'Perempuan', 'Ngawi', '', 0, '', '', '', '0000-00-00', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_adm`),
  ADD KEY `password` (`password`),
  ADD KEY `username` (`username`),
  ADD KEY `username_2` (`username`,`password`),
  ADD KEY `password_2` (`password`),
  ADD KEY `password_3` (`password`);

--
-- Indexes for table `datamhs`
--
ALTER TABLE `datamhs`
  ADD PRIMARY KEY (`npm`),
  ADD KEY `usernametf` (`username`),
  ADD KEY `pass` (`password`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`iddos`);

--
-- Indexes for table `sifo`
--
ALTER TABLE `sifo`
  ADD PRIMARY KEY (`npms`),
  ADD KEY `passw` (`password`),
  ADD KEY `usernamesf` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
