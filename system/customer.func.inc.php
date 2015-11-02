<?php

// function DB
function addCustomer($CustomerStatus, $CustomerName, $BusinessTypeID, $Email, $Phone, $Fax, $Address, $Township, $City, $Province, $Zipcode, $Country, $PersonID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer`"
            . "(`CustomerStatus`,`CustomerName`,`BusinessTypeID`,`Email`,`Phone`,`Fax`,`Address`,"
            . "`Township`,`City`,`Province`,`Zipcode`,`Country`,`CreateBy`,`UpdateBy`) "
            . "VALUES "
            . "(:CustomerStatus, :CustomerName, :BusinessTypeID, :Email, :Phone, :Fax, :Address, "
            . ":Township, :City, :Province, :Zipcode, :Country, :CreateBy, :UpdateBy)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("CustomerStatus" => $CustomerStatus, "CustomerName" => $CustomerName,
        "BusinessTypeID" => $BusinessTypeID, "Email" => $Email, "Phone" => $Phone, "Fax" => $Fax,
        "Address" => $Address, "Township" => $Township, "City" => $City, "Province" => $Province,
        "Zipcode" => $Zipcode, "Country" => $Country, "CreateBy" => $PersonID, "UpdateBy" => $PersonID));

    if ($SQLPrepare->rowCount() > 0) {
        $cusID = $conn->lastInsertId();
        return $cusID;
    } else {
        echo $SQLCommand;
        return false;
    }
}

function getCustomers() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `CustomerID`, `CustomerStatus`, `CustomerName`, `Email`, `Phone`, `Fax`, `Address`, `Township`, `City`, `Province`, `Zipcode`, `Country`, `BusinessTypeID`, `BusinessType`, `CreateDateTime`, `UpdateDateTime`, `CreateBy`, `UpdateBy` FROM `view_customer`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getCustomer($cusID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, "
            . "`CustomerStatus`, "
            . "`CustomerName`, "
            . "`BusinessTypeID`, "
            . "`BusinessType`, "
            . "`Email`, "
            . "`Phone`, "
            . "`Fax`, "
            . "`Address`, "
            . "`Township`, "
            . "`City`, "
            . "`Province`, "
            . "`Zipcode`, "
            . "`Country`, "
            . "`CreateDateTime`, "
            . "`UpdateDateTime`, "
            . "`CreateBy`, "
            . "`UpdateBy` "
            . "FROM `view_customer` "
            . "WHERE `CustomerID`= :cusID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//function checkEmail($email) {
//    $conn = dbconnect();
//    $SQLCommand = "SELECT * FROM `cus_person` WHERE `Email` LIKE :email ";
//    $SQLPrepare = $conn->prepare($SQLCommand);
//    $SQLPrepare->execute(array("email" => $email));
//    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
//    if ($SQLPrepare->rowCount() > 0) {
//        return 1;
//    } else {
//        return 0;
//    }
//}

function addPerson($Fname, $Lname, $Phone, $Email, $IDCard, $TypePerson, $PersonStatus) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_person`"
            . "(`Fname`, `Lname`, `Phone`, `Email`, `IDCard`, `TypePerson`, `PersonStatus`) "
            . "VALUES "
            . "(:Fname, :Lname, :Phone, :Email, :IDCard, :TypePerson, :PersonStatus)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("Fname" => $Fname, "Lname" => $Lname, "Phone" => $Phone, "Email" => $Email, "IDCard" => $IDCard, "TypePerson" => $TypePerson, "PersonStatus" => $PersonStatus));
    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function addContact($CustomerID, $PersonID, $IDCCard, $IDCCardType, $ContactType) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_person_contact`"
            . "(`CustomerID`, `PersonID`, `IDCCard`, `IDCCardType`, `ContactType`) "
            . "VALUES "
            . "(:CustomerID, :PersonID, :IDCCard, :IDCCardType, :ContactType)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("CustomerID" => $CustomerID, "PersonID" => $PersonID,
        "IDCCard" => $IDCCard, "IDCCardType" => $IDCCardType, "ContactType" => $ContactType));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function addAccount($PersonID, $Username, $Password) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `account`(`PersonID`, `Username`, `Password`) "
            . "VALUES (:PersonID, :Username, :Password)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("PersonID" => $PersonID, "Username" => $Username, "Password" => $Password));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function addStaff($PersonID, $EmployeeID, $StaffPositionID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_person_staff`(`PersonID`, `EmployeeID`, `StaffPositionID`) "
            . "VALUES (:PersonID, :EmployeeID, :StaffPositionID)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":PersonID" => $PersonID, ":EmployeeID" => $EmployeeID, ":StaffPositionID" => $StaffPositionID));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function editPerson($personID, $Fname, $Lname, $Phone, $Email, $Password, $empID, $IDCard, $type, $Position, $status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `cus_person` SET `Fname`=:name,`Lname`=:sname,"
            . "`Phone`=:phone,`Email`=:email,`Password`=:pass,`CatEmpID`=:empID,"
            . "`IDCard`=:IDCard,`TypePerson`=:type,`Position`=:position,"
            . "`PersonStatus`=:status WHERE `cus_person`.`PersonID` = :personID;";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
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
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, `Fname`, `Lname`, `Phone`, `Email`, "
            . "`CustomerID`, `Password`, `CatEmpID`, `IDCard`, "
            . "`TypePerson`, `Position`, `PersonStatus` "
            . "FROM `cus_person` WHERE `PersonID` = :personID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":personID" => $personID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getContactByCustomer($cusID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`IDCard`, "
            . "`TypePerson`, "
            . "`CustomerID`, "
            . "`IDCCard`, "
            . "`IDCCardType`, "
            . "`ContactType`, "
            . "`PersonStatus` "
            . "FROM `view_contact` "
            . "WHERE `CustomerID` = :cusID AND `PersonStatus`='Active' "
            . "ORDER BY `view_contact`.`PersonID` ASC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getContactByPersonID($personID_) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`cusID`, "
            . "`prefixID`, "
            . "`cusStatus`, "
            . "`cusName`, "
            . "`cusType`, "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`Password`, "
            . "`CatEmpID`, "
            . "`IDCard`, "
            . "`IDCCard`, "
            . "`IDCCardType`, "
            . "`TypePerson`, "
            . "`Position`, "
            . "`PersonStatus` "
            . "FROM `view_contact` "
            . "WHERE `PersonID`= :personID_";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":personID_" => $personID_));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function addPackage($PackageName, $PackageDetail, $PackageType, $PackageCategoryID, $PackageStatus, $PersonID, $LocationID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_package`"
            . "(`PackageName`, `PackageDetail`, `PackageType`, `PackageCategoryID`, `PackageStatus`, `CreateBy`, `UpdateBy`, `LocationID`) "
            . "VALUES "
            . "(:PackageName, :PackageDetail, :PackageType, :PackageCategoryID, :PackageStatus, :CreateBy, :UpdateBy, :LocationID)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("PackageName" => $PackageName, "PackageDetail" => $PackageDetail,
        "PackageType" => $PackageType, "PackageCategoryID" => $PackageCategoryID, "PackageStatus" => $PackageStatus,
        "CreateBy" => $PersonID, "UpdateBy" => $PersonID, "LocationID" => $LocationID));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

function editPackage($packageID, $name, $detail, $type, $category, $status, $ip, $port, $rack, $service, $personID) {
    $conn = dbconnect();
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
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":packageID" => $packageID, ":name" => $name,
        ":detail" => $detail, ":type" => $type, ":category" => $category,
        ":status" => $status, ":ip" => $ip, ":port" => $port,
        ":rack" => $rack, ":service" => $service, ":personID" => $personID));
    return $SQLPrepare->rowCount();
}

function getPackages() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `PackageID`, `PackageName`, `PackageDetail`, "
            . "`PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, "
            . "`PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` FROM `cus_package` "
            . "ORDER BY `cus_package`.`PackageStatus` ASC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPackagesActive() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `PackageID`, `PackageName`, `PackageDetail`, "
            . "`PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, "
            . "`PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` "
            . "FROM `cus_package` WHERE `PackageStatus` LIKE 'active' "
            . "ORDER BY `cus_package`.`PackageCategory`,`cus_package`.`PackageType` DESC ,`cus_package`.`PackageName` ASC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPackage($packageID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `PackageID`, `PackageName`, `PackageDetail`, "
            . "`PackageType`, `PackageCategory`, `PackageStatus`, `IPAmount`, "
            . "`PortAmount`, `RackAmount`, `ServiceAmount`, `DateTimeCreate`, "
            . "`DateTimeUpdate`, `CreateBy`, `UpdateBy` FROM `cus_package` "
            . "WHERE `PackageID`= :ID";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ID" => $packageID));
    return $SQLPrepare->fetch(PDO::FETCH_ASSOC);
}

