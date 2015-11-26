<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$PersonID_login = $_SESSION['Account']['PersonID'];

if ($para == "delSwitch") {
    $SwitchID = $_GET['SwitchID'];
    $result = delSwitch($SwitchID);
    if ($result) {
        header("Location: ../../core/?p=viewPort&para=deleteSwitchSuccess");
    } else {
        header("Location: ../../core/?p=viewPort&para=deleteSwitchError");
    }
} else if ($para == "delNetwork") {
    $NetworkID = $_GET['NetworkID'];
    $result = delNetwork($NetworkID);
    if ($result) {
        header("Location: ../../core/?p=viewIP&para=deleteNetworkSuccess");
    } else {
        header("Location: ../../core/?p=viewIP&para=deleteNetworkError");
    }
} else if ($para == "delRackPosition") {
    $RackPositionID = $_GET['RackPositionID'];
    $result = delRackPosition($RackPositionID);
    if ($result) {
        header("Location: ../../core/?p=viewRack&para=deleteRackPositionSuccess");
    } else {
        header("Location: ../../core/?p=viewRack&para=deleteRackPositionError");
    }
} else {
    echo "<pre>";
    echo "POST";
    print_r($_POST);
    echo "<br>GET";
    print_r($_GET);
    echo "</pre>";
}