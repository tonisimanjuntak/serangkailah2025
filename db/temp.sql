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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_average_hargabarang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_average_hargabarang_persekolah`(`var_kdsekolah` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_pemakaian_barang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_pemakaian_barang_persekolah`(`var_kdsekolah` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_penambahan_barang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_penambahan_barang_persekolah`(`var_kdsekolah` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_saldoawal_barang_perruangan`(`var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaan_dinas_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaan_perruangan_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaan_perupt_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdupt` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `pengeluaran_dinas_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `pengeluaran_perruangan_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `pengeluaran_perupt_new`(`var_tglawal` DATE, `var_tglakhir` DATE, `var_kdupt` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `saldoawal_dinas_new`(`var_tglawal` DATE, `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `saldoawal_perruangan_new`(`var_tglawal` DATE, `var_kdruangan` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `saldoawal_perupt_new`(`var_tglawal` DATE, `var_kdupt` CHAR(10), `var_tahunanggaran` CHAR(4), `var_keybarang` CHAR(26), `var_hargabelisatuan` DECIMAL(18,0)) RETURNS int
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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
