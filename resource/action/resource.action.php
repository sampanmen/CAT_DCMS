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
    
} else if ($para == "addRack") {
    
} else if ($para == "addService") {
    
}