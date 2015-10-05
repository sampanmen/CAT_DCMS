<?php

// function DB
function dbconnect() {
    global $connection;
    if (!$connection) {
        $connection = new PDO(DSN, DBUSER, DBPASS);
        $connection->query("SET NAMES UTF8");
    }
}

function addCustomer($PrefixID, $status, $CustomerName, $bisstype, $Email, $Phone, $Fax, $Address, $Township, $City, $Province, $Zipcode, $Country, $user) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_customer` (`PrefixID`, `CustomerStatus`, `CustomerName`, `BusinessType`, `Email`, `Phone`, `Fax`, `Address`, `Township`, `City`, `Province`, `Zipcode`, `Country`, `DateTimeCreate`, `DateTimeUpdate`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:prefix, :status, :name, :type, :email, :phone, :fax, :address, :township, :city, :province, :zipcode, :country, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :user, :user);";

    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":prefix" => $PrefixID, ":status" => $status, ":name" => $CustomerName, ":type" => $bisstype, ":email" => $Email, ":phone" => $Phone, ":fax" => $Fax, ":address" => $Address, ":township" => $Township, ":city" => $City, ":province" => $Province, ":zipcode" => $Zipcode, ":country" => $Country, ":user" => $user));

    if ($SQLPrepare->rowCount()) {
        $cusID = $connection->lastInsertId();
        return $cusID;
    } else {
        return false;
    }
}

function getCustomers() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, `PrefixID`, `CustomerStatus`, `CustomerName`, "
            . "`BusinessType`, `Email`, `Phone`, `Fax`, `Address`, `Township`, "
            . "`City`, `Province`, `Zipcode`, `Country`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` "
            . "FROM `cus_customer`";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getCustomer($cusID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, `PrefixID`, `CustomerStatus`, `CustomerName`, "
            . "`BusinessType`, `Email`, `Phone`, `Fax`, `Address`, `Township`, "
            . "`City`, `Province`, `Zipcode`, `Country`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` "
            . "FROM `cus_customer` WHERE `CustomerID`=:cusID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function checkEmail($email) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT * FROM `cus_person` WHERE `Email` LIKE :email ";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array("email" => $email));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    if ($SQLPrepare->rowCount() > 0) {
        return 1;
    } else {
        return 0;
    }
}

function addPerson($Fname, $Lname, $Phone, $Email, $Password, $empID, $IDCard, $type, $Position, $CustomerID) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_person` (`Fname`, `Lname`, `Phone`, `Email`, `CustomerID`, `Password`, `CatEmpID`, `IDCard`, `TypePerson`, `Position`) "
            . "VALUES (:name, :sname, :phone, :email, :cusID, :pass, :empID, :IDCard, :type, :position);";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":name" => $Fname, ":sname" => $Lname, ":phone" => $Phone, ":email" => $Email, ":pass" => $Password, ":empID" => $empID, ":IDCard" => $IDCard, ":type" => $type, ":position" => $Position, ":cusID" => $CustomerID));
    return $SQLPrepare->rowCount();
}

function getContactByCustomer($cusID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, `Fname`, `Lname`, `Phone`, `Email`, "
            . "`CustomerID`, `Password`, `CatEmpID`, `IDCard`, `TypePerson`, `Position` "
            . "FROM `cus_person` "
            . "WHERE `CustomerID` = :cusID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function insertService($name, $detail, $type, $status) {
//    global $connection;
//    dbconnect();
//    $SQLCommand = "INSERT INTO `cus_service`(`NameService`, `Detail`, `ServiceType`, `ServiceStatus`) "
//            . "VALUES (:name,:detail,:type,:status)";
//    $SQLPrepare = $connection->prepare($SQLCommand);
//    $SQLPrepare->execute(array(":name" => $name, ":detail" => $detail, ":type" => $type, ":status" => $status));
//    return $connection->lastInsertId();
}

function getService() {
//    global $connection;
//    dbconnect();
//    $SQLCommand = "SELECT `ServiceID`, `NameService`, `Detail`, `ServiceType`, `Status` FROM `view_service`";
//    $SQLPrepare = $connection->prepare($SQLCommand);
//    $SQLPrepare->execute();
//    $resultArr = array();
//    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
//        array_push($resultArr, $result);
//    }
//    return $resultArr;
}
