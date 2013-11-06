-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2013 at 08:49 AM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webter_inventori`
--
CREATE DATABASE `webter_inventori` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `webter_inventori`;

-- --------------------------------------------------------

--
-- Table structure for table `tbbarang`
--

CREATE TABLE IF NOT EXISTS `tbbarang` (
  `kodebrg` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `barcode` varchar(10) NOT NULL,
  `namabrg` varchar(71) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga` double unsigned NOT NULL,
  `stok` int(10) unsigned NOT NULL,
  PRIMARY KEY (`kodebrg`),
  UNIQUE KEY `barcode` (`barcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Triggers `tbbeli`
--
DROP TRIGGER IF EXISTS `ins_beli`;
DELIMITER //
CREATE TRIGGER `ins_beli` BEFORE INSERT ON `tbbeli`
 FOR EACH ROW begin
update tbbarang set stok=stok + new.jumlah
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
  ADD CONSTRAINT `tbbeli_ibfk_4` FOREIGN KEY (`kodesupp`) REFERENCES `tbsuplier` (`kodesupp`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbbeli_ibfk_3` FOREIGN KEY (`kodebrg`) REFERENCES `tbbarang` (`kodebrg`) ON DELETE CASCADE;

--
-- Constraints for table `tbjual`
--
ALTER TABLE `tbjual`
  ADD CONSTRAINT `tbjual_ibfk_2` FOREIGN KEY (`kodecst`) REFERENCES `tbcustomer` (`kodecst`),
  ADD CONSTRAINT `tbjual_ibfk_3` FOREIGN KEY (`kodebrg`) REFERENCES `tbbarang` (`kodebrg`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
