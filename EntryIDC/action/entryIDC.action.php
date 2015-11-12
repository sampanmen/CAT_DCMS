<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "addEntryIDC") {

//    echo "<pre>";
//    print_r($_POST);
//    print_r($_GET);
//    echo "</pre>";

    $isPerson = $_GET['isPerson'];

    $getPersonID = $_POST['personID'];
    $personType = $_GET['personType'];
    $cusID = isset($_POST['cusID']) ? $_POST['cusID'] : "";
    $EmpID = isset($_POST['EmpID']) ? $_POST['EmpID'] : NULL;
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
    $item_name = $_POST['item_name'];
    $item_brand = $_POST['item_brand'];
    $item_model = $_POST['item_model'];
    $item_serialno = $_POST['item_serialno'];
    $item_rackID = $_POST['item_rackID'];

    $items = array();
    $items['name'] = $item_name;
    $items['brand'] = $item_brand;
    $items['model'] = $item_model;
    $items['serialno'] = $item_serialno;
    $items['rackID'] = $item_rackID;
    //end item
    //
    //internet
    if (isset($_POST['internet'])) {
        $internet = $_POST['internet'];
        $internet = json_encode($internet);
    } else {
        $internet = NULL;
    }
    //end internet

    $zoneArr = $_POST['area'];
    $datetimeIN = $_POST['datetimeIN'];

    $EntryID = addEntry($getPersonID, $visitCard, $IDCard, $IDCCard, $IDCCardType, $EmpID, $datetimeIN, NULL, $purpose, $internet, $locationID, $personID);
    if ($EntryID > 0) {
        
        $EquipmentID = addEquipment($items); //Add Equipment
        addEquipmentDetail($EquipmentID, $EntryID, "in", $datetimeIN); // Add Equipment Detail
        
        addZoneDetail($EntryID, $zoneArr); // Add Zone Detail
        
        updatePerson($getPersonID, $conName, $conLname, $conPhone, $conEmail, $IDCard);
        if ($personType == "Contact") {
            updateContact($getPersonID, $IDCCard, $IDCCardType);
        } else if ($personType == "Staff") {
            updateStaff($getPersonID, $EmpID);
        }
        header("Location: ../../core/?p=entryIDCShow&para=addEntrySuccess");
    } else {
        header("Location: ../../core/?p=entryIDCForm&personID=" . $getPersonID . "&type=" . $personType . "&isPerson=1&para=addEntryError");
    }
} else if ($para == "CheckOut") {
    $entryID = $_GET['entryID'];
    $res = checkOutEntry($entryID, $personID);
    if ($res) {
        echo "1";
    } else {
        echo "0";
    }
} 