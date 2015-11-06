-- MySQL Script generated by MySQL Workbench
-- 11/06/15 13:58:11
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cat_dcms
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cat_dcms
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cat_dcms` DEFAULT CHARACTER SET utf8 ;
USE `cat_dcms` ;

-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_businesstype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_businesstype` (
  `BusinessTypeID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `BusinessType` VARCHAR(45) NULL COMMENT '',
  `Status` ENUM('Active', 'Deactive') NULL DEFAULT 'Active' COMMENT '',
  PRIMARY KEY (`BusinessTypeID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer` (
  `CustomerID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `CustomerStatus` ENUM('Active', 'Suppened', 'Delete') NULL COMMENT 'Active\nSuppened\nDelete',
  `CustomerName` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `BusinessTypeID` INT(11) NULL COMMENT 'กสท.\nนิติบุคคล\nบุคคล',
  `Email` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Phone` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Fax` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Address` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Township` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `City` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Province` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Zipcode` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Country` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `CreateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `UpdateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`CustomerID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_rack`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_rack` (
  `ResourceRackID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `Col` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Row` INT(5) NULL DEFAULT NULL COMMENT '',
  `PositionRack` INT(3) NULL DEFAULT NULL COMMENT '',
  `RackType` VARCHAR(45) NULL DEFAULT NULL COMMENT 'ex. Full Rack, 1/2 Rack, 1/4 Rack',
  `RackSize` INT(3) NULL DEFAULT NULL COMMENT '',
  `EnableResourceRack` INT(1) NULL DEFAULT '1' COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `RackKey` TEXT NULL COMMENT 'เก็บไว้คิด',
  `LocationID` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceRackID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 104
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry_equipment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry_equipment` (
  `EquipmentID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `Equipment` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Brand` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Model` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `SerialNo` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `RackID` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`EquipmentID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_service` (
  `ServiceID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `CustomerID` INT(11) NULL COMMENT '',
  `LocationID` INT(11) NULL DEFAULT NULL COMMENT 'แยก Table',
  `DateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ServiceID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_network_link`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_network_link` (
  `ResourceNetworkLinkID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `NetworkLink` VARCHAR(45) NULL COMMENT '',
  `CoperateName` VARCHAR(45) NULL COMMENT '',
  `ContactName` VARCHAR(45) NULL COMMENT '',
  `Phone` VARCHAR(45) NULL COMMENT '',
  `Email` VARCHAR(45) NULL COMMENT '',
  `NetworkLinkStatus` ENUM('Active', 'Deactive') NULL COMMENT '1=active,0=deactive',
  `LocationID` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceNetworkLinkID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_package_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_package_category` (
  `PackageCategoryID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `PackageCategory` VARCHAR(45) NULL COMMENT '',
  `Status` ENUM('Active', 'Deative') NULL DEFAULT 'Active' COMMENT '',
  PRIMARY KEY (`PackageCategoryID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_package`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_package` (
  `PackageID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `PackageName` VARCHAR(45) NULL COMMENT '',
  `PackageDetail` TEXT NULL DEFAULT NULL COMMENT '',
  `PackageType` ENUM('Main', 'Add-on') NULL DEFAULT NULL COMMENT 'main,add-on',
  `PackageCategoryID` INT NULL DEFAULT NULL COMMENT '',
  `PackageStatus` ENUM('Active', 'Deative') NULL DEFAULT 'Active' COMMENT '1=active,0=deactive',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `LocationID` INT NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`PackageID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_service_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_service_detail` (
  `ServiceDetailID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `ServiceID` INT(11) NULL COMMENT '',
  `PackageID` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ServiceDetailID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_person`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_person` (
  `PersonID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `Fname` VARCHAR(45) NULL COMMENT '',
  `Lname` VARCHAR(45) NULL COMMENT '',
  `Phone` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Email` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `IDCard` VARCHAR(45) NULL COMMENT 'Thai ID Card',
  `TypePerson` ENUM('Staff', 'Contact', 'Visitor') NULL DEFAULT 'Visitor' COMMENT '1=staff,2=contact,3=visitor',
  `PersonStatus` ENUM('Active', 'Deactive') NULL DEFAULT 'Active' COMMENT '0=deactive,1=active',
  PRIMARY KEY (`PersonID`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry` (
  `EntryID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `PersonID` INT(11) NULL COMMENT '',
  `VisitorCardID` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `IDCard` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `IDCCard` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `IDCCardType` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `EmpID` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `TimeIn` DATETIME NULL COMMENT '',
  `TimeOut` DATETIME NULL DEFAULT NULL COMMENT '',
  `Purpose` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `InternetAccount` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`EntryID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`location` (
  `LocationID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `Location` VARCHAR(45) NULL COMMENT '',
  `Address` TEXT NULL COMMENT '',
  `Status` ENUM('Active', 'Deative') NULL DEFAULT 'Active' COMMENT '',
  PRIMARY KEY (`LocationID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry_zone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry_zone` (
  `EntryZoneID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `EntryZone` VARCHAR(45) NULL COMMENT '',
  `LocationID` INT NULL COMMENT '',
  `Status` TINYINT(1) NULL DEFAULT 1 COMMENT '',
  PRIMARY KEY (`EntryZoneID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 67
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_ip`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_ip` (
  `ResourceIPID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `IP` VARCHAR(45) NULL COMMENT '',
  `NetworkIP` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Subnet` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `VlanID` INT(11) NULL DEFAULT NULL COMMENT '',
  `EnableResourceIP` INT(1) NULL DEFAULT '1' COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `LocationID` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceIPID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 255
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_service` (
  `ResourceServiceID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `Name` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Detail` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `Tag` TEXT NULL DEFAULT NULL COMMENT '',
  `PersonID` INT(11) NULL DEFAULT NULL COMMENT '',
  `EnableResourceService` INT(1) NULL DEFAULT '1' COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `LocationID` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceServiceID`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_switch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_switch` (
  `ResourceSwitchID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `SwitchName` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `SwitchIP` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `TotalPort` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `SnmpCommuPublic` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `SwitchTypeID` INT(11) NULL COMMENT '',
  `Brand` VARCHAR(45) NULL COMMENT '',
  `Model` VARCHAR(45) NULL COMMENT '',
  `SerialNo` VARCHAR(45) NULL COMMENT '',
  `RackID` INT(11) NULL COMMENT '',
  `EnableResourceSW` INT(1) NULL DEFAULT '1' COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `LocationID` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceSwitchID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_switch_port`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_switch_port` (
  `ResourceSwitchPortID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `ResourceSwitchID` INT(11) NULL DEFAULT NULL COMMENT '',
  `PortNumber` INT(11) NULL DEFAULT NULL COMMENT '',
  `PortType` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `PortVlan` INT(5) NULL COMMENT '',
  `Uplink` TINYINT(4) NULL DEFAULT NULL COMMENT '',
  `EnableResourcePort` INT(1) NULL DEFAULT '1' COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ResourceSwitchPortID`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 67
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_rack_used`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_rack_used` (
  `ResourceRackUsedID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `ResourceRackID` INT NULL COMMENT '',
  `Status` TINYINT(1) NULL COMMENT '',
  `CreateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `UpdateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ResourceRackUsedID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_ip_used`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_ip_used` (
  `ResourceIPUsedID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `ResourceIPID` INT NULL COMMENT '',
  `Status` TINYINT(1) NULL COMMENT '',
  `CreateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `UpdateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ResourceIPUsedID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_switch_port_used`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_switch_port_used` (
  `ResourceSwitchPortUsedID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `ResourcePortID` INT NULL COMMENT '',
  `Status` TINYINT(1) NULL COMMENT '',
  `CreateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `UpdateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ResourceSwitchPortUsedID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_service_used`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_service_used` (
  `ResourceServiceUsedID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `ResourceServiceID` INT NULL COMMENT '',
  `Status` TINYINT(1) NULL COMMENT '',
  `CreateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `UpdateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ResourceServiceUsedID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_network_link_used`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_network_link_used` (
  `ResourceNetworkLinkUsedID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `ResourceNetworkLinkID` INT NULL COMMENT '',
  `Status` TINYINT(1) NULL COMMENT '',
  `CreateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `UpdateDateTime` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`ResourceNetworkLinkUsedID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`account` (
  `AccountID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `PersonID` INT NULL COMMENT '',
  `Username` VARCHAR(45) NOT NULL COMMENT '',
  `Password` VARCHAR(45) NOT NULL COMMENT '',
  `LastLogin` VARCHAR(45) NULL COMMENT '',
  `LoginPass` INT(5) NULL COMMENT '',
  `LoginFail` INT(5) NULL COMMENT '',
  PRIMARY KEY (`AccountID`)  COMMENT '',
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_person_contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_person_contact` (
  `PersonContactID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `CustomerID` INT NULL COMMENT '',
  `PersonID` INT NULL COMMENT '',
  `IDCCard` VARCHAR(15) NULL COMMENT '',
  `IDCCardType` VARCHAR(10) NULL COMMENT '',
  `ContactType` ENUM('Main', 'Secondary') NULL COMMENT '1=main,2=secondary',
  PRIMARY KEY (`PersonContactID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_person_staff_position`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_person_staff_position` (
  `StaffPositionID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `Position` VARCHAR(45) NULL COMMENT '',
  `Status` ENUM('Active', 'Deactive') NULL DEFAULT 'Active' COMMENT '',
  PRIMARY KEY (`StaffPositionID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_person_staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_person_staff` (
  `PersonStaffID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `PersonID` INT NULL COMMENT '',
  `EmployeeID` VARCHAR(45) NULL COMMENT '',
  `StaffPositionID` INT NULL COMMENT '',
  PRIMARY KEY (`PersonStaffID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry_equipment_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry_equipment_detail` (
  `EquipmentDetailID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `EquipmentID` INT NULL COMMENT '',
  `EntryID` INT NULL COMMENT '',
  `EquipmentAction` VARCHAR(5) NULL COMMENT 'in,out',
  `DateTime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`EquipmentDetailID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry_zone_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry_zone_detail` (
  `ZoneDetailID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `EntryID` INT NULL COMMENT '',
  `ZoneID` INT NULL COMMENT '',
  PRIMARY KEY (`ZoneDetailID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_amount`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_amount` (
  `ResourceAmountID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `PackageID` INT NULL COMMENT '',
  `IPAmount` INT(5) NULL DEFAULT 0 COMMENT '',
  `PortAmount` INT(5) NULL DEFAULT 0 COMMENT '',
  `RackAmount` INT(5) NULL DEFAULT 0 COMMENT '',
  `ServiceAmount` INT(5) NULL DEFAULT 0 COMMENT '',
  PRIMARY KEY (`ResourceAmountID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`customer_service_detail_action`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`customer_service_detail_action` (
  `ServiceDetailActionID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `ServiceDetailID` INT(11) NULL COMMENT '',
  `Status` ENUM('Action', 'Suppened', 'Deactive') NULL DEFAULT 'Active' COMMENT '',
  `Cause` VARCHAR(100) NULL COMMENT '',
  `DateTime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`ServiceDetailActionID`)  COMMENT '')
ENGINE = InnoDB;

USE `cat_dcms` ;

-- -----------------------------------------------------
-- Placeholder table for view `cat_dcms`.`view_contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`view_contact` (`PersonID` INT, `Fname` INT, `Lname` INT, `Phone` INT, `Email` INT, `IDCard` INT, `TypePerson` INT, `CustomerID` INT, `IDCCard` INT, `IDCCardType` INT, `ContactType` INT, `PersonStatus` INT);

-- -----------------------------------------------------
-- Placeholder table for view `cat_dcms`.`view_customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`view_customer` (`CustomerID` INT, `CustomerStatus` INT, `CustomerName` INT, `BusinessTypeID` INT, `BusinessType` INT, `Email` INT, `Phone` INT, `Fax` INT, `Address` INT, `Township` INT, `City` INT, `Province` INT, `Zipcode` INT, `Country` INT, `CreateDateTime` INT, `UpdateDateTime` INT, `CreateBy` INT, `UpdateBy` INT);

-- -----------------------------------------------------
-- Placeholder table for view `cat_dcms`.`view_package`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`view_package` (`PackageID` INT, `PackageName` INT, `PackageDetail` INT, `PackageType` INT, `PackageCategoryID` INT, `PackageCategory` INT, `PackageStatus` INT, `DateTimeCreate` INT, `DateTimeUpdate` INT, `LocationID` INT, `Location` INT);

-- -----------------------------------------------------
-- Placeholder table for view `cat_dcms`.`view_service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`view_service` (`ServiceID` INT, `CustomerID` INT, `DateTimeService` INT, `CreateBy` INT, `ServiceDetailID` INT, `PackageID` INT, `PackageName` INT, `PackageType` INT, `PackageCategoryID` INT, `PackageCategory` INT, `Status` INT, `Cause` INT, `LocationID` INT, `Location` INT, `DateTimeAction` INT);

-- -----------------------------------------------------
-- View `cat_dcms`.`view_contact`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cat_dcms`.`view_contact`;
USE `cat_dcms`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_contact` AS select `customer_person`.`PersonID` AS `PersonID`,`customer_person`.`Fname` AS `Fname`,`customer_person`.`Lname` AS `Lname`,`customer_person`.`Phone` AS `Phone`,`customer_person`.`Email` AS `Email`,`customer_person`.`IDCard` AS `IDCard`,`customer_person`.`TypePerson` AS `TypePerson`,`customer_person_contact`.`CustomerID` AS `CustomerID`,`customer_person_contact`.`IDCCard` AS `IDCCard`,`customer_person_contact`.`IDCCardType` AS `IDCCardType`,`customer_person_contact`.`ContactType` AS `ContactType`,`customer_person`.`PersonStatus` AS `PersonStatus` from (`customer_person_contact` join `customer_person` on((`customer_person_contact`.`PersonID` = `customer_person`.`PersonID`)));

-- -----------------------------------------------------
-- View `cat_dcms`.`view_customer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cat_dcms`.`view_customer`;
USE `cat_dcms`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_customer` AS select `customer`.`CustomerID` AS `CustomerID`,`customer`.`CustomerStatus` AS `CustomerStatus`,`customer`.`CustomerName` AS `CustomerName`,`customer_businesstype`.`BusinessTypeID` AS `BusinessTypeID`,`customer_businesstype`.`BusinessType` AS `BusinessType`,`customer`.`Email` AS `Email`,`customer`.`Phone` AS `Phone`,`customer`.`Fax` AS `Fax`,`customer`.`Address` AS `Address`,`customer`.`Township` AS `Township`,`customer`.`City` AS `City`,`customer`.`Province` AS `Province`,`customer`.`Zipcode` AS `Zipcode`,`customer`.`Country` AS `Country`,`customer`.`CreateDateTime` AS `CreateDateTime`,`customer`.`UpdateDateTime` AS `UpdateDateTime`,`customer`.`CreateBy` AS `CreateBy`,`customer`.`UpdateBy` AS `UpdateBy` from (`customer` join `customer_businesstype` on((`customer`.`BusinessTypeID` = `customer_businesstype`.`BusinessTypeID`)));

-- -----------------------------------------------------
-- View `cat_dcms`.`view_package`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cat_dcms`.`view_package`;
USE `cat_dcms`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_package` AS select `customer_package`.`PackageID` AS `PackageID`,`customer_package`.`PackageName` AS `PackageName`,`customer_package`.`PackageDetail` AS `PackageDetail`,`customer_package`.`PackageType` AS `PackageType`,`customer_package`.`PackageCategoryID` AS `PackageCategoryID`,`customer_package_category`.`PackageCategory` AS `PackageCategory`,`customer_package`.`PackageStatus` AS `PackageStatus`,`customer_package`.`DateTimeCreate` AS `DateTimeCreate`,`customer_package`.`DateTimeUpdate` AS `DateTimeUpdate`,`customer_package`.`LocationID` AS `LocationID`,`location`.`Location` AS `Location` from ((`customer_package` join `customer_package_category` on((`customer_package`.`PackageCategoryID` = `customer_package_category`.`PackageCategoryID`))) join `location` on((`customer_package`.`LocationID` = `location`.`LocationID`)));

-- -----------------------------------------------------
-- View `cat_dcms`.`view_service`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cat_dcms`.`view_service`;
USE `cat_dcms`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`cat`@`localhost` SQL SECURITY DEFINER VIEW `view_service` AS select `customer_service`.`ServiceID` AS `ServiceID`,`customer_service`.`CustomerID` AS `CustomerID`,`customer_service`.`DateTime` AS `DateTimeService`,`customer_service`.`CreateBy` AS `CreateBy`,`customer_service_detail`.`ServiceDetailID` AS `ServiceDetailID`,`customer_service_detail`.`PackageID` AS `PackageID`,`customer_package`.`PackageName` AS `PackageName`,`customer_package`.`PackageType` AS `PackageType`,`customer_package_category`.`PackageCategoryID` AS `PackageCategoryID`,`customer_package_category`.`PackageCategory` AS `PackageCategory`,`customer_service_detail_action`.`Status` AS `Status`,`customer_service_detail_action`.`Cause` AS `Cause`,`location`.`LocationID` AS `LocationID`,`location`.`Location` AS `Location`,`customer_service_detail_action`.`DateTime` AS `DateTimeAction` from (((((`customer_service` join `customer_service_detail` on((`customer_service`.`ServiceID` = `customer_service_detail`.`ServiceID`))) join `customer_package` on((`customer_package`.`PackageID` = `customer_service_detail`.`PackageID`))) join `customer_service_detail_action` on((`customer_service_detail`.`ServiceDetailID` = `customer_service_detail_action`.`ServiceDetailID`))) join `location` on((`location`.`LocationID` = `customer_service`.`LocationID`))) join `customer_package_category` on((`customer_package_category`.`PackageCategoryID` = `customer_package`.`PackageCategoryID`)));

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `cat_dcms`.`customer_businesstype`
-- -----------------------------------------------------
START TRANSACTION;
USE `cat_dcms`;
INSERT INTO `cat_dcms`.`customer_businesstype` (`BusinessTypeID`, `BusinessType`, `Status`) VALUES (1, 'กสท', 'Active');
INSERT INTO `cat_dcms`.`customer_businesstype` (`BusinessTypeID`, `BusinessType`, `Status`) VALUES (2, 'นิติบุคคล', 'Active');
INSERT INTO `cat_dcms`.`customer_businesstype` (`BusinessTypeID`, `BusinessType`, `Status`) VALUES (3, 'บุคคล', 'Active');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cat_dcms`.`customer_package_category`
-- -----------------------------------------------------
START TRANSACTION;
USE `cat_dcms`;
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (1, 'Shared Rack', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (2, '1/4 Rack', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (3, '1/2 Rack', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (4, 'Full Rack', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (5, 'IP Address', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (6, 'Port 10/100', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (7, 'Port 10/100/1000', 'Active');
INSERT INTO `cat_dcms`.`customer_package_category` (`PackageCategoryID`, `PackageCategory`, `Status`) VALUES (8, 'Firewall', 'Active');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cat_dcms`.`location`
-- -----------------------------------------------------
START TRANSACTION;
USE `cat_dcms`;
INSERT INTO `cat_dcms`.`location` (`LocationID`, `Location`, `Address`, `Status`) VALUES (1, 'CAT-IDC Nonthaburi', 'Nonthaburi', 'Active');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cat_dcms`.`entry_zone`
-- -----------------------------------------------------
START TRANSACTION;
USE `cat_dcms`;
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (1, 'Customer Room', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (2, 'IDC 1', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (3, 'IDC 2', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (4, 'Core Network', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (5, 'IDC NOC', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (6, 'Manager', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (7, 'Power', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (8, 'Meeting', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (9, 'VIP 1', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (10, 'VIP 2', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (11, 'VIP 3', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (12, 'VIP 4', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (13, 'VIP 5', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (14, 'VIP 6', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (15, 'VIP 7', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (16, 'Office', 1, NULL);
INSERT INTO `cat_dcms`.`entry_zone` (`EntryZoneID`, `EntryZone`, `LocationID`, `Status`) VALUES (17, 'Temp Office', 1, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `cat_dcms`.`customer_person_staff_position`
-- -----------------------------------------------------
START TRANSACTION;
USE `cat_dcms`;
INSERT INTO `cat_dcms`.`customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES (1, 'frontdesk', NULL);
INSERT INTO `cat_dcms`.`customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES (2, 'helpdesk', NULL);
INSERT INTO `cat_dcms`.`customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES (3, 'engineering', NULL);
INSERT INTO `cat_dcms`.`customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES (4, 'manager', NULL);
INSERT INTO `cat_dcms`.`customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES (5, 'other', NULL);
INSERT INTO `cat_dcms`.`customer_person_staff_position` (`StaffPositionID`, `Position`, `Status`) VALUES (6, 'vender', NULL);

COMMIT;

