<?php

function addEntry($PersonID, $VisitorCardID, $IDCCard, $IDCCardType, $TimeIn, $TimeOut, $Purpose, $InternetAccount, $locationID, $personID_) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry`(`PersonID`, `VisitorCardID`, `IDCCard`, `IDCCardType`, `TimeIn`, `TimeOut`, `Purpose`, `InternetAccount`, `LocationID`,`CreateBy`, `UpdateBy`) "
            . "VALUES (:PersonID, :VisitorCardID, :IDCCard, :IDCCardType, :TimeIn, :TimeOut, :Purpose, :InternetAccount, :LocationID, :personID_, :personID_)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PersonID" => $PersonID,
                ":VisitorCardID" => $VisitorCardID,
                ":IDCCard" => $IDCCard,
                ":IDCCardType" => $IDCCardType,
                ":TimeIn" => $TimeIn,
                ":TimeOut" => $TimeOut,
                ":Purpose" => $Purpose,
                ":InternetAccount" => $InternetAccount,
                ":LocationID" => $locationID,
                ":personID_" => $personID_
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        $EntryID = $con->lastInsertId();
        return $EntryID;
    }
    return false;
}

function addZoneDetail($EntryID, $zoneArr) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_zone_detail`(`EntryID`, `ZoneID`) "
            . "VALUES (:EntryID,:ZoneID)";
    $SQLPrepare = $con->prepare($SQLCommand);
    foreach ($zoneArr as $value) {
        $SQLPrepare->execute(
                array(
                    ":EntryID" => $EntryID,
                    ":ZoneID" => $value
                )
        );
    }
    if ($SQLPrepare->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addEquipment($equipmentArr, $entryID_in) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_equipment`(`Equipment`, `Brand`, `Model`, `SerialNo`, `RackID`,`EntryID_IN`) "
            . "VALUES (:Equipment, :Brand, :Model, :SerialNo, :RackID, :EntryID_IN)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $count = count($equipmentArr['brand']);
    for ($i = 0; $i < $count; $i++) {
        $Equipment = $equipmentArr['name'][$i];
        $Brand = $equipmentArr['brand'][$i];
        $Model = $equipmentArr['model'][$i];
        $SerialNo = $equipmentArr['serialno'][$i];
        $RackID = ($equipmentArr['rackID'][$i] != "-1") ? $equipmentArr['rackID'][$i] : NULL;

        $SQLPrepare->execute(
                array(
                    ":Equipment" => $Equipment,
                    ":Brand" => $Brand,
                    ":Model" => $Model,
                    ":SerialNo" => $SerialNo,
                    ":RackID" => $RackID,
                    ":EntryID_IN" => $entryID_in
                )
        );
    }
    if ($SQLPrepare->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

//function addEquipmentDetail($EquipmentID, $EntryID, $EquipmentAction, $DateTime) {
//    $con = dbconnect();
//    $SQLCommand = "INSERT INTO `entry_equipment_detail`(`EquipmentID`, `EntryID`, `EquipmentAction`, `DateTime`) "
//            . "VALUES (:EquipmentID, :EntryID, :EquipmentAction, :DateTime)";
//    $SQLPrepare = $con->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                ":EquipmentID" => $EquipmentID,
//                ":EntryID" => $EntryID,
//                ":EquipmentAction" => $EquipmentAction, //Action has "in,out"
//                ":DateTime" => $DateTime
//            )
//    );
//    if ($SQLPrepare->rowCount() > 0) {
//        return $con->lastInsertId();
//    } else
//        return false;
//}
//function updatePerson($PersonID, $Fname, $Lname, $Phone, $Email, $IDCard) {
//    $con = dbconnect();
//    $SQLCommand = "UPDATE `customer_person` SET "
//            . "`Fname`=:Fname,"
//            . "`Lname`=:Lname,"
//            . "`Phone`=:Phone,"
//            . "`Email`=:Email,"
//            . "`IDCard`=:IDCard "
//            . "WHERE `PersonID`=:PersonID";
//    $SQLPrepare = $con->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                ":PersonID" => $PersonID,
//                ":Fname" => $Fname,
//                ":Lname" => $Lname,
//                ":Phone" => $Phone,
//                ":Email" => $Email,
//                ":IDCard" => $IDCard
//            )
//    );
//    if ($SQLPrepare->rowCount() > 0) {
//        return true;
//    } else
//        return false;
//}
//function updateContact($personID, $IDCCard, $IDCCardType) {
//    $con = dbconnect();
//    $SQLCommand = "UPDATE `customer_person_contact` SET "
//            . "`IDCCard`=:IDCCard,"
//            . "`IDCCardType`=:IDCCardType "
//            . "WHERE `PersonID`=:PersonID";
//    $SQLPrepare = $con->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                ":PersonID" => $personID,
//                ":IDCCard" => $IDCCard,
//                ":IDCCardType" => $IDCCardType
//            )
//    );
//    if ($SQLPrepare->rowCount() > 0) {
//        return true;
//    } else
//        return false;
//}
//function updateStaff($PersonID, $EmployeeID) {
//    $con = dbconnect();
//    $SQLCommand = "UPDATE `customer_person_staff` SET "
//            . "`EmployeeID`=:EmployeeID "
//            . "WHERE `PersonID`=:PersonID";
//    $SQLPrepare = $con->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                ":PersonID" => $PersonID,
//                ":EmployeeID" => $EmployeeID
//            )
//    );
//    if ($SQLPrepare->rowCount() > 0) {
//        return true;
//    } else
//        return false;
//}

function getEntryNow() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`EntryID`, "
            . "`PersonID`, "
            . "`TimeIn`, "
            . "`TimeOut`, "
            . "`Purpose`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`TypePerson`, "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`Organization`, "
            . "`Division`,"
            . "`LocationID`, "
            . "`Location` "
            . "FROM `view_entry` "
            . "WHERE `TimeOut` IS NULL "
            . "ORDER BY `TimeIn` DESC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getEntryNowByCusID($cusID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`EntryID`, "
            . "`PersonID`, "
            . "`TimeIn`, "
            . "`TimeOut`, "
            . "`Purpose`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`TypePerson`, "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`Organization`, "
            . "`Division`,"
            . "`LocationID`, "
            . "`Location` "
            . "FROM `view_entry` "
            . "WHERE `CustomerID` = :cusID "
            . "ORDER BY `TimeIn` DESC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":cusID" => $cusID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getEntryLog() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`EntryID`, "
            . "`PersonID`, "
            . "`TimeIn`, "
            . "`TimeOut`, "
            . "`Purpose`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`TypePerson`, "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`Organization`, "
            . "`Division` ,"
            . "`LocationID`, "
            . "`Location` "
            . "FROM `view_entry` "
            . "WHERE 1 "
            . "ORDER BY `TimeIn` DESC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function checkOutEntry($entryID, $PersonID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `entry` SET "
            . "`TimeOut`= CURRENT_TIMESTAMP ,"
            . "`UpdateBy`=:UpdateBy "
            . "WHERE `EntryID`=:EntryID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":EntryID" => $entryID,
                ":UpdateBy" => $PersonID
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return 1;
    } else
        return 0;
}

function checkOutEquipment($entryID, $equipmentID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `entry_equipment` SET "
            . "`EntryID_OUT`=:EntryID_OUT "
            . "WHERE `EquipmentID`=:EquipmentID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":EntryID_OUT" => $entryID,
                ":EquipmentID" => $equipmentID
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else
        return FALSE;
}

function getEntryByID($entryID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`EntryID`, "
            . "`PersonID`, "
            . "`VisitorCardID`, "
            . "`IDCard`, "
            . "`IDCCard`, "
            . "`IDCCardType`, "
            . "`EmpID`, "
            . "`TimeIn`, "
            . "`TimeOut`, "
            . "`Purpose`, "
            . "`InternetAccount`, "
            . "`LocationID`, "
            . "`Location`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`TypePerson`, "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`Organization`, "
            . "`Division` "
            . "FROM `view_entry` "
            . "WHERE `EntryID`= :EntryID ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":EntryID" => $entryID
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getZoneByEntryID($entryID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`ZoneDetailID`, "
            . "`EntryID`, "
            . "`ZoneID` "
            . "FROM `entry_zone_detail` "
            . "WHERE `EntryID`= :EntryID ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":EntryID" => $entryID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result['ZoneID']);
    }
    return $resultArr;
}

function getEquipments() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`EquipmentID`, "
            . "`Equipment`, "
            . "`Brand`, "
            . "`Model`, "
            . "`SerialNo`, "
            . "`RackID`, "
            . "`CustomerID`, "
            . "`EntryID_IN`, "
            . "`TimeIn`, "
            . "`EntryID_OUT`, "
            . "`TimeOut`, "
            . "`ResourceRackID`, "
            . "`Col`, "
            . "`Row`, "
            . "`PositionRack` "
            . "FROM `view_equipment`";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
