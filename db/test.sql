# Host: 127.0.0.1  (Version 5.5.5-10.4.13-MariaDB-log)
# Date: 2021-01-22 11:24:23
# Generator: MySQL-Front 6.0  (Build 1.204)


#
# Structure for table "tbl_alternatif"
#

DROP TABLE IF EXISTS `tbl_alternatif`;
CREATE TABLE `tbl_alternatif` (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `nama_alternatif` varchar(50) NOT NULL,
  `nis_alternatif` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `telp_alternatif` varchar(20) NOT NULL,
  `jk_alternatif` varchar(10) NOT NULL,
  `agama_alternatif` varchar(15) NOT NULL,
  `alamat_alternatif` text NOT NULL,
  `hasil_norm` double NOT NULL,
  `tahun` varchar(100) NOT NULL,
  PRIMARY KEY (`id_alternatif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "tbl_alternatif"
#


#
# Structure for table "tbl_jurusan"
#

DROP TABLE IF EXISTS `tbl_jurusan`;
CREATE TABLE `tbl_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `skor_jurusan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "tbl_jurusan"
#

INSERT INTO `tbl_jurusan` VALUES (1,18.5);

#
# Structure for table "tbl_kriteria"
#

DROP TABLE IF EXISTS `tbl_kriteria`;
CREATE TABLE `tbl_kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(50) NOT NULL,
  `slug` varchar(40) NOT NULL,
  `tipe_kriteria` varchar(15) NOT NULL,
  `bobot_kriteria` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_kriteria"
#

INSERT INTO `tbl_kriteria` VALUES (4,'Nilai Matematika','nilai-matematika','benefit',5,'2021-01-07 12:10:55','2021-01-19 16:49:19'),(5,'Nilai Bahasa Indonesia','nilai-bahasa-indonesia','benefit',4,'2021-01-07 12:11:44','2021-01-19 16:49:24'),(6,'Nilai Bahasa Inggris','nilai-bahasa-inggris','benefit',4,'2021-01-07 12:12:00','2021-01-19 16:49:30'),(7,'Nilai IPA','nilai-ipa','benefit',3,'2021-01-07 12:12:15','2021-01-19 16:49:35'),(8,'Nilai IPS','nilai-ips','benefit',3,'2021-01-07 12:12:28','2021-01-19 16:49:40'),(9,'Hasil Psikotes','hasil-psikotes','benefit',2,'2021-01-07 12:12:39','2021-01-19 16:49:45'),(10,'Minat Siswa','minat-siswa','benefit',2,'2021-01-07 12:12:50','2021-01-19 16:49:52'),(11,'Saran Orang Tua','saran-orang-tua','benefit',2,'2021-01-07 12:12:57','2021-01-19 16:49:58');

#
# Structure for table "tbl_login"
#

DROP TABLE IF EXISTS `tbl_login`;
CREATE TABLE `tbl_login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_login"
#

INSERT INTO `tbl_login` VALUES (1,'admin','$2y$10$ASdpA1DOnpqCKtLDPCagqOo72YnBY/WSnzT7oYF3cIEo/JZz1Hal2','Administrator');

#
# Structure for table "tbl_nilai"
#

DROP TABLE IF EXISTS `tbl_nilai`;
CREATE TABLE `tbl_nilai` (
  `id_nilai` int(11) NOT NULL AUTO_INCREMENT,
  `ket_nilai` varchar(50) NOT NULL,
  `jum_nilai` double NOT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_nilai"
#

INSERT INTO `tbl_nilai` VALUES (1,'> 85',5),(2,'70 - 84',4),(3,'55 - 69',3),(4,'40 - 54',2),(5,'< 49',1);

#
# Structure for table "tbl_penilaian"
#

DROP TABLE IF EXISTS `tbl_penilaian`;
CREATE TABLE `tbl_penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai_penilaian` double NOT NULL,
  `nilai_normalisasi` double NOT NULL,
  `hasil_normalisasi` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `id_alternatif` (`id_alternatif`),
  KEY `id_kriteria` (`id_kriteria`),
  CONSTRAINT `tbl_penilaian_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `tbl_alternatif` (`id_alternatif`),
  CONSTRAINT `tbl_penilaian_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `tbl_kriteria` (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "tbl_penilaian"
#


#
# Structure for table "tbl_sub_kriteria"
#

DROP TABLE IF EXISTS `tbl_sub_kriteria`;
CREATE TABLE `tbl_sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `nama_sub_kriteria` varchar(100) NOT NULL,
  `bobot_sub_kriteria` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_sub_kriteria`),
  KEY `id_kriteria` (`id_kriteria`),
  CONSTRAINT `tbl_sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `tbl_kriteria` (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_sub_kriteria"
#

INSERT INTO `tbl_sub_kriteria` VALUES (2,10,'IPA',4,'2021-01-07 12:14:14','2021-01-19 16:38:44'),(3,10,'IPS',3,'2021-01-07 12:15:08','2021-01-19 16:38:50'),(4,11,'IPA',4,'2021-01-07 12:15:16','2021-01-19 16:38:56'),(5,11,'IPS',3,'2021-01-07 12:15:24','2021-01-19 16:39:05'),(6,9,'IPA',4,'2021-01-20 00:46:34','2021-01-20 00:46:34'),(7,9,'IPS',3,'2021-01-20 00:47:10','2021-01-20 00:47:10');
