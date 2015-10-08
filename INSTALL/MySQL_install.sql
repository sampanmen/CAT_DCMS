-- MySQL Script generated by MySQL Workbench
-- 10/06/15 11:50:01
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
CREATE SCHEMA IF NOT EXISTS `cat_dcms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `cat_dcms` ;

-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_person`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_person` (
  `PersonID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `Fname` VARCHAR(45) NULL COMMENT '',
  `Lname` VARCHAR(45) NULL COMMENT '',
  `Phone` VARCHAR(45) NULL COMMENT '',
  `Email` VARCHAR(45) NULL COMMENT '',
  `CustomerID` INT NULL COMMENT '',
  `Password` VARCHAR(45) NULL COMMENT '',
  `CatEmpID` VARCHAR(45) NULL COMMENT '',
  `IDCard` INT NULL COMMENT '',
  `TypePerson` VARCHAR(45) NULL COMMENT 'staff\ncontact\nsubcontact\nvisitor',
  `Position` VARCHAR(45) NULL COMMENT '',
  `PersonStatus` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`PersonID`)  COMMENT '',
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_customer` (
  `CustomerID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `PrefixID` VARCHAR(45) NULL COMMENT '',
  `CustomerStatus` VARCHAR(45) NULL COMMENT 'Active\nSuppened\nDelete',
  `CustomerName` VARCHAR(45) NULL COMMENT '',
  `BusinessType` VARCHAR(45) NULL COMMENT 'กสท.\nนิติบุคคล\nบุคคล',
  `Email` VARCHAR(45) NULL COMMENT '',
  `Phone` VARCHAR(45) NULL COMMENT '',
  `Fax` VARCHAR(45) NULL COMMENT '',
  `Address` VARCHAR(45) NULL COMMENT '',
  `Township` VARCHAR(45) NULL COMMENT '',
  `City` VARCHAR(45) NULL COMMENT '',
  `Province` VARCHAR(45) NULL COMMENT '',
  `Zipcode` INT NULL COMMENT '',
  `Country` VARCHAR(45) NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`CustomerID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_package`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_package` (
  `PackageID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `PackageName` VARCHAR(45) NULL COMMENT '',
  `PackageDetail` TEXT NULL COMMENT '',
  `PackageType` VARCHAR(45) NULL COMMENT 'หลัก\nรอง',
  `PackageCategory` VARCHAR(45) NULL COMMENT 'Full\n1/2\n1/4\nShare',
  `PackageStatus` VARCHAR(45) NULL DEFAULT 1 COMMENT '',
  `IPAmount` INT NULL DEFAULT 0 COMMENT '',
  `PortAmount` INT NULL DEFAULT 0 COMMENT '',
  `RackAmount` INT NULL DEFAULT 0 COMMENT '',
  `ServiceAmount` INT NULL DEFAULT 0 COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`PackageID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_order` (
  `OrderID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderPreID` VARCHAR(45) NULL COMMENT '',
  `OrderIDOld` VARCHAR(45) NULL COMMENT '',
  `CustomerID` INT NULL COMMENT '',
  `Name` VARCHAR(45) NULL COMMENT '',
  `Location` VARCHAR(45) NULL COMMENT '',
  `StatusOrder` VARCHAR(45) NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`OrderID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_order_bundle_network`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_order_bundle_network` (
  `orderBundleNetworkID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderID` INT NULL COMMENT '',
  `BundleNetwork` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`orderBundleNetworkID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`ticket`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`ticket` (
  `TicketID` INT NOT NULL COMMENT '',
  `PersonID` INT NULL COMMENT '',
  `Topic` VARCHAR(45) NULL COMMENT '',
  `Detail` TEXT NULL COMMENT '',
  `TicketStatus` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`TicketID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`ticket_event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`ticket_event` (
  `TicketEventID` INT NOT NULL COMMENT '',
  `TicketID` INT NULL COMMENT '',
  `PersonID` INT NULL COMMENT '',
  `TicketEvent` TEXT NULL COMMENT '',
  PRIMARY KEY (`TicketEventID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry_idc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry_idc` (
  `EntryIDCID` INT NOT NULL COMMENT '',
  `PersonID` INT NULL COMMENT '',
  `VisitorCardID` VARCHAR(45) NULL COMMENT '',
  `IDCCardID` VARCHAR(45) NULL COMMENT '',
  `IDCCardType` VARCHAR(45) NULL COMMENT '',
  `TimeIn` DATETIME NULL COMMENT '',
  `TimeOut` DATETIME NULL COMMENT '',
  `Purpose` VARCHAR(150) NULL COMMENT '',
  `InternetAccount` VARCHAR(45) NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`EntryIDCID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`entry_idc_zone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`entry_idc_zone` (
  `EntryIDCZoneID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `EntryIDCID` INT NULL COMMENT '',
  `Zone` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`EntryIDCZoneID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_switch_port`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_switch_port` (
  `ResourceSwitchPortID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `ResourceSwitchID` INT NULL COMMENT '',
  `PortNumber` INT NULL COMMENT '',
  `PortType` VARCHAR(45) NULL COMMENT '',
  `Uplink` TINYINT NULL COMMENT '',
  `EnableResourcePort` INT(1) NULL DEFAULT 1 COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceSwitchPortID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_Switch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_Switch` (
  `ResourceSwitchID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `SwitchName` VARCHAR(45) NULL COMMENT '',
  `SwitchIP` VARCHAR(45) NULL COMMENT '',
  `TotalPort` VARCHAR(45) NULL COMMENT '',
  `SnmpCommuPublic` VARCHAR(45) NULL COMMENT '',
  `SnmpCommuPrivate` VARCHAR(45) NULL COMMENT '',
  `SwitchType` VARCHAR(45) NULL COMMENT '',
  `EnableResourceSW` INT(1) NULL DEFAULT 1 COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceSwitchID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_ip`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_ip` (
  `ResourceIpID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `IP` VARCHAR(45) NULL COMMENT '',
  `NetworkIP` VARCHAR(45) NULL COMMENT '',
  `Subnet` VARCHAR(45) NULL COMMENT '',
  `VlanID` INT NULL COMMENT '',
  `EnableResourceIP` INT(1) NULL DEFAULT 1 COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL DEFAULT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceIpID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_rack`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_rack` (
  `ResourceRackID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `Zone` VARCHAR(45) NULL COMMENT '',
  `Position` VARCHAR(45) NULL COMMENT '',
  `SubPosition` VARCHAR(45) NULL COMMENT '',
  `RackType` VARCHAR(45) NULL COMMENT 'ex. Full Rack, 1/2 Rack, 1/4 Rack',
  `RackSize` INT NULL COMMENT '',
  `EnableResourceRack` INT(1) NULL DEFAULT 1 COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceRackID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`resource_Service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`resource_Service` (
  `ResourceServiceID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `Name` VARCHAR(45) NULL COMMENT '',
  `Detail` VARCHAR(45) NULL COMMENT '',
  `Tag` TEXT NULL COMMENT '',
  `PersonID` INT NULL DEFAULT NULL COMMENT '',
  `EnableResourceService` INT(1) NULL DEFAULT 1 COMMENT '',
  `OrderDetailID` INT NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`ResourceServiceID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_order_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_order_detail` (
  `OrderDetailID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `OrderID` INT NULL COMMENT '',
  `PackageID` INT NULL COMMENT '',
  `OrderDetailStatus` VARCHAR(45) NULL COMMENT '',
  `DateTimeCreate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `DateTimeUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
  `CreateBy` INT NULL COMMENT '',
  `UpdateBy` INT NULL COMMENT '',
  PRIMARY KEY (`OrderDetailID`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_dcms`.`cus_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_dcms`.`cus_item` (
  `ItemID` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `EntryIDCID` INT NULL COMMENT '',
  `Equipment` VARCHAR(45) NULL COMMENT '',
  `Brand` VARCHAR(45) NULL COMMENT '',
  `Model` VARCHAR(45) NULL COMMENT '',
  `SerialNo` VARCHAR(45) NULL COMMENT '',
  `RackID` INT NULL COMMENT '',
  `TimeIn` DATETIME NULL COMMENT '',
  `TimeOut` DATETIME NULL COMMENT '',
  PRIMARY KEY (`ItemID`)  COMMENT '')
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
