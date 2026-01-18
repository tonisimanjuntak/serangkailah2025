/*
SQLyog Enterprise v10.42 
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

/*Table structure for table `bataswaktuperruangan` */

DROP TABLE IF EXISTS `bataswaktuperruangan`;

CREATE TABLE `bataswaktuperruangan` (
  `kdruangan` char(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tglruangan` datetime DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `idpengguna` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`kdruangan`),
  KEY `idpengguna` (`idpengguna`),
  CONSTRAINT `bataswaktuperruangan_ibfk_1` FOREIGN KEY (`kdruangan`) REFERENCES `ruangan` (`kdruangan`),
  CONSTRAINT `bataswaktuperruangan_ibfk_2` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`idpengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `bataswaktuperruangan` */

insert  into `bataswaktuperruangan`(`kdruangan`,`tglruangan`,`tglinsert`,`idpengguna`) values ('2104190001','2026-01-19 01:21:00','2026-01-19 01:21:49','2510230001');

/*Table structure for table `v_bataswaktuperruangan` */

DROP TABLE IF EXISTS `v_bataswaktuperruangan`;

/*!50001 DROP VIEW IF EXISTS `v_bataswaktuperruangan` */;
/*!50001 DROP TABLE IF EXISTS `v_bataswaktuperruangan` */;

/*!50001 CREATE TABLE  `v_bataswaktuperruangan`(
 `kdruangan` char(10) ,
 `tglruangan` datetime ,
 `tglinsert` datetime ,
 `idpengguna` char(10) ,
 `namaruangan` varchar(100) ,
 `namapengguna` varchar(100) 
)*/;

/*View structure for view v_bataswaktuperruangan */

/*!50001 DROP TABLE IF EXISTS `v_bataswaktuperruangan` */;
/*!50001 DROP VIEW IF EXISTS `v_bataswaktuperruangan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_bataswaktuperruangan` AS select `bataswaktuperruangan`.`kdruangan` AS `kdruangan`,`bataswaktuperruangan`.`tglruangan` AS `tglruangan`,`bataswaktuperruangan`.`tglinsert` AS `tglinsert`,`bataswaktuperruangan`.`idpengguna` AS `idpengguna`,`ruangan`.`namaruangan` AS `namaruangan`,`pengguna`.`namapengguna` AS `namapengguna` from ((`bataswaktuperruangan` join `ruangan` on((`bataswaktuperruangan`.`kdruangan` = `ruangan`.`kdruangan`))) join `pengguna` on((`bataswaktuperruangan`.`idpengguna` = `pengguna`.`idpengguna`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
