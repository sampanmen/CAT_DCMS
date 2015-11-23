<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$PersonID_login = "-1";

if ($para == "assignIP") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $IPID = $_GET['ipid'];
    $Status = "Active";
//    $res = assignIP($ip, $orderDetailID, $PersonID_login);
    $res = addIPUsed($IPID, $ServiceDetailID, $Status, $PersonID_login);
    if ($res) {
        echo "Assign completed.";
    } else
        echo "Assign isn't complete.";
}else if ($para == "assignIPNull") {
    $IPID = $_GET['ip'];
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $Status = "Deactive";
//    $res = assignIPNull($ipid, $PersonID_login);
    $res = addIPUsed($IPID, $ServiceDetailID, $Status, $PersonID_login);
    if ($res) {
        echo "Remove IP completed.";
    } else
        echo "Can not remove IP.";
}else if ($para == "assignPort") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $PortID = $_GET['portID'];
    $Status = "Active";
//    $resAssignPort = assignPort($portID, $orderDetailID, $PersonID_login);
    $resAssignPort = addSwitchPortUsed($ServiceDetailID, $PortID, $Status, $PersonID_login);
    if ($resAssignPort) {
        echo "Assign completed.";
    } else {
        echo "Assign isn't complete.";
    }
} else if ($para == "assignPortNull") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $PortID = $_GET['portID'];
    $Status = "Deactive";
//    $resAssignNullPort = assignPortNull($portID, $PersonID_login);
    $resAssignNullPort = addSwitchPortUsed($ServiceDetailID, $PortID, $Status, $PersonID_login);
    if ($resAssignNullPort) {
        echo "Remove completed.";
    } else {
        echo "Can not remove.";
    }
} else if ($para == "assignRack") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $SubRackID = $_GET['SubRackID'];
    $Status = "Active";
    $resAssignRack = addRackUsed($ServiceDetailID, $SubRackID, $Status, $PersonID_login);
//    $resAssignRack = assignRack($rackID, $ServiceDetailID, $PersonID_login);
    if ($resAssignRack) {
        echo "Assign completed.";
    } else {
        echo "Assign isn't complete.";
    }
} else if ($para == "assignRackNull") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $SubRackID = $_GET['SubRackID'];
    $Status = "Deactive";
    $resAssignRack = addRackUsed($ServiceDetailID, $SubRackID, $Status, $PersonID_login);
//    $resAssignNullRack = assignRackNull($rackID, $PersonID_login);
    if ($resAssignNullRack) {
        echo "Remove completed.";
    } else {
        echo "Can not remove.";
    }
}