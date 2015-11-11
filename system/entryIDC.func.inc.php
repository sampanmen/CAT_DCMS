<?php

function addEntry($PersonID, $VisitorCardID, $IDCard, $IDCCard, $IDCCardType, $EmpID, $TimeIn, $TimeOut, $Purpose, $InternetAccount, $personID_) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry`(`PersonID`, `VisitorCardID`, `IDCard`, `IDCCard`, `IDCCardType`, `EmpID`, `TimeIn`, `TimeOut`, `Purpose`, `InternetAccount`,`CreateBy`, `UpdateBy`) "
            . "VALUES (:PersonID, :VisitorCardID, :IDCard, :IDCCard, :IDCCardType, :EmpID, :TimeIn, :TimeOut, :Purpose, :InternetAccount, :personID_, :personID_)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PersonID" => $PersonID,
                ":VisitorCardID" => $VisitorCardID,
                ":IDCard" => $IDCard,
                ":IDCCard" => $IDCCard,
                ":IDCCardType" => $IDCCardType,
                ":EmpID" => $EmpID,
                ":TimeIn" => $TimeIn,
                ":TimeOut" => $TimeOut,
                ":Purpose" => $Purpose,
                ":InternetAccount" => $InternetAccount,
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
        return true;
    } else
        return false;
}

function addEquipment($equipmentArr) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_equipment`(`Equipment`, `Brand`, `Model`, `SerialNo`, `RackID`) "
            . "VALUES (:Equipment, :Brand, :Model, :SerialNo, :RackID)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $count = count($itemsArr['brand']);
    for ($i = 0; $i < $count; $i++) {
        $Equipment = $itemsArr['name'][$i];
        $Brand = $itemsArr['brand'][$i];
        $Model = $itemsArr['model'][$i];
        $SerialNo = $itemsArr['serialno'][$i];
        $RackID = $itemsArr['rackID'][$i];

        $SQLPrepare->execute(
                array(
                    ":Equipment" => $Equipment,
                    ":Brand" => $Brand,
                    ":Model" => $Model,
                    ":SerialNo" => $SerialNo,
                    ":RackID" => $RackID
                )
        );
    }
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function addEquipmentDetail($EquipmentID, $EntryID, $EquipmentAction, $DateTime) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_equipment_detail`(`EquipmentID`, `EntryID`, `EquipmentAction`, `DateTime`) "
            . "VALUES (:EquipmentID, :EntryID, :EquipmentAction, :DateTime)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":EquipmentID" => $EquipmentID,
                ":EntryID" => $EntryID,
                ":EquipmentAction" => $EquipmentAction, //Action has "in,out"
                ":DateTime" => $DateTime
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function updatePerson($PersonID, $Fname, $Lname, $Phone, $Email, $IDCard) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `customer_person` SET "
            . "`Fname`=:Fname,"
            . "`Lname`=:Lname,"
            . "`Phone`=:Phone,"
            . "`Email`=:Email,"
            . "`IDCard`=:IDCard "
            . "WHERE `PersonID`=:PersonID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PersonID" => $PersonID,
                ":Fname" => $Fname,
                ":Lname" => $Lname,
                ":Phone" => $Phone,
                ":Email" => $Email,
                ":IDCard" => $IDCard
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function updateContact($personID, $IDCCard, $IDCCardType) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `customer_person_contact` SET "
            . "`IDCCard`=:IDCCard,"
            . "`IDCCardType`=:IDCCardType "
            . "WHERE `PersonID`=:PersonID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PersonID" => $personID,
                ":IDCCard" => $IDCCard,
                ":IDCCardType" => $IDCCardType
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function updateStaff($PersonID, $EmployeeID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `customer_person_staff` SET "
            . "`EmployeeID`=:EmployeeID "
            . "WHERE `PersonID`=:PersonID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PersonID" => $PersonID,
                ":EmployeeID" => $EmployeeID
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

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
            . "`Division`"
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
            . "`Division`"
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

function getOutEntry($entryID) {
    $con = dbconnect();
    $SQLCommand = "";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":entryID" => $entryID));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getEntryByID($entryID) {
    $con = dbconnect();
    $SQLCommand = "";
//    echo $SQLCommand;
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":entryID" => $entryID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getZoneByEntryID($entryID) {
    $con = dbconnect();
    $SQLCommand = "";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":entryID" => $entryID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