function addService($CustomerID, $Name, $Location, $PersonID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_order`(`CustomerID`, `Name`, `Location`, `CreateBy`) "
            . "VALUES "
            . "(:CustomerID, :Name, :Location, :CreateBy)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("CustomerID" => $CustomerID, "Name" => $Name,
        "Location" => $Location, "CreateBy" => $PersonID));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

function addNetworkLink() {
    $conn = dbconnect();
    $SQLCommand = "";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array());

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

function addServiceDetail($OrderID, $PackageID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_order_detail`(`OrderID`, `PackageID`) "
            . "VALUES (:OrderID, :PackageID)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("OrderID" => $OrderID, "PackageID" => $PackageID));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

function addServiceDetailAction($ServiceDetailID,$Action){
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_service_detail_action`(`ServiceDetailID`, `Action`) "
            . "VALUES (:ServiceDetailID, :Action)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ServiceDetailID" => $ServiceDetailID, ":Action" => $Action));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

function getOrderAmountPackage($orderID, $type) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `PackageType`,count(`PackageType`) AS `Amount` "
            . "FROM `cus_order_detail` "
            . "INNER JOIN `cus_package` "
            . "ON `cus_order_detail`.`PackageID`=`cus_package`.`PackageID` "
            . "WHERE `OrderID`= :orderID AND `PackageType` LIKE :addon AND `cus_order_detail`.`OrderDetailStatus` NOT LIKE 'delete' "
            . "GROUP BY `PackageType`,`OrderID`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderID" => $orderID, ":addon" => $type));
    $res = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $res['Amount'];
}

function getOrderByCusID($cusID) {
    $conn = dbconnect();
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
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function editCustomer($cusID, $status, $CustomerName, $bisstype, $Email, $Phone, $Fax, $Address, $Township, $City, $Province, $Zipcode, $Country, $personID) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `cus_customer` SET "
            . "`CustomerID`= :cusID,"
            . "`CustomerStatus`=:status,"
            . "`CustomerName`= :name,"
            . "`BusinessType`= :type,"
            . "`Email`= :email,"
            . "`Phone`= :phone,"
            . "`Fax`= :fax,"
            . "`Address`= :address,"
            . "`Township`= :township,"
            . "`City`= :city,"
            . "`Province`= :province,"
            . "`Zipcode`= :zipcode,"
            . "`Country`= :country,"
            . "`UpdateBy`= :personID "
            . "WHERE `CustomerID`= :cusID";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID, ":status" => $status, ":name" => $CustomerName,
        ":type" => $bisstype, ":email" => $Email, ":phone" => $Phone,
        ":fax" => $Fax, ":address" => $Address, ":township" => $Township,
        ":city" => $City, ":province" => $Province, ":zipcode" => $Zipcode,
        ":country" => $Country, ":personID" => $personID));

    if ($SQLPrepare->rowCount()) {
        return true;
    } else {
        return false;
    }
}

function getOrderDetailByOrderID($orderID, $type) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`OrderDetailID`, "
            . "`OrderID`, "
            . "`OrderDetailStatus`, "
            . "`DateTime`, "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageType`, "
            . "`PackageCategory`, "
            . "`IPAmount`, "
            . "`PortAmount`, "
            . "`RackAmount`, "
            . "`ServiceAmount`"
            . "FROM `view_order_detail` "
            . "WHERE `OrderID` = :orderID AND `PackageType` LIKE :type AND `OrderDetailStatus` NOT LIKE 'delete' "
            . "ORDER BY `view_order_detail`.`OrderDetailStatus`,`view_order_detail`.`DateTime` ASC";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderID" => $orderID, ":type" => $type));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getOrderDetailPackageByID($orderDetailID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`OrderDetailID`, "
            . "`OrderID`, "
            . "`OrderDetailStatus`, "
            . "`DateTime`, "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageType`, "
            . "`PackageCategory` "
            . "FROM `view_order_detail` "
            . "WHERE `OrderDetailID`= :orderDetailID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    return $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
}

function editStatusOrderDetail($orderDetailID, $status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `cus_order_detail` SET `OrderDetailStatus`= :status WHERE `OrderDetailID`= :orderDetailID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID, ":status" => $status));
    return $SQLPrepare->rowCount();
}
