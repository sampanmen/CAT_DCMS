<?php

function getZone() {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`entry_zone`.`EntryZoneID`,"
            . "`entry_zone`.`EntryZone` ,"
            . "`location`.`Location`,"
            . "`entry_zone`.`Status`"
            . "FROM `entry_zone`"
            . "inner join `location`"
            . "ON `entry_zone`.`LocationID`=`location`.`LocationID`";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getCatagory() {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`PackageCategoryID`,"
            . "`PackageCategory`,"
            . "`Status`"
            . "FROM `customer_package_category`";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getStaffPosition() {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`StaffPositionID`,"
            . "`Position`,"
            . "`Status`"
            . "FROM `customer_person_staff_position`";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getViewstaff() {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`customer_person_staff`.`EmployeeID`,"
            . "`customer_person`.`Fname`,"
            . "`customer_person`.`Lname`,"
            . "`customer_person_staff_position`.`Position`,"
            . "`customer_person`.`PersonStatus`"
            . "FROM `customer_person`"
            . "JOIN `customer_person_staff`"
            . "ON  `customer_person`.`PersonID`  =  `customer_person_staff`.`PersonID`"
            . "JOIN `customer_person_staff_position` "
            . "ON  `customer_person_staff`.`StaffPositionID`  = `customer_person_staff_position`.`StaffPositionID`";
//   echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
