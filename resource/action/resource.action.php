<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$PersonID_login = "-1";

if ($para == "addIP") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $NetworkIP = $_POST['network'];
    $Subnet = $_POST['subnet'];
    $Vlan = $_POST['vlan'];
    $LocationID = $_POST['Location'];
    $Status = "Active";
    $ips = genIPs($NetworkIP, $Subnet);
    $AmountIP = count($ips);
    $NetworkID = addIPNetwork($NetworkIP, $Subnet, $Vlan, $AmountIP, $Status, $LocationID, $PersonID_login);
    $res = addIP($ips, $NetworkID, NULL);

    if ($res) {
        header("Location: ../../core/?p=viewIP&para=addIPSuccess");
    } else {
        header("Location: ../../core/?p=viewIP&para=addIPError");
    }
} else if ($para == "addSwitch") {
//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";

    $name = $_POST['name'];
    $ip = $_POST['ip'];
    $commu = $_POST['commu'];
    $typeSW = $_POST['typeSW'];
    $typePort = $_POST['typePort'];
    $totalport = $_POST['port'];
    $uplinks = $_POST['uplink'];
    $vlans = $_POST['vlan'];

    $vlanArr = explode(",", $vlans);
    $uplinkArr = explode(",", $uplinks);

//    echo "<pre>";
//    print_r($vlanArr);
//    print_r($uplinkArr);
//    echo "</pre>";

    $res = addSwitch($name, $ip, $commu, $typeSW, $totalport, $typePort, $uplinkArr, $vlanArr, $PersonID_login);

    if ($res) {
        header("Location: ../../core/?p=viewPort&para=addSwitchPortSuccess");
    } else {
        header("Location: ../../core/?p=viewPort&para=addSwitchPortError");
    }
} else if ($para == "addRack") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $RackSize = $_POST['size'];
    $RackType = $_POST['type'];
    $Col = $_POST['col'];
    $amount = $_POST['amount'];
    $LocationID = $_POST['location'];
    $Status = "Active";
    $Row = 1;
    $SubRackPosition = 1;

    if (getLastRow($Col, $LocationID) !== false) {
        $Row = getLastRow($Col, $LocationID)['Row'] + 1;
    }

    switch ($RackType) {
        case "Full Rack" :
            $SubRackPosition = 1;
            break;
        case "1/2 Rack" :
            $SubRackPosition = 2;
            break;
        case "1/4 Rack" :
            $SubRackPosition = 4;
            break;
        case "Shared Rack" :
            $SubRackPosition = $RackSize;
            break;
    }

    for ($i = 0; $i < $amount; $i++) {
        echo $RackPositionID = addRackPosition($Col, $Row + $i, $RackType, $RackSize, $Status, NULL, $LocationID, $PersonID_login);
        for ($j = 0; $j < $SubRackPosition; $j++) {
            echo addRack($RackPositionID, $j + 1, NULL);
        }
    }

    echo "Add. OK";
    header("Location: ../../core/?p=viewRack&para=addRackSuccess");
} else if ($para == "addService") {
    
} else if ($para == "assignIP") {
    $orderDetailID = $_GET['orderDetailID'];
    $ip = $_GET['ip'];
    $res = assignIP($ip, $orderDetailID, $PersonID_login);
    if ($res) {
        echo "Assign completed.";
    } else
        echo "Assign isn't complete.";
}else if ($para == "assignIPNull") {
    $ip = $_GET['ip'];
    $res = assignIPNull($ip, $PersonID_login);
    if ($res) {
        echo "Remove IP completed.";
    } else
        echo "Can not remove IP.";
}else if ($para == "assignPort") {
    $orderDetailID = $_GET['orderDetailID'];
    $portID = $_GET['portID'];
    $resAssignPort = assignPort($portID, $orderDetailID, $PersonID_login);
    if ($resAssignPort) {
        echo "Assign completed.";
    } else {
        echo "Assign isn't complete.";
    }
} else if ($para == "assignPortNull") {
    $portID = $_GET['portID'];
    $resAssignNullPort = assignPortNull($portID, $PersonID_login);
    if ($resAssignNullPort) {
        echo "Remove completed.";
    } else {
        echo "Can not remove.";
    }
} else if ($para == "assignRack") {
    $orderDetailID = $_GET['orderDetailID'];
    $rackID = $_GET['rackID'];
    $resAssignRack = assignRack($rackID, $orderDetailID, $personID);
    if ($resAssignRack) {
        echo "Assign completed.";
    } else {
        echo "Assign isn't complete.";
    }
} else if ($para == "assignRackNull") {
    $rackID = $_GET['rackID'];
    $resAssignNullRack = assignRackNull($rackID, $PersonID_login);
    if ($resAssignNullRack) {
        echo "Remove completed.";
    } else {
        echo "Can not remove.";
    }
}if ($para == "addResourceService") {
    $servicename = $_POST['servicename'];
    $servicedetail = $_POST['servicedetail'];
    $serviceamount = $_POST['serviceamount'];
    $servicetag = $_POST['servicetag'];
    $servicelocation = $_POST['servicelocation'];

    $res = addResourceService($servicename, $servicedetail, $servicetag, null, null, null, null, null, null, $servicelocation);
    if ($res) {
        header("location: ../../core/?p=resourceHome&para=addResourceServiceCompleted");
    } else {
        header("location: ../../core/?p=resourceHome&para=addResourceServiceFailed");
    }
} 