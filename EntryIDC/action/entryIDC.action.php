<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$PersonID_login = $_SESSION['Account']['PersonID'];


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

    $EntryID = addEntry($getPersonID, $visitCard, $IDCCard, $IDCCardType, $datetimeIN, NULL, $purpose, $internet, $locationID, $PersonID_login);
    if ($EntryID > 0) {
        $EquipmentID = addEquipment($items, $EntryID); //Add Equipment
        addZoneDetail($EntryID, $zoneArr); // Add Zone Detail
        header("Location: ../../core/?p=entryIDCShowHome&para=addEntrySuccess");
    } else {
        header("Location: ../../core/?p=entryIDCForm&personID=" . $getPersonID . "&type=" . $personType . "&isPerson=1&para=addEntryError");
    }
} else if ($para == "CheckOut") {
    require_once dirname(__FILE__) . '/../../account/function/account.func.inc.php';
    $Permission = array("admin", "frontdesk", "helpdesk");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $Username = $_SESSION['Account']['Username'];
    $account = checkLogin($Username);
    if ($account !== FALSE) {
        $Position = $account['Position'];
        $chkPermission = array_search($Position, $Permission);
        if ($chkPermission === FALSE) {
            echo "0";
        } else {
            $entryID = $_GET['entryID'];
            $res = checkOutEntry($entryID, $PersonID_login);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        }
    } else {
        echo "0";
    }
} else if ($para == "getOutEquipment") {
    $equipmentID = $_GET['equipmentID'];
    $entryID = $_POST['entryID'];
    $res = checkOutEquipment($entryID, $equipmentID);
    if ($res) {
        header("Location: ../../core/?p=entryIDCShowEquipment&para=checkOutEquipmentSuccess");
    } else {
        header("Location: ../../core/?p=entryIDCShowEquipment&para=checkOutEquipmentError");
    }
} else if ($para == "cancelGetOutEquipment") {
    $equipmentID = $_GET['equipmentID'];

    $res = cancelCheckOutEquipment($equipmentID);
    if ($res) {
        echo "<br><br><br><center><h3 class='text-success'>Cancel check out equipment success</h3></center><br><br><br>";
    } else {
        echo "<br><br><br><center><h3 class='text-danger'>Cancel check out equipment error</h3></center><br><br><br>";
    }
} 