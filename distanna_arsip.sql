-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.39-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table distanna_arsip.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.ci_sessions: ~27 rows (approximately)
DELETE FROM `ci_sessions`;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('00v7aj089s84misn174psv20lbu25mfo', '127.0.0.1', 1638156306, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135363330363B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('08c8itcgq6la003fmpole6vfts2pad2b', '127.0.0.1', 1638172209, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383137313936383B7573657269647C733A353A225553522D33223B726F6C655F69647C733A313A2233223B6E616D657C733A31323A224B61737562616720556D756D223B6E6F6D6F725F696E64756B7C733A353A223039383736223B),
	('0d7afivamiienfmtialkcsnud4it10p0', '127.0.0.1', 1638149086, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383134393038363B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('0u7lse881j0uc7s0fqin7mcv7airfqtl', '127.0.0.1', 1638150423, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135303432333B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('196jadqnudvp45k4u5kfam0ljd293itr', '127.0.0.1', 1638155604, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135353630343B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('1ie6ena9bhrja3tu46dtqpbhagr6o32c', '127.0.0.1', 1638156981, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135363938313B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('5sekh7iiqgq2jush2qnkgv0hb4us25o4', '127.0.0.1', 1638171968, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383137313936383B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('77eh3rmm20kgjfn7ltlr8rn60a9suleg', '127.0.0.1', 1638151250, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135313235303B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('7r7go35hes40va02639167a9jm4jdqbq', '127.0.0.1', 1638157425, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135373432353B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('8g61v0irk8s6g3r0g30jseuu0u7fckta', '127.0.0.1', 1638423438, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383432333433383B7573657269647C733A353A225553522D32223B726F6C655F69647C733A313A2232223B6E616D657C733A31303A2253656B72657461726973223B6E6F6D6F725F696E64756B7C733A353A223637383930223B),
	('d7vjsvj55miapuh568370bftn0k6pfo8', '127.0.0.1', 1638153086, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135333038363B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('dek0ddh1onson9s62dr9p4fmscojgfab', '127.0.0.1', 1638158686, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135383638363B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('e9gkgkp81nh6r61f6g3pk4k82u72k6g7', '127.0.0.1', 1638150748, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135303734383B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('evdie5avhagjfoj23kue0o9bthufud24', '127.0.0.1', 1638153956, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135333935363B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('fbc75vf33ur40rmb8tv4u2nhdrac9a81', '127.0.0.1', 1638148442, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383134383434323B),
	('g0du2n5qs6dqbtej4edsq9c2ghpspe2b', '127.0.0.1', 1638156664, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135363636343B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('gj4bnha5pnb0hsugd2nuok58a9mm3gfb', '127.0.0.1', 1638423957, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383432333935373B7573657269647C733A353A225553522D32223B726F6C655F69647C733A313A2232223B6E616D657C733A31303A2253656B72657461726973223B6E6F6D6F725F696E64756B7C733A353A223637383930223B),
	('hoftrof4a32qrhkbnr2e0a8nmnjrm3bb', '127.0.0.1', 1638154322, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135343332323B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('imc3tice7a49mm789p6h41d57p3oev71', '127.0.0.1', 1638158220, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135383232303B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('j9a4jkm5ngfg6t6ue0vf0foq0pc4uj88', '127.0.0.1', 1638154830, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135343833303B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('jdsfd95ogo9q9iurfpj6iash6hg3vdut', '127.0.0.1', 1638157910, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135373931303B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('kjcqhtumlo15br0hugrla7k8vrt3vf77', '127.0.0.1', 1638158696, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135383638363B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('lm74uviuof6fn2j2sn8nc43lbmta7tl8', '127.0.0.1', 1638171562, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383137313536323B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('nu03s9abnbvqmkpfhrff3uemcolb6l6d', '127.0.0.1', 1638155919, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135353931393B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('ouf5s3oi7h682p7gg7cal6mh7prhtiuq', '127.0.0.1', 1638426769, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383432363736393B7573657269647C733A353A225553522D32223B726F6C655F69647C733A313A2232223B6E616D657C733A31303A2253656B72657461726973223B6E6F6D6F725F696E64756B7C733A353A223637383930223B),
	('pgvdava0vqo45vmmfjmvrbnk68q2698p', '127.0.0.1', 1638153652, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135333635323B7573657269647C733A353A225553522D35223B726F6C655F69647C733A313A2235223B6E616D657C733A31303A22556E6974204B65726A61223B6E6F6D6F725F696E64756B7C733A383A223334323334323334223B),
	('qm496uj2q3661ho8317fsa1t889q98cc', '127.0.0.1', 1638426876, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383432363736393B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('s2ubi1mik8ndpn35q7v9bin3hf2ktf24', '127.0.0.1', 1638151623, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135313632333B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B),
	('u1p26h7v2ipqb88pqviefl655udn5o4l', '127.0.0.1', 1638155165, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313633383135353136353B7573657269647C733A353A225553522D31223B726F6C655F69647C733A313A2231223B6E616D657C733A31323A224B6570616C612044696E6173223B6E6F6D6F725F696E64756B7C733A353A223132333435223B);
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.mst_apps
CREATE TABLE IF NOT EXISTS `mst_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_login` varchar(128) NOT NULL,
  `subjudul` varchar(128) NOT NULL,
  `nama_aplikasi` varchar(128) NOT NULL,
  `logo` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.mst_apps: ~0 rows (approximately)
DELETE FROM `mst_apps`;
/*!40000 ALTER TABLE `mst_apps` DISABLE KEYS */;
INSERT INTO `mst_apps` (`id`, `judul_login`, `subjudul`, `nama_aplikasi`, `logo`) VALUES
	(1, 'SIASEPP KECe', 'Sistem Administrasi Surat Menyurat Dinas Pertanian dan Peternakan yang Akuntable Efisien dan Cepat', 'SIASEPP KECe', 'musirawas2.png');
/*!40000 ALTER TABLE `mst_apps` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.mst_indeks
CREATE TABLE IF NOT EXISTS `mst_indeks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.mst_indeks: ~2 rows (approximately)
DELETE FROM `mst_indeks`;
/*!40000 ALTER TABLE `mst_indeks` DISABLE KEYS */;
INSERT INTO `mst_indeks` (`id`, `nama`, `kode`, `deskripsi`, `date_created`) VALUES
	(9, 'Surat Keterangan', 'SKET', 'Coba buat indeks surat', '2021-11-14 05:43:35'),
	(10, 'Surat Keputusan', 'SK', 'Coba buat indeks surat', '2021-11-14 05:43:56');
/*!40000 ALTER TABLE `mst_indeks` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.mst_unit_kerja
CREATE TABLE IF NOT EXISTS `mst_unit_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(128) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `deskripsi` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.mst_unit_kerja: ~2 rows (approximately)
DELETE FROM `mst_unit_kerja`;
/*!40000 ALTER TABLE `mst_unit_kerja` DISABLE KEYS */;
INSERT INTO `mst_unit_kerja` (`id`, `nama`, `kode`, `deskripsi`, `date_created`) VALUES
	(2, 'Marketing', 'MKT', 'Departement Marketing', '2021-11-14 16:24:33'),
	(3, 'Administrasi', 'ADM', 'Departement Administrasi', '2021-11-14 16:24:38');
/*!40000 ALTER TABLE `mst_unit_kerja` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.tbl_disposisi
CREATE TABLE IF NOT EXISTS `tbl_disposisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat` int(11) NOT NULL,
  `no_surat` varchar(128) NOT NULL,
  `pengirim` varchar(128) NOT NULL,
  `penerima` varchar(128) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nomor_agenda` varchar(50) NOT NULL,
  `is_read` enum('YES','NO') NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`id`),
  KEY `id_surat` (`id_surat`),
  KEY `no_surat` (`no_surat`),
  KEY `pengirim` (`pengirim`),
  KEY `penerima` (`penerima`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.tbl_disposisi: ~9 rows (approximately)
DELETE FROM `tbl_disposisi`;
/*!40000 ALTER TABLE `tbl_disposisi` DISABLE KEYS */;
INSERT INTO `tbl_disposisi` (`id`, `id_surat`, `no_surat`, `pengirim`, `penerima`, `date_created`, `nomor_agenda`, `is_read`) VALUES
	(19, 1, '09/XXX/JAI/2021', 'Pengagenda', 'Kepala Dinas', '2021-11-18 12:13:42', '', 'NO'),
	(25, 1, '09/XXX/JAI/2021', 'Kepala Dinas', 'Kasubag Umum', '2021-11-18 16:04:05', '', 'NO'),
	(26, 1, '09/XXX/JAI/2021', 'Kepala Dinas', 'Pengagenda', '2021-11-23 09:11:31', '', 'NO'),
	(27, 1, '09/XXX/JAI/2021a', 'Kepala Dinas', 'Unit Kerja', '2021-11-23 09:12:39', '', 'NO'),
	(28, 2, '001/SKET/ART/X/2021', 'Kepala Dinas', 'Pengagenda', '2021-11-26 11:43:16', 'asdasd', 'NO'),
	(29, 2, '001/SKET/ART/X/2021', 'Kepala Dinas', 'Kasubag Umum', '2021-11-26 11:43:16', 'asdasd', 'NO'),
	(30, 2, '001/SKET/ART/X/2021', 'Kepala Dinas', 'Sekretaris', '2021-11-26 11:43:16', 'asdasd', 'NO'),
	(31, 4, 'SURAT-01', 'Kepala Dinas', 'Pengagenda', '2021-11-29 09:07:23', 'sadasd', 'NO'),
	(32, 4, 'SURAT-01', 'Kepala Dinas', 'Kasubag Umum', '2021-11-29 09:07:23', 'sadasd', 'NO');
/*!40000 ALTER TABLE `tbl_disposisi` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.tbl_log
CREATE TABLE IF NOT EXISTS `tbl_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL,
  `activity` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `date_created` (`date_created`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table distanna_arsip.tbl_log: ~48 rows (approximately)
DELETE FROM `tbl_log`;
/*!40000 ALTER TABLE `tbl_log` DISABLE KEYS */;
INSERT INTO `tbl_log` (`id`, `userid`, `activity`, `date_created`) VALUES
	(106, 'USR-1', 'Register new user asdasd', '2021-11-02 11:42:16'),
	(107, 'USR-1', 'Delete data user - asdasd', '2021-11-02 11:43:05'),
	(108, 'USR-1', 'Register new user erwer', '2021-11-02 11:43:13'),
	(109, 'USR-1', 'Delete data user - erwer', '2021-11-02 11:43:24'),
	(110, 'USR-1', 'Register new unit kerja dsfsdf', '2021-11-02 11:43:33'),
	(111, 'USR-1', 'Delete data mst_unit_kerja - undefined', '2021-11-02 11:44:35'),
	(112, 'USR-1', 'Register new unit kerja asdasd', '2021-11-02 11:44:41'),
	(113, 'USR-1', 'Delete data mst_unit_kerja - undefined', '2021-11-02 11:44:45'),
	(114, 'USR-1', 'Delete data tbl_surat_masuk - 001/SKET/ART/X/2021', '2021-11-02 16:04:34'),
	(115, 'USR-1', 'Delete data tbl_surat_keluar - 001/SKET/UPAA/V/2021', '2021-11-02 16:22:23'),
	(116, 'USR-1', 'Register new indeks fgjj', '2021-11-14 05:42:37'),
	(117, 'USR-1', 'Delete data mst_indeks - sdfsdf', '2021-11-14 05:42:51'),
	(118, 'USR-1', 'Delete data mst_indeks - fgjj', '2021-11-14 05:42:54'),
	(119, 'USR-1', 'Register new indeks Surat Keterangan', '2021-11-14 05:43:35'),
	(120, 'USR-1', 'Register new indeks Surat Keputusan', '2021-11-14 05:43:56'),
	(121, 'USR-1', 'Delete data mst_unit_kerja - undefined', '2021-11-14 05:44:35'),
	(122, 'USR-1', 'Register new unit kerja MKT', '2021-11-14 05:45:00'),
	(123, 'USR-1', 'Register new unit kerja ADM', '2021-11-14 05:45:19'),
	(124, 'USR-1', 'Register new user kadin', '2021-11-14 05:47:20'),
	(125, 'USR-6', 'Delete data tbl_surat_masuk - 001/SKET/ART/X/2021', '2021-11-14 05:50:08'),
	(126, 'superadmin', 'Delete data tbl_surat_masuk - sdfsdf', '2021-11-14 06:24:07'),
	(127, 'USR-1', 'Delete data tbl_surat_masuk - adsdasd', '2021-11-14 06:27:37'),
	(128, 'USR-1', 'Delete data tbl_surat_masuk - jhk', '2021-11-14 10:12:31'),
	(129, 'USR-1', 'Delete data tbl_surat_masuk - asdad', '2021-11-14 16:25:02'),
	(130, 'USR-1', 'Delete data tbl_surat_masuk - 0056/SCM/XI/2021', '2021-11-14 16:25:06'),
	(131, 'USR-1', 'Register new unit kerja DRS', '2021-11-14 16:26:32'),
	(132, 'USR-1', 'Delete data mst_unit_kerja - undefined', '2021-11-14 16:27:56'),
	(133, 'superadmin', 'Delete data tbl_surat_masuk - assdasd', '2021-11-14 16:58:31'),
	(134, 'superadmin', 'Delete data user - kadin', '2021-11-14 17:02:58'),
	(135, 'USR-1', 'Delete data tbl_surat_keluar - asdasd', '2021-11-15 15:02:23'),
	(136, 'USR-2', 'Register new unit kerja Industri', '2021-11-23 08:18:25'),
	(137, 'USR-2', 'Delete data mst_unit_kerja - undefined', '2021-11-23 08:22:24'),
	(138, 'USR-2', 'Register new unit kerja asda', '2021-11-23 08:23:13'),
	(139, 'USR-2', 'Delete data mst_unit_kerja - undefined', '2021-11-23 08:23:16'),
	(140, 'USR-2', 'Register new unit kerja asd', '2021-11-23 08:24:21'),
	(141, 'USR-2', 'Delete data mst_unit_kerja - undefined', '2021-11-23 08:24:24'),
	(142, 'USR-2', 'Register new unit kerja asd', '2021-11-23 08:24:42'),
	(143, 'USR-2', 'Delete data mst_unit_kerja - undefined', '2021-11-23 08:24:47'),
	(144, 'USR-1', 'Register new indeks asd', '2021-11-23 09:03:08'),
	(145, 'USR-1', 'Delete data mst_indeks - asd', '2021-11-23 09:03:11'),
	(146, 'USR-1', 'Register new unit kerja asdasd', '2021-11-23 09:03:19'),
	(147, 'USR-1', 'Delete data mst_unit_kerja - undefined', '2021-11-23 09:03:22'),
	(148, 'USR-1', 'Register new user asdasd', '2021-11-23 09:03:30'),
	(149, 'USR-1', 'Delete data user - asdasd', '2021-11-23 09:03:34'),
	(150, 'USR-1', 'Delete data tbl_pesan - ', '2021-11-23 09:11:38'),
	(151, 'USR-1', 'Register new indeks asdaasd', '2021-11-23 09:11:49'),
	(152, 'USR-1', 'Delete data mst_indeks - asdaasd', '2021-11-23 09:11:53'),
	(153, 'USR-1', 'Register new unit kerja asda', '2021-11-23 09:12:00'),
	(154, 'USR-1', 'Delete data mst_unit_kerja - undefined', '2021-11-23 09:12:04'),
	(155, 'USR-1', 'Register new user asdaasd', '2021-11-23 09:12:13'),
	(156, 'USR-1', 'Delete data user - asdaasd', '2021-11-23 09:12:17'),
	(157, 'USR-1', 'Delete data tbl_surat_masuk - 09/XXX/JAI/2021a', '2021-11-23 09:12:44');
/*!40000 ALTER TABLE `tbl_log` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.tbl_pesan
CREATE TABLE IF NOT EXISTS `tbl_pesan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat_masuk` int(11) NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `is_read` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pengirim` (`pengirim`),
  KEY `penerima` (`penerima`),
  KEY `perihal` (`perihal`),
  KEY `id_surat_masuk` (`id_surat_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.tbl_pesan: ~8 rows (approximately)
DELETE FROM `tbl_pesan`;
/*!40000 ALTER TABLE `tbl_pesan` DISABLE KEYS */;
INSERT INTO `tbl_pesan` (`id`, `id_surat_masuk`, `pengirim`, `penerima`, `perihal`, `pesan`, `nama_file`, `is_read`, `date_created`) VALUES
	(13, 7, 'Kepala Dinas', 'Kasubag Umum', 'Surat Keputusan', 'Pak Kasubag, tolong dicek', 'Muchlisin.pdf', 'YES', '2021-11-18 16:04:05'),
	(14, 7, 'Kepala Dinas', 'Pengagenda', 'Surat Keputusan', '', 'Muchlisin.pdf', 'NO', '2021-11-23 09:11:31'),
	(15, 7, 'Kepala Dinas', 'Unit Kerja', 'Surat Keputusan', 'asdasd', 'Muchlisin.pdf', 'YES', '2021-11-23 09:12:39'),
	(16, 3, 'Kepala Dinas', 'Pengagenda', 'Surat Keterangan', '', '', 'YES', '2021-11-26 11:43:16'),
	(17, 3, 'Kepala Dinas', 'Kasubag Umum', 'Surat Keterangan', '', '', 'NO', '2021-11-26 11:43:16'),
	(18, 3, 'Kepala Dinas', 'Sekretaris', 'Surat Keterangan', '', '', 'YES', '2021-11-26 11:43:16'),
	(19, 4, 'Kepala Dinas', 'Pengagenda', 'none', 'TES DISPOSISI', 'Tes_SCM_M_Taftiyan.pdf', 'NO', '2021-11-29 09:07:23'),
	(20, 4, 'Kepala Dinas', 'Kasubag Umum', 'none', 'TES DISPOSISI', 'Tes_SCM_M_Taftiyan.pdf', 'YES', '2021-11-29 09:07:23');
/*!40000 ALTER TABLE `tbl_pesan` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.tbl_surat_keluar
CREATE TABLE IF NOT EXISTS `tbl_surat_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tujuan` varchar(255) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `unit_pengirim` varchar(255) NOT NULL,
  `indeks` varchar(255) NOT NULL,
  `sifat` varchar(255) NOT NULL,
  `ringkasan_surat` text NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.tbl_surat_keluar: ~0 rows (approximately)
DELETE FROM `tbl_surat_keluar`;
/*!40000 ALTER TABLE `tbl_surat_keluar` DISABLE KEYS */;
INSERT INTO `tbl_surat_keluar` (`id`, `tujuan`, `no_surat`, `tanggal_surat`, `unit_pengirim`, `indeks`, `sifat`, `ringkasan_surat`, `nama_file`, `date_created`) VALUES
	(1, 'DINAS PENDIDIKAN', '001/SKET/UPAA/V/2021a', '2021-11-02', 'Marketing', 'Surat Keterangan', 'Penting', 'INI COBA TES SURAT KELUAR', 'Muchlisin.pdf', '2021-11-02 16:13:04');
/*!40000 ALTER TABLE `tbl_surat_keluar` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.tbl_surat_masuk
CREATE TABLE IF NOT EXISTS `tbl_surat_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asal` varchar(255) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_surat_diterima` date NOT NULL,
  `unit_penerima` varchar(255) NOT NULL,
  `indeks` varchar(255) NOT NULL,
  `sifat` varchar(50) NOT NULL,
  `ringkasan_surat` text NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `status_surat` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nomor_agenda` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.tbl_surat_masuk: ~4 rows (approximately)
DELETE FROM `tbl_surat_masuk`;
/*!40000 ALTER TABLE `tbl_surat_masuk` DISABLE KEYS */;
INSERT INTO `tbl_surat_masuk` (`id`, `asal`, `no_surat`, `tanggal_surat`, `tanggal_surat_diterima`, `unit_penerima`, `indeks`, `sifat`, `ringkasan_surat`, `nama_file`, `status_surat`, `date_created`, `nomor_agenda`) VALUES
	(1, 'DINAS KOMINFO', '001/SKET/UPAA/V/2021', '2021-11-02', '0000-00-00', 'MARKETING', 'Surat Keterangan', 'Penting', 'INI RINGKASAN SURAT DARI SURAT INI', 'Muchlisin.pdf', 'Didisposisikan', '2021-11-02 11:58:13', ''),
	(2, 'PRESIDEN RI', '001/SKET/PRES/X/2021', '2021-10-02', '0000-00-00', 'KEPALA DINAS', 'Surat Keterangan', 'Rahasia', '', '', 'Belum diteruskan', '2021-11-02 11:58:13', 'asdasd'),
	(3, 'ARTHUR JULIO', '001/SKET/ART/X/2021', '2021-10-02', '0000-00-00', 'KEPALA DINAS', 'Surat Keterangan', 'Biasa', '', '', 'Didisposisikan', '2021-11-02 11:58:13', ''),
	(4, 'PT. JAI', 'SURAT-01', '2021-11-29', '2021-11-01', 'Administrasi', 'none', 'Biasa', 'INI TES SURAT', 'Tes_SCM_M_Taftiyan.pdf', 'Didisposisikan', '2021-11-29 08:50:03', 'sadasd');
/*!40000 ALTER TABLE `tbl_surat_masuk` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `userid` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nomor_induk` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.user: ~5 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `userid`, `password`, `nomor_induk`, `role_id`, `is_active`, `date_created`) VALUES
	(7, 'Kepala Dinas', 'USR-1', '$2y$10$YfAiO6PfnSlrLv2gQMncfO0rnQ5KXypoUZzTFRfbPhMYe6g/B1pOS', '12345', 1, 1, '2021-09-20 10:56:42'),
	(9, 'Sekretaris', 'USR-2', '$2y$10$FcAY7B.o6TVsgLAUPT4sFusM.x2O3agrpGz4X/QBLXSw5J5xb6vYG', '67890', 2, 1, '2021-09-20 10:56:46'),
	(15, 'Kasubag Umum', 'USR-3', '$2y$10$JoUQBYP7g40Bp.WsPMViO.sKJxyl4mWD/hUTbH4BLGi9LDjBKeM6q', '09876', 3, 1, '2021-09-20 10:56:54'),
	(17, 'Pengagenda', 'USR-4', '$2y$10$JoUQBYP7g40Bp.WsPMViO.sKJxyl4mWD/hUTbH4BLGi9LDjBKeM6q', '54321', 4, 1, '2021-09-20 10:38:09'),
	(18, 'Unit Kerja', 'USR-5', '$2y$10$JoUQBYP7g40Bp.WsPMViO.sKJxyl4mWD/hUTbH4BLGi9LDjBKeM6q', '34234234', 5, 1, '2021-09-20 10:38:09');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table distanna_arsip.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table distanna_arsip.user_role: ~5 rows (approximately)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`id`, `role`) VALUES
	(1, 'Kepala Dinas'),
	(2, 'Sekretaris'),
	(3, 'Kasubag Umum'),
	(4, 'Pengagenda'),
	(5, 'Unit Kerja');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
