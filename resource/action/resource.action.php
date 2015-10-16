<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "addIP") {
    $network = $_POST['network'];
    $subnet = $_POST['subnet'];
    $vlan = $_POST['vlan'];
    $ips = genIPs($network, $subnet);
    $res = addIP($ips, $vlan, $personID);
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

    $res = addSwitch($name, $ip, $commu, $typeSW, $totalport, $typePort, $uplinkArr, $vlanArr, $personID);

    if ($res) {
        header("Location: ../../core/?p=viewPort&para=addSwitchPortSuccess");
    } else {
        header("Location: ../../core/?p=viewPort&para=addSwitchPortError");
    }
} else if ($para == "addRack") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $size = $_POST['size'];
    $type = $_POST['type'];
    $zone = $_POST['zone'];
    $amount = $_POST['amount'];
    $position = 1;
    $subposition = 1;

    if (getLastPosition($zone) !== false) {
        $position = getLastPosition($zone) + 1;
    }

    switch ($type) {
        case "full rack" :
            $subposition = 1;
            break;
        case "1/2 rack" :
            $subposition = 2;
            break;
        case "1/4 rack" :
            $subposition = 4;
            break;
        case "shared rack" :
            $subposition = $size;
            break;
    }

    for ($i = 0; $i < $amount; $i++) {
        for ($j = 0; $j < $subposition; $j++) {
            addRack($zone, $position + $i, $j + 1, $type, $size, $personID);
        }
    }

    echo "Add. OK";
    header("Location: ../../core/?p=viewRack&para=addRackSuccess");
} else if ($para == "addService") {
    
} else if ($para == "assignIP") {
    $orderDetailID = $_GET['orderDetailID'];
    $ip = $_GET['ip'];
    $res = assignIP($ip, $orderDetailID, $personID);
    if ($res) {
        echo "Assign completed.";
    } else
        echo "Assign isn't complete.";
}else if ($para == "assignIPNull") {
    $ip = $_GET['ip'];
    $res = assignIPNull($ip, $personID);
    if ($res) {
        echo "Remove IP completed.";
    } else
        echo "Can not remove IP.";
}