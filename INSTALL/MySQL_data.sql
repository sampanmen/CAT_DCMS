-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2015 at 06:36 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cat_dcms`
--

--
-- Dumping data for table `cus_customer`
--

INSERT INTO `cus_customer` (`CustomerID`, `PrefixID`, `CustomerStatus`, `CustomerName`, `BusinessType`, `Email`, `Phone`, `Fax`, `Address`, `Township`, `City`, `Province`, `Zipcode`, `Country`, `DateTimeCreate`, `DateTimeUpdate`, `CreateBy`, `UpdateBy`) VALUES
(1, 'CUS', 'active', 'สัมพันธ์', 'บุคคล', 'sampan.sara@outlook.com', '0873616961', '0909404625', '34 ม.12', 'จรเข้สามพัน', 'อู่ทอง', 'สุพรรณบุรี', 71170, 'ไทย', '2015-10-05 13:53:49', '2015-10-05 13:53:49', 1, 1);

--
-- Dumping data for table `cus_package`
--

INSERT INTO `cus_package` (`PackageID`, `PackageName`, `PackageDetail`, `PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, `PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, `DateTimeUpdate`, `CreateBy`, `UpdateBy`) VALUES
(2, 'ทอสอบ', 'ทอสอบ', 'main', 'full rack', 'not active', 11, 11, 11, 1, '2015-10-06 03:32:02', '2015-10-06 04:22:35', 1, -2),
(3, 'sdaf', 'sdaf', 'main', 'full rack', 'active', 1, 1, 1, 0, '2015-10-06 03:34:33', '2015-10-06 04:22:30', -1, -2),
(4, 'fadsfasdf', 'fadsfasd', 'add-on', 'full rack', 'active', 1, 1, 1, 1, '2015-10-06 03:39:39', '2015-10-06 03:39:39', -1, -1);

--
-- Dumping data for table `cus_person`
--

INSERT INTO `cus_person` (`PersonID`, `Fname`, `Lname`, `Phone`, `Email`, `CustomerID`, `Password`, `CatEmpID`, `IDCard`, `TypePerson`, `Position`, `PersonStatus`) VALUES
(1, 'สัมพันธ์', 'สาราณียะพงษ์', '0873616961', 'sampan.sara@outlook.com', 1, '123456', NULL, NULL, 'contact', NULL, 'active'),
(2, 'sfs', 'sfsaf', 'jkjl;jkl', 'sfasf@sdfsaf', NULL, 'sdfsaf', NULL, NULL, 'subcontact', NULL, 'active'),
(4, 'sfsa', 'dfsdf', 'sfsdf', 'catsfdf@sdfsdf', NULL, '123456', NULL, NULL, 'subcontact', NULL, 'active'),
(5, 'sdf1a', 'sfsd1', 'fsdf1', 'cat@sdfasfasdf1', 1, '1234561', NULL, NULL, 'subcontact', NULL, 'not active'),
(7, 'ฟดกฟหกดฟหด', 'ฟหกดฟหดฟหก', 'sdfsdfดฟหกดฟหด', 'cat@sdfsdf', 1, '123456กด', NULL, NULL, 'subcontact', NULL, 'active'),
(8, 'sfsas', 'fasdfd', 'fsdf', 'cat@sdfasfasfa', 1, '123456', NULL, NULL, 'subcontact', NULL, 'active'),
(9, 'erar', 'dfaasdfa', 'sdfasdfa', 'cat@faefsdfaf', 1, 'asdferafd', NULL, NULL, 'subcontact', NULL, 'active'),
(10, 'fddsf', 'afd', 'sfsadfs', 'cat@sdafghj', 1, '123456h', NULL, NULL, 'contact', NULL, 'active');
