<?php
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
    $SQLPrepare->execute(array(":cusStatus" => "1", ":cusPrefixID" => $PrefixID, ":cusName" => $CustomerName, ":cusEmail" => $Email, ":cusPhone" => $Phone, ":cusFax" => $Fax, ":cusAddress" => $Address, ":cusTownship" => $Township, ":cusCity" => $City, ":cusProvince" => $Province, ":cusZipcode" => $Zipcode, ":cusCountry" => $Country, ":cusBusinessTypeID" => $BusinessTypeID));
    
    if ($SQLPrepare->rowCount()) {
        $cusID = $connection->lastInsertId();
        return $cusID;
    } else {
        return false;
    }
}
function getCustomer(){
    global $connection;
    dbconnect();
    $SQLCommand="SELECT `CustomerID`, `PrefixID`, `CustomerName`, `BusinessType`, `Status` FROM `view_cus`";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)){
        array_push($resultArr, $result);
    }
    return $resultArr;
}
function checkEmail($email){
    global $connection;
    dbconnect();
    $SQLCommand="SELECT * FROM `cus_person` WHERE `Email` LIKE :email ";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array("email"=>$email));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    if($SQLPrepare->rowCount()>0){
        return 1;
    }
    else{
        return 0;
    }
}

function insertPerson($Fname, $Lname, $Phone, $Email, $Password, $TypePerson, $IDCard, $Position, $CustomerID) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_person`( `Fname`, `Lname`, `Phone`, `Email`, `Password`, `TypePerson`, `IDCard`, `Position`, `CustomerID`) "
            . "VALUES (:conFname,:conLname,:conPhone,:conEmail,:conPass,:conType,:conIDCard,:conPosition,:conCusID)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":conFname"=>$Fname,":conLname"=>$Lname,":conPhone"=>$Phone,":conEmail"=>$Email,":conPass"=>$Password,":conType"=>$TypePerson,":conIDCard"=>$IDCard,":conPosition"=>$Position,":conCusID"=>$CustomerID));
    return $SQLPrepare->rowCount();
}

function getBussinessTypeHTML(){
    global $connection;
    dbconnect();
    $SQLCommand="SELECT `BusinessTypeID`, `BusinessType` FROM `cus_customer_businesstype` WHERE `StatusBusinessType`='active'";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    
    while($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="'.$result['BusinessTypeID'].'">'.$result['BusinessType'].'</option>';
    }
}

function insertService($name,$detail,$type,$status) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_service`(`NameService`, `Detail`, `ServiceType`, `ServiceStatus`) "
            . "VALUES (:name,:detail,:type,:status)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":name"=>$name,":detail"=>$detail,":type"=>$type,":status"=>$status));
    return $connection->lastInsertId();
}