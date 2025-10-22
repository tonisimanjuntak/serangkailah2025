/*
SQLyog Ultimate v10.42 
MySQL - 8.0.30 : Database - serg5889_serangkailah_2025
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`serg5889_serangkailah_2025` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `serg5889_serangkailah_2025`;

/*Table structure for table `akun5` */

DROP TABLE IF EXISTS `akun5`;

CREATE TABLE `akun5` (
  `keyakun5` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdakun5` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namaakun5` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`keyakun5`),
  UNIQUE KEY `kdakun5` (`kdakun5`,`tahunanggaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `keybarang` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdbarang` char(22) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namabarang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keyakun5` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `merk` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `satuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdkelompok` char(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`keybarang`),
  UNIQUE KEY `kdbarang` (`kdbarang`,`tahunanggaran`),
  KEY `keyakun5` (`keyakun5`),
  KEY `kdkelompok` (`kdkelompok`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`keyakun5`) REFERENCES `akun5` (`keyakun5`),
  CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`kdkelompok`) REFERENCES `kelompokbarang` (`kdkelompok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dpa` */

DROP TABLE IF EXISTS `dpa`;

CREATE TABLE `dpa` (
  `nodpa` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgldpa` date NOT NULL,
  `jenis` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '1=DPA Penyusunan; 2=DPA Perubahan',
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`nodpa`),
  UNIQUE KEY `jenis` (`jenis`,`kdruangan`,`tahunanggaran`),
  KEY `kdruangan` (`kdruangan`),
  KEY `idpengguna` (`idpengguna`),
  CONSTRAINT `dpa_ibfk_1` FOREIGN KEY (`kdruangan`) REFERENCES `ruangan` (`kdruangan`),
  CONSTRAINT `dpa_ibfk_2` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`idpengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `dpadetail` */

DROP TABLE IF EXISTS `dpadetail`;

CREATE TABLE `dpadetail` (
  `nodpa` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keykegiatan` char(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keyakun5` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` decimal(18,0) NOT NULL,
  `triwulan1` decimal(18,0) DEFAULT NULL,
  `triwulan2` decimal(18,0) DEFAULT NULL,
  `triwulan3` decimal(18,0) DEFAULT NULL,
  `triwulan4` decimal(18,0) DEFAULT NULL,
  KEY `nodpa` (`nodpa`),
  KEY `keykegiatan` (`keykegiatan`),
  KEY `keyakun5` (`keyakun5`),
  CONSTRAINT `dpadetail_ibfk_1` FOREIGN KEY (`nodpa`) REFERENCES `dpa` (`nodpa`),
  CONSTRAINT `dpadetail_ibfk_2` FOREIGN KEY (`keykegiatan`) REFERENCES `kegiatan` (`keykegiatan`),
  CONSTRAINT `dpadetail_ibfk_3` FOREIGN KEY (`keyakun5`) REFERENCES `akun5` (`keyakun5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `kegiatan` */

DROP TABLE IF EXISTS `kegiatan`;

CREATE TABLE `kegiatan` (
  `keykegiatan` char(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdkegiatan` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namakegiatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keyprogram` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`keykegiatan`),
  UNIQUE KEY `kdkegiatan` (`kdkegiatan`,`tahunanggaran`),
  KEY `keyprogram` (`keyprogram`),
  CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`keyprogram`) REFERENCES `program` (`keyprogram`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `kelompokbarang` */

DROP TABLE IF EXISTS `kelompokbarang`;

CREATE TABLE `kelompokbarang` (
  `kdkelompok` char(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namakelompok` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `statusaktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`kdkelompok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `migrasibarang` */

DROP TABLE IF EXISTS `migrasibarang`;

CREATE TABLE `migrasibarang` (
  `idmigrasi` int NOT NULL AUTO_INCREMENT,
  `tglmigrasi` datetime NOT NULL,
  `kdruangan` char(10) DEFAULT NULL,
  `kdupt` char(7) DEFAULT NULL,
  `keybarangasal` char(14) NOT NULL,
  `namabarangasal` varchar(100) NOT NULL,
  `keybarangtujuan` char(14) NOT NULL,
  `namabarangtujuan` varchar(100) NOT NULL,
  `tahunanggaran` char(4) NOT NULL,
  `idpengguna` char(10) NOT NULL,
  PRIMARY KEY (`idmigrasi`)
) ENGINE=InnoDB AUTO_INCREMENT=2006 DEFAULT CHARSET=latin1;

/*Table structure for table `penandatangan` */

DROP TABLE IF EXISTS `penandatangan`;

CREATE TABLE `penandatangan` (
  `idpenandatangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nip` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namapenandatangan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idstruktur` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `statusaktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `golongan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kdttd` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idpenandatangan`),
  KEY `kdruangan` (`kdruangan`),
  KEY `idstruktur` (`idstruktur`),
  CONSTRAINT `penandatangan_ibfk_1` FOREIGN KEY (`kdruangan`) REFERENCES `ruangan` (`kdruangan`),
  CONSTRAINT `penandatangan_ibfk_3` FOREIGN KEY (`idstruktur`) REFERENCES `struktur` (`idstruktur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `penerimaanbarang` */

DROP TABLE IF EXISTS `penerimaanbarang`;

CREATE TABLE `penerimaanbarang` (
  `noterima` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tglterima` date NOT NULL,
  `uraian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `totalbeli` decimal(18,0) DEFAULT NULL,
  `jenispenerimaan` enum('Saldo Awal','Penerimaan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Penerimaan',
  PRIMARY KEY (`noterima`),
  KEY `kdruangan` (`kdruangan`),
  KEY `idpengguna` (`idpengguna`),
  CONSTRAINT `penerimaanbarang_ibfk_1` FOREIGN KEY (`kdruangan`) REFERENCES `ruangan` (`kdruangan`),
  CONSTRAINT `penerimaanbarang_ibfk_2` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`idpengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `penerimaanbarangdetail` */

DROP TABLE IF EXISTS `penerimaanbarangdetail`;

CREATE TABLE `penerimaanbarangdetail` (
  `noterima` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keybarang` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qtyterima` int NOT NULL,
  `hargabelisatuan` decimal(10,0) NOT NULL,
  `stokbarang` int NOT NULL,
  UNIQUE KEY `noterima` (`noterima`,`keybarang`,`hargabelisatuan`) USING BTREE,
  KEY `keybarang` (`keybarang`),
  CONSTRAINT `penerimaanbarangdetail_ibfk_1` FOREIGN KEY (`noterima`) REFERENCES `penerimaanbarang` (`noterima`),
  CONSTRAINT `penerimaanbarangdetail_ibfk_2` FOREIGN KEY (`keybarang`) REFERENCES `barang` (`keybarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `pengaturan` */

DROP TABLE IF EXISTS `pengaturan`;

CREATE TABLE `pengaturan` (
  `aktifbataspenginputan` tinyint(1) DEFAULT NULL,
  `tglbataspenginputan` datetime DEFAULT NULL,
  `sekolahbisalogin` tinyint(1) DEFAULT NULL,
  `uptbisalogin` tinyint(1) DEFAULT NULL,
  `aktifbataspenginputansekolah` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pengaturanbatassekolah` */

DROP TABLE IF EXISTS `pengaturanbatassekolah`;

CREATE TABLE `pengaturanbatassekolah` (
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tglbataspenginputan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `pengeluaranbarang` */

DROP TABLE IF EXISTS `pengeluaranbarang`;

CREATE TABLE `pengeluaranbarang` (
  `nokeluar` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tglkeluar` date NOT NULL,
  `uraian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tglinsert` datetime NOT NULL,
  `tglupdate` datetime NOT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`nokeluar`),
  KEY `kdruangan` (`kdruangan`),
  KEY `idpengguna` (`idpengguna`),
  CONSTRAINT `pengeluaranbarang_ibfk_1` FOREIGN KEY (`kdruangan`) REFERENCES `ruangan` (`kdruangan`),
  CONSTRAINT `pengeluaranbarang_ibfk_2` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`idpengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `pengeluaranbarangdetail` */

DROP TABLE IF EXISTS `pengeluaranbarangdetail`;

CREATE TABLE `pengeluaranbarangdetail` (
  `nokeluar` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keybarang` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qtykeluar` int NOT NULL,
  KEY `nokeluar` (`nokeluar`),
  KEY `keybarang` (`keybarang`),
  CONSTRAINT `pengeluaranbarangdetail_ibfk_1` FOREIGN KEY (`nokeluar`) REFERENCES `pengeluaranbarang` (`nokeluar`),
  CONSTRAINT `pengeluaranbarangdetail_ibfk_2` FOREIGN KEY (`keybarang`) REFERENCES `barang` (`keybarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `pengeluaranbarangdetail_noterima` */

DROP TABLE IF EXISTS `pengeluaranbarangdetail_noterima`;

CREATE TABLE `pengeluaranbarangdetail_noterima` (
  `nokeluar` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `noterima` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keybarang` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `qtykeluar` int DEFAULT NULL,
  `hargabelisatuan` decimal(18,0) DEFAULT NULL,
  UNIQUE KEY `nokeluar` (`nokeluar`,`noterima`,`keybarang`),
  KEY `noterima` (`noterima`),
  KEY `keybarang` (`keybarang`),
  CONSTRAINT `pengeluaranbarangdetail_noterima_ibfk_1` FOREIGN KEY (`nokeluar`) REFERENCES `pengeluaranbarang` (`nokeluar`),
  CONSTRAINT `pengeluaranbarangdetail_noterima_ibfk_2` FOREIGN KEY (`noterima`) REFERENCES `penerimaanbarang` (`noterima`),
  CONSTRAINT `pengeluaranbarangdetail_noterima_ibfk_3` FOREIGN KEY (`keybarang`) REFERENCES `barang` (`keybarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `pengguna` */

DROP TABLE IF EXISTS `pengguna`;

CREATE TABLE `pengguna` (
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namapengguna` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jk` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgllahir` date DEFAULT NULL,
  `tempatlahir` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notelp` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `statusaktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `akseslevel` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '1=pengguna ruangan; 2=adminsystem',
  `kdupt` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastupdate` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idupdater` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idpengguna`),
  UNIQUE KEY `username` (`username`),
  KEY `kdruangan` (`kdruangan`),
  CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`kdruangan`) REFERENCES `ruangan` (`kdruangan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `program` */

DROP TABLE IF EXISTS `program`;

CREATE TABLE `program` (
  `keyprogram` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdprogram` char(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namaprogram` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahunanggaran` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`keyprogram`),
  UNIQUE KEY `kdprogram` (`kdprogram`,`tahunanggaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `riwayataktifitas` */

DROP TABLE IF EXISTS `riwayataktifitas`;

CREATE TABLE `riwayataktifitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `idpengguna` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `namapengguna` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inserted_date` datetime DEFAULT NULL,
  `namatabel` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `namafunction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2983 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `ruangan` */

DROP TABLE IF EXISTS `ruangan`;

CREATE TABLE `ruangan` (
  `kdruangan` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namaruangan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `notelp` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kdupt` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `statusaktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`kdruangan`),
  KEY `kdupt` (`kdupt`),
  CONSTRAINT `ruangan_ibfk_1` FOREIGN KEY (`kdupt`) REFERENCES `upt` (`kdupt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `sheet1$` */

DROP TABLE IF EXISTS `sheet1$`;

CREATE TABLE `sheet1$` (
  `KDKATEGORI` varchar(255) DEFAULT NULL,
  `NAMAKATEGORI` varchar(255) DEFAULT NULL,
  `KDBARANG` varchar(255) DEFAULT NULL,
  `NAMABARANG` varchar(255) DEFAULT NULL,
  `MERK` varchar(255) DEFAULT NULL,
  `TYPE` varchar(255) DEFAULT NULL,
  `SATUAN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

/*Table structure for table `skpd` */

DROP TABLE IF EXISTS `skpd`;

CREATE TABLE `skpd` (
  `kdskpd` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namaskpd` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notelp` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`kdskpd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `struktur` */

DROP TABLE IF EXISTS `struktur`;

CREATE TABLE `struktur` (
  `idstruktur` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namastruktur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idstruktur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `upt` */

DROP TABLE IF EXISTS `upt`;

CREATE TABLE `upt` (
  `kdupt` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namaupt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notelp` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kdskpd` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `idpengguna` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`kdupt`),
  KEY `kdskpd` (`kdskpd`),
  CONSTRAINT `upt_ibfk_1` FOREIGN KEY (`kdskpd`) REFERENCES `skpd` (`kdskpd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* Function  structure for function  `create_idpenandatangan` */

/*!50003 DROP FUNCTION IF EXISTS `create_idpenandatangan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_idpenandatangan`(`_tgl` DATE) RETURNS char(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT DEFAULT 4;
	DECLARE cTgl CHAR(6);
		
	SET cTgl = DATE_FORMAT(_tgl, '%y%m%d');
	
	SELECT MAX(RIGHT(RTRIM(idpenandatangan),jumlah_digit)) FROM penandatangan  
		WHERE LEFT(idpenandatangan,6) = CONCAT(cTgl) INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_idpengguna` */

/*!50003 DROP FUNCTION IF EXISTS `create_idpengguna` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_idpengguna`(`_tgl` DATE) RETURNS char(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT DEFAULT 4;
	DECLARE cTgl CHAR(6);
		
	SET cTgl = DATE_FORMAT(_tgl, '%y%m%d');
	
	SELECT MAX(RIGHT(RTRIM(idpengguna),jumlah_digit)) FROM pengguna  
		WHERE LEFT(idpengguna,6) = CONCAT(cTgl) INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_kdbarang` */

/*!50003 DROP FUNCTION IF EXISTS `create_kdbarang` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_kdbarang`(`_id` CHAR(5)) RETURNS char(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(5);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(5);
	DECLARE jumlah_digit INT DEFAULT 5;
			
	SELECT MAX(RIGHT(RTRIM(kdbarang),jumlah_digit)) FROM `barang`  
		WHERE LEFT(kdbarang,5) = _id INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(_id, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_kdkelompok` */

/*!50003 DROP FUNCTION IF EXISTS `create_kdkelompok` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_kdkelompok`(`_id` CHAR(2)) RETURNS char(5) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(3);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(3);
	DECLARE jumlah_digit INT DEFAULT 3;
			
	SELECT MAX(RIGHT(RTRIM(kdkelompok),jumlah_digit)) FROM `kelompokbarang`  
		WHERE LEFT(kdkelompok,2) = _id INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(_id, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_kdruangan` */

/*!50003 DROP FUNCTION IF EXISTS `create_kdruangan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_kdruangan`(`_tgl` DATE) RETURNS char(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT DEFAULT 4;
	DECLARE cTgl CHAR(6);
		
	SET cTgl = DATE_FORMAT(_tgl, '%y%m%d');
	
	SELECT MAX(RIGHT(RTRIM(kdruangan),jumlah_digit)) FROM ruangan  
		WHERE LEFT(kdruangan,6) = CONCAT(cTgl) INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_kdsekolah` */

/*!50003 DROP FUNCTION IF EXISTS `create_kdsekolah` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_kdsekolah`(`_tgl` DATE) RETURNS char(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT DEFAULT 4;
	DECLARE cTgl CHAR(6);
		
	SET cTgl = DATE_FORMAT(_tgl, '%y%m%d');
	
	SELECT MAX(RIGHT(RTRIM(kdsekolah),jumlah_digit)) FROM sekolah  
		WHERE LEFT(kdsekolah,6) = CONCAT(cTgl) INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_kdupt` */

/*!50003 DROP FUNCTION IF EXISTS `create_kdupt` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_kdupt`(`_id` CHAR(3)) RETURNS char(7) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT DEFAULT 4;
			
	SELECT MAX(RIGHT(RTRIM(kdupt),jumlah_digit)) FROM `upt`  
		WHERE LEFT(kdupt,3) = _id INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(_id, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_nokeluar` */

/*!50003 DROP FUNCTION IF EXISTS `create_nokeluar` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_nokeluar`(`var_tgl` DATE) RETURNS char(10) CHARSET latin1
BEGIN
	DECLARE cNosekarang CHAR(5);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(5);
	DECLARE jumlah_digit INT DEFAULT 5;
	DECLARE cTgl CHAR(4);
	DECLARE cId CHAR(1) DEFAULT 'K';
		
	SET cTgl = DATE_FORMAT(var_tgl, '%y%m');
	
	SELECT MAX(RIGHT(RTRIM(nokeluar),jumlah_digit)) FROM pengeluaranbarang  
		WHERE LEFT(nokeluar,5) = CONCAT(cTgl, cId) INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cId, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `create_noterima` */

/*!50003 DROP FUNCTION IF EXISTS `create_noterima` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `create_noterima`(`var_tgl` DATE) RETURNS char(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
	DECLARE cNosekarang CHAR(5);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(5);
	DECLARE jumlah_digit INT DEFAULT 5;
	DECLARE cTgl CHAR(4);
	DECLARE cId CHAR(1) DEFAULT 'L';
		
	SET cTgl = DATE_FORMAT(var_tgl, '%y%m');
	
	SELECT MAX(RIGHT(RTRIM(noterima),jumlah_digit)) FROM penerimaanbarang  
		WHERE LEFT(noterima,5) = CONCAT(cTgl, cId) INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CAST(cNosekarang AS UNSIGNED)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cId, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `getHargaBeliTerakhir` */

/*!50003 DROP FUNCTION IF EXISTS `getHargaBeliTerakhir` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getHargaBeliTerakhir`(`varTahunAnggaran` CHAR(4), `varKdRuangan` CHAR(10), `varKeyBarang` CHAR(14)) RETURNS decimal(18,0)
BEGIN
	DECLARE varHargaBeliSatuan DECIMAL(18,2);
	
	SELECT hargabelisatuan 
		FROM penerimaanbarangdetail INNER JOIN penerimaanbarang ON penerimaanbarang.`noterima`=penerimaanbarangdetail.`noterima`
		WHERE penerimaanbarang.`tahunanggaran` = varTahunAnggaran AND penerimaanbarang.`kdruangan`=varKdRuangan 
			AND penerimaanbarangdetail.`keybarang`=varKeyBarang
		ORDER BY penerimaanbarang.`tglterima` DESC, penerimaanbarang.`noterima` DESC
		LIMIT 1 INTO varHargaBeliSatuan;
	
	IF varHargaBeliSatuan IS NULL THEN 
		SET varHargaBeliSatuan = 0;
	END IF;
	RETURN varHargaBeliSatuan;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_average_hargabarang_perruangan` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_average_hargabarang_perruangan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_average_hargabarang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_totalhargabeli DECIMAL(18,0);
	DECLARE var_pembagai INT(11);
	DECLARE var_average_hargabeli DECIMAL(18,0);
	
	SELECT SUM(hargabelisatuan) INTO var_totalhargabeli FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang;
	
	SELECT COUNT(*) INTO var_pembagai FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang;
	
	IF var_totalhargabeli IS NULL OR var_totalhargabeli = 0 OR var_pembagai IS NULL OR var_pembagai = 0 THEN
		SET var_average_hargabeli = 0;
	ELSE
		SET var_average_hargabeli = var_totalhargabeli/var_pembagai;
	END IF;
	
	RETURN var_average_hargabeli;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_average_hargabarang_persekolah` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_average_hargabarang_persekolah` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_average_hargabarang_persekolah`(`var_kdsekolah` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_totalhargabeli DECIMAL(18,0);
	DECLARE var_pembagai INT(11);
	DECLARE var_average_hargabeli DECIMAL(18,0);
	
	SELECT SUM(hargabelisatuan) INTO var_totalhargabeli FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdsekolah`=var_kdsekolah AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang;
	
	SELECT COUNT(*) INTO var_pembagai FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdsekolah`=var_kdsekolah AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang;
	
	IF var_totalhargabeli IS NULL OR var_totalhargabeli = 0 OR var_pembagai IS NULL OR var_pembagai = 0 THEN
		SET var_average_hargabeli = 0;
	ELSE
		SET var_average_hargabeli = var_totalhargabeli/var_pembagai;
	END IF;
	
	RETURN var_average_hargabeli;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_pemakaian_barang_perruangan` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_pemakaian_barang_perruangan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_pemakaian_barang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_jumlah INT(11);
	
	SELECT SUM(qtykeluar) INTO var_jumlah FROM pengeluaranbarangdetail JOIN pengeluaranbarang 
		ON pengeluaranbarang.`nokeluar`=`pengeluaranbarangdetail`.`nokeluar`
		WHERE pengeluaranbarang.`kdruangan`=var_kdruangan AND pengeluaranbarang.`tahunanggaran`=var_tahunanggaran
			AND pengeluaranbarangdetail.`keybarang`=var_keybarang;
	
	IF var_jumlah IS NULL THEN
		SET var_jumlah = 0;
	END IF;
	RETURN var_jumlah;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_pemakaian_barang_persekolah` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_pemakaian_barang_persekolah` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_pemakaian_barang_persekolah`(`var_kdsekolah` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_jumlah INT(11);
	
	SELECT SUM(qtykeluar) INTO var_jumlah FROM pengeluaranbarangdetail JOIN pengeluaranbarang 
		ON pengeluaranbarang.`nokeluar`=`pengeluaranbarangdetail`.`nokeluar`
		WHERE pengeluaranbarang.`kdsekolah`=var_kdsekolah AND pengeluaranbarang.`tahunanggaran`=var_tahunanggaran
			AND pengeluaranbarangdetail.`keybarang`=var_keybarang;
	
	IF var_jumlah IS NULL THEN
		SET var_jumlah = 0;
	END IF;
	RETURN var_jumlah;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_penambahan_barang_perruangan` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_penambahan_barang_perruangan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_penambahan_barang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_jumlah INT(11);
	
	SELECT SUM(qtyterima) INTO var_jumlah FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Penerimaan';
	
	IF var_jumlah IS NULL THEN
		SET var_jumlah = 0;
	END IF;
	RETURN var_jumlah;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_penambahan_barang_persekolah` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_penambahan_barang_persekolah` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_penambahan_barang_persekolah`(`var_kdsekolah` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_jumlah INT(11);
	
	SELECT SUM(qtyterima) INTO var_jumlah FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdsekolah`=var_kdsekolah AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Penerimaan';
	
	IF var_jumlah IS NULL THEN
		SET var_jumlah = 0;
	END IF;
	RETURN var_jumlah;
    END */$$
DELIMITER ;

/* Function  structure for function  `hitung_saldoawal_barang_perruangan` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_saldoawal_barang_perruangan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_saldoawal_barang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14)) RETURNS int
BEGIN
	DECLARE var_jumlah INT(11);
	
	SELECT SUM(qtyterima) INTO var_jumlah FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Saldo Awal';
	
	IF var_jumlah IS NULL THEN
		SET var_jumlah = 0;
	END IF;
	RETURN var_jumlah;
    END */$$
DELIMITER ;

/* Function  structure for function  `penerimaan_dinas_new` */

/*!50003 DROP FUNCTION IF EXISTS `penerimaan_dinas_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaan_dinas_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	
	SELECT SUM(qtyterima) INTO var_jumlah1 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Penerimaan' 
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan 
			AND penerimaanbarang.`tglterima` BETWEEN var_tglawal AND var_tglakhir;
	
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	RETURN var_jumlah1;
    END */$$
DELIMITER ;

/* Function  structure for function  `penerimaan_perruangan_new` */

/*!50003 DROP FUNCTION IF EXISTS `penerimaan_perruangan_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaan_perruangan_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	
	SELECT SUM(qtyterima) INTO var_jumlah1 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Penerimaan' 
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan 
			AND penerimaanbarang.`tglterima` BETWEEN var_tglawal AND var_tglakhir;
	
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	RETURN var_jumlah1;
    END */$$
DELIMITER ;

/* Function  structure for function  `penerimaan_perupt_new` */

/*!50003 DROP FUNCTION IF EXISTS `penerimaan_perupt_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaan_perupt_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdupt` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	
	SELECT SUM(qtyterima) INTO var_jumlah1 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		JOIN ruangan ON ruangan.kdruangan=penerimaanbarang.kdruangan
		WHERE ruangan.`kdupt`=var_kdupt AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Penerimaan' 
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan 
			AND penerimaanbarang.`tglterima` BETWEEN var_tglawal AND var_tglakhir;
	
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	RETURN var_jumlah1;
    END */$$
DELIMITER ;

/* Function  structure for function  `pengeluaran_dinas_new` */

/*!50003 DROP FUNCTION IF EXISTS `pengeluaran_dinas_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `pengeluaran_dinas_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	
	SELECT SUM(qtykeluar) INTO var_jumlah1 FROM v_pengeluaranbarangdetail_with_hargabelisatuan
		WHERE v_pengeluaranbarangdetail_with_hargabelisatuan.`tahunanggaran`=var_tahunanggaran
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`keybarang`=var_keybarang
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.hargabelisatuan = var_hargabelisatuan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tglkeluar` BETWEEN var_tglawal AND var_tglakhir;
			
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	RETURN var_jumlah1;
    END */$$
DELIMITER ;

/* Function  structure for function  `pengeluaran_perruangan_new` */

/*!50003 DROP FUNCTION IF EXISTS `pengeluaran_perruangan_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `pengeluaran_perruangan_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	
	SELECT SUM(qtykeluar) INTO var_jumlah1 FROM v_pengeluaranbarangdetail_with_hargabelisatuan
		WHERE v_pengeluaranbarangdetail_with_hargabelisatuan.`kdruangan`=var_kdruangan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tahunanggaran`=var_tahunanggaran
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`keybarang`=var_keybarang
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.hargabelisatuan = var_hargabelisatuan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tglkeluar` BETWEEN var_tglawal AND var_tglakhir;
			
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	RETURN var_jumlah1;
    END */$$
DELIMITER ;

/* Function  structure for function  `pengeluaran_perupt_new` */

/*!50003 DROP FUNCTION IF EXISTS `pengeluaran_perupt_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `pengeluaran_perupt_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdupt` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	
	SELECT SUM(qtykeluar) INTO var_jumlah1 FROM v_pengeluaranbarangdetail_with_hargabelisatuan
		WHERE v_pengeluaranbarangdetail_with_hargabelisatuan.`kdupt`=var_kdupt 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tahunanggaran`=var_tahunanggaran
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`keybarang`=var_keybarang
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.hargabelisatuan = var_hargabelisatuan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tglkeluar` BETWEEN var_tglawal AND var_tglakhir;
			
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	RETURN var_jumlah1;
    END */$$
DELIMITER ;

/* Function  structure for function  `saldoawal_dinas_new` */

/*!50003 DROP FUNCTION IF EXISTS `saldoawal_dinas_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `saldoawal_dinas_new`(`var_tglawal` DATE, `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	DECLARE var_jumlah2 INT(11);
	DECLARE var_jumlah3 INT(11);
	
	
	SELECT SUM(qtyterima) INTO var_jumlah1 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Saldo Awal' 
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan;
	
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	
	SELECT SUM(qtyterima) INTO var_jumlah2 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan<>'Saldo Awal'
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan
			AND penerimaanbarang.`tglterima` < var_tglawal;
	
	IF var_jumlah2 IS NULL THEN
		SET var_jumlah2 = 0;
	END IF;
	
	
	SELECT SUM(qtykeluar) INTO var_jumlah3 FROM v_pengeluaranbarangdetail_with_hargabelisatuan
		WHERE v_pengeluaranbarangdetail_with_hargabelisatuan.`tahunanggaran`=var_tahunanggaran
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`keybarang`=var_keybarang
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.hargabelisatuan = var_hargabelisatuan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tglkeluar` < var_tglawal;
	
	IF var_jumlah3 IS NULL THEN
		SET var_jumlah3 = 0;
	END IF;
	
	RETURN var_jumlah1 + var_jumlah2 - var_jumlah3;
    END */$$
DELIMITER ;

/* Function  structure for function  `saldoawal_perruangan_new` */

/*!50003 DROP FUNCTION IF EXISTS `saldoawal_perruangan_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `saldoawal_perruangan_new`(`var_tglawal` DATE, `var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	DECLARE var_jumlah2 INT(11);
	DECLARE var_jumlah3 INT(11);
	
	
	SELECT SUM(qtyterima) INTO var_jumlah1 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Saldo Awal' 
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan;
	
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	
	SELECT SUM(qtyterima) INTO var_jumlah2 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		WHERE penerimaanbarang.`kdruangan`=var_kdruangan AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan<>'Saldo Awal'
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan
			AND penerimaanbarang.`tglterima` < var_tglawal;
	
	IF var_jumlah2 IS NULL THEN
		SET var_jumlah2 = 0;
	END IF;
	
	
	SELECT SUM(qtykeluar) INTO var_jumlah3 FROM v_pengeluaranbarangdetail_with_hargabelisatuan
		WHERE v_pengeluaranbarangdetail_with_hargabelisatuan.`kdruangan`=var_kdruangan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tahunanggaran`=var_tahunanggaran
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`keybarang`=var_keybarang
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.hargabelisatuan = var_hargabelisatuan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tglkeluar` < var_tglawal;
	
	IF var_jumlah3 IS NULL THEN
		SET var_jumlah3 = 0;
	END IF;
	
	RETURN var_jumlah1 + var_jumlah2 - var_jumlah3;
    END */$$
DELIMITER ;

/* Function  structure for function  `saldoawal_perupt_new` */

/*!50003 DROP FUNCTION IF EXISTS `saldoawal_perupt_new` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `saldoawal_perupt_new`(`var_tglawal` DATE, `var_kdupt` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(14), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
BEGIN
	DECLARE var_jumlah1 INT(11);
	DECLARE var_jumlah2 INT(11);
	DECLARE var_jumlah3 INT(11);
	
	
	SELECT SUM(qtyterima) INTO var_jumlah1 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		JOIN ruangan ON ruangan.kdruangan=penerimaanbarang.kdruangan
		WHERE ruangan.`kdupt`=var_kdupt AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan='Saldo Awal' 
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan;
	
	IF var_jumlah1 IS NULL THEN
		SET var_jumlah1 = 0;
	END IF;
	
	
	SELECT SUM(qtyterima) INTO var_jumlah2 FROM penerimaanbarangdetail JOIN penerimaanbarang 
		ON penerimaanbarang.`noterima`=`penerimaanbarangdetail`.`noterima`
		JOIN ruangan ON ruangan.kdruangan=penerimaanbarang.kdruangan
		WHERE ruangan.`kdupt`=var_kdupt AND penerimaanbarang.`tahunanggaran`=var_tahunanggaran
			AND penerimaanbarangdetail.`keybarang`=var_keybarang AND jenispenerimaan<>'Saldo Awal'
			AND penerimaanbarangdetail.hargabelisatuan = var_hargabelisatuan
			AND penerimaanbarang.`tglterima` < var_tglawal;
	
	IF var_jumlah2 IS NULL THEN
		SET var_jumlah2 = 0;
	END IF;
	
	
	SELECT SUM(qtykeluar) INTO var_jumlah3 FROM v_pengeluaranbarangdetail_with_hargabelisatuan
		WHERE v_pengeluaranbarangdetail_with_hargabelisatuan.`kdupt`=var_kdupt 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tahunanggaran`=var_tahunanggaran
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`keybarang`=var_keybarang
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.hargabelisatuan = var_hargabelisatuan 
		AND v_pengeluaranbarangdetail_with_hargabelisatuan.`tglkeluar` < var_tglawal;
	
	IF var_jumlah3 IS NULL THEN
		SET var_jumlah3 = 0;
	END IF;
	
	RETURN var_jumlah1 + var_jumlah2 - var_jumlah3;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_copymasterbarang` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_copymasterbarang` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_copymasterbarang`(`tahunanggaran_lama` CHAR(4), `tahunanggaran_baru` CHAR(4))
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE vkdbarang CHAR(10);
	DECLARE vnamabarang VARCHAR(100);
	DECLARE vkeyakun5 CHAR(11);
	DECLARE vmerk VARCHAR(25);
	DECLARE vtype VARCHAR(25);
	DECLARE vsatuan VARCHAR(25);
	DECLARE vkdkelompok CHAR(5);
	DECLARE vidpengguna CHAR(10);
	DECLARE vkeybarang CHAR(14);
	
	
	DECLARE curBarang CURSOR FOR 
		SELECT kdbarang, namabarang, keyakun5, merk, `type`, satuan, kdkelompok, idpengguna 
			FROM barang WHERE tahunanggaran=tahunanggaran_lama ORDER BY kdkelompok, kdbarang; 
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
        
        OPEN curBarang;
        mulaiLooping: LOOP
		FETCH curBarang INTO vkdbarang, vnamabarang, vkeyakun5, vmerk, vtype, vsatuan, vkdkelompok, vidpengguna;
		IF finished = 1 THEN 
			LEAVE mulaiLooping;
		END IF;
		
		SET vkeybarang = CONCAT(vkdbarang, tahunanggaran_baru);
		-- copy dari tahun lalu
		INSERT INTO barang(keybarang, kdbarang, namabarang, keyakun5, merk, `type`, satuan, 
				tahunanggaran, kdkelompok, idpengguna)
			VALUES(vkeybarang, vkdbarang, vnamabarang, vkeyakun5, vmerk, vtype, vsatuan, 
				tahunanggaran_baru, vkdkelompok, vidpengguna);
		
	END LOOP mulaiLooping;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_lapmutasi` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_lapmutasi` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_lapmutasi`(`vartglawal` DATE, `vartglakhir` DATE, `varkdruangan` CHAR(10))
BEGIN
	SELECT * FROM v_lapmutasi_sup_union WHERE tanggal BETWEEN vartglawal AND vartglakhir AND kdruangan = varkdruangan;
    END */$$
DELIMITER ;

/*Table structure for table `v_barang` */

DROP TABLE IF EXISTS `v_barang`;

/*!50001 DROP VIEW IF EXISTS `v_barang` */;
/*!50001 DROP TABLE IF EXISTS `v_barang` */;

/*!50001 CREATE TABLE  `v_barang`(
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `type` varchar(25) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `kdkelompok` char(17) 
)*/;

/*Table structure for table `v_barang_mutasi` */

DROP TABLE IF EXISTS `v_barang_mutasi`;

/*!50001 DROP VIEW IF EXISTS `v_barang_mutasi` */;
/*!50001 DROP TABLE IF EXISTS `v_barang_mutasi` */;

/*!50001 CREATE TABLE  `v_barang_mutasi`(
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `type` varchar(25) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `kdkelompok` char(17) 
)*/;

/*Table structure for table `v_barang_stok` */

DROP TABLE IF EXISTS `v_barang_stok`;

/*!50001 DROP VIEW IF EXISTS `v_barang_stok` */;
/*!50001 DROP TABLE IF EXISTS `v_barang_stok` */;

/*!50001 CREATE TABLE  `v_barang_stok`(
 `noterima` char(10) ,
 `keybarang` char(26) ,
 `stokbarang` decimal(32,0) ,
 `kdruangan` char(10) ,
 `tahunanggaran` char(4) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) 
)*/;

/*Table structure for table `v_kegiatan` */

DROP TABLE IF EXISTS `v_kegiatan`;

/*!50001 DROP VIEW IF EXISTS `v_kegiatan` */;
/*!50001 DROP TABLE IF EXISTS `v_kegiatan` */;

/*!50001 CREATE TABLE  `v_kegiatan`(
 `keykegiatan` char(19) ,
 `kdkegiatan` char(15) ,
 `namakegiatan` varchar(100) ,
 `keyprogram` char(13) ,
 `tahunanggaran` char(4) ,
 `namaprogram` varchar(100) ,
 `kdprogram` char(9) 
)*/;

/*Table structure for table `v_kelompokbarang` */

DROP TABLE IF EXISTS `v_kelompokbarang`;

/*!50001 DROP VIEW IF EXISTS `v_kelompokbarang` */;
/*!50001 DROP TABLE IF EXISTS `v_kelompokbarang` */;

/*!50001 CREATE TABLE  `v_kelompokbarang`(
 `kdkelompok` char(17) ,
 `namakelompok` varchar(100) ,
 `statusaktif` char(1) ,
 `statusaktif2` varchar(11) 
)*/;

/*Table structure for table `v_lap_mutasi` */

DROP TABLE IF EXISTS `v_lap_mutasi`;

/*!50001 DROP VIEW IF EXISTS `v_lap_mutasi` */;
/*!50001 DROP TABLE IF EXISTS `v_lap_mutasi` */;

/*!50001 CREATE TABLE  `v_lap_mutasi`(
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `type` varchar(25) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `kdkelompok` char(17) ,
 `namakelompok` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) ,
 `hargabeli_average` int ,
 `jumlahunit_saldoawal` int ,
 `jumlahunit_penambahan` int ,
 `jumlahunit_pemakaian` int 
)*/;

/*Table structure for table `v_lap_mutasi_fifo` */

DROP TABLE IF EXISTS `v_lap_mutasi_fifo`;

/*!50001 DROP VIEW IF EXISTS `v_lap_mutasi_fifo` */;
/*!50001 DROP TABLE IF EXISTS `v_lap_mutasi_fifo` */;

/*!50001 CREATE TABLE  `v_lap_mutasi_fifo`(
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `type` varchar(25) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `kdkelompok` char(17) ,
 `namakelompok` varchar(100) ,
 `noterima` char(10) ,
 `tglterima` date ,
 `kdruangan` char(10) ,
 `jenispenerimaan` enum('Saldo Awal','Penerimaan') ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) ,
 `stokbarang` int ,
 `hargabelisatuan` decimal(10,0) ,
 `qtysaldoawal` bigint ,
 `qtypenerimaan` bigint ,
 `qtypengeluaran` bigint 
)*/;

/*Table structure for table `v_lapmutasi_sup1` */

DROP TABLE IF EXISTS `v_lapmutasi_sup1`;

/*!50001 DROP VIEW IF EXISTS `v_lapmutasi_sup1` */;
/*!50001 DROP TABLE IF EXISTS `v_lapmutasi_sup1` */;

/*!50001 CREATE TABLE  `v_lapmutasi_sup1`(
 `nokeluar` char(10) ,
 `tglkeluar` date ,
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `qtykeluar` int ,
 `noterima` char(10) ,
 `hargabelisatuan` decimal(10,0) ,
 `kdruangan` char(10) ,
 `kdkelompok` char(17) ,
 `namakelompok` varchar(100) 
)*/;

/*Table structure for table `v_lapmutasi_sup2` */

DROP TABLE IF EXISTS `v_lapmutasi_sup2`;

/*!50001 DROP VIEW IF EXISTS `v_lapmutasi_sup2` */;
/*!50001 DROP TABLE IF EXISTS `v_lapmutasi_sup2` */;

/*!50001 CREATE TABLE  `v_lapmutasi_sup2`(
 `noterima` char(10) ,
 `tglterima` date ,
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `qtyterima` int ,
 `hargabelisatuan` decimal(10,0) ,
 `kdruangan` char(10) ,
 `kdkelompok` char(17) ,
 `namakelompok` varchar(100) 
)*/;

/*Table structure for table `v_lapmutasi_sup_union` */

DROP TABLE IF EXISTS `v_lapmutasi_sup_union`;

/*!50001 DROP VIEW IF EXISTS `v_lapmutasi_sup_union` */;
/*!50001 DROP TABLE IF EXISTS `v_lapmutasi_sup_union` */;

/*!50001 CREATE TABLE  `v_lapmutasi_sup_union`(
 `notransaksi` char(10) ,
 `tanggal` date ,
 `kdruangan` char(10) ,
 `keybarang` char(26) ,
 `kdbarang` char(22) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `qtyterima` int ,
 `qtykeluar` int ,
 `hargabelisatuan` decimal(10,0) ,
 `kdkelompok` char(17) ,
 `namakelompok` varchar(100) 
)*/;

/*Table structure for table `v_penandatangan` */

DROP TABLE IF EXISTS `v_penandatangan`;

/*!50001 DROP VIEW IF EXISTS `v_penandatangan` */;
/*!50001 DROP TABLE IF EXISTS `v_penandatangan` */;

/*!50001 CREATE TABLE  `v_penandatangan`(
 `idpenandatangan` char(10) ,
 `nip` char(20) ,
 `namapenandatangan` varchar(100) ,
 `idstruktur` char(2) ,
 `jabatan` varchar(100) ,
 `golongan` varchar(50) ,
 `kdttd` char(2) ,
 `kdruangan` char(10) ,
 `statusaktif` char(1) ,
 `statusaktif2` varchar(11) ,
 `namaruangan` varchar(100) 
)*/;

/*Table structure for table `v_penerimaanbarang` */

DROP TABLE IF EXISTS `v_penerimaanbarang`;

/*!50001 DROP VIEW IF EXISTS `v_penerimaanbarang` */;
/*!50001 DROP TABLE IF EXISTS `v_penerimaanbarang` */;

/*!50001 CREATE TABLE  `v_penerimaanbarang`(
 `noterima` char(10) ,
 `tglterima` date ,
 `uraian` varchar(255) ,
 `tahunanggaran` char(4) ,
 `kdruangan` char(10) ,
 `tglinsert` datetime ,
 `tglupdate` datetime ,
 `idpengguna` char(10) ,
 `totalbeli` decimal(18,0) ,
 `jenispenerimaan` enum('Saldo Awal','Penerimaan') 
)*/;

/*Table structure for table `v_penerimaanbarangdetail` */

DROP TABLE IF EXISTS `v_penerimaanbarangdetail`;

/*!50001 DROP VIEW IF EXISTS `v_penerimaanbarangdetail` */;
/*!50001 DROP TABLE IF EXISTS `v_penerimaanbarangdetail` */;

/*!50001 CREATE TABLE  `v_penerimaanbarangdetail`(
 `noterima` char(10) ,
 `keybarang` char(26) ,
 `qtyterima` int ,
 `hargabelisatuan` decimal(10,0) ,
 `stokbarang` int ,
 `kdruangan` char(10) ,
 `tahunanggaran` char(4) ,
 `tglterima` date ,
 `uraian` varchar(255) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) ,
 `type` varchar(25) ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) 
)*/;

/*Table structure for table `v_penerimaanbarangdetail_all` */

DROP TABLE IF EXISTS `v_penerimaanbarangdetail_all`;

/*!50001 DROP VIEW IF EXISTS `v_penerimaanbarangdetail_all` */;
/*!50001 DROP TABLE IF EXISTS `v_penerimaanbarangdetail_all` */;

/*!50001 CREATE TABLE  `v_penerimaanbarangdetail_all`(
 `noterima` char(10) ,
 `keybarang` char(26) ,
 `qtyterima` int ,
 `hargabelisatuan` decimal(10,0) ,
 `stokbarang` int ,
 `kdruangan` char(10) ,
 `tahunanggaran` char(4) ,
 `tglterima` date ,
 `uraian` varchar(255) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) ,
 `type` varchar(25) ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) 
)*/;

/*Table structure for table `v_pengeluaranbarang` */

DROP TABLE IF EXISTS `v_pengeluaranbarang`;

/*!50001 DROP VIEW IF EXISTS `v_pengeluaranbarang` */;
/*!50001 DROP TABLE IF EXISTS `v_pengeluaranbarang` */;

/*!50001 CREATE TABLE  `v_pengeluaranbarang`(
 `nokeluar` char(10) ,
 `tglkeluar` date ,
 `uraian` varchar(255) ,
 `tahunanggaran` char(4) ,
 `kdruangan` char(10) ,
 `tglinsert` datetime ,
 `tglupdate` datetime ,
 `idpengguna` char(10) 
)*/;

/*Table structure for table `v_pengeluaranbarangdetail` */

DROP TABLE IF EXISTS `v_pengeluaranbarangdetail`;

/*!50001 DROP VIEW IF EXISTS `v_pengeluaranbarangdetail` */;
/*!50001 DROP TABLE IF EXISTS `v_pengeluaranbarangdetail` */;

/*!50001 CREATE TABLE  `v_pengeluaranbarangdetail`(
 `nokeluar` char(10) ,
 `keybarang` char(26) ,
 `qtykeluar` int ,
 `tglkeluar` date ,
 `uraian` varchar(255) ,
 `tahunanggaran` char(4) ,
 `kdruangan` char(10) ,
 `idpengguna` char(10) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `type` varchar(25) ,
 `satuan` varchar(100) ,
 `kdkelompok` char(17) ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) 
)*/;

/*Table structure for table `v_pengeluaranbarangdetail_with_hargabelisatuan` */

DROP TABLE IF EXISTS `v_pengeluaranbarangdetail_with_hargabelisatuan`;

/*!50001 DROP VIEW IF EXISTS `v_pengeluaranbarangdetail_with_hargabelisatuan` */;
/*!50001 DROP TABLE IF EXISTS `v_pengeluaranbarangdetail_with_hargabelisatuan` */;

/*!50001 CREATE TABLE  `v_pengeluaranbarangdetail_with_hargabelisatuan`(
 `nokeluar` char(10) ,
 `keybarang` char(26) ,
 `qtykeluar` int ,
 `tglkeluar` date ,
 `uraian` varchar(255) ,
 `tahunanggaran` char(4) ,
 `kdruangan` char(10) ,
 `idpengguna` char(10) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `type` varchar(25) ,
 `satuan` varchar(100) ,
 `kdkelompok` char(17) ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) ,
 `noterima` char(10) ,
 `hargabelisatuan` decimal(10,0) 
)*/;

/*Table structure for table `v_pengguna` */

DROP TABLE IF EXISTS `v_pengguna`;

/*!50001 DROP VIEW IF EXISTS `v_pengguna` */;
/*!50001 DROP TABLE IF EXISTS `v_pengguna` */;

/*!50001 CREATE TABLE  `v_pengguna`(
 `idpengguna` char(10) ,
 `namapengguna` varchar(100) ,
 `kdruangan` char(10) ,
 `nip` char(20) ,
 `jk` char(1) ,
 `tgllahir` date ,
 `tempatlahir` varchar(50) ,
 `notelppengguna` char(16) ,
 `username` varchar(25) ,
 `password` varchar(100) ,
 `statusaktif` char(1) ,
 `foto` varchar(255) ,
 `akseslevel` char(1) ,
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `akseslevel2` varchar(21) ,
 `statusaktif2` varchar(11) ,
 `jk2` varchar(9) ,
 `namaruangan` varchar(100) ,
 `alamat` varchar(255) ,
 `notelp` char(16) 
)*/;

/*Table structure for table `v_program` */

DROP TABLE IF EXISTS `v_program`;

/*!50001 DROP VIEW IF EXISTS `v_program` */;
/*!50001 DROP TABLE IF EXISTS `v_program` */;

/*!50001 CREATE TABLE  `v_program`(
 `keyprogram` char(13) ,
 `kdprogram` char(9) ,
 `namaprogram` varchar(100) ,
 `tahunanggaran` char(4) 
)*/;

/*Table structure for table `v_ruangan` */

DROP TABLE IF EXISTS `v_ruangan`;

/*!50001 DROP VIEW IF EXISTS `v_ruangan` */;
/*!50001 DROP TABLE IF EXISTS `v_ruangan` */;

/*!50001 CREATE TABLE  `v_ruangan`(
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `alamat` varchar(255) ,
 `notelp` char(16) ,
 `kdupt` char(7) ,
 `statusaktif` char(1) ,
 `statusaktif2` varchar(11) ,
 `namaupt` varchar(100) 
)*/;

/*Table structure for table `v_saldoawal` */

DROP TABLE IF EXISTS `v_saldoawal`;

/*!50001 DROP VIEW IF EXISTS `v_saldoawal` */;
/*!50001 DROP TABLE IF EXISTS `v_saldoawal` */;

/*!50001 CREATE TABLE  `v_saldoawal`(
 `noterima` char(10) ,
 `tglterima` date ,
 `uraian` varchar(255) ,
 `tahunanggaran` char(4) ,
 `kdruangan` char(10) ,
 `tglinsert` datetime ,
 `tglupdate` datetime ,
 `idpengguna` char(10) ,
 `totalbeli` decimal(18,0) ,
 `jenispenerimaan` enum('Saldo Awal','Penerimaan') 
)*/;

/*Table structure for table `v_saldoawaldetail` */

DROP TABLE IF EXISTS `v_saldoawaldetail`;

/*!50001 DROP VIEW IF EXISTS `v_saldoawaldetail` */;
/*!50001 DROP TABLE IF EXISTS `v_saldoawaldetail` */;

/*!50001 CREATE TABLE  `v_saldoawaldetail`(
 `noterima` char(10) ,
 `keybarang` char(26) ,
 `qtyterima` int ,
 `hargabelisatuan` decimal(10,0) ,
 `stokbarang` int ,
 `kdruangan` char(10) ,
 `tahunanggaran` char(4) ,
 `tglterima` date ,
 `uraian` varchar(255) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `keyakun5` char(11) ,
 `merk` varchar(25) ,
 `namabarang` varchar(100) ,
 `satuan` varchar(100) ,
 `type` varchar(25) ,
 `namaruangan` varchar(100) ,
 `kdupt` char(7) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2020` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2020`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2020` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2020` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2020`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2021` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2021`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2021` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2021` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2021`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2022` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2022`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2022` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2022` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2022`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2023` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2023`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2023` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2023` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2023`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2024` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2024`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2024` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2024` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2024`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2025` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2025`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2025` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2025` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2025`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2026` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2026`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2026` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2026` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2026`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2027` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2027`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2027` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2027` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2027`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2028` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2028`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2028` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2028` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2028`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2029` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2029`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2029` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2029` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2029`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_stok_keseluruhan_2030` */

DROP TABLE IF EXISTS `v_stok_keseluruhan_2030`;

/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2030` */;
/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2030` */;

/*!50001 CREATE TABLE  `v_stok_keseluruhan_2030`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `kdruangan` char(10) ,
 `namaruangan` varchar(100) ,
 `tahunanggaran` char(4) ,
 `keybarang` char(26) ,
 `namabarang` varchar(100) ,
 `kdbarang` char(22) ,
 `kdkelompok` char(17) ,
 `satuan` varchar(100) ,
 `namakelompok` varchar(100) ,
 `stokbarang` decimal(32,0) 
)*/;

/*Table structure for table `v_upt` */

DROP TABLE IF EXISTS `v_upt`;

/*!50001 DROP VIEW IF EXISTS `v_upt` */;
/*!50001 DROP TABLE IF EXISTS `v_upt` */;

/*!50001 CREATE TABLE  `v_upt`(
 `kdupt` char(7) ,
 `namaupt` varchar(100) ,
 `alamat` varchar(255) ,
 `notelp` char(16) ,
 `kdskpd` char(5) ,
 `namaskpd` varchar(100) 
)*/;

/*View structure for view v_barang */

/*!50001 DROP TABLE IF EXISTS `v_barang` */;
/*!50001 DROP VIEW IF EXISTS `v_barang` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_barang` AS select `barang`.`keybarang` AS `keybarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`type` AS `type`,`barang`.`satuan` AS `satuan`,`barang`.`tahunanggaran` AS `tahunanggaran`,`barang`.`kdkelompok` AS `kdkelompok` from `barang` */;

/*View structure for view v_barang_mutasi */

/*!50001 DROP TABLE IF EXISTS `v_barang_mutasi` */;
/*!50001 DROP VIEW IF EXISTS `v_barang_mutasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_barang_mutasi` AS select `barang`.`keybarang` AS `keybarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`type` AS `type`,`barang`.`satuan` AS `satuan`,`barang`.`tahunanggaran` AS `tahunanggaran`,`barang`.`kdkelompok` AS `kdkelompok` from `barang` */;

/*View structure for view v_barang_stok */

/*!50001 DROP TABLE IF EXISTS `v_barang_stok` */;
/*!50001 DROP VIEW IF EXISTS `v_barang_stok` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_barang_stok` AS select `penerimaanbarangdetail`.`noterima` AS `noterima`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`satuan` AS `satuan` from ((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarang`.`noterima` = `penerimaanbarangdetail`.`noterima`))) join `barang` on((`barang`.`keybarang` = `penerimaanbarangdetail`.`keybarang`))) group by `penerimaanbarangdetail`.`noterima`,`penerimaanbarangdetail`.`keybarang`,`penerimaanbarang`.`kdruangan`,`barang`.`kdbarang`,`barang`.`namabarang`,`penerimaanbarang`.`tahunanggaran` */;

/*View structure for view v_kegiatan */

/*!50001 DROP TABLE IF EXISTS `v_kegiatan` */;
/*!50001 DROP VIEW IF EXISTS `v_kegiatan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_kegiatan` AS select `kegiatan`.`keykegiatan` AS `keykegiatan`,`kegiatan`.`kdkegiatan` AS `kdkegiatan`,`kegiatan`.`namakegiatan` AS `namakegiatan`,`kegiatan`.`keyprogram` AS `keyprogram`,`kegiatan`.`tahunanggaran` AS `tahunanggaran`,`program`.`namaprogram` AS `namaprogram`,`program`.`kdprogram` AS `kdprogram` from (`kegiatan` join `program` on((`program`.`keyprogram` = `kegiatan`.`keyprogram`))) */;

/*View structure for view v_kelompokbarang */

/*!50001 DROP TABLE IF EXISTS `v_kelompokbarang` */;
/*!50001 DROP VIEW IF EXISTS `v_kelompokbarang` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_kelompokbarang` AS select `kelompokbarang`.`kdkelompok` AS `kdkelompok`,`kelompokbarang`.`namakelompok` AS `namakelompok`,`kelompokbarang`.`statusaktif` AS `statusaktif`,(case when (`kelompokbarang`.`statusaktif` = '1') then 'Aktif' else 'Tidak Aktif' end) AS `statusaktif2` from `kelompokbarang` */;

/*View structure for view v_lap_mutasi */

/*!50001 DROP TABLE IF EXISTS `v_lap_mutasi` */;
/*!50001 DROP VIEW IF EXISTS `v_lap_mutasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lap_mutasi` AS select `barang`.`keybarang` AS `keybarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`type` AS `type`,`barang`.`satuan` AS `satuan`,`barang`.`tahunanggaran` AS `tahunanggaran`,`barang`.`kdkelompok` AS `kdkelompok`,`kelompokbarang`.`namakelompok` AS `namakelompok`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`kdupt` AS `kdupt`,`hitung_average_hargabarang_perruangan`(`ruangan`.`kdruangan`,`barang`.`tahunanggaran`,`barang`.`keybarang`) AS `hargabeli_average`,`hitung_saldoawal_barang_perruangan`(`ruangan`.`kdruangan`,`barang`.`tahunanggaran`,`barang`.`keybarang`) AS `jumlahunit_saldoawal`,`hitung_penambahan_barang_perruangan`(`ruangan`.`kdruangan`,`barang`.`tahunanggaran`,`barang`.`keybarang`) AS `jumlahunit_penambahan`,`hitung_pemakaian_barang_perruangan`(`ruangan`.`kdruangan`,`barang`.`tahunanggaran`,`barang`.`keybarang`) AS `jumlahunit_pemakaian` from ((`barang` join `kelompokbarang` on((`kelompokbarang`.`kdkelompok` = `barang`.`kdkelompok`))) join `ruangan`) */;

/*View structure for view v_lap_mutasi_fifo */

/*!50001 DROP TABLE IF EXISTS `v_lap_mutasi_fifo` */;
/*!50001 DROP VIEW IF EXISTS `v_lap_mutasi_fifo` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lap_mutasi_fifo` AS select `barang`.`keybarang` AS `keybarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`type` AS `type`,`barang`.`satuan` AS `satuan`,`barang`.`tahunanggaran` AS `tahunanggaran`,`barang`.`kdkelompok` AS `kdkelompok`,`kelompokbarang`.`namakelompok` AS `namakelompok`,`penerimaanbarang`.`noterima` AS `noterima`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`jenispenerimaan` AS `jenispenerimaan`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`kdupt` AS `kdupt`,`penerimaanbarangdetail`.`stokbarang` AS `stokbarang`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan`,(case when (`penerimaanbarang`.`jenispenerimaan` = 'Saldo Awal') then `penerimaanbarangdetail`.`qtyterima` else 0 end) AS `qtysaldoawal`,(case when (`penerimaanbarang`.`jenispenerimaan` <> 'Saldo Awal') then `penerimaanbarangdetail`.`qtyterima` else 0 end) AS `qtypenerimaan`,(`penerimaanbarangdetail`.`qtyterima` - `penerimaanbarangdetail`.`stokbarang`) AS `qtypengeluaran` from ((((`barang` join `penerimaanbarangdetail` on((`barang`.`keybarang` = `penerimaanbarangdetail`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) */;

/*View structure for view v_lapmutasi_sup1 */

/*!50001 DROP TABLE IF EXISTS `v_lapmutasi_sup1` */;
/*!50001 DROP VIEW IF EXISTS `v_lapmutasi_sup1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lapmutasi_sup1` AS select `pengeluaranbarangdetail`.`nokeluar` AS `nokeluar`,`pengeluaranbarang`.`tglkeluar` AS `tglkeluar`,`pengeluaranbarangdetail`.`keybarang` AS `keybarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`satuan` AS `satuan`,`pengeluaranbarang`.`tahunanggaran` AS `tahunanggaran`,`pengeluaranbarangdetail`.`qtykeluar` AS `qtykeluar`,`pengeluaranbarangdetail_noterima`.`noterima` AS `noterima`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan`,`pengeluaranbarang`.`kdruangan` AS `kdruangan`,`barang`.`kdkelompok` AS `kdkelompok`,`kelompokbarang`.`namakelompok` AS `namakelompok` from (((((`pengeluaranbarangdetail` join `pengeluaranbarang` on((`pengeluaranbarangdetail`.`nokeluar` = `pengeluaranbarang`.`nokeluar`))) join `pengeluaranbarangdetail_noterima` on(((`pengeluaranbarangdetail_noterima`.`nokeluar` = `pengeluaranbarangdetail`.`nokeluar`) and (`pengeluaranbarangdetail`.`keybarang` = `pengeluaranbarangdetail_noterima`.`keybarang`)))) join `barang` on((`pengeluaranbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `penerimaanbarangdetail` on(((`pengeluaranbarangdetail_noterima`.`noterima` = `penerimaanbarangdetail`.`noterima`) and (`pengeluaranbarangdetail_noterima`.`keybarang` = `penerimaanbarangdetail`.`keybarang`)))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) */;

/*View structure for view v_lapmutasi_sup2 */

/*!50001 DROP TABLE IF EXISTS `v_lapmutasi_sup2` */;
/*!50001 DROP VIEW IF EXISTS `v_lapmutasi_sup2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lapmutasi_sup2` AS select `penerimaanbarangdetail`.`noterima` AS `noterima`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`satuan` AS `satuan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`qtyterima` AS `qtyterima`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`barang`.`kdkelompok` AS `kdkelompok`,`kelompokbarang`.`namakelompok` AS `namakelompok` from (((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) */;

/*View structure for view v_lapmutasi_sup_union */

/*!50001 DROP TABLE IF EXISTS `v_lapmutasi_sup_union` */;
/*!50001 DROP VIEW IF EXISTS `v_lapmutasi_sup_union` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lapmutasi_sup_union` AS select `v_lapmutasi_sup2`.`noterima` AS `notransaksi`,`v_lapmutasi_sup2`.`tglterima` AS `tanggal`,`v_lapmutasi_sup2`.`kdruangan` AS `kdruangan`,`v_lapmutasi_sup2`.`keybarang` AS `keybarang`,`v_lapmutasi_sup2`.`kdbarang` AS `kdbarang`,`v_lapmutasi_sup2`.`namabarang` AS `namabarang`,`v_lapmutasi_sup2`.`satuan` AS `satuan`,`v_lapmutasi_sup2`.`tahunanggaran` AS `tahunanggaran`,`v_lapmutasi_sup2`.`qtyterima` AS `qtyterima`,0 AS `qtykeluar`,`v_lapmutasi_sup2`.`hargabelisatuan` AS `hargabelisatuan`,`v_lapmutasi_sup2`.`kdkelompok` AS `kdkelompok`,`v_lapmutasi_sup2`.`namakelompok` AS `namakelompok` from `v_lapmutasi_sup2` */;

/*View structure for view v_penandatangan */

/*!50001 DROP TABLE IF EXISTS `v_penandatangan` */;
/*!50001 DROP VIEW IF EXISTS `v_penandatangan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penandatangan` AS select `penandatangan`.`idpenandatangan` AS `idpenandatangan`,`penandatangan`.`nip` AS `nip`,`penandatangan`.`namapenandatangan` AS `namapenandatangan`,`penandatangan`.`idstruktur` AS `idstruktur`,`penandatangan`.`jabatan` AS `jabatan`,`penandatangan`.`golongan` AS `golongan`,`penandatangan`.`kdttd` AS `kdttd`,`penandatangan`.`kdruangan` AS `kdruangan`,`penandatangan`.`statusaktif` AS `statusaktif`,(case when (`penandatangan`.`statusaktif` = '1') then 'Aktif' else 'Tidak Aktif' end) AS `statusaktif2`,`ruangan`.`namaruangan` AS `namaruangan` from (`penandatangan` join `ruangan` on((`ruangan`.`kdruangan` = `penandatangan`.`kdruangan`))) */;

/*View structure for view v_penerimaanbarang */

/*!50001 DROP TABLE IF EXISTS `v_penerimaanbarang` */;
/*!50001 DROP VIEW IF EXISTS `v_penerimaanbarang` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penerimaanbarang` AS select `penerimaanbarang`.`noterima` AS `noterima`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarang`.`uraian` AS `uraian`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`tglinsert` AS `tglinsert`,`penerimaanbarang`.`tglupdate` AS `tglupdate`,`penerimaanbarang`.`idpengguna` AS `idpengguna`,`penerimaanbarang`.`totalbeli` AS `totalbeli`,`penerimaanbarang`.`jenispenerimaan` AS `jenispenerimaan` from `penerimaanbarang` where (`penerimaanbarang`.`jenispenerimaan` = 'Penerimaan') */;

/*View structure for view v_penerimaanbarangdetail */

/*!50001 DROP TABLE IF EXISTS `v_penerimaanbarangdetail` */;
/*!50001 DROP VIEW IF EXISTS `v_penerimaanbarangdetail` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penerimaanbarangdetail` AS select `penerimaanbarangdetail`.`noterima` AS `noterima`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`penerimaanbarangdetail`.`qtyterima` AS `qtyterima`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan`,`penerimaanbarangdetail`.`stokbarang` AS `stokbarang`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarang`.`uraian` AS `uraian`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`namabarang` AS `namabarang`,`barang`.`satuan` AS `satuan`,`barang`.`type` AS `type`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`kdupt` AS `kdupt` from (((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarang`.`noterima` = `penerimaanbarangdetail`.`noterima`))) join `barang` on((`barang`.`keybarang` = `penerimaanbarangdetail`.`keybarang`))) join `ruangan` on((`ruangan`.`kdruangan` = `penerimaanbarang`.`kdruangan`))) where (`penerimaanbarang`.`jenispenerimaan` = 'Penerimaan') */;

/*View structure for view v_penerimaanbarangdetail_all */

/*!50001 DROP TABLE IF EXISTS `v_penerimaanbarangdetail_all` */;
/*!50001 DROP VIEW IF EXISTS `v_penerimaanbarangdetail_all` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penerimaanbarangdetail_all` AS select `penerimaanbarangdetail`.`noterima` AS `noterima`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`penerimaanbarangdetail`.`qtyterima` AS `qtyterima`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan`,`penerimaanbarangdetail`.`stokbarang` AS `stokbarang`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarang`.`uraian` AS `uraian`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`namabarang` AS `namabarang`,`barang`.`satuan` AS `satuan`,`barang`.`type` AS `type`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`kdupt` AS `kdupt` from (((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarang`.`noterima` = `penerimaanbarangdetail`.`noterima`))) join `barang` on((`barang`.`keybarang` = `penerimaanbarangdetail`.`keybarang`))) join `ruangan` on((`ruangan`.`kdruangan` = `penerimaanbarang`.`kdruangan`))) */;

/*View structure for view v_pengeluaranbarang */

/*!50001 DROP TABLE IF EXISTS `v_pengeluaranbarang` */;
/*!50001 DROP VIEW IF EXISTS `v_pengeluaranbarang` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pengeluaranbarang` AS select `pengeluaranbarang`.`nokeluar` AS `nokeluar`,`pengeluaranbarang`.`tglkeluar` AS `tglkeluar`,`pengeluaranbarang`.`uraian` AS `uraian`,`pengeluaranbarang`.`tahunanggaran` AS `tahunanggaran`,`pengeluaranbarang`.`kdruangan` AS `kdruangan`,`pengeluaranbarang`.`tglinsert` AS `tglinsert`,`pengeluaranbarang`.`tglupdate` AS `tglupdate`,`pengeluaranbarang`.`idpengguna` AS `idpengguna` from `pengeluaranbarang` */;

/*View structure for view v_pengeluaranbarangdetail */

/*!50001 DROP TABLE IF EXISTS `v_pengeluaranbarangdetail` */;
/*!50001 DROP VIEW IF EXISTS `v_pengeluaranbarangdetail` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pengeluaranbarangdetail` AS select `pengeluaranbarangdetail`.`nokeluar` AS `nokeluar`,`pengeluaranbarangdetail`.`keybarang` AS `keybarang`,`pengeluaranbarangdetail`.`qtykeluar` AS `qtykeluar`,`pengeluaranbarang`.`tglkeluar` AS `tglkeluar`,`pengeluaranbarang`.`uraian` AS `uraian`,`pengeluaranbarang`.`tahunanggaran` AS `tahunanggaran`,`pengeluaranbarang`.`kdruangan` AS `kdruangan`,`pengeluaranbarang`.`idpengguna` AS `idpengguna`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`type` AS `type`,`barang`.`satuan` AS `satuan`,`barang`.`kdkelompok` AS `kdkelompok`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`kdupt` AS `kdupt` from (((`pengeluaranbarangdetail` join `pengeluaranbarang` on((`pengeluaranbarangdetail`.`nokeluar` = `pengeluaranbarang`.`nokeluar`))) join `barang` on((`pengeluaranbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `ruangan` on((`ruangan`.`kdruangan` = `pengeluaranbarang`.`kdruangan`))) */;

/*View structure for view v_pengeluaranbarangdetail_with_hargabelisatuan */

/*!50001 DROP TABLE IF EXISTS `v_pengeluaranbarangdetail_with_hargabelisatuan` */;
/*!50001 DROP VIEW IF EXISTS `v_pengeluaranbarangdetail_with_hargabelisatuan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pengeluaranbarangdetail_with_hargabelisatuan` AS select `v_pengeluaranbarangdetail`.`nokeluar` AS `nokeluar`,`v_pengeluaranbarangdetail`.`keybarang` AS `keybarang`,`pengeluaranbarangdetail_noterima`.`qtykeluar` AS `qtykeluar`,`v_pengeluaranbarangdetail`.`tglkeluar` AS `tglkeluar`,`v_pengeluaranbarangdetail`.`uraian` AS `uraian`,`v_pengeluaranbarangdetail`.`tahunanggaran` AS `tahunanggaran`,`v_pengeluaranbarangdetail`.`kdruangan` AS `kdruangan`,`v_pengeluaranbarangdetail`.`idpengguna` AS `idpengguna`,`v_pengeluaranbarangdetail`.`namabarang` AS `namabarang`,`v_pengeluaranbarangdetail`.`kdbarang` AS `kdbarang`,`v_pengeluaranbarangdetail`.`keyakun5` AS `keyakun5`,`v_pengeluaranbarangdetail`.`merk` AS `merk`,`v_pengeluaranbarangdetail`.`type` AS `type`,`v_pengeluaranbarangdetail`.`satuan` AS `satuan`,`v_pengeluaranbarangdetail`.`kdkelompok` AS `kdkelompok`,`v_pengeluaranbarangdetail`.`namaruangan` AS `namaruangan`,`v_pengeluaranbarangdetail`.`kdupt` AS `kdupt`,`penerimaanbarangdetail`.`noterima` AS `noterima`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan` from ((`v_pengeluaranbarangdetail` join `pengeluaranbarangdetail_noterima` on(((`v_pengeluaranbarangdetail`.`nokeluar` = `pengeluaranbarangdetail_noterima`.`nokeluar`) and (`v_pengeluaranbarangdetail`.`keybarang` = `pengeluaranbarangdetail_noterima`.`keybarang`)))) join `penerimaanbarangdetail` on(((`pengeluaranbarangdetail_noterima`.`noterima` = `penerimaanbarangdetail`.`noterima`) and (`pengeluaranbarangdetail_noterima`.`keybarang` = `penerimaanbarangdetail`.`keybarang`) and (`pengeluaranbarangdetail_noterima`.`hargabelisatuan` = `penerimaanbarangdetail`.`hargabelisatuan`)))) */;

/*View structure for view v_pengguna */

/*!50001 DROP TABLE IF EXISTS `v_pengguna` */;
/*!50001 DROP VIEW IF EXISTS `v_pengguna` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pengguna` AS select `pengguna`.`idpengguna` AS `idpengguna`,`pengguna`.`namapengguna` AS `namapengguna`,`pengguna`.`kdruangan` AS `kdruangan`,`pengguna`.`nip` AS `nip`,`pengguna`.`jk` AS `jk`,`pengguna`.`tgllahir` AS `tgllahir`,`pengguna`.`tempatlahir` AS `tempatlahir`,`pengguna`.`notelp` AS `notelppengguna`,`pengguna`.`username` AS `username`,`pengguna`.`password` AS `password`,`pengguna`.`statusaktif` AS `statusaktif`,`pengguna`.`foto` AS `foto`,`pengguna`.`akseslevel` AS `akseslevel`,`pengguna`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,(case `pengguna`.`akseslevel` when '1' then 'User Sekolah' when '2' then 'User UPT' when '3' then 'User Dinas Pendidikan' when '9' then 'Admin System' else 'Pengguna ruangan' end) AS `akseslevel2`,(case when (`pengguna`.`statusaktif` = '1') then 'Aktif' else 'Tidak Aktif' end) AS `statusaktif2`,(case when (`pengguna`.`jk` = 'L') then 'Laki-laki' else 'Perempuan' end) AS `jk2`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`alamat` AS `alamat`,`ruangan`.`notelp` AS `notelp` from ((`pengguna` left join `ruangan` on((`ruangan`.`kdruangan` = `pengguna`.`kdruangan`))) left join `upt` on((`upt`.`kdupt` = `pengguna`.`kdupt`))) */;

/*View structure for view v_program */

/*!50001 DROP TABLE IF EXISTS `v_program` */;
/*!50001 DROP VIEW IF EXISTS `v_program` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_program` AS select `program`.`keyprogram` AS `keyprogram`,`program`.`kdprogram` AS `kdprogram`,`program`.`namaprogram` AS `namaprogram`,`program`.`tahunanggaran` AS `tahunanggaran` from `program` */;

/*View structure for view v_ruangan */

/*!50001 DROP TABLE IF EXISTS `v_ruangan` */;
/*!50001 DROP VIEW IF EXISTS `v_ruangan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ruangan` AS select `ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`alamat` AS `alamat`,`ruangan`.`notelp` AS `notelp`,`ruangan`.`kdupt` AS `kdupt`,`ruangan`.`statusaktif` AS `statusaktif`,(case when (`ruangan`.`statusaktif` = '1') then 'Aktif' else 'Tidak Aktif' end) AS `statusaktif2`,`upt`.`namaupt` AS `namaupt` from (`ruangan` join `upt` on((`upt`.`kdupt` = `ruangan`.`kdupt`))) */;

/*View structure for view v_saldoawal */

/*!50001 DROP TABLE IF EXISTS `v_saldoawal` */;
/*!50001 DROP VIEW IF EXISTS `v_saldoawal` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_saldoawal` AS select `penerimaanbarang`.`noterima` AS `noterima`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarang`.`uraian` AS `uraian`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`tglinsert` AS `tglinsert`,`penerimaanbarang`.`tglupdate` AS `tglupdate`,`penerimaanbarang`.`idpengguna` AS `idpengguna`,`penerimaanbarang`.`totalbeli` AS `totalbeli`,`penerimaanbarang`.`jenispenerimaan` AS `jenispenerimaan` from `penerimaanbarang` where (`penerimaanbarang`.`jenispenerimaan` = 'Saldo Awal') */;

/*View structure for view v_saldoawaldetail */

/*!50001 DROP TABLE IF EXISTS `v_saldoawaldetail` */;
/*!50001 DROP VIEW IF EXISTS `v_saldoawaldetail` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_saldoawaldetail` AS select `penerimaanbarangdetail`.`noterima` AS `noterima`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`penerimaanbarangdetail`.`qtyterima` AS `qtyterima`,`penerimaanbarangdetail`.`hargabelisatuan` AS `hargabelisatuan`,`penerimaanbarangdetail`.`stokbarang` AS `stokbarang`,`penerimaanbarang`.`kdruangan` AS `kdruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarang`.`tglterima` AS `tglterima`,`penerimaanbarang`.`uraian` AS `uraian`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`keyakun5` AS `keyakun5`,`barang`.`merk` AS `merk`,`barang`.`namabarang` AS `namabarang`,`barang`.`satuan` AS `satuan`,`barang`.`type` AS `type`,`ruangan`.`namaruangan` AS `namaruangan`,`ruangan`.`kdupt` AS `kdupt` from (((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarang`.`noterima` = `penerimaanbarangdetail`.`noterima`))) join `barang` on((`barang`.`keybarang` = `penerimaanbarangdetail`.`keybarang`))) join `ruangan` on((`ruangan`.`kdruangan` = `penerimaanbarang`.`kdruangan`))) where (`penerimaanbarang`.`jenispenerimaan` = 'Saldo Awal') */;

/*View structure for view v_stok_keseluruhan_2020 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2020` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2020` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2020` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2020') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2021 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2021` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2021` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2021` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2021') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2022 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2022` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2022` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2022` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2022') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2023 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2023` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2023` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2023` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2023') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2024 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2024` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2024` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2024` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2024') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2025 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2025` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2025` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2025` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2025') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2026 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2026` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2026` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2026` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2026') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2027 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2027` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2027` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2027` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2027') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2028 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2028` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2028` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2028` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2028') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2029 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2029` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2029` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2029` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2029') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_stok_keseluruhan_2030 */

/*!50001 DROP TABLE IF EXISTS `v_stok_keseluruhan_2030` */;
/*!50001 DROP VIEW IF EXISTS `v_stok_keseluruhan_2030` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_keseluruhan_2030` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`ruangan`.`kdruangan` AS `kdruangan`,`ruangan`.`namaruangan` AS `namaruangan`,`penerimaanbarang`.`tahunanggaran` AS `tahunanggaran`,`penerimaanbarangdetail`.`keybarang` AS `keybarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`kdbarang` AS `kdbarang`,`barang`.`kdkelompok` AS `kdkelompok`,`barang`.`satuan` AS `satuan`,`kelompokbarang`.`namakelompok` AS `namakelompok`,sum(`penerimaanbarangdetail`.`stokbarang`) AS `stokbarang` from (((((`penerimaanbarangdetail` join `penerimaanbarang` on((`penerimaanbarangdetail`.`noterima` = `penerimaanbarang`.`noterima`))) join `barang` on((`penerimaanbarangdetail`.`keybarang` = `barang`.`keybarang`))) join `kelompokbarang` on((`barang`.`kdkelompok` = `kelompokbarang`.`kdkelompok`))) join `ruangan` on((`penerimaanbarang`.`kdruangan` = `ruangan`.`kdruangan`))) join `upt` on((`ruangan`.`kdupt` = `upt`.`kdupt`))) where (`penerimaanbarang`.`tahunanggaran` = '2030') group by `upt`.`kdupt`,`upt`.`namaupt`,`ruangan`.`kdruangan`,`ruangan`.`namaruangan`,`penerimaanbarang`.`tahunanggaran`,`penerimaanbarangdetail`.`keybarang`,`barang`.`namabarang`,`barang`.`kdbarang`,`barang`.`kdkelompok`,`kelompokbarang`.`namakelompok` */;

/*View structure for view v_upt */

/*!50001 DROP TABLE IF EXISTS `v_upt` */;
/*!50001 DROP VIEW IF EXISTS `v_upt` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_upt` AS select `upt`.`kdupt` AS `kdupt`,`upt`.`namaupt` AS `namaupt`,`upt`.`alamat` AS `alamat`,`upt`.`notelp` AS `notelp`,`upt`.`kdskpd` AS `kdskpd`,`skpd`.`namaskpd` AS `namaskpd` from (`upt` join `skpd` on((`upt`.`kdskpd` = `skpd`.`kdskpd`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
