<?php

function addEntryIDC($contactID, $EmpID, $VisitorCardID, $IDCard, $IDCCard, $IDCCardType, $TimeIn, $Purpose, $InternetAccount, $personID, $itemsArr, $zoneArr) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_idc`(`PersonID`, `VisitorCardID`, `IDCard`, `IDCCard`, `IDCCardType`, `EmpID`, `TimeIn`, `Purpose`, `InternetAccount`,  `CreateBy`, `UpdateBy`) "
            . "VALUES (:contactID, :VisitorCardID, :IDCard, :IDCCard, :IDCCardType, :EmpID, :TimeIn, :Purpose, :InternetAccount,  :personID, :personID)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":contactID" => $contactID, "EmpID" => $EmpID, ":VisitorCardID" => $VisitorCardID, ":IDCard" => $IDCard, ":IDCCard" => $IDCCard, ":IDCCardType" => $IDCCardType, ":TimeIn" => $TimeIn, ":Purpose" => $Purpose, ":InternetAccount" => $InternetAccount, ":personID" => $personID));
    if ($SQLPrepare->rowCount() > 0) {
        $EntryIDC_ID = $con->lastInsertId();
//        echo "entryIDC_ID=" . $EntryIDC_ID . "<br>";
        updateContact($contactID, $EmpID, $IDCard, $IDCCard, $IDCCardType);
        addEntryIDCArea($EntryIDC_ID, $zoneArr);
        addEntryIDCItem($EntryIDC_ID, $itemsArr, $TimeIn);
        return $EntryIDC_ID;
    }
    return false;
}

function addEntryIDCArea($EntryIDC_ID, $zoneArr) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_idc_zone`( `EntryIDCID`, `Zone`) "
            . "VALUES (:EntryIDCID,:zone)";
    $SQLPrepare = $con->prepare($SQLCommand);
    foreach ($zoneArr as $value) {
        $SQLPrepare->execute(array(":EntryIDCID" => $EntryIDC_ID, ":zone" => $value));
    }
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function addEntryIDCItem($EntryIDC_ID, $itemsArr, $TimeIn) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `cus_item`(`EntryIDCID`, `Equipment`, `Brand`, `Model`, `SerialNo`, `RackID`, `TimeIn`) "
            . "VALUES (:EntryIDCID,:Equipment,:Brand,:Model,:SerialNo,:RackID,:TimeIn)";
    $SQLPrepare = $con->prepare($SQLCommand);
    for ($i = 0; $i < count($itemsArr['brand']); $i++) {
        $Equipment = $itemsArr['name'][$i];
        $Brand = $itemsArr['brand'][$i];
        $Model = $itemsArr['model'][$i];
        $SerialNo = $itemsArr['serialno'][$i];
        $RackID = $itemsArr['rackID'][$i];

        $SQLPrepare->execute(array(":EntryIDCID" => $EntryIDC_ID, ":Equipment" => $Equipment,
            ":Brand" => $Brand, ":Model" => $Model, ":SerialNo" => $SerialNo, ":RackID" => $RackID, ":TimeIn" => $TimeIn));
    }
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function updateContact($contactID, $EmpID, $IDCard, $IDCCard, $IDCCardType) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `cus_person` SET "
            . "`CatEmpID`=:EmpID,"
            . "`IDCard`=:IDCard,"
            . "`IDCCard`=:IDCCard,"
            . "`IDCCardType`=:IDCCardType "
            . "WHERE `PersonID`= :contactID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":contactID" => $contactID, ":EmpID" => $EmpID, ":IDCard" => $IDCard, ":IDCCard" => $IDCCard, ":IDCCardType" => $IDCCardType));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getEntryIDCNow() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`EntryIDCID`, "
            . "`TimeIn` "
            . "FROM `view_entry_idc` "
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

function checkOut($entryID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `entry_idc` SET `TimeOut` = NOW() WHERE `entry_idc`.`EntryIDCID` = :entryID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":entryID" => $entryID));
    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getEntryByID($entryID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`CustomerID`, "
            . "`CustomerName`, "
            . "`BusinessType`, "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Phone`, "
            . "`Email`, "
            . "`EntryIDCID`, "
            . "`VisitorCardID`, "
            . "`IDCard`, "
            . "`IDCCard`, "
            . "`IDCCardType`, "
            . "`EmpID`, "
            . "DATE(`TimeIn`) AS `DateIn`, "
            . "TIME(`TimeIn`) AS `TimeIn`, "
            . "DATE(`TimeOut`) AS `TimeOut`, "
            . "TIME(`TimeOut`) AS `TimeOut`, "
            . "`Purpose`, "
            . "`InternetAccount` "
            . "FROM `view_entry_idc` "
            . "WHERE `EntryIDCID`= :entryID";
//    echo $SQLCommand;
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":entryID" => $entryID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getEntryZone($entryID) {
    $con = dbconnect();
    $SQLCommand = "SELECT `EntryIDCZoneID`, `EntryIDCID`, `Zone` FROM `entry_idc_zone` WHERE `EntryIDCID`= :entryID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":entryID" => $entryID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
