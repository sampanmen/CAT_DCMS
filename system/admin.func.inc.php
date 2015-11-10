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


function getStaffPositionByID($StaffPositionID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`StaffPositionID`,"
            . "`Position`,"
            . "`Status`"
            . "FROM `customer_person_staff_position`"
            . "WHERE `StaffPositionID`= :staffPositionID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":staffPositionID" => $StaffPositionID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
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

function addPosition($Position, $Status) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `customer_person_staff_position`(`Position`, `Status`) "
            . "VALUES (:Position,:Status)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Position" => $Position,
        ":Status" => $Status
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}


function addBusinesstype($Businesstype, $Status) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `customer_businesstype`(`BusinessType`, `Status`) "
            . "VALUES (:BusinessType,:Status)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":BusinessType" => $Businesstype,
        ":Status" => $Status
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}


function addLocation($Location,$Address, $Status) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO`location`(`Location`, `Address`, `Status`) "
            . "VALUES (:Location,:Address,:Status)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Location" => $Location,
        ":Address" => $Address,
        ":Status" => $Status
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}


function addPacCatagory($PackageCategory, $Status) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO`customer_package_category`(`PackageCategory`,`Status`)"
            . "VALUES (:PackageCategory,:Status)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":PackageCategory" => $PackageCategory,
        ":Status" => $Status
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function addZone($EntryZone, $LocationID, $Status) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_zone`(`EntryZone`, `LocationID`, `Status`)"
            . "VALUES (:EntryZone,:LocationID,:Status)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":EntryZone" => $EntryZone,
        ":LocationID" => $LocationID,
        ":Status" => $Status
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}


function editPosition($StaffPositionID, $Position, $Status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_person_staff_position` SET "
            . "`Position`=:Position, "
            . "`Status`=:Status "
            . "WHERE `StaffPositionID`= :StaffPositionID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Position" => $Position,
        ":Status" => $Status,
        ":StaffPositionID" => $StaffPositionID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}




