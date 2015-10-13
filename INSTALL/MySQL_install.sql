-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2015 at 11:02 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cat_dcms`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cus_order_bundle_network`
--

DROP TABLE IF EXISTS `cus_order_bundle_network`;
CREATE TABLE IF NOT EXISTS `cus_order_bundle_network` (
`orderBundleNetworkID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `BundleNetwork` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

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
  `IDCard` int(11) DEFAULT NULL,
  `TypePerson` varchar(45) DEFAULT NULL COMMENT 'staff\ncontact\nsubcontact\nvisitor',
  `Position` varchar(45) DEFAULT NULL,
  `PersonStatus` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_idc`
--

DROP TABLE IF EXISTS `entry_idc`;
CREATE TABLE IF NOT EXISTS `entry_idc` (
  `EntryIDCID` int(11) NOT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `VisitorCardID` varchar(45) DEFAULT NULL,
  `IDCCardID` varchar(45) DEFAULT NULL,
  `IDCCardType` varchar(45) DEFAULT NULL,
  `TimeIn` datetime DEFAULT NULL,
  `TimeOut` datetime DEFAULT NULL,
  `Purpose` varchar(150) DEFAULT NULL,
  `InternetAccount` varchar(45) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_idc_zone`
--

DROP TABLE IF EXISTS `entry_idc_zone`;
CREATE TABLE IF NOT EXISTS `entry_idc_zone` (
`EntryIDCZoneID` int(11) NOT NULL,
  `EntryIDCID` int(11) DEFAULT NULL,
  `Zone` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=513 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_rack`
--

DROP TABLE IF EXISTS `resource_rack`;
CREATE TABLE IF NOT EXISTS `resource_rack` (
`ResourceRackID` int(11) NOT NULL,
  `Zone` varchar(45) DEFAULT NULL,
  `Position` varchar(45) DEFAULT NULL,
  `SubPosition` varchar(45) DEFAULT NULL,
  `RackType` varchar(45) DEFAULT NULL COMMENT 'ex. Full Rack, 1/2 Rack, 1/4 Rack',
  `RackSize` int(11) DEFAULT NULL,
  `EnableResourceRack` int(1) DEFAULT '1',
  `OrderDetailID` int(11) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch_vlan`
--

DROP TABLE IF EXISTS `resource_switch_vlan`;
CREATE TABLE IF NOT EXISTS `resource_switch_vlan` (
`VlanID` int(11) NOT NULL,
  `VlanNumber` int(11) NOT NULL,
  `SwitchID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
-- Structure for view `view_ip` exported as a table
--
DROP TABLE IF EXISTS `view_ip`;
CREATE TABLE IF NOT EXISTS `view_ip`(
    `IP` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `NetworkIP` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `Subnet` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `VlanID` int(11) DEFAULT NULL,
    `EnableResourceIP` int(1) DEFAULT '1',
    `OrderDetailID` int(11) DEFAULT NULL,
    `DateTimeCreate` timestamp DEFAULT NULL,
    `DateTimeUpdate` timestamp DEFAULT NULL,
    `CreateBy` int(11) DEFAULT NULL,
    `UpdateBy` int(11) DEFAULT NULL,
    `OrderID` int(11) DEFAULT NULL,
    `PackageID` int(11) DEFAULT NULL,
    `CustomerID` int(11) DEFAULT NULL,
    `Location` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `CustomerName` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `BusinessType` varchar(45) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'กสท.
นิติบุคคล
บุคคล'
);

-- --------------------------------------------------------

--
-- Structure for view `view_order_detail` exported as a table
--
DROP TABLE IF EXISTS `view_order_detail`;
CREATE TABLE IF NOT EXISTS `view_order_detail`(
    `OrderDetailID` int(11) NOT NULL DEFAULT '0',
    `OrderID` int(11) DEFAULT NULL,
    `OrderDetailStatus` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `DateTime` timestamp DEFAULT NULL,
    `PackageID` int(11) NOT NULL DEFAULT '0',
    `PackageName` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `PackageType` varchar(45) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'หลัก
รอง',
    `PackageCategory` varchar(45) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Full
1/2
1/4
Share'
);

-- --------------------------------------------------------

--
-- Structure for view `view_switch_port` exported as a table
--
DROP TABLE IF EXISTS `view_switch_port`;
CREATE TABLE IF NOT EXISTS `view_switch_port`(
    `ResourceSwitchPortID` int(11) DEFAULT '0',
    `ResourceSwitchID` int(11) DEFAULT NULL,
    `PortNumber` int(11) DEFAULT NULL,
    `PortType` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `Uplink` tinyint(4) DEFAULT NULL,
    `EnableResourcePort` int(1) DEFAULT '1',
    `OrderDetailID` int(11) DEFAULT NULL,
    `DateTimeCreate` timestamp DEFAULT NULL,
    `DateTimeUpdate` timestamp DEFAULT NULL,
    `CreateBy` int(11) DEFAULT NULL,
    `UpdateBy` int(11) DEFAULT NULL,
    `SwitchName` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `SwitchIP` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `TotalPort` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `SnmpCommuPublic` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `SwitchType` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
    `EnableResourceSW` int(1) DEFAULT '1',
    `OrderID` int(11) DEFAULT NULL,
    `CustomerID` int(11) DEFAULT '0',
    `CustomerName` varchar(45) COLLATE utf8_general_ci DEFAULT NULL
);

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
MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cus_item`
--
ALTER TABLE `cus_item`
MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cus_order`
--
ALTER TABLE `cus_order`
MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `cus_order_bundle_network`
--
ALTER TABLE `cus_order_bundle_network`
MODIFY `orderBundleNetworkID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cus_order_detail`
--
ALTER TABLE `cus_order_detail`
MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `cus_package`
--
ALTER TABLE `cus_package`
MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `cus_person`
--
ALTER TABLE `cus_person`
MODIFY `PersonID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `entry_idc_zone`
--
ALTER TABLE `entry_idc_zone`
MODIFY `EntryIDCZoneID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_ip`
--
ALTER TABLE `resource_ip`
MODIFY `ResourceIpID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=513;
--
-- AUTO_INCREMENT for table `resource_rack`
--
ALTER TABLE `resource_rack`
MODIFY `ResourceRackID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_service`
--
ALTER TABLE `resource_service`
MODIFY `ResourceServiceID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_switch`
--
ALTER TABLE `resource_switch`
MODIFY `ResourceSwitchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `resource_switch_port`
--
ALTER TABLE `resource_switch_port`
MODIFY `ResourceSwitchPortID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `resource_switch_vlan`
--
ALTER TABLE `resource_switch_vlan`
MODIFY `VlanID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;