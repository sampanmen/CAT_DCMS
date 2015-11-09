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
        "Zipcode" => $Zipcode, "Country" => $Country, "CreateBy" => $PersonID, "UpdateBy" => $PersonID
    ));

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

function editPerson($personID, $Fname, $Lname, $Phone, $Email, $IDCard, $type, $status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_person` SET "
            . "`Fname`=:Fname,"
            . "`Lname`=:Lname,"
            . "`Phone`=:Phone,"
            . "`Email`=:Email,"
            . "`IDCard`=:IDCard,"
            . "`TypePerson`=:TypePerson,"
            . "`PersonStatus`=:PersonStatus "
            . "WHERE `PersonID`= :personID;";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":Fname" => $Fname,
        ":Lname" => $Lname,
        ":Phone" => $Phone,
        ":Email" => $Email,
        ":IDCard" => $IDCard,
        ":TypePerson" => $type,
        ":PersonStatus" => $status,
        ":personID" => $personID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function editContactType($personID, $ContactType) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_person_contact` SET "
            . "`ContactType`=:ContactType "
            . "WHERE `PersonID`= :personID;";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":ContactType" => $ContactType,
        ":personID" => $personID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function editContact($personID, $IDCCard, $IDCCardType, $ContactType) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_person_contact` SET "
            . "`IDCCard`=:IDCCard,"
            . "`IDCCardType`=:IDCCardType,"
            . "`ContactType`=:ContactType "
            . "WHERE `PersonID`= :personID;";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":IDCCard" => $IDCCard,
        ":IDCCardType" => $IDCCardType,
        ":ContactType" => $ContactType,
        ":personID" => $personID
    ));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function getPerson($personID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`IDCard`, "
            . "`TypePerson`, "
            . "`PersonStatus` "
            . "FROM `customer_person` "
            . "WHERE `PersonID` = :personID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":personID" => $personID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getStaffByPosition($position) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, "
            . "`PersonStaffID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`IDCard`, "
            . "`EmployeeID`, "
            . "`StaffPositionID`, "
            . "`Position`, "
            . "`TypePerson`, "
            . "`PersonStatus` "
            . "FROM `view_staff` "
            . "WHERE `Position` LIKE :position ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":position" => $position
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getStaff($personID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, "
            . "`PersonStaffID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`IDCard`, "
            . "`EmployeeID`, "
            . "`StaffPositionID`, "
            . "`Position`, "
            . "`TypePerson`, "
            . "`PersonStatus` "
            . "FROM `view_staff` "
            . "WHERE `PersonID`= :personID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":personID" => $personID
    ));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getPersonByType($type) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`IDCard`, "
            . "`TypePerson`, "
            . "`PersonStatus` "
            . "FROM `customer_person` "
            . "WHERE `TypePerson` LIKE :type ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":type" => $type
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
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
            . "WHERE `CustomerID` = :cusID AND `PersonStatus` NOT LIKE 'Delete' "
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
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`IDCard`, "
            . "`TypePerson`, "
            . "`CustomerID`, "
            . "`CustomerName`,"
            . "`IDCCard`, "
            . "`IDCCardType`, "
            . "`ContactType`, "
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

function editPackage($packageID, $name, $detail, $type, $categoryID, $locationID, $status, $personID) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer_package` "
            . "SET "
            . "`PackageName`= :PackageName,"
            . "`PackageDetail`= :PackageDetail,"
            . "`PackageType`= :PackageType,"
            . "`PackageCategoryID`= :PackageCategoryID,"
            . "`PackageStatus`= :PackageStatus,"
            . "`UpdateBy`= :personID,"
            . "`LocationID`= :LocationID "
            . "WHERE `PackageID` = :PackageID;";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":PackageName" => $name,
        ":PackageDetail" => $detail,
        ":PackageType" => $type,
        ":PackageCategoryID" => $categoryID,
        ":PackageStatus" => $status,
        ":personID" => $personID,
        ":LocationID" => $locationID,
        ":PackageID" => $packageID
    ));
    return $SQLPrepare->rowCount();
}

function getPackages() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageDetail`, "
            . "`PackageType`, "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "`PackageStatus`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`LocationID`, "
            . "`Location` "
            . "FROM `view_package` ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPackageCategory() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "`Status` "
            . "FROM `customer_package_category` ";
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
    $SQLCommand = "SELECT "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageDetail`, "
            . "`PackageType`, "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "`PackageStatus`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`LocationID`, "
            . "`Location` "
            . "FROM `view_package` "
            . "WHERE `PackageID`= :packageID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":packageID" => $packageID));
    return $SQLPrepare->fetch(PDO::FETCH_ASSOC);
}

function addService($CustomerID, $Location, $CreateBy) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_service`(`CustomerID`, `LocationID`, `CreateBy`) "
            . "VALUES (:CustomerID,:LocationID,:CreateBy)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        "CustomerID" => $CustomerID,
        "LocationID" => $Location,
        "CreateBy" => $CreateBy));

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

function addServiceDetail($ServiceID, $PackageID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_service_detail`(`ServiceID`, `PackageID`) "
            . "VALUES (:ServiceID, :PackageID)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array("ServiceID" => $ServiceID, "PackageID" => $PackageID));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

function addServiceDetailAction($ServiceDetailID, $Status, $cause) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `customer_service_detail_action`(`ServiceDetailID`, `Status`, `Cause`) "
            . "VALUES (:ServiceDetailID, :Status, :Cause)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":ServiceDetailID" => $ServiceDetailID,
        ":Status" => $Status,
        ":Cause" => $cause
    ));

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else
        return false;
}

//function getOrderAmountPackage($orderID, $type) {
//    $conn = dbconnect();
//    $SQLCommand = "SELECT `PackageType`,count(`PackageType`) AS `Amount` "
//            . "FROM `cus_order_detail` "
//            . "INNER JOIN `cus_package` "
//            . "ON `cus_order_detail`.`PackageID`=`cus_package`.`PackageID` "
//            . "WHERE `OrderID`= :orderID AND `PackageType` LIKE :addon AND `cus_order_detail`.`OrderDetailStatus` NOT LIKE 'delete' "
//            . "GROUP BY `PackageType`,`OrderID`";
//    $SQLPrepare = $conn->prepare($SQLCommand);
//    $SQLPrepare->execute(array(":orderID" => $orderID, ":addon" => $type));
//    $res = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
//    return $res['Amount'];
//}

function getServiceByCustomerID($customerID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`ServiceID`, "
            . "`CustomerID`, "
            . "`DateTimeService`, "
            . "SUM(case when `PackageType`='Main' then 1 else 0 end) AS `sumMain` , "
            . "SUM(case when `PackageType`='Add-on' then 1 else 0 end) AS `sumAddOn` , "
            . "`CreateBy` "
            . "FROM `view_service` "
            . "WHERE `CustomerID`= :customerID AND `Status`='Active' "
            . "GROUP BY `ServiceID` "
            . "ORDER BY `ServiceID` DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":customerID" => $customerID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getServiceDetailByCustomerID($customerID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`ServiceID`, "
            . "`CustomerID`, "
            . "`DateTimeService`, "
            . "`CreateBy`, "
            . "`a`.`ServiceDetailID`, "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageType`, "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "`LocationID`, "
            . "`Location`, "
            . "`Status`, "
            . "`b`.`DateTimeAction` "
            . "FROM `view_service` AS `a` inner join (SELECT `ServiceDetailID`, MAX(`DateTimeAction`) AS `DateTimeAction` FROM `view_service` GROUP BY `ServiceDetailID`) AS `b` on `a`.`ServiceDetailID`=`b`.`ServiceDetailID` AND `a`.`DateTimeAction`=`b`.`DateTimeAction` "
            . "WHERE `CustomerID` LIKE :customerID "
            . "ORDER BY `b`.`DateTimeAction` DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":customerID" => $customerID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function editCustomer($cusID, $status, $CustomerName, $bisstype, $Email, $Phone, $Fax, $Address, $Township, $City, $Province, $Zipcode, $Country, $personID) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `customer` SET "
            . "`CustomerStatus`=:CustomerStatus,"
            . "`CustomerName`=:CustomerName,"
            . "`BusinessTypeID`=:BusinessTypeID,"
            . "`Email`=:Email,"
            . "`Phone`=:Phone,"
            . "`Fax`=:Fax,"
            . "`Address`=:Address,"
            . "`Township`=:Township,"
            . "`City`=:City,"
            . "`Province`=:Province,"
            . "`Zipcode`=:Zipcode,"
            . "`Country`=:Country,"
            . "`UpdateBy`=:personID "
            . "WHERE `CustomerID`= :CustomerID";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":CustomerID" => $cusID,
        ":CustomerStatus" => $status,
        ":CustomerName" => $CustomerName,
        ":BusinessTypeID" => $bisstype,
        ":Email" => $Email,
        ":Phone" => $Phone,
        ":Fax" => $Fax,
        ":Address" => $Address,
        ":Township" => $Township,
        ":City" => $City,
        ":Province" => $Province,
        ":Zipcode" => $Zipcode,
        ":Country" => $Country,
        ":personID" => $personID
    ));

    if ($SQLPrepare->rowCount()) {
        return true;
    } else {
        return false;
    }
}

function getServiceDetailByServiceID($serviceID, $type) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`ServiceID`, "
            . "`CustomerID`, "
            . "`DateTimeService`, "
            . "`CreateBy`, "
            . "`ServiceDetailID`, "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageType`, "
            . "`Status`, "
            . "`DateTimeAction` "
            . "FROM `view_service` "
            . "WHERE `PackageType`= :type AND `ServiceID`= :ServiceID "
            . "GROUP BY `ServiceDetailID`"
            . "ORDER BY `ServiceDetailID` ASC, `DateTimeAction` DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":ServiceID" => $serviceID,
        ":type" => $type
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getServiceDetailStatus($serviceDetailID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`Status` "
            . "FROM `customer_service_detail_action` "
            . "WHERE `ServiceDetailID` = :ServiceDetailID "
            . "ORDER BY `DateTime` DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":ServiceDetailID" => $serviceDetailID
    ));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['Status'];
}

function getServiceDetailCountByCategory($cusID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "SUM(case when `Status`='Active' then 1 else 0 end) AS `sumActive` , "
            . "SUM(case when `Status`='Suppened' then 1 else 0 end) AS `sumSuppened`, "
            . "SUM(case when `Status`='Deactive' then 1 else 0 end) AS `sumDeactive` "
            . "FROM `view_service` AS `a` inner join (SELECT `ServiceDetailID`, MAX(`DateTimeAction`) AS `DateTimeAction` FROM `view_service` GROUP BY `ServiceDetailID`) AS `b` on `a`.`ServiceDetailID`=`b`.`ServiceDetailID` AND `a`.`DateTimeAction`=`b`.`DateTimeAction` "
            . "WHERE `CustomerID`= :cusID "
            . "GROUP BY `CustomerID`,`a`.`PackageCategoryID` "
            . "ORDER BY `a`.`PackageCategoryID` ASC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":cusID" => $cusID
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getServiceDetailSummary($cusID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, "
            . "COUNT(`a`.`ServiceDetailID`) AS `total`, "
            . "SUM(case when `PackageType`='Main' then 1 else 0 end) AS `sumMain` , "
            . "SUM(case when `PackageType`='Add-on' then 1 else 0 end) AS `sumAddOn` , "
            . "SUM(case when `Status`='Active' then 1 else 0 end) AS `sumActive` , "
            . "SUM(case when `Status`='Suppened' then 1 else 0 end) AS `sumSuppened`, "
            . "SUM(case when `Status`='Deactive' then 1 else 0 end) AS `sumDeactive` "
            . "FROM `view_service` AS `a` inner join (SELECT `ServiceDetailID`, MAX(`DateTimeAction`) AS `DateTimeAction` FROM `view_service` GROUP BY `ServiceDetailID`) AS `b` on `a`.`ServiceDetailID`=`b`.`ServiceDetailID` AND `a`.`DateTimeAction`=`b`.`DateTimeAction` "
            . "WHERE `CustomerID`= :cusID "
            . "GROUP BY `CustomerID` ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":cusID" => $cusID
    ));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getServiceDetailLog($cusID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`ServiceID`, "
            . "`CustomerID`, "
            . "`DateTimeService`, "
            . "`CreateBy`, "
            . "`ServiceDetailID`, "
            . "`PackageID`, "
            . "`PackageName`, "
            . "`PackageType`, "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "`LocationID`, "
            . "`Location`, "
            . "`Status`, "
            . "`Cause`, "
            . "`DateTimeAction` "
            . "FROM `view_service` "
            . "WHERE `CustomerID` LIKE :cusID "
            . "ORDER BY `DateTimeAction` DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":cusID" => $cusID
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//function getServiceDetailPackageByID($orderDetailID) {
//    $conn = dbconnect();
//    $SQLCommand = "SELECT "
//            . "`OrderDetailID`, "
//            . "`OrderID`, "
//            . "`OrderDetailStatus`, "
//            . "`DateTime`, "
//            . "`PackageID`, "
//            . "`PackageName`, "
//            . "`PackageType`, "
//            . "`PackageCategory` "
//            . "FROM `view_order_detail` "
//            . "WHERE `OrderDetailID`= :orderDetailID ";
//    $SQLPrepare = $conn->prepare($SQLCommand);
//    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
//    return $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
//}

function editStatusOrderDetail($orderDetailID, $status) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `cus_order_detail` SET `OrderDetailStatus`= :status WHERE `OrderDetailID`= :orderDetailID";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID, ":status" => $status));
    return $SQLPrepare->rowCount();
}

function getLocation() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`LocationID`, "
            . "`Location`, "
            . "`Address`, "
            . "`Status` "
            . "FROM `location`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getBusinessType() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`BusinessTypeID`, "
            . "`BusinessType`, "
            . "`Status` "
            . "FROM `customer_businesstype`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function searchCustomer($text) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`BusinessTypeID`, "
            . "`BusinessType`, "
            . "`cusEmail`, "
            . "`cusPhone`, "
            . "`Fax`, "
            . "`Address`, "
            . "`Township`, "
            . "`City`, "
            . "`Province`, "
            . "`Zipcode`, "
            . "`Country`, "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`conPhone`, "
            . "`conEmail`, "
            . "`IDCard`, "
            . "`TypePerson`, "
            . "`IDCCard`, "
            . "`IDCCardType`, "
            . "`ContactType` "
            . "FROM `view_customer_contact` "
            . "WHERE "
            . "MATCH (`CustomerName`, `cusEmail`, `cusPhone`, `Fax`, `Address`, `Township`, `City`, `Province`, `Zipcode`, `Country`) AGAINST (:text IN NATURAL LANGUAGE MODE) OR "
            . "MATCH (`Fname`, `Lname`, `conPhone`, `conEmail`,`IDCard`) AGAINST (:text IN NATURAL LANGUAGE MODE) OR "
            . "MATCH (`BusinessType`) AGAINST (:text IN NATURAL LANGUAGE MODE) OR MATCH (`IDCCard`) AGAINST (:text IN NATURAL LANGUAGE MODE) OR "
            . "`CustomerID` = :text ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":text" => $text));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}


function getZone() {
    $conn = dbconnect();
    $SQLCommand = "SELECT"
            ."`entry_zone`.`EntryZoneID`," 
            ."`entry_zone`.`EntryZone` ,"
            ."`location`.`Location`,'" 
            ."`entry_zone`.`Status`"
            ."FROM `entry_zone`"
            ."inner join `location`"
            ."ON `entry_zone`.`LocationID`=`location`.`LocationID`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
