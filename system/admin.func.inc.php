<?php

//<!--ZONE-->
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

function getZoneByLocationID($locationID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`entry_zone`.`EntryZoneID`,"
            . "`entry_zone`.`EntryZone` ,"
            . "`location`.`Location`,"
            . "`entry_zone`.`Status`"
            . "FROM `entry_zone`"
            . "inner join `location`"
            . "ON `entry_zone`.`LocationID`=`location`.`LocationID` "
            . "WHERE `location`.`LocationID` = :locationID";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":locationID" => $locationID
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getZoneByID($EntryZoneID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`entry_zone`.`EntryZoneID`,"
            . "`entry_zone`.`EntryZone` ,"
            . "`location`.`LocationID`,"
            . "`location`.`Location`,"
            . "`entry_zone`.`Status`"
            . "FROM `entry_zone`"
            . "inner join `location`"
            . "ON `entry_zone`.`LocationID`=`location`.`LocationID` "
            . "WHERE `entry_zone`.`EntryZoneID` = :EntryZoneID";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":EntryZoneID" => $EntryZoneID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
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

function editZone($EntryZoneID, $EntryZone, $LocationID, $Status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `entry_zone` SET "
            . "`EntryZone`=:EntryZone, "
            . "`LocationID`=:LocationID, "
            . "`Status`=:Status "
            . "WHERE `EntryZoneID`= :EntryZoneID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":EntryZone" => $EntryZone,
        ":LocationID" => $LocationID,
        ":Status" => $Status,
        ":EntryZoneID" => $EntryZoneID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

//<!--Catagory-->
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

function getCatagoryByID($PackageCategoryID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`PackageCategoryID`,"
            . "`PackageCategory`,"
            . "`Status`"
            . "FROM `customer_package_category`"
            . "WHERE `PackageCategoryID`= :packageCategoryID";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":packageCategoryID" => $PackageCategoryID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
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

function editCategory($PackageCategoryID, $PackageCategory, $Status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_package_category` SET "
            . "`PackageCategory`=:PackageCategory, "
            . "`Status`=:Status "
            . "WHERE `PackageCategoryID`= :PackageCategoryID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":PackageCategory" => $PackageCategory,
        ":Status" => $Status,
        ":PackageCategoryID" => $PackageCategoryID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

//<!--Position-->
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

//<!--Viewstaff-->
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

//<!--Businesstype-->
function getBusinessTypeByID($BusinessTypeID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`BusinessTypeID`, "
            . "`BusinessType`, "
            . "`Status` "
            . "FROM `customer_businesstype`"
            . "WHERE `BusinessTypeID`= :BusinessTypeID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":BusinessTypeID" => $BusinessTypeID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
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

function editBusinesstype($BusinessTypeID, $BusinessType, $Status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_businesstype` SET "
            . "`BusinessType`=:BusinessType, "
            . "`Status`=:Status "
            . "WHERE `BusinessTypeID`= :BusinessTypeID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":BusinessType" => $BusinessType,
        ":Status" => $Status,
        ":BusinessTypeID" => $BusinessTypeID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

//<!--Location-->
function getLocationByID($LocationID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`LocationID`, "
            . "`Location`, "
            . "`Address`, "
            . "`Status` "
            . "FROM `location`"
            . "WHERE `LocationID`= :LocationID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":LocationID" => $LocationID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function addLocation($Location, $Address, $Status) {
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

function editLocation($LocationID, $Location, $Address, $Status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `location` SET "
            . "`Location`=:Location, "
            . "`Address`=:Address, "
            . "`Status`=:Status "
            . "WHERE `LocationID`= :LocationID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Location" => $Location,
        ":Address" => $Address,
        ":Status" => $Status,
        ":LocationID" => $LocationID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}




//<!--Division-->
function getDivision() {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`DivisionID`,"
            . "`Division`,"
            . "`Organization`,"
            . "`Address`, "
            . "`Status` "
            . "FROM `customer_person_staff_division`"
            . "ORDER BY Organization ";
    
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getDivisionByID($DivisionID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            . "`DivisionID`,"
            . "`Division`,"
            . "`Organization`,"
            . "`Address`, "
            . "`Status` "
            . "FROM `customer_person_staff_division`"
            . "WHERE `DivisionID`= :DivisionID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":DivisionID" => $DivisionID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function addDivision($Division,$Organization,$Address,$Status) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `customer_person_staff_division`(`Division`, `Organization`, `Address`, `Status`) "
            . "VALUES (:Division,:Organization,:Address,:Status)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Division" => $Division,
        ":Organization" => $Organization,
        ":Address" => $Address,
        ":Status" => $Status
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}
function editDivision($DivisionID, $Division,$Organization, $Address, $Status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_person_staff_division` SET "
            . "`Division`=:Division, "
            . "`Organization`=:Organization, "
            . "`Address`=:Address, "
            . "`Status`=:Status "
            . "WHERE `DivisionID`= :DivisionID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Division" => $Division,
        ":Organization" => $Organization,
        ":Address" => $Address,
        ":Status" => $Status,
        ":DivisionID" => $DivisionID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
