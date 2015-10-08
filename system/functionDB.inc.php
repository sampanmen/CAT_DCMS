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
    $SQLCommand = "INSERT INTO `cus_customer` (`PrefixID`, `CustomerStatus`, "
            . "`CustomerName`, `BusinessType`, `Email`, `Phone`, `Fax`, `Address`, "
            . "`Township`, `City`, `Province`, `Zipcode`, `Country`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:prefix, :status, :name, :type, :email, :phone, :fax, "
            . ":address, :township, :city, :province, :zipcode, :country, "
            . "CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :user, :user);";

    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":prefix" => $PrefixID, ":status" => $status,
        ":name" => $CustomerName, ":type" => $bisstype, ":email" => $Email,
        ":phone" => $Phone, ":fax" => $Fax, ":address" => $Address,
        ":township" => $Township, ":city" => $City, ":province" => $Province,
        ":zipcode" => $Zipcode, ":country" => $Country, ":user" => $user));

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

function addPerson($Fname, $Lname, $Phone, $Email, $Password, $empID, $IDCard, $type, $Position, $CustomerID, $status) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_person` (`Fname`, `Lname`, `Phone`, `Email`, "
            . "`CustomerID`, `Password`, `CatEmpID`, `IDCard`, `TypePerson`, "
            . "`Position`,`PersonStatus`) "
            . "VALUES (:name, :sname, :phone, :email, :cusID, :pass, :empID, "
            . ":IDCard, :type, :position, :status);";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":name" => $Fname, ":sname" => $Lname,
        ":phone" => $Phone, ":email" => $Email, ":pass" => $Password,
        ":empID" => $empID, ":IDCard" => $IDCard, ":type" => $type,
        ":position" => $Position, ":cusID" => $CustomerID, ":status" => $status));
    if ($SQLPrepare->rowCount() > 0) {
        return $connection->lastInsertId();
    } else {
        return false;
    }
}

function editPerson($personID, $Fname, $Lname, $Phone, $Email, $Password, $empID, $IDCard, $type, $Position, $status) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `cus_person` SET `Fname`=:name,`Lname`=:sname,"
            . "`Phone`=:phone,`Email`=:email,`Password`=:pass,`CatEmpID`=:empID,"
            . "`IDCard`=:IDCard,`TypePerson`=:type,`Position`=:position,"
            . "`PersonStatus`=:status WHERE `cus_person`.`PersonID` = :personID;";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":name" => $Fname, ":sname" => $Lname,
        ":phone" => $Phone, ":email" => $Email, ":pass" => $Password,
        ":empID" => $empID, ":IDCard" => $IDCard, ":type" => $type,
        ":position" => $Position, ":status" => $status, ":personID" => $personID));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function getPerson($personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, `Fname`, `Lname`, `Phone`, `Email`, "
            . "`CustomerID`, `Password`, `CatEmpID`, `IDCard`, "
            . "`TypePerson`, `Position`, `PersonStatus` "
            . "FROM `cus_person` WHERE `PersonID` = :personID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":personID" => $personID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getContactByCustomer($cusID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, `Fname`, `Lname`, `Phone`, `Email`, "
            . "`CustomerID`, `Password`, `CatEmpID`, `IDCard`, `TypePerson`, "
            . "`Position` FROM `cus_person` "
            . "WHERE `CustomerID` = :cusID AND `PersonStatus` = 'active' "
            . "ORDER BY `cus_person`.`TypePerson` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function addPackage($name, $detail, $type, $category, $status, $ip, $port, $rack, $service, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_package` "
            . "(`PackageName`, `PackageDetail`, `PackageType`, "
            . "`PackageCategory`, `PackageStatus`, `IPAmount`, `PortAmount`, "
            . "`RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:name, :detail, :type, :category, :status, :ip, "
            . ":port, :rack, :service, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP,"
            . " :personID, :personID);";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":name" => $name, ":detail" => $detail, ":type" => $type,
        ":category" => $category, ":status" => $status, ":ip" => $ip, ":port" => $port,
        ":rack" => $rack, ":service" => $service, ":personID" => $personID));
    return $SQLPrepare->rowCount();
}

function editPackage($packageID, $name, $detail, $type, $category, $status, $ip, $port, $rack, $service, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `cus_package` SET "
            . "`PackageName` = :name, "
            . "`PackageDetail` = :detail, "
            . "`PackageType` = :type, "
            . "`PackageCategory` = :category, "
            . "`PackageStatus` = :status, "
            . "`IPAmount` = :ip, "
            . "`PortAmount` = :port, "
            . "`RackAmount` = :rack, "
            . "`ServiceAmount` = :service, "
            . "`UpdateBy` = :personID "
            . "WHERE `cus_package`.`PackageID` = :packageID;";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":packageID" => $packageID, ":name" => $name,
        ":detail" => $detail, ":type" => $type, ":category" => $category,
        ":status" => $status, ":ip" => $ip, ":port" => $port,
        ":rack" => $rack, ":service" => $service, ":personID" => $personID));
    return $SQLPrepare->rowCount();
}

function getPackages() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `PackageID`, `PackageName`, `PackageDetail`, "
            . "`PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, "
            . "`PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` FROM `cus_package` "
            . "ORDER BY `cus_package`.`PackageStatus` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPackagesActive() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `PackageID`, `PackageName`, `PackageDetail`, "
            . "`PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, "
            . "`PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` "
            . "FROM `cus_package` WHERE `PackageStatus` LIKE 'active' "
            . "ORDER BY `cus_package`.`PackageStatus` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPackage($packageID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `PackageID`, `PackageName`, `PackageDetail`, "
            . "`PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, "
            . "`PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` FROM `cus_package` "
            . "WHERE `PackageID`= :ID";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ID" => $packageID));
    $resultArr = array();
    return $SQLPrepare->fetch(PDO::FETCH_ASSOC);
}

function addOrder($preID, $oldID, $cusID, $location, $status, $personID, $bundle, $package) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `cus_order`(`OrderPreID`, `OrderIDOld`, `CustomerID`, `Location`, `StatusOrder`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:preID,:oldID,:cusID,:location,:status,:personID,:personID)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":preID" => $preID, ":oldID" => $oldID, ":cusID" => $cusID,
        ":location" => $location, ":status" => $status, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {

        $orderID = $connection->lastInsertId();

        // start insert bundle
        $SQLCommand = "INSERT INTO `cus_order_bundle_network`( `OrderID`, `BundleNetwork`) VALUES (:orderID,:bundle)";
        $SQLPrepare = $connection->prepare($SQLCommand);
        foreach ($bundle as $value) {
            $SQLPrepare->execute(array(":orderID" => $orderID, ":bundle" => $value));
        }
        // end insert bundle
        // start insert package
        $SQLCommand = "INSERT INTO `cus_order_detail`(`OrderID`, `PackageID`, `OrderDetailStatus`, `CreateBy`, `UpdateBy`) "
                . "VALUES (:orderID, :packageID, :status, :personID, :personID)";
        $SQLPrepare = $connection->prepare($SQLCommand);
        for ($i = 0; $i < count($package['ID']); $i++) {
            for ($j = 0; $j < $package['amount'][$i]; $j++) {
                $SQLPrepare->execute(array(":orderID" => $orderID, ":packageID" => $package['ID'][$i], ":status" => $status, ":personID" => $personID));
            }
        }
        // end insert package
    }
    return true;
}

function getOrderAmountPackage($orderID, $type) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `PackageType`,count(`PackageType`) AS `Amount` "
            . "FROM `cus_order_detail` "
            . "INNER JOIN `cus_package` "
            . "ON `cus_order_detail`.`PackageID`=`cus_package`.`PackageID` "
            . "WHERE `OrderID`= :orderID AND `PackageType` LIKE :addon "
            . "GROUP BY `PackageType`,`OrderID`";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderID" => $orderID, ":addon" => $type));
    $res = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $res['Amount'];
}

function getOrderByCusID($cusID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `OrderID`, "
            . "`OrderPreID`, "
            . "`OrderIDOld`, "
            . "`CustomerID`, "
            . "`Name`, "
            . "`Location`, "
            . "`StatusOrder`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy` "
            . "FROM `cus_order` "
            . "WHERE `CustomerID`= :cusID "
            . "ORDER BY `cus_order`.`StatusOrder` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID"=>$cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}