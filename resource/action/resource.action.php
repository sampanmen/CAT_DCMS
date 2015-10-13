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
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

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

    $res = addSwitch($name, $ip, $commu, $typeSW, $totalport,$typePort, $uplinkArr, $vlanArr, $personID);
    
    if ($res) {
        header("Location: ../../core/?p=viewPort&para=addSwitchPortSuccess");
    } else {
        header("Location: ../../core/?p=viewPort&para=addSwitchPortError");
    }
} else if ($para == "addRack") {
    
} else if ($para == "addService") {
    
}