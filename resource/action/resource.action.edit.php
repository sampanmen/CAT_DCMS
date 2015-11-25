<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$PersonID_login = $_SESSION['Account']['PersonID'];

if ($para == "editSwitch") {
    $SwitchID = $_GET['SwitchID'];
    $LocationID = $_GET['LocationID'];

    $name = $_POST['name'];
    $ip = $_POST['ip'];
    $commu = $_POST['commu'];
    $typeID = $_POST['typeSW'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serialNo = $_POST['serialNo'];
    $rackID = $_POST['rackID'];
    $status = $_POST['status'];

    $result = editSwitch($SwitchID, $name, $ip, $commu, $typeID, $brand, $model, $serialNo, $rackID, $status, $PersonID_login);
    if ($result) {
        header("Location: ../../core/?p=viewPort&para=editSwitchSuccess&LocationID=$LocationID&SwitchID=$SwitchID");
    } else {
        header("Location: ../../core/?p=viewPort&para=editSwitchError&LocationID=$LocationID&SwitchID=$SwitchID");
    }
} else if ($para == "editNetwork") {
    $NetworkID = $_GET['NetworkID'];
    $LocationID = $_GET['LocationID'];

    $vlan = $_POST['vlan'];
    $status = $_POST['status'];

    $result = editNetwork($NetworkID, $vlan, $status, $PersonID_login);
    if ($result) {
        header("Location: ../../core/?p=viewIP&para=editNetworkSuccess&LocationID=$LocationID&NetworkID=$NetworkID");
    } else {
        header("Location: ../../core/?p=viewIP&para=editNetworkError&LocationID=$LocationID&NetworkID=$NetworkID");
    }
} else if ($para == "editRackPosition") {
    $RackPositionID = $_GET['RackPositionID'];
    $LocationID = $_GET['LocationID'];

    $col = $_POST['col'];
    $row = $_POST['row'];
    $status = $_POST['status'];

    $result = editRackPosition($RackPositionID, $col, $row, $status, $PersonID_login);
    if ($result) {
        header("Location: ../../core/?p=viewRack&para=editRackPositionSuccess&LocationID=$LocationID&RackPositionID=$RackPositionID");
    } else {
        header("Location: ../../core/?p=viewRack&para=editRackPositionError&LocationID=$LocationID&RackPositionID=$RackPositionID");
    }
} else {
    echo "<pre>";
    echo "POST";
    print_r($_POST);
    echo "<br>GET";
    print_r($_GET);
    echo "</pre>";
}