-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2015 at 05:31 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
`AccountID` int(11) NOT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `LastLogin` varchar(45) DEFAULT NULL,
  `LoginPass` int(5) DEFAULT NULL,
  `LoginFail` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`CustomerID` int(11) NOT NULL,
  `CustomerStatus` enum('Active','Suppened','Delete') DEFAULT NULL COMMENT 'Active\nSuppened\nDelete',
  `CustomerName` varchar(45) DEFAULT NULL,
  `BusinessTypeID` int(11) DEFAULT NULL COMMENT 'กสท.\nนิติบุคคล\nบุคคล',
  `Email` varchar(45) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Fax` varchar(45) DEFAULT NULL,
  `Address` varchar(45) DEFAULT NULL,
  `Township` varchar(45) DEFAULT NULL,
  `City` varchar(45) DEFAULT NULL,
  `Province` varchar(45) DEFAULT NULL,
  `Zipcode` varchar(45) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `CreateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_businesstype`
--

CREATE TABLE IF NOT EXISTS `customer_businesstype` (
`BusinessTypeID` int(11) NOT NULL,
  `BusinessType` varchar(45) DEFAULT NULL,
  `Status` enum('Active','Deactive') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_businesstype`
--

INSERT INTO `customer_businesstype` (`BusinessTypeID`, `BusinessType`, `Status`) VALUES
(1, 'กสท', 'Active'),
(2, 'นิติบุคคล', 'Active'),
(3, 'บุคคล', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer_package`
--

CREATE TABLE IF NOT EXISTS `customer_package` (
`PackageID` int(11) NOT NULL,
  `PackageName` varchar(45) DEFAULT NULL,
  `PackageDetail` text,
  `PackageType` enum('Main','Add-on') DEFAULT NULL COMMENT 'main,add-on',
  `PackageCategoryID` int(11) DEFAULT NULL,
  `PackageStatus` enum('Active','Deative') DEFAULT 'Active' COMMENT '1=active,0=deactive',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_package_category`
--

CREATE TABLE IF NOT EXISTS `customer_package_category` (
`PackageCategoryID` int(11) NOT NULL,
  `PackageCategory` varchar(45) DEFAULT NULL,
  `Status` enum('Active','Deative') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_package_category`
--

INSERT INTO `customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES
(1, 'Shared Rack', 'Active'),
(2, '1/4 Rack', 'Active'),
(3, '1/2 Rack', 'Active'),
(4, 'Full Rack', 'Active'),
(5, 'IP Address', 'Active'),
(6, 'Port 10/100', 'Active'),
(7, 'Port 10/100/1000', 'Active'),
(8, 'Firewall', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer_person`
--

CREATE TABLE IF NOT EXISTS `customer_person` (
`PersonID` int(11) NOT NULL,
  `Fname` varchar(45) DEFAULT NULL,
  `Lname` varchar(45) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `IDCard` varchar(45) DEFAULT NULL COMMENT 'Thai ID Card',
  `TypePerson` enum('Staff','Contact','Visitor') DEFAULT 'Visitor' COMMENT '1=staff,2=contact,3=visitor',
  `PersonStatus` enum('Active','Deactive') DEFAULT 'Active' COMMENT '0=deactive,1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_person_contact`
--

CREATE TABLE IF NOT EXISTS `customer_person_contact` (
`PersonContactID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `IDCCard` varchar(15) DEFAULT NULL,
  `IDCCardType` varchar(10) DEFAULT NULL,
  `ContactType` enum('Main','Secondary') DEFAULT NULL COMMENT '1=main,2=secondary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_person_staff`
--

CREATE TABLE IF NOT EXISTS `customer_person_staff` (
`StaffID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `PersonID` int(11) NOT NULL,
  `StaffPositionID` int(11) DEFAULT NULL,
  `DivisionID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_person_staff_division`
--

CREATE TABLE IF NOT EXISTS `customer_person_staff_division` (
`DivisionID` int(11) NOT NULL,
  `Division` varchar(45) DEFAULT NULL,
  `Organization` enum('CAT','Vender') DEFAULT NULL,
  `Address` text,
  `Status` enum('Active','Deactive') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_person_staff_division`
--

INSERT INTO `customer_person_staff_division` (`DivisionID`, `Division`, `Organization`, `Address`, `Status`) VALUES
(1, 'IDC NON', 'CAT', 'Nonthaburi', NULL),
(2, 'SPM Coperation', 'Vender', 'Suphanburi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_person_staff_position`
--

CREATE TABLE IF NOT EXISTS `customer_person_staff_position` (
`StaffPositionID` int(11) NOT NULL,
  `Position` varchar(45) DEFAULT NULL,
  `Status` enum('Active','Deactive') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_person_staff_position`
--

INSERT INTO `customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES
(1, 'frontdesk', NULL),
(2, 'helpdesk', NULL),
(3, 'engineering', NULL),
(4, 'manager', NULL),
(5, 'other', NULL),
(6, 'vender', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_service`
--

CREATE TABLE IF NOT EXISTS `customer_service` (
`ServiceID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL COMMENT 'แยก Table',
  `DateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_service_detail`
--

CREATE TABLE IF NOT EXISTS `customer_service_detail` (
`ServiceDetailID` int(11) NOT NULL,
  `ServiceID` int(11) DEFAULT NULL,
  `PackageID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_service_detail_action`
--

CREATE TABLE IF NOT EXISTS `customer_service_detail_action` (
`ServiceDetailActionID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `Status` enum('Active','Suppened','Deactive') DEFAULT 'Active',
  `Cause` varchar(100) DEFAULT NULL,
  `DateTime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
`EntryID` int(11) NOT NULL,
  `PersonID` int(11) NOT NULL,
  `VisitorCardID` varchar(45) DEFAULT NULL,
  `IDCard` varchar(45) DEFAULT NULL,
  `IDCCard` varchar(45) DEFAULT NULL,
  `IDCCardType` varchar(45) DEFAULT NULL,
  `EmpID` varchar(45) DEFAULT NULL,
  `TimeIn` datetime DEFAULT NULL,
  `TimeOut` datetime DEFAULT NULL,
  `Purpose` varchar(255) DEFAULT NULL,
  `InternetAccount` varchar(45) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL,
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_equipment`
--

CREATE TABLE IF NOT EXISTS `entry_equipment` (
`EquipmentID` int(11) NOT NULL,
  `Equipment` varchar(45) DEFAULT NULL,
  `Brand` varchar(45) DEFAULT NULL,
  `Model` varchar(45) DEFAULT NULL,
  `SerialNo` varchar(45) DEFAULT NULL,
  `RackID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_equipment_detail`
--

CREATE TABLE IF NOT EXISTS `entry_equipment_detail` (
`EquipmentDetailID` int(11) NOT NULL,
  `EquipmentID` int(11) DEFAULT NULL,
  `EntryID` int(11) DEFAULT NULL,
  `EquipmentAction` enum('in','out') DEFAULT NULL COMMENT 'in,out',
  `DateTime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_zone`
--

CREATE TABLE IF NOT EXISTS `entry_zone` (
`EntryZoneID` int(11) NOT NULL,
  `EntryZone` varchar(45) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL,
  `Status` enum('Active','Deactive') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entry_zone`
--

INSERT INTO `entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES
(1, 'Customer Room', 1, 'Active'),
(2, 'IDC 1', 1, 'Active'),
(3, 'IDC 2', 1, 'Active'),
(4, 'Core Network', 1, 'Active'),
(5, 'IDC NOC', 1, 'Active'),
(6, 'Manager', 1, 'Active'),
(7, 'Power', 1, 'Active'),
(8, 'Meeting', 1, 'Active'),
(9, 'VIP 1', 1, 'Active'),
(10, 'VIP 2', 1, 'Active'),
(11, 'VIP 3', 1, 'Active'),
(12, 'VIP 4', 1, 'Active'),
(13, 'VIP 5', 1, 'Active'),
(14, 'VIP 6', 1, 'Active'),
(15, 'VIP 7', 1, 'Active'),
(16, 'Office', 1, 'Active'),
(17, 'Temp Office', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `entry_zone_detail`
--

CREATE TABLE IF NOT EXISTS `entry_zone_detail` (
`ZoneDetailID` int(11) NOT NULL,
  `EntryID` int(11) DEFAULT NULL,
  `ZoneID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
`LocationID` int(11) NOT NULL,
  `Location` varchar(45) DEFAULT NULL,
  `Address` text,
  `Status` enum('Active','Deative') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocationID`, `Location`, `Address`, `Status`) VALUES
(1, 'CAT-IDC Nonthaburi', 'Nonthaburi', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `resource_amount`
--

CREATE TABLE IF NOT EXISTS `resource_amount` (
`ResourceAmountID` int(11) NOT NULL,
  `PackageID` int(11) DEFAULT NULL,
  `IPAmount` int(5) DEFAULT '0',
  `PortAmount` int(5) DEFAULT '0',
  `RackAmount` int(5) DEFAULT '0',
  `ServiceAmount` int(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_ip`
--

CREATE TABLE IF NOT EXISTS `resource_ip` (
`ResourceIPID` int(11) NOT NULL,
  `IP` varchar(45) DEFAULT NULL,
  `NetworkIP` varchar(45) DEFAULT NULL,
  `Subnet` varchar(45) DEFAULT NULL,
  `VlanID` int(11) DEFAULT NULL,
  `EnableResourceIP` int(1) DEFAULT '1',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_ip_used`
--

CREATE TABLE IF NOT EXISTS `resource_ip_used` (
`ResourceIPUsedID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `ResourceIPID` int(11) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `CreateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_network_link`
--

CREATE TABLE IF NOT EXISTS `resource_network_link` (
`ResourceNetworkLinkID` int(11) NOT NULL,
  `NetworkLink` varchar(45) DEFAULT NULL,
  `CoperateName` varchar(45) DEFAULT NULL,
  `ContactName` varchar(45) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `NetworkLinkStatus` enum('Active','Deactive') DEFAULT NULL COMMENT '1=active,0=deactive',
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_network_link_used`
--

CREATE TABLE IF NOT EXISTS `resource_network_link_used` (
`ResourceNetworkLinkUsedID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `ResourceNetworkLinkID` int(11) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `CreateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_rack`
--

CREATE TABLE IF NOT EXISTS `resource_rack` (
`ResourceRackID` int(11) NOT NULL,
  `Col` varchar(45) DEFAULT NULL,
  `Row` int(5) DEFAULT NULL,
  `PositionRack` int(3) DEFAULT NULL,
  `RackType` varchar(45) DEFAULT NULL COMMENT 'ex. Full Rack, 1/2 Rack, 1/4 Rack',
  `RackSize` int(3) DEFAULT NULL,
  `EnableResourceRack` int(1) DEFAULT '1',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL,
  `RackKey` text COMMENT 'เก็บไว้คิด',
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_rack_used`
--

CREATE TABLE IF NOT EXISTS `resource_rack_used` (
`ResourceRackUsedID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `ResourceRackID` int(11) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `CreateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_service`
--

CREATE TABLE IF NOT EXISTS `resource_service` (
`ResourceServiceID` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Detail` varchar(45) DEFAULT NULL,
  `Tag` text,
  `PersonID` int(11) DEFAULT NULL,
  `EnableResourceService` int(1) DEFAULT '1',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_service_used`
--

CREATE TABLE IF NOT EXISTS `resource_service_used` (
`ResourceServiceUsedID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `ResourceServiceID` int(11) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `CreateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch`
--

CREATE TABLE IF NOT EXISTS `resource_switch` (
`ResourceSwitchID` int(11) NOT NULL,
  `SwitchName` varchar(45) DEFAULT NULL,
  `SwitchIP` varchar(45) DEFAULT NULL,
  `TotalPort` varchar(45) DEFAULT NULL,
  `SnmpCommuPublic` varchar(45) DEFAULT NULL,
  `SwitchTypeID` int(11) DEFAULT NULL,
  `Brand` varchar(45) DEFAULT NULL,
  `Model` varchar(45) DEFAULT NULL,
  `SerialNo` varchar(45) DEFAULT NULL,
  `RackID` int(11) DEFAULT NULL,
  `EnableResourceSW` int(1) DEFAULT '1',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch_port`
--

CREATE TABLE IF NOT EXISTS `resource_switch_port` (
`ResourceSwitchPortID` int(11) NOT NULL,
  `ResourceSwitchID` int(11) DEFAULT NULL,
  `PortNumber` int(11) DEFAULT NULL,
  `PortType` varchar(45) DEFAULT NULL,
  `PortVlan` int(5) DEFAULT NULL,
  `Uplink` tinyint(4) DEFAULT NULL,
  `EnableResourcePort` int(1) DEFAULT '1',
  `DateTimeCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateTimeUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resource_switch_port_used`
--

CREATE TABLE IF NOT EXISTS `resource_switch_port_used` (
`ResourceSwitchPortUsedID` int(11) NOT NULL,
  `ServiceDetailID` int(11) DEFAULT NULL,
  `ResourcePortID` int(11) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `CreateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_contact`
--
CREATE TABLE IF NOT EXISTS `view_contact` (
`PersonID` int(11)
,`Fname` varchar(45)
,`Lname` varchar(45)
,`Phone` varchar(45)
,`Email` varchar(45)
,`IDCard` varchar(45)
,`TypePerson` enum('Staff','Contact','Visitor')
,`CustomerID` int(11)
,`CustomerName` varchar(45)
,`IDCCard` varchar(15)
,`IDCCardType` varchar(10)
,`ContactType` enum('Main','Secondary')
,`PersonStatus` enum('Active','Deactive')
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer`
--
CREATE TABLE IF NOT EXISTS `view_customer` (
`CustomerID` int(11)
,`CustomerStatus` enum('Active','Suppened','Delete')
,`CustomerName` varchar(45)
,`BusinessTypeID` int(11)
,`BusinessType` varchar(45)
,`Email` varchar(45)
,`Phone` varchar(45)
,`Fax` varchar(45)
,`Address` varchar(45)
,`Township` varchar(45)
,`City` varchar(45)
,`Province` varchar(45)
,`Zipcode` varchar(45)
,`Country` varchar(45)
,`CreateDateTime` timestamp
,`UpdateDateTime` timestamp
,`CreateBy` int(11)
,`UpdateBy` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer_contact`
--
CREATE TABLE IF NOT EXISTS `view_customer_contact` (
`CustomerID` int(11)
,`CustomerName` varchar(45)
,`BusinessTypeID` int(11)
,`BusinessType` varchar(45)
,`cusEmail` varchar(45)
,`cusPhone` varchar(45)
,`Fax` varchar(45)
,`Address` varchar(45)
,`Township` varchar(45)
,`City` varchar(45)
,`Province` varchar(45)
,`Zipcode` varchar(45)
,`Country` varchar(45)
,`PersonID` int(11)
,`Fname` varchar(45)
,`Lname` varchar(45)
,`conPhone` varchar(45)
,`conEmail` varchar(45)
,`IDCard` varchar(45)
,`TypePerson` enum('Staff','Contact','Visitor')
,`IDCCard` varchar(15)
,`IDCCardType` varchar(10)
,`ContactType` enum('Main','Secondary')
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_entry`
--
CREATE TABLE IF NOT EXISTS `view_entry` (
`EntryID` int(11)
,`PersonID` int(11)
,`VisitorCardID` varchar(45)
,`IDCard` varchar(45)
,`IDCCard` varchar(45)
,`IDCCardType` varchar(45)
,`EmpID` varchar(45)
,`TimeIn` datetime
,`TimeOut` datetime
,`Purpose` varchar(255)
,`InternetAccount` varchar(45)
,`Fname` varchar(45)
,`Lname` varchar(45)
,`Phone` varchar(45)
,`Email` varchar(45)
,`TypePerson` enum('Staff','Contact','Visitor')
,`CustomerID` int(11)
,`CustomerName` varchar(45)
,`Organization` enum('CAT','Vender')
,`Division` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_package`
--
CREATE TABLE IF NOT EXISTS `view_package` (
`PackageID` int(11)
,`PackageName` varchar(45)
,`PackageDetail` text
,`PackageType` enum('Main','Add-on')
,`PackageCategoryID` int(11)
,`PackageCategory` varchar(45)
,`PackageStatus` enum('Active','Deative')
,`DateTimeCreate` timestamp
,`DateTimeUpdate` timestamp
,`LocationID` int(11)
,`Location` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_service`
--
CREATE TABLE IF NOT EXISTS `view_service` (
`ServiceID` int(11)
,`CustomerID` int(11)
,`DateTimeService` timestamp
,`CreateBy` int(11)
,`ServiceDetailID` int(11)
,`PackageID` int(11)
,`PackageName` varchar(45)
,`PackageType` enum('Main','Add-on')
,`PackageCategoryID` int(11)
,`PackageCategory` varchar(45)
,`Status` enum('Active','Suppened','Deactive')
,`Cause` varchar(100)
,`LocationID` int(11)
,`Location` varchar(45)
,`DateTimeAction` datetime
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_staff`
--
CREATE TABLE IF NOT EXISTS `view_staff` (
`PersonID` int(11)
,`Fname` varchar(45)
,`Lname` varchar(45)
,`Phone` varchar(45)
,`Email` varchar(45)
,`IDCard` varchar(45)
,`EmployeeID` int(11)
,`StaffPositionID` int(11)
,`Position` varchar(45)
,`DivisionID` int(11)
,`Division` varchar(45)
,`Organization` enum('CAT','Vender')
,`Address` text
,`TypePerson` enum('Staff','Contact','Visitor')
,`PersonStatus` enum('Active','Deactive')
);
-- --------------------------------------------------------

--
-- Structure for view `view_contact`
--
DROP TABLE IF EXISTS `view_contact`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_contact` AS select `customer_person`.`PersonID` AS `PersonID`,`customer_person`.`Fname` AS `Fname`,`customer_person`.`Lname` AS `Lname`,`customer_person`.`Phone` AS `Phone`,`customer_person`.`Email` AS `Email`,`customer_person`.`IDCard` AS `IDCard`,`customer_person`.`TypePerson` AS `TypePerson`,`customer_person_contact`.`CustomerID` AS `CustomerID`,`customer`.`CustomerName` AS `CustomerName`,`customer_person_contact`.`IDCCard` AS `IDCCard`,`customer_person_contact`.`IDCCardType` AS `IDCCardType`,`customer_person_contact`.`ContactType` AS `ContactType`,`customer_person`.`PersonStatus` AS `PersonStatus` from ((`customer_person_contact` join `customer_person` on((`customer_person_contact`.`PersonID` = `customer_person`.`PersonID`))) join `customer` on((`customer_person_contact`.`CustomerID` = `customer`.`CustomerID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_customer`
--
DROP TABLE IF EXISTS `view_customer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_customer` AS select `customer`.`CustomerID` AS `CustomerID`,`customer`.`CustomerStatus` AS `CustomerStatus`,`customer`.`CustomerName` AS `CustomerName`,`customer_businesstype`.`BusinessTypeID` AS `BusinessTypeID`,`customer_businesstype`.`BusinessType` AS `BusinessType`,`customer`.`Email` AS `Email`,`customer`.`Phone` AS `Phone`,`customer`.`Fax` AS `Fax`,`customer`.`Address` AS `Address`,`customer`.`Township` AS `Township`,`customer`.`City` AS `City`,`customer`.`Province` AS `Province`,`customer`.`Zipcode` AS `Zipcode`,`customer`.`Country` AS `Country`,`customer`.`CreateDateTime` AS `CreateDateTime`,`customer`.`UpdateDateTime` AS `UpdateDateTime`,`customer`.`CreateBy` AS `CreateBy`,`customer`.`UpdateBy` AS `UpdateBy` from (`customer` join `customer_businesstype` on((`customer`.`BusinessTypeID` = `customer_businesstype`.`BusinessTypeID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_customer_contact`
--
DROP TABLE IF EXISTS `view_customer_contact`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_customer_contact` AS select `view_customer`.`CustomerID` AS `CustomerID`,`view_customer`.`CustomerName` AS `CustomerName`,`view_customer`.`BusinessTypeID` AS `BusinessTypeID`,`view_customer`.`BusinessType` AS `BusinessType`,`view_customer`.`Email` AS `cusEmail`,`view_customer`.`Phone` AS `cusPhone`,`view_customer`.`Fax` AS `Fax`,`view_customer`.`Address` AS `Address`,`view_customer`.`Township` AS `Township`,`view_customer`.`City` AS `City`,`view_customer`.`Province` AS `Province`,`view_customer`.`Zipcode` AS `Zipcode`,`view_customer`.`Country` AS `Country`,`view_contact`.`PersonID` AS `PersonID`,`view_contact`.`Fname` AS `Fname`,`view_contact`.`Lname` AS `Lname`,`view_contact`.`Phone` AS `conPhone`,`view_contact`.`Email` AS `conEmail`,`view_contact`.`IDCard` AS `IDCard`,`view_contact`.`TypePerson` AS `TypePerson`,`view_contact`.`IDCCard` AS `IDCCard`,`view_contact`.`IDCCardType` AS `IDCCardType`,`view_contact`.`ContactType` AS `ContactType` from (`view_contact` join `view_customer` on((`view_contact`.`CustomerID` = `view_customer`.`CustomerID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_entry`
--
DROP TABLE IF EXISTS `view_entry`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_entry` AS select `entry`.`EntryID` AS `EntryID`,`entry`.`PersonID` AS `PersonID`,`entry`.`VisitorCardID` AS `VisitorCardID`,`entry`.`IDCard` AS `IDCard`,`entry`.`IDCCard` AS `IDCCard`,`entry`.`IDCCardType` AS `IDCCardType`,`entry`.`EmpID` AS `EmpID`,`entry`.`TimeIn` AS `TimeIn`,`entry`.`TimeOut` AS `TimeOut`,`entry`.`Purpose` AS `Purpose`,`entry`.`InternetAccount` AS `InternetAccount`,`customer_person`.`Fname` AS `Fname`,`customer_person`.`Lname` AS `Lname`,`customer_person`.`Phone` AS `Phone`,`customer_person`.`Email` AS `Email`,`customer_person`.`TypePerson` AS `TypePerson`,`customer`.`CustomerID` AS `CustomerID`,`customer`.`CustomerName` AS `CustomerName`,`customer_person_staff_division`.`Organization` AS `Organization`,`customer_person_staff_division`.`Division` AS `Division` from (((((`entry` join `customer_person` on((`entry`.`PersonID` = `customer_person`.`PersonID`))) left join `customer_person_contact` on((`entry`.`PersonID` = `customer_person_contact`.`PersonID`))) left join `customer_person_staff` on((`entry`.`PersonID` = `customer_person_staff`.`PersonID`))) left join `customer` on((`customer_person_contact`.`CustomerID` = `customer`.`CustomerID`))) left join `customer_person_staff_division` on((`customer_person_staff_division`.`DivisionID` = `customer_person_staff`.`DivisionID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_package`
--
DROP TABLE IF EXISTS `view_package`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_package` AS select `customer_package`.`PackageID` AS `PackageID`,`customer_package`.`PackageName` AS `PackageName`,`customer_package`.`PackageDetail` AS `PackageDetail`,`customer_package`.`PackageType` AS `PackageType`,`customer_package`.`PackageCategoryID` AS `PackageCategoryID`,`customer_package_category`.`PackageCategory` AS `PackageCategory`,`customer_package`.`PackageStatus` AS `PackageStatus`,`customer_package`.`DateTimeCreate` AS `DateTimeCreate`,`customer_package`.`DateTimeUpdate` AS `DateTimeUpdate`,`customer_package`.`LocationID` AS `LocationID`,`location`.`Location` AS `Location` from ((`customer_package` join `customer_package_category` on((`customer_package`.`PackageCategoryID` = `customer_package_category`.`PackageCategoryID`))) join `location` on((`customer_package`.`LocationID` = `location`.`LocationID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_service`
--
DROP TABLE IF EXISTS `view_service`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_service` AS select `customer_service`.`ServiceID` AS `ServiceID`,`customer_service`.`CustomerID` AS `CustomerID`,`customer_service`.`DateTime` AS `DateTimeService`,`customer_service`.`CreateBy` AS `CreateBy`,`customer_service_detail`.`ServiceDetailID` AS `ServiceDetailID`,`customer_service_detail`.`PackageID` AS `PackageID`,`customer_package`.`PackageName` AS `PackageName`,`customer_package`.`PackageType` AS `PackageType`,`customer_package_category`.`PackageCategoryID` AS `PackageCategoryID`,`customer_package_category`.`PackageCategory` AS `PackageCategory`,`customer_service_detail_action`.`Status` AS `Status`,`customer_service_detail_action`.`Cause` AS `Cause`,`location`.`LocationID` AS `LocationID`,`location`.`Location` AS `Location`,`customer_service_detail_action`.`DateTime` AS `DateTimeAction` from (((((`customer_service` join `customer_service_detail` on((`customer_service`.`ServiceID` = `customer_service_detail`.`ServiceID`))) join `customer_package` on((`customer_package`.`PackageID` = `customer_service_detail`.`PackageID`))) join `customer_service_detail_action` on((`customer_service_detail`.`ServiceDetailID` = `customer_service_detail_action`.`ServiceDetailID`))) join `location` on((`location`.`LocationID` = `customer_service`.`LocationID`))) join `customer_package_category` on((`customer_package_category`.`PackageCategoryID` = `customer_package`.`PackageCategoryID`)));

-- --------------------------------------------------------

--
-- Structure for view `view_staff`
--
DROP TABLE IF EXISTS `view_staff`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_staff` AS select `customer_person`.`PersonID` AS `PersonID`,`customer_person`.`Fname` AS `Fname`,`customer_person`.`Lname` AS `Lname`,`customer_person`.`Phone` AS `Phone`,`customer_person`.`Email` AS `Email`,`customer_person`.`IDCard` AS `IDCard`,`customer_person_staff`.`EmployeeID` AS `EmployeeID`,`customer_person_staff_position`.`StaffPositionID` AS `StaffPositionID`,`customer_person_staff_position`.`Position` AS `Position`,`customer_person_staff_division`.`DivisionID` AS `DivisionID`,`customer_person_staff_division`.`Division` AS `Division`,`customer_person_staff_division`.`Organization` AS `Organization`,`customer_person_staff_division`.`Address` AS `Address`,`customer_person`.`TypePerson` AS `TypePerson`,`customer_person`.`PersonStatus` AS `PersonStatus` from (((`customer_person` join `customer_person_staff` on((`customer_person_staff`.`PersonID` = `customer_person`.`PersonID`))) join `customer_person_staff_position` on((`customer_person_staff_position`.`StaffPositionID` = `customer_person_staff`.`StaffPositionID`))) join `customer_person_staff_division` on((`customer_person_staff_division`.`DivisionID` = `customer_person_staff`.`DivisionID`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`AccountID`), ADD UNIQUE KEY `Username_UNIQUE` (`Username`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `customer_businesstype`
--
ALTER TABLE `customer_businesstype`
 ADD PRIMARY KEY (`BusinessTypeID`);

--
-- Indexes for table `customer_package`
--
ALTER TABLE `customer_package`
 ADD PRIMARY KEY (`PackageID`);

--
-- Indexes for table `customer_package_category`
--
ALTER TABLE `customer_package_category`
 ADD PRIMARY KEY (`PackageCategoryID`);

--
-- Indexes for table `customer_person`
--
ALTER TABLE `customer_person`
 ADD PRIMARY KEY (`PersonID`);

--
-- Indexes for table `customer_person_contact`
--
ALTER TABLE `customer_person_contact`
 ADD PRIMARY KEY (`PersonContactID`);

--
-- Indexes for table `customer_person_staff`
--
ALTER TABLE `customer_person_staff`
 ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `customer_person_staff_division`
--
ALTER TABLE `customer_person_staff_division`
 ADD PRIMARY KEY (`DivisionID`);

--
-- Indexes for table `customer_person_staff_position`
--
ALTER TABLE `customer_person_staff_position`
 ADD PRIMARY KEY (`StaffPositionID`);

--
-- Indexes for table `customer_service`
--
ALTER TABLE `customer_service`
 ADD PRIMARY KEY (`ServiceID`);

--
-- Indexes for table `customer_service_detail`
--
ALTER TABLE `customer_service_detail`
 ADD PRIMARY KEY (`ServiceDetailID`);

--
-- Indexes for table `customer_service_detail_action`
--
ALTER TABLE `customer_service_detail_action`
 ADD PRIMARY KEY (`ServiceDetailActionID`);

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
 ADD PRIMARY KEY (`EntryID`);

--
-- Indexes for table `entry_equipment`
--
ALTER TABLE `entry_equipment`
 ADD PRIMARY KEY (`EquipmentID`);

--
-- Indexes for table `entry_equipment_detail`
--
ALTER TABLE `entry_equipment_detail`
 ADD PRIMARY KEY (`EquipmentDetailID`);

--
-- Indexes for table `entry_zone`
--
ALTER TABLE `entry_zone`
 ADD PRIMARY KEY (`EntryZoneID`);

--
-- Indexes for table `entry_zone_detail`
--
ALTER TABLE `entry_zone_detail`
 ADD PRIMARY KEY (`ZoneDetailID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
 ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `resource_amount`
--
ALTER TABLE `resource_amount`
 ADD PRIMARY KEY (`ResourceAmountID`);

--
-- Indexes for table `resource_ip`
--
ALTER TABLE `resource_ip`
 ADD PRIMARY KEY (`ResourceIPID`);

--
-- Indexes for table `resource_ip_used`
--
ALTER TABLE `resource_ip_used`
 ADD PRIMARY KEY (`ResourceIPUsedID`);

--
-- Indexes for table `resource_network_link`
--
ALTER TABLE `resource_network_link`
 ADD PRIMARY KEY (`ResourceNetworkLinkID`);

--
-- Indexes for table `resource_network_link_used`
--
ALTER TABLE `resource_network_link_used`
 ADD PRIMARY KEY (`ResourceNetworkLinkUsedID`);

--
-- Indexes for table `resource_rack`
--
ALTER TABLE `resource_rack`
 ADD PRIMARY KEY (`ResourceRackID`);

--
-- Indexes for table `resource_rack_used`
--
ALTER TABLE `resource_rack_used`
 ADD PRIMARY KEY (`ResourceRackUsedID`);

--
-- Indexes for table `resource_service`
--
ALTER TABLE `resource_service`
 ADD PRIMARY KEY (`ResourceServiceID`);

--
-- Indexes for table `resource_service_used`
--
ALTER TABLE `resource_service_used`
 ADD PRIMARY KEY (`ResourceServiceUsedID`);

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
-- Indexes for table `resource_switch_port_used`
--
ALTER TABLE `resource_switch_port_used`
 ADD PRIMARY KEY (`ResourceSwitchPortUsedID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_businesstype`
--
ALTER TABLE `customer_businesstype`
MODIFY `BusinessTypeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_package`
--
ALTER TABLE `customer_package`
MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_package_category`
--
ALTER TABLE `customer_package_category`
MODIFY `PackageCategoryID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `customer_person`
--
ALTER TABLE `customer_person`
MODIFY `PersonID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_person_contact`
--
ALTER TABLE `customer_person_contact`
MODIFY `PersonContactID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_person_staff`
--
ALTER TABLE `customer_person_staff`
MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_person_staff_division`
--
ALTER TABLE `customer_person_staff_division`
MODIFY `DivisionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_person_staff_position`
--
ALTER TABLE `customer_person_staff_position`
MODIFY `StaffPositionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customer_service`
--
ALTER TABLE `customer_service`
MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_service_detail`
--
ALTER TABLE `customer_service_detail`
MODIFY `ServiceDetailID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_service_detail_action`
--
ALTER TABLE `customer_service_detail_action`
MODIFY `ServiceDetailActionID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
MODIFY `EntryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entry_equipment`
--
ALTER TABLE `entry_equipment`
MODIFY `EquipmentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entry_equipment_detail`
--
ALTER TABLE `entry_equipment_detail`
MODIFY `EquipmentDetailID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entry_zone`
--
ALTER TABLE `entry_zone`
MODIFY `EntryZoneID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `entry_zone_detail`
--
ALTER TABLE `entry_zone_detail`
MODIFY `ZoneDetailID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `resource_amount`
--
ALTER TABLE `resource_amount`
MODIFY `ResourceAmountID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_ip`
--
ALTER TABLE `resource_ip`
MODIFY `ResourceIPID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_ip_used`
--
ALTER TABLE `resource_ip_used`
MODIFY `ResourceIPUsedID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_network_link`
--
ALTER TABLE `resource_network_link`
MODIFY `ResourceNetworkLinkID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_network_link_used`
--
ALTER TABLE `resource_network_link_used`
MODIFY `ResourceNetworkLinkUsedID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_rack`
--
ALTER TABLE `resource_rack`
MODIFY `ResourceRackID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_rack_used`
--
ALTER TABLE `resource_rack_used`
MODIFY `ResourceRackUsedID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_service`
--
ALTER TABLE `resource_service`
MODIFY `ResourceServiceID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_service_used`
--
ALTER TABLE `resource_service_used`
MODIFY `ResourceServiceUsedID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_switch`
--
ALTER TABLE `resource_switch`
MODIFY `ResourceSwitchID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_switch_port`
--
ALTER TABLE `resource_switch_port`
MODIFY `ResourceSwitchPortID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_switch_port_used`
--
ALTER TABLE `resource_switch_port_used`
MODIFY `ResourceSwitchPortUsedID` int(11) NOT NULL AUTO_INCREMENT;