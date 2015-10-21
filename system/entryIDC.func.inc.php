<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function addEntryIDC($contactID, $VisitorCardID, $IDCard, $IDCCard, $IDCCardType, $TimeIn, $Purpose, $InternetAccount, $personID, $itemsArr, $zoneArr) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `entry_idc`(`PersonID`, `VisitorCardID`, `IDCard`, `IDCCard`, `IDCCardType`, `TimeIn`, `Purpose`, `InternetAccount`,  `CreateBy`, `UpdateBy`) "
            . "VALUES (:contactID, :VisitorCardID, :IDCard, :IDCCard, :IDCCardType, :TimeIn, :Purpose, :InternetAccount,  :personID, :personID)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":contactID" => $contactID, ":VisitorCardID" => $VisitorCardID, ":IDCard" => $IDCard, ":IDCCard" => $IDCCard, ":IDCCardType" => $IDCCardType, ":TimeIn" => $TimeIn, ":Purpose" => $Purpose, ":InternetAccount" => $InternetAccount, ":personID" => $personID));
    if ($SQLPrepare->rowCount() > 0) {
        $EntryIDC_ID = $con->lastInsertId();
//        echo "entryIDC_ID=" . $EntryIDC_ID . "<br>";
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
