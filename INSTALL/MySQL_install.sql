-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2015 at 03:46 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cat_dcms`
--
DROP DATABASE `cat_dcms`;
CREATE DATABASE IF NOT EXISTS `cat_dcms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cat_dcms`;

-- --------------------------------------------------------

--
-- Table structure for table `cus_customer`
--

DROP TABLE IF EXISTS `cus_customer`;
CREATE TABLE IF NOT EXISTS `cus_customer` (
`CustomerID` int(11) NOT NULL,
  `PrefixID` varchar(45) DEFAULT NULL,
  `CustomerStatus` varchar(45) DEFAULT NULL COMMENT 'Active\nSuppened\nDelete',
  `CustomerName` varchar(45) DEFAULT NULL,
  `BusinessType` varchar(45) DEFAULT NULL COMMENT 'กสท.\nนิติบุคคล\nบุคคล',
  `Email` varchar(45) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Fax` varchar(45) DEFAULT NULL,
  `Address` varchar(45) DEFAULT NULL,
  `Township` varchar(45) DEFAULT NULL,
  `City` varchar(45) DEFAULT NULL,
  `Province` varchar(45) DEFAULT NULL,
  `Zipcode` int(11) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_item`
--

DROP TABLE IF EXISTS `cus_item`;
CREATE TABLE IF NOT EXISTS `cus_item` (
`ItemID` int(11) NOT NULL,
  `EntryIDCID` int(11) DEFAULT NULL,
  `Equipment` varchar(45) DEFAULT NULL,
  `Brand` varchar(45) DEFAULT NULL,
  `Model` varchar(45) DEFAULT NULL,
  `SerialNo` varchar(45) DEFAULT NULL,
  `RackID` int(11) DEFAULT NULL,
  `TimeIn` datetime DEFAULT NULL,
  `TimeOut` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_order`
--

