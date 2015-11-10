<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "addEntryIDC") {

    echo "<pre>";
    print_r($_POST);
    print_r($_GET);
    echo "</pre>";

    $getPersonID = $_POST['personID'];
    $personType = $_GET['personType'];
    $cusID = isset($_POST['cusID']) ? $_POST['cusID'] : "";
    $EmpID = isset($_POST['EmpID']) ? $_POST['EmpID'] : "";
    $visitCard = $_POST['visitCard'];
    $IDCCard = $_POST['IDCCard'];
    $IDCCardType = $_POST['IDCCardType'];
    $IDCard = $_POST['IDCard'];
    $conName = $_POST['conName'];
    $conLname = $_POST['conLname'];
    $conEmail = $_POST['conEmail'];
    $cusName = $_POST['cusName'];
    $conPhone = $_POST['conPhone'];
    $purpose = $_POST['purpose'];
    $locationID = $_POST['locationID'];

    //items
//    $item_name = $_POST['item_name'];
//    $item_brand = $_POST['item_brand'];
//    $item_model = $_POST['item_model'];
//    $item_serialno = $_POST['item_serialno'];
//    $item_rackID = $_POST['item_rackID'];
//
//    $items['name'] = $item_name;
//    $items['brand'] = $item_brand;
//    $items['model'] = $item_model;
//    $items['serialno'] = $item_serialno;
//    $items['rackID'] = $item_rackID;
    //end item
    //internet
    $internet = $_POST['internet'];
    $internetJson = json_encode($internet);
    //end internet

    $area = $_POST['area'];
    $datetime = $_POST['datetime'];

    $res = addEntryIDC($conID, $EmpID, $visitCard, $IDCard, $IDCCard, $IDCCardType, $datetime, $purpose, $internetJson, $personID, $items, $area);
    if ($res > 0) {
        header("Location: ../../core/?p=entryBeforePrint&entryID=" . $res . "&contactID=" . $conID . "&para=addEntrySuccess");
    } else {
        header("Location: ../../core/?p=entryIDCForm&contactID=" . $conID . "&para=addEntryError");
    }
} else if ($para == "checkOut") {
    $entryID = $_GET['entryID'];
    $res = checkOut($entryID);
    if ($res) {
        echo "1";
    } else {
        echo "0";
    }
}