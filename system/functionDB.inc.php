<?php
include_once 'config.inc.php';

// function DB
function dbconnect() {
    global $connection;
    if (!$connection) {
        $connection = new PDO(DSN, DBUSER, DBPASS);
        $connection->query("SET NAMES UTF8");
    }
}

function insertCustomer($PrefixID, $CustomerName, $Email, $Phone, $Fax, $Address, $Township, $City, $Province, $Zipcode, $Country, $BusinessTypeID) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_customer`(`CustomerStatus`, `PrefixID`, `CustomerName`, `Email`, `Phone`, `Fax`, `Address`, `Township`, `City`, `Province`, `Zipcode`, `Country`, `BusinessTypeID`) "
            . "VALUES (:cusStatus,:cusPrefixID,:cusName,:cusEmail,:cusPhone,:cusFax,:cusAddress,:cusTownship,:cusCity,:cusProvince,:cusZipcode,:cusCountry,:cusBusinessTypeID)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusStatus" => "active", ":cusPrefixID" => $PrefixID, ":cusName" => $CustomerName, ":cusEmail" => $Email, ":cusPhone" => $Phone, ":cusFax" => $Fax, ":cusAddress" => $Address, ":cusTownship" => $Township, ":cusCity" => $City, ":cusProvince" => $Province, ":cusZipcode" => $Zipcode, ":cusCountry" => $Country, ":cusBusinessTypeID" => $BusinessTypeID));
    if ($SQLPrepare->rowCount()) {
        $cusID = $SQLPrepare->lastInsertId();
        return $cusID;
    } else {
        return false;
    }
}

function insertContact($Fname, $Lname, $Phone, $Email, $Password, $TypePerson, $IDCard, $Position, $CustomerID) {
    $SQLCommand = "INSERT INTO `cus_person`( `Fname`, `Lname`, `Phone`, `Email`, `Password`, `TypePerson`, `IDCard`, `Position`, `CustomerID`) "
            . "VALUES (:conFname,:conLname,:conPhone,:conEmail,:conPass,:conType,:conIDCard,:conPosition,:conCusID)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":conFname"=>$Fname,":conLname"=>$Lname,":conPhone"=>$Phone,":conEmail"=>$Email,":conPass"=>$Password,":conType"=>$TypePerson,":conIDCard"=>$IDCard,":conPosition"=>$Position,":conCusID"=>$CustomerID));
    return $SQLPrepare->rowCount();
}