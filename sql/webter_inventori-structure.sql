-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2013 at 04:52 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webter_inventori`
--
CREATE DATABASE IF NOT EXISTS `webter_inventori` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `webter_inventori`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `test`()
BEGIN
declare a int unsigned;
declare b int unsigned;
declare c decimal;
declare d int unsigned;
set a = 50;
set b = 60;
set d = 100;
select cast(a as decimal);
select cast(b as decimal);

set c = cast(a as decimal)-cast(b as decimal);
select c;
set d = d + c;
select d;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbbarang`
--

CREATE TABLE IF NOT EXISTS `tbbarang` (
  `kodebrg` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `barcode` varchar(10) NOT NULL,
  `namabrg` varchar(71) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga` bigint(20) unsigned NOT NULL,
  `stok` int(10) unsigned NOT NULL,
  PRIMARY KEY (`kodebrg`),
  UNIQUE KEY `barcode` (`barcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbbeli`
--

CREATE TABLE IF NOT EXISTS `tbbeli` (
  `nofaktur` int(11) NOT NULL AUTO_INCREMENT,
  `kodebrg` int(10) unsigned NOT NULL,
  `kodesupp` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` double unsigned NOT NULL,
  `jumlah` int(10) unsigned NOT NULL,
  PRIMARY KEY (`nofaktur`),
  KEY `kodebrg` (`kodebrg`),
  KEY `kodesupp` (`kodesupp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Triggers `tbbeli`
--
DROP TRIGGER IF EXISTS `del_beli`;
DELIMITER //
CREATE TRIGGER `del_beli` AFTER DELETE ON `tbbeli`
 FOR EACH ROW begin
update tbbarang set stok=cast(stok as decimal) - old.jumlah
where kodebrg=old.kodebrg;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ins_beli`;
DELIMITER //
CREATE TRIGGER `ins_beli` AFTER INSERT ON `tbbeli`
 FOR EACH ROW begin
update tbbarang set stok=stok + new.jumlah
where kodebrg=new.kodebrg;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `upd_beli`;
DELIMITER //
CREATE TRIGGER `upd_beli` AFTER UPDATE ON `tbbeli`
 FOR EACH ROW begin
declare JumlahBaru decimal;
set JumlahBaru = cast(new.jumlah as decimal) - cast(old.jumlah as decimal);

update tbbarang set stok = stok + JumlahBaru
where kodebrg=new.kodebrg;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbcustomer`
--

CREATE TABLE IF NOT EXISTS `tbcustomer` (
  `kodecst` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namacst` varchar(71) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(20) NOT NULL,
  PRIMARY KEY (`kodecst`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbjual`
--

CREATE TABLE IF NOT EXISTS `tbjual` (
  `nofaktur` int(11) NOT NULL AUTO_INCREMENT,
  `kodebrg` int(10) unsigned NOT NULL,
  `kodecst` int(10) unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `harga` double unsigned NOT NULL,
  `jumlah` int(10) unsigned NOT NULL,
  PRIMARY KEY (`nofaktur`),
  KEY `kodecst` (`kodecst`),
  KEY `kodebrg` (`kodebrg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Triggers `tbjual`
--
DROP TRIGGER IF EXISTS `del_jual`;
DELIMITER //
CREATE TRIGGER `del_jual` AFTER DELETE ON `tbjual`
 FOR EACH ROW begin
update tbbarang set stok=stok + old.jumlah
where kodebrg=old.kodebrg;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ins_jual`;
DELIMITER //
CREATE TRIGGER `ins_jual` AFTER INSERT ON `tbjual`
 FOR EACH ROW begin
update tbbarang set stok=cast(stok as decimal) - new.jumlah
where kodebrg=new.kodebrg;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `upd_jual`;
DELIMITER //
CREATE TRIGGER `upd_jual` AFTER UPDATE ON `tbjual`
 FOR EACH ROW begin
declare JumlahBaru decimal;
set JumlahBaru = cast(new.jumlah as decimal) - cast(old.jumlah as decimal);

update tbbarang set stok=stok + JumlahBaru
where kodebrg=new.kodebrg;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbsuplier`
--

CREATE TABLE IF NOT EXISTS `tbsuplier` (
  `kodesupp` int(11) NOT NULL AUTO_INCREMENT,
  `namasupp` varchar(71) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(20) NOT NULL,
  PRIMARY KEY (`kodesupp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_beli`
--
CREATE TABLE IF NOT EXISTS `v_beli` (
`namabrg` varchar(71)
,`satuan` varchar(10)
,`namasupp` varchar(71)
,`nofaktur` int(11)
,`kodebrg` int(10) unsigned
,`kodesupp` int(11)
,`tanggal` date
,`harga` double unsigned
,`jumlah` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jual`
--
CREATE TABLE IF NOT EXISTS `v_jual` (
`namabrg` varchar(71)
,`satuan` varchar(10)
,`namacst` varchar(71)
,`nofaktur` int(11)
,`kodebrg` int(10) unsigned
,`kodecst` int(10) unsigned
,`tanggal` date
,`harga` double unsigned
,`jumlah` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Structure for view `v_beli`
--
DROP TABLE IF EXISTS `v_beli`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_beli` AS select `a`.`namabrg` AS `namabrg`,`a`.`satuan` AS `satuan`,`b`.`namasupp` AS `namasupp`,`c`.`nofaktur` AS `nofaktur`,`c`.`kodebrg` AS `kodebrg`,`c`.`kodesupp` AS `kodesupp`,`c`.`tanggal` AS `tanggal`,`c`.`harga` AS `harga`,`c`.`jumlah` AS `jumlah` from ((`tbbarang` `a` join `tbsuplier` `b`) join `tbbeli` `c`) where ((`a`.`kodebrg` = `c`.`kodebrg`) and (`b`.`kodesupp` = `c`.`kodesupp`));

-- --------------------------------------------------------

--
-- Structure for view `v_jual`
--
DROP TABLE IF EXISTS `v_jual`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jual` AS select `a`.`namabrg` AS `namabrg`,`a`.`satuan` AS `satuan`,`b`.`namacst` AS `namacst`,`c`.`nofaktur` AS `nofaktur`,`c`.`kodebrg` AS `kodebrg`,`c`.`kodecst` AS `kodecst`,`c`.`tanggal` AS `tanggal`,`c`.`harga` AS `harga`,`c`.`jumlah` AS `jumlah` from ((`tbbarang` `a` join `tbcustomer` `b`) join `tbjual` `c`) where ((`a`.`kodebrg` = `c`.`kodebrg`) and (`b`.`kodecst` = `c`.`kodecst`));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbbeli`
--
ALTER TABLE `tbbeli`
  ADD CONSTRAINT `tbbeli_ibfk_3` FOREIGN KEY (`kodebrg`) REFERENCES `tbbarang` (`kodebrg`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbbeli_ibfk_4` FOREIGN KEY (`kodesupp`) REFERENCES `tbsuplier` (`kodesupp`) ON DELETE CASCADE;

--
-- Constraints for table `tbjual`
--
ALTER TABLE `tbjual`
  ADD CONSTRAINT `tbjual_ibfk_2` FOREIGN KEY (`kodecst`) REFERENCES `tbcustomer` (`kodecst`),
  ADD CONSTRAINT `tbjual_ibfk_3` FOREIGN KEY (`kodebrg`) REFERENCES `tbbarang` (`kodebrg`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