DROP TABLE IF EXISTS `cus_order`;
CREATE TABLE IF NOT EXISTS `cus_order` (
`OrderID` int(11) NOT NULL,
  `OrderPreID` varchar(45) DEFAULT NULL,
  `OrderIDOld` varchar(45) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Location` varchar(45) DEFAULT NULL,
  `StatusOrder` varchar(45) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_order_bundle_network`
--

DROP TABLE IF EXISTS `cus_order_bundle_network`;
CREATE TABLE IF NOT EXISTS `cus_order_bundle_network` (
`orderBundleNetworkID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `BundleNetwork` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_order_detail`
--

DROP TABLE IF EXISTS `cus_order_detail`;
CREATE TABLE IF NOT EXISTS `cus_order_detail` (
`OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `PackageID` int(11) DEFAULT NULL,
  `OrderDetailStatus` varchar(45) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_package`
--

DROP TABLE IF EXISTS `cus_package`;
CREATE TABLE IF NOT EXISTS `cus_package` (
`PackageID` int(11) NOT NULL,
  `PackageName` varchar(45) DEFAULT NULL,
  `PackageDetail` text,
  `PackageType` varchar(45) DEFAULT NULL COMMENT 'หลัก\nรอง',
  `PackageCategory` varchar(45) DEFAULT NULL COMMENT 'Full\n1/2\n1/4\nShare',
  `PackageStatus` varchar(45) DEFAULT '1',
  `IPAmount` int(11) DEFAULT '0',
  `PortAmount` int(11) DEFAULT '0',
  `RackAmount` int(11) DEFAULT '0',
  `ServiceAmount` int(11) DEFAULT '0',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_person`
--

DROP TABLE IF EXISTS `cus_person`;
CREATE TABLE IF NOT EXISTS `cus_person` (
`PersonID` int(11) NOT NULL,
  `Fname` varchar(45) DEFAULT NULL,
  `Lname` varchar(45) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `CatEmpID` varchar(45) DEFAULT NULL,
  `IDCard` varchar(45) DEFAULT NULL,
  `IDCCard` varchar(45) DEFAULT NULL,
  `IDCCardType` varchar(5) DEFAULT NULL,
  `TypePerson` varchar(45) DEFAULT NULL COMMENT 'staff\ncontact\nsubcontact\nvisitor',
  `Position` varchar(45) DEFAULT NULL,
  `PersonStatus` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_idc`
--

DROP TABLE IF EXISTS `entry_idc`;
CREATE TABLE IF NOT EXISTS `entry_idc` (
`EntryIDCID` int(11) NOT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `VisitorCardID` varchar(45) DEFAULT NULL,
  `IDCard` varchar(45) DEFAULT NULL,
  `IDCCard` varchar(45) DEFAULT NULL,
  `IDCCardType` varchar(45) DEFAULT NULL,
  `EmpID` varchar(45) DEFAULT NULL,
  `TimeIn` datetime DEFAULT NULL,
  `TimeOut` datetime DEFAULT NULL,
  `Purpose` varchar(255) DEFAULT NULL,
  `InternetAccount` varchar(45) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_idc_zone`
--

DROP TABLE IF EXISTS `entry_idc_zone`;
CREATE TABLE IF NOT EXISTS `entry_idc_zone` (
`EntryIDCZoneID` int(11) NOT NULL,
  `EntryIDCID` int(11) DEFAULT NULL,
  `Zone` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_ip`
--

DROP TABLE IF EXISTS `resource_ip`;
CREATE TABLE IF NOT EXISTS `resource_ip` (
`ResourceIpID` int(11) NOT NULL,
  `IP` varchar(45) DEFAULT NULL,
  `NetworkIP` varchar(45) DEFAULT NULL,
  `Subnet` varchar(45) DEFAULT NULL,
  `VlanID` int(11) DEFAULT NULL,
  `EnableResourceIP` int(1) DEFAULT '1',
  `OrderDetailID` int(11) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_rack`
--

DROP TABLE IF EXISTS `resource_rack`;
CREATE TABLE IF NOT EXISTS `resource_rack` (
`ResourceRackID` int(11) NOT NULL,
  `Zone` varchar(45) DEFAULT NULL,
  `Position` int(11) DEFAULT NULL,
  `SubPosition` int(11) DEFAULT NULL,
  `RackType` varchar(45) DEFAULT NULL COMMENT 'ex. Full Rack, 1/2 Rack, 1/4 Rack',
  `RackSize` int(11) DEFAULT NULL,
  `EnableResourceRack` int(1) DEFAULT '1',
  `OrderDetailID` int(11) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_service`
--

DROP TABLE IF EXISTS `resource_service`;
CREATE TABLE IF NOT EXISTS `resource_service` (
`ResourceServiceID` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Detail` varchar(45) DEFAULT NULL,
  `Tag` text,
  `PersonID` int(11) DEFAULT NULL,
  `EnableResourceService` int(1) DEFAULT '1',
  `OrderDetailID` int(11) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch`
--

DROP TABLE IF EXISTS `resource_switch`;
CREATE TABLE IF NOT EXISTS `resource_switch` (
`ResourceSwitchID` int(11) NOT NULL,
  `SwitchName` varchar(45) DEFAULT NULL,
  `SwitchIP` varchar(45) DEFAULT NULL,
  `TotalPort` varchar(45) DEFAULT NULL,
  `SnmpCommuPublic` varchar(45) DEFAULT NULL,
  `SnmpCommuPrivate` varchar(45) DEFAULT NULL,
  `SwitchType` varchar(45) DEFAULT NULL,
  `EnableResourceSW` int(1) DEFAULT '1',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch_port`
--

DROP TABLE IF EXISTS `resource_switch_port`;
CREATE TABLE IF NOT EXISTS `resource_switch_port` (
`ResourceSwitchPortID` int(11) NOT NULL,
  `ResourceSwitchID` int(11) DEFAULT NULL,
  `PortNumber` int(11) DEFAULT NULL,
  `PortType` varchar(45) DEFAULT NULL,
  `Uplink` tinyint(4) DEFAULT NULL,
  `EnableResourcePort` int(1) DEFAULT '1',
  `OrderDetailID` int(11) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch_vlan`
--

DROP TABLE IF EXISTS `resource_switch_vlan`;
CREATE TABLE IF NOT EXISTS `resource_switch_vlan` (
`VlanID` int(11) NOT NULL,
  `VlanNumber` int(11) NOT NULL,
  `SwitchID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `TicketID` int(11) NOT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `Topic` varchar(45) DEFAULT NULL,
  `Detail` text,
  `TicketStatus` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_event`
--

DROP TABLE IF EXISTS `ticket_event`;
CREATE TABLE IF NOT EXISTS `ticket_event` (
  `TicketEventID` int(11) NOT NULL,
  `TicketID` int(11) DEFAULT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `TicketEvent` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_contact`
--
DROP VIEW IF EXISTS `view_contact`;
CREATE TABLE IF NOT EXISTS `view_contact` (
`cusID` int(11)
,`prefixID` varchar(45)
,`cusStatus` varchar(45)
,`cusName` varchar(45)
,`cusType` varchar(45)
,`PersonID` int(11)
,`Fname` varchar(45)
,`Lname` varchar(45)
,`Phone` varchar(45)
,`Email` varchar(45)
,`Password` varchar(45)
,`CatEmpID` varchar(45)
,`IDCard` varchar(45)
,`IDCCard` varchar(45)
,`IDCCardType` varchar(5)
,`TypePerson` varchar(45)
,`Position` varchar(45)
,`PersonStatus` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_entry_idc`
--
DROP VIEW IF EXISTS `view_entry_idc`;
CREATE TABLE IF NOT EXISTS `view_entry_idc` (
`CustomerID` int(11)
,`CustomerName` varchar(45)
,`BusinessType` varchar(45)
,`PersonID` int(11)
,`Fname` varchar(45)
,`Lname` varchar(45)
,`EntryIDCID` int(11)
,`EmpID` varchar(45)
,`Phone` varchar(45)
,`Email` varchar(45)
,`VisitorCardID` varchar(45)
,`IDCard` varchar(45)
,`IDCCard` varchar(45)
,`IDCCardType` varchar(45)
,`TimeIn` datetime
,`TimeOut` datetime
,`Purpose` varchar(255)
,`InternetAccount` varchar(45)
,`DateTimeCreate` timestamp
,`DateTimeUpdate` timestamp
,`CreateBy` int(11)
,`UpdateBy` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_ip`
--
DROP VIEW IF EXISTS `view_ip`;
CREATE TABLE IF NOT EXISTS `view_ip` (
`IP` varchar(45)
,`NetworkIP` varchar(45)
,`Subnet` varchar(45)
,`VlanID` int(11)
,`EnableResourceIP` int(1)
,`OrderDetailID` int(11)
,`DateTimeCreate` timestamp
,`DateTimeUpdate` timestamp
,`CreateBy` int(11)
,`UpdateBy` int(11)
,`OrderID` int(11)
,`PackageID` int(11)
,`CustomerID` int(11)
,`Location` varchar(45)
,`CustomerName` varchar(45)
,`BusinessType` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_order_detail`
--
DROP VIEW IF EXISTS `view_order_detail`;
CREATE TABLE IF NOT EXISTS `view_order_detail` (
`OrderDetailID` int(11)
,`OrderID` int(11)
,`OrderDetailStatus` varchar(45)
,`DateTime` timestamp
,`PackageID` int(11)
,`PackageName` varchar(45)
,`PackageType` varchar(45)
,`PackageCategory` varchar(45)
,`IPAmount` int(11)
,`PortAmount` int(11)
,`RackAmount` int(11)
,`ServiceAmount` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_rack`
--
DROP VIEW IF EXISTS `view_rack`;
CREATE TABLE IF NOT EXISTS `view_rack` (
`ResourceRackID` int(11)
,`Zone` varchar(45)
,`Position` int(11)
,`SubPosition` int(11)
,`RackType` varchar(45)
,`RackSize` int(11)
,`EnableResourceRack` int(1)
,`OrderDetailID` int(11)
,`DateTimeCreate` timestamp
,`DateTimeUpdate` timestamp
,`CreateBy` int(11)
,`UpdateBy` int(11)
,`OrderID` int(11)
,`PackageID` int(11)
,`CustomerID` int(11)
,`CustomerName` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_resource_reserve`
--
DROP VIEW IF EXISTS `view_resource_reserve`;
CREATE TABLE IF NOT EXISTS `view_resource_reserve` (
`ip` int(11)
,`port` int(11)
,`rack` int(11)
,`service` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_summery_port`
--
DROP VIEW IF EXISTS `view_summery_port`;
CREATE TABLE IF NOT EXISTS `view_summery_port` (
`ResourceSwitchID` int(11)
,`SwitchName` varchar(45)
,`SwitchType` varchar(45)
,`use` decimal(23,0)
,`uplink` decimal(23,0)
,`TotalPort` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_switch_port`
--
DROP VIEW IF EXISTS `view_switch_port`;
CREATE TABLE IF NOT EXISTS `view_switch_port` (
`ResourceSwitchPortID` int(11)
,`ResourceSwitchID` int(11)
,`PortNumber` int(11)
,`PortType` varchar(45)
,`Uplink` tinyint(4)
,`EnableResourcePort` int(1)
,`OrderDetailID` int(11)
,`DateTimeCreate` timestamp
,`DateTimeUpdate` timestamp
,`CreateBy` int(11)
,`UpdateBy` int(11)
,`SwitchName` varchar(45)
,`SwitchIP` varchar(45)
,`TotalPort` varchar(45)
,`SnmpCommuPublic` varchar(45)
,`SwitchType` varchar(45)
,`EnableResourceSW` int(1)
,`OrderID` int(11)
,`CustomerID` int(11)
,`CustomerName` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_switch_port_balance`
--
DROP VIEW IF EXISTS `view_switch_port_balance`;
CREATE TABLE IF NOT EXISTS `view_switch_port_balance` (
`ResourceSwitchID` int(11)
,`SwitchName` varchar(45)
,`balance` decimal(23,0)
);
-- --------------------------------------------------------

--
-- Structure for view `view_contact`
--
DROP TABLE IF EXISTS `view_contact`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_contact` AS select `cus_customer`.`CustomerID` AS `cusID`,`cus_customer`.`PrefixID` AS `prefixID`,`cus_customer`.`CustomerStatus` AS `cusStatus`,`cus_customer`.`CustomerName` AS `cusName`,`cus_customer`.`BusinessType` AS `cusType`,`cus_person`.`PersonID` AS `PersonID`,`cus_person`.`Fname` AS `Fname`,`cus_person`.`Lname` AS `Lname`,`cus_person`.`Phone` AS `Phone`,`cus_person`.`Email` AS `Email`,`cus_person`.`Password` AS `Password`,`cus_person`.`CatEmpID` AS `CatEmpID`,`cus_person`.`IDCard` AS `IDCard`,`cus_person`.`IDCCard` AS `IDCCard`,`cus_person`.`IDCCardType` AS `IDCCardType`,`cus_person`.`TypePerson` AS `TypePerson`,`cus_person`.`Position` AS `Position`,`cus_person`.`PersonStatus` AS `PersonStatus` from (`cus_person` join `cus_customer` on((`cus_person`.`CustomerID` = `cus_customer`.`CustomerID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_entry_idc`
--
DROP TABLE IF EXISTS `view_entry_idc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_entry_idc` AS select `cus_customer`.`CustomerID` AS `CustomerID`,`cus_customer`.`CustomerName` AS `CustomerName`,`cus_customer`.`BusinessType` AS `BusinessType`,`cus_person`.`PersonID` AS `PersonID`,`cus_person`.`Fname` AS `Fname`,`cus_person`.`Lname` AS `Lname`,`entry_idc`.`EntryIDCID` AS `EntryIDCID`,`entry_idc`.`EmpID` AS `EmpID`,`cus_person`.`Phone` AS `Phone`,`cus_person`.`Email` AS `Email`,`entry_idc`.`VisitorCardID` AS `VisitorCardID`,`entry_idc`.`IDCard` AS `IDCard`,`entry_idc`.`IDCCard` AS `IDCCard`,`entry_idc`.`IDCCardType` AS `IDCCardType`,`entry_idc`.`TimeIn` AS `TimeIn`,`entry_idc`.`TimeOut` AS `TimeOut`,`entry_idc`.`Purpose` AS `Purpose`,`entry_idc`.`InternetAccount` AS `InternetAccount`,`entry_idc`.`DateTimeCreate` AS `DateTimeCreate`,`entry_idc`.`DateTimeUpdate` AS `DateTimeUpdate`,`entry_idc`.`CreateBy` AS `CreateBy`,`entry_idc`.`UpdateBy` AS `UpdateBy` from ((`entry_idc` join `cus_person` on((`entry_idc`.`PersonID` = `cus_person`.`PersonID`))) join `cus_customer` on((`cus_customer`.`CustomerID` = `cus_person`.`CustomerID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_ip`
--
DROP TABLE IF EXISTS `view_ip`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_ip` AS select `resource_ip`.`IP` AS `IP`,`resource_ip`.`NetworkIP` AS `NetworkIP`,`resource_ip`.`Subnet` AS `Subnet`,`resource_ip`.`VlanID` AS `VlanID`,`resource_ip`.`EnableResourceIP` AS `EnableResourceIP`,`resource_ip`.`OrderDetailID` AS `OrderDetailID`,`resource_ip`.`DateTimeCreate` AS `DateTimeCreate`,`resource_ip`.`DateTimeUpdate` AS `DateTimeUpdate`,`resource_ip`.`CreateBy` AS `CreateBy`,`resource_ip`.`UpdateBy` AS `UpdateBy`,`cus_order_detail`.`OrderID` AS `OrderID`,`cus_order_detail`.`PackageID` AS `PackageID`,`cus_order`.`CustomerID` AS `CustomerID`,`cus_order`.`Location` AS `Location`,`cus_customer`.`CustomerName` AS `CustomerName`,`cus_customer`.`BusinessType` AS `BusinessType` from (((`resource_ip` left join `cus_order_detail` on((`resource_ip`.`OrderDetailID` = `cus_order_detail`.`OrderDetailID`))) left join `cus_order` on((`cus_order`.`OrderID` = `cus_order_detail`.`OrderID`))) left join `cus_customer` on((`cus_customer`.`CustomerID` = `cus_order`.`CustomerID`))) where 1;

-- --------------------------------------------------------

--
-- Structure for view `view_order_detail`
--
DROP TABLE IF EXISTS `view_order_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_order_detail` AS select `cus_order_detail`.`OrderDetailID` AS `OrderDetailID`,`cus_order_detail`.`OrderID` AS `OrderID`,`cus_order_detail`.`OrderDetailStatus` AS `OrderDetailStatus`,`cus_order_detail`.`DateTimeUpdate` AS `DateTime`,`cus_package`.`PackageID` AS `PackageID`,`cus_package`.`PackageName` AS `PackageName`,`cus_package`.`PackageType` AS `PackageType`,`cus_package`.`PackageCategory` AS `PackageCategory`,`cus_package`.`IPAmount` AS `IPAmount`,`cus_package`.`PortAmount` AS `PortAmount`,`cus_package`.`RackAmount` AS `RackAmount`,`cus_package`.`ServiceAmount` AS `ServiceAmount` from (`cus_order_detail` join `cus_package` on((`cus_order_detail`.`PackageID` = `cus_package`.`PackageID`))) order by `cus_order_detail`.`OrderDetailStatus`;

-- --------------------------------------------------------

--
-- Structure for view `view_rack`
--
DROP TABLE IF EXISTS `view_rack`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_rack` AS select `resource_rack`.`ResourceRackID` AS `ResourceRackID`,`resource_rack`.`Zone` AS `Zone`,`resource_rack`.`Position` AS `Position`,`resource_rack`.`SubPosition` AS `SubPosition`,`resource_rack`.`RackType` AS `RackType`,`resource_rack`.`RackSize` AS `RackSize`,`resource_rack`.`EnableResourceRack` AS `EnableResourceRack`,`resource_rack`.`OrderDetailID` AS `OrderDetailID`,`resource_rack`.`DateTimeCreate` AS `DateTimeCreate`,`resource_rack`.`DateTimeUpdate` AS `DateTimeUpdate`,`resource_rack`.`CreateBy` AS `CreateBy`,`resource_rack`.`UpdateBy` AS `UpdateBy`,`cus_order_detail`.`OrderID` AS `OrderID`,`cus_order_detail`.`PackageID` AS `PackageID`,`cus_order`.`CustomerID` AS `CustomerID`,`cus_customer`.`CustomerName` AS `CustomerName` from (((`resource_rack` left join `cus_order_detail` on((`cus_order_detail`.`OrderDetailID` = `resource_rack`.`OrderDetailID`))) left join `cus_order` on((`cus_order`.`OrderID` = `cus_order_detail`.`OrderID`))) left join `cus_customer` on((`cus_customer`.`CustomerID` = `cus_order`.`CustomerID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_resource_reserve`
--
DROP TABLE IF EXISTS `view_resource_reserve`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_resource_reserve` AS select `resource_ip`.`OrderDetailID` AS `ip`,`resource_switch_port`.`OrderDetailID` AS `port`,`resource_rack`.`OrderDetailID` AS `rack`,`resource_service`.`OrderDetailID` AS `service` from (((`resource_ip` left join `resource_rack` on((`resource_ip`.`OrderDetailID` = `resource_rack`.`OrderDetailID`))) left join `resource_switch_port` on((`resource_rack`.`OrderDetailID` = `resource_switch_port`.`OrderDetailID`))) left join `resource_service` on((`resource_switch_port`.`OrderDetailID` = `resource_service`.`OrderDetailID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_summery_port`
--
DROP TABLE IF EXISTS `view_summery_port`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_summery_port` AS select `resource_switch`.`ResourceSwitchID` AS `ResourceSwitchID`,`resource_switch`.`SwitchName` AS `SwitchName`,`resource_switch`.`SwitchType` AS `SwitchType`,sum((case when (`resource_switch_port`.`OrderDetailID` is not null) then 1 else 0 end)) AS `use`,sum((case when (`resource_switch_port`.`Uplink` like 1) then 1 else 0 end)) AS `uplink`,`resource_switch`.`TotalPort` AS `TotalPort` from (`resource_switch` join `resource_switch_port` on((`resource_switch_port`.`ResourceSwitchID` = `resource_switch`.`ResourceSwitchID`))) group by `resource_switch`.`ResourceSwitchID`;

-- --------------------------------------------------------

--
-- Structure for view `view_switch_port`
--
DROP TABLE IF EXISTS `view_switch_port`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_switch_port` AS select `resource_switch_port`.`ResourceSwitchPortID` AS `ResourceSwitchPortID`,`resource_switch_port`.`ResourceSwitchID` AS `ResourceSwitchID`,`resource_switch_port`.`PortNumber` AS `PortNumber`,`resource_switch_port`.`PortType` AS `PortType`,`resource_switch_port`.`Uplink` AS `Uplink`,`resource_switch_port`.`EnableResourcePort` AS `EnableResourcePort`,`resource_switch_port`.`OrderDetailID` AS `OrderDetailID`,`resource_switch_port`.`DateTimeCreate` AS `DateTimeCreate`,`resource_switch_port`.`DateTimeUpdate` AS `DateTimeUpdate`,`resource_switch_port`.`CreateBy` AS `CreateBy`,`resource_switch_port`.`UpdateBy` AS `UpdateBy`,`resource_switch`.`SwitchName` AS `SwitchName`,`resource_switch`.`SwitchIP` AS `SwitchIP`,`resource_switch`.`TotalPort` AS `TotalPort`,`resource_switch`.`SnmpCommuPublic` AS `SnmpCommuPublic`,`resource_switch`.`SwitchType` AS `SwitchType`,`resource_switch`.`EnableResourceSW` AS `EnableResourceSW`,`cus_order_detail`.`OrderID` AS `OrderID`,`cus_customer`.`CustomerID` AS `CustomerID`,`cus_customer`.`CustomerName` AS `CustomerName` from ((((`resource_switch` left join `resource_switch_port` on((`resource_switch`.`ResourceSwitchID` = `resource_switch_port`.`ResourceSwitchID`))) left join `cus_order_detail` on((`cus_order_detail`.`OrderDetailID` = `resource_switch_port`.`OrderDetailID`))) left join `cus_order` on((`cus_order`.`OrderID` = `cus_order_detail`.`OrderID`))) left join `cus_customer` on((`cus_customer`.`CustomerID` = `cus_order`.`CustomerID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_switch_port_balance`
--
DROP TABLE IF EXISTS `view_switch_port_balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_switch_port_balance` AS select `resource_switch_port`.`ResourceSwitchID` AS `ResourceSwitchID`,`resource_switch`.`SwitchName` AS `SwitchName`,sum((case when isnull(`resource_switch_port`.`OrderDetailID`) then 1 else 0 end)) AS `balance` from (`resource_switch_port` join `resource_switch` on((`resource_switch_port`.`ResourceSwitchID` = `resource_switch`.`ResourceSwitchID`))) where (`resource_switch_port`.`Uplink` = 0) group by `resource_switch_port`.`ResourceSwitchID` order by `resource_switch_port`.`ResourceSwitchID`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cus_customer`
--
ALTER TABLE `cus_customer`
 ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `cus_item`
--
ALTER TABLE `cus_item`
 ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `cus_order`
--
ALTER TABLE `cus_order`
 ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `cus_order_bundle_network`
--
ALTER TABLE `cus_order_bundle_network`
 ADD PRIMARY KEY (`orderBundleNetworkID`);

--
-- Indexes for table `cus_order_detail`
--
ALTER TABLE `cus_order_detail`
 ADD PRIMARY KEY (`OrderDetailID`);

--
-- Indexes for table `cus_package`
--
ALTER TABLE `cus_package`
 ADD PRIMARY KEY (`PackageID`);

--
-- Indexes for table `cus_person`
--
ALTER TABLE `cus_person`
 ADD PRIMARY KEY (`PersonID`), ADD UNIQUE KEY `Email_UNIQUE` (`Email`);

--
-- Indexes for table `entry_idc`
--
ALTER TABLE `entry_idc`
 ADD PRIMARY KEY (`EntryIDCID`);

--
-- Indexes for table `entry_idc_zone`
--
ALTER TABLE `entry_idc_zone`
 ADD PRIMARY KEY (`EntryIDCZoneID`);

--
-- Indexes for table `resource_ip`
--
ALTER TABLE `resource_ip`
 ADD PRIMARY KEY (`ResourceIpID`);

--
-- Indexes for table `resource_rack`
--
ALTER TABLE `resource_rack`
 ADD PRIMARY KEY (`ResourceRackID`);

--
-- Indexes for table `resource_service`
--
ALTER TABLE `resource_service`
 ADD PRIMARY KEY (`ResourceServiceID`);

--
-- Indexes for table `resource_switch`
--
ALTER TABLE `resource_switch`
 ADD PRIMARY KEY (`ResourceSwitchID`);

--
-- Indexes for table `resource_switch_port`
--
ALTER TABLE `resource_switch_port`
 ADD PRIMARY KEY (`ResourceSwitchPortID`);

--
-- Indexes for table `resource_switch_vlan`
--
ALTER TABLE `resource_switch_vlan`
 ADD PRIMARY KEY (`VlanID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
 ADD PRIMARY KEY (`TicketID`);

--
-- Indexes for table `ticket_event`
--
ALTER TABLE `ticket_event`
 ADD PRIMARY KEY (`TicketEventID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cus_customer`
--
ALTER TABLE `cus_customer`
MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `cus_item`
--
ALTER TABLE `cus_item`
MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `cus_order`
--
ALTER TABLE `cus_order`
MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cus_order_bundle_network`
--
ALTER TABLE `cus_order_bundle_network`
MODIFY `orderBundleNetworkID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cus_order_detail`
--
ALTER TABLE `cus_order_detail`
MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cus_package`
--
ALTER TABLE `cus_package`
MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cus_person`
--
ALTER TABLE `cus_person`
MODIFY `PersonID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `entry_idc`
--
ALTER TABLE `entry_idc`
MODIFY `EntryIDCID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `entry_idc_zone`
--
ALTER TABLE `entry_idc_zone`
MODIFY `EntryIDCZoneID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `resource_ip`
--
ALTER TABLE `resource_ip`
MODIFY `ResourceIpID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=255;
--
-- AUTO_INCREMENT for table `resource_rack`
--
ALTER TABLE `resource_rack`
MODIFY `ResourceRackID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `resource_service`
--
ALTER TABLE `resource_service`
MODIFY `ResourceServiceID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_switch`
--
ALTER TABLE `resource_switch`
MODIFY `ResourceSwitchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `resource_switch_port`
--
ALTER TABLE `resource_switch_port`
MODIFY `ResourceSwitchPortID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `resource_switch_vlan`
--
ALTER TABLE `resource_switch_vlan`
MODIFY `VlanID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;