<?php

function addIP($ipArr, $vlan, $personID) {
    global $connection;
    dbconnect();
    $sqlCommand = "INSERT INTO `resource_ip`( `IP`, `NetworkIP`, `Subnet`, `VlanID`, `EnableResourceIP`, `OrderDetailID`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:ip , :network , :subnet , :vlan , 1 , NULL , :personID , :personID )";
    $res = $connection->prepare($sqlCommand);
    foreach ($ipArr as $ip) {
        $res->execute(array(":ip" => $ip['ip'], ":network" => $ip['network'], ":subnet" => $ip['subnet'], ":vlan" => $vlan, ":personID" => $personID));
    }
    $rows = $res->rowCount();
    if ($rows > 0) {
        return true;
    } else {
        return false;
    }
}

function genIPs($network, $subnet) {
    $ipAdd = $network;
    $subnet = (int) $subnet;
    $ipAddArr = explode('.', $ipAdd);
    if (count($ipAddArr) == 4) {
        $ip[] = (int) $ipAddArr[0];
        $ip[] = (int) $ipAddArr[1];
        $ip[] = (int) $ipAddArr[2];
        $ip[] = (int) $ipAddArr[3];
        $number = pow(2, 32 - $subnet);
        $arrIP = array();
        for ($index = 0; $index < $number - 2; $index++) {
            $ip[3] ++;
            if ($ip[3] == 256) {
                $ip[3] = 0;
                $ip[2] ++;
                if ($ip[2] == 256) {
                    $ip[2] = 0;
                    $ip[1] ++;
                    if ($ip[1] == 256) {
                        $ip[1] = 0;
                        $ip[0] ++;
                    }
                }
            }
            $ipRes = $ip[0] . '.' . $ip[1] . '.' . $ip[2] . '.' . $ip[3];
            array_push($arrIP, array("ip" => $ipRes, "network" => $network, "subnet" => $subnet));
        }
    }
    return $arrIP;
}

function getNetworks() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `NetworkIP`, `Subnet`, `VlanID` FROM `view_ip` GROUP BY `NetworkIP` ORDER BY `view_ip`.`NetworkIP` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getNetworksValue() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`NetworkIP`, "
            . "SUM(case when `OrderDetailID` IS NULL then 1 else 0 end) AS `balance` "
            . "FROM `resource_ip` "
            . "GROUP BY `NetworkIP` "
            . "ORDER BY `NetworkIP` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getIPs($network) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `IP`, `NetworkIP`, `Subnet`, `VlanID`, `EnableResourceIP`, "
            . "`OrderDetailID`, `DateTimeCreate`, `DateTimeUpdate`, `CreateBy`, "
            . "`UpdateBy`, `OrderID`, `PackageID`, `CustomerID`, `Location`, "
            . "`CustomerName`, `BusinessType` "
            . "FROM `view_ip` WHERE `NetworkIP` LIKE :network ";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":network" => $network));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getIPsByOrderDetailID($orderDetailID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`IP`, "
            . "`NetworkIP`, "
            . "`Subnet`, "
            . "`VlanID`, "
            . "`EnableResourceIP`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`OrderID`, "
            . "`PackageID`, "
            . "`CustomerID`, "
            . "`Location`, "
            . "`CustomerName`, "
            . "`BusinessType` "
            . "FROM `view_ip` "
            . "WHERE `OrderDetailID` = :orderDetailID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function addSwitch($name, $ip, $commu, $type, $totalport, $typePort, $uplinkArr, $vlanArr, $personID) {
    global $connection;
    dbconnect();
    $sqlCommand = "INSERT INTO `resource_switch`( `SwitchName`, `SwitchIP`, `TotalPort`, `SnmpCommuPublic`, `SnmpCommuPrivate`, `SwitchType`, `EnableResourceSW`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:name,:ip,:totalport,:commu,NULL,:type,1,:personID,:personID)";
    $res = $connection->prepare($sqlCommand);
    $res->execute(array(":name" => $name, ":ip" => $ip, ":totalport" => $totalport, ":commu" => $commu, ":type" => $type, ":personID" => $personID));

    if ($res->rowCount() > 0) {
        $swID = $connection->lastInsertId();
        $resAddPort = addSwichPort($swID, $totalport, $typePort, $uplinkArr, $personID);
        $resAddVlan = addSwtichVlan($swID, $vlanArr);
        if ($resAddPort && $resAddVlan) {
            return true;
        } else
            return false;
    } else
        return false;
}

function addSwichPort($swID, $totalport, $typePort, $uplinkArr, $personID) {
    global $connection;
    dbconnect();
    $sqlCommand = "INSERT INTO `resource_switch_port`( `ResourceSwitchID`, `PortNumber`, `PortType`, `Uplink`, `EnableResourcePort`, `OrderDetailID`,  `CreateBy`, `UpdateBy`) "
            . "VALUES (:swID,:port,:typePort,:uplink,1,NULL,:personID,:personID)";
    $res = $connection->prepare($sqlCommand);

    for ($i = 1; $i <= $totalport; $i++) {
        (array_search($i, $uplinkArr) !== false) ? ($uplink = 1) : ($uplink = 0);
        $res->execute(array(":swID" => $swID, ":port" => $i, ":typePort" => $typePort, ":uplink" => $uplink, "personID" => $personID));
    }

    $rows = $res->rowCount();
    if ($rows > 0) {
        return true;
    } else {
        return false;
    }
}

function addSwtichVlan($swID, $vlanArr) {
    global $connection;
    dbconnect();
    $sqlCommand = "INSERT INTO `resource_switch_vlan`( `VlanNumber`, `SwitchID`) VALUES (:vlan,:swID)";
    $res = $connection->prepare($sqlCommand);
    foreach ($vlanArr as $value) {
        $res->execute(array(":swID" => $swID, ":vlan" => $value));
    }

    if ($res->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getSwitchs() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceSwitchID`, "
            . "`SwitchName`, "
            . "`SwitchIP`, "
            . "`TotalPort`, "
            . "`SnmpCommuPublic`, "
            . "`SnmpCommuPrivate`, "
            . "`SwitchType`, "
            . "`EnableResourceSW`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy` "
            . "FROM `resource_switch` "
            . "ORDER BY `SwitchName` ASC";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPortByOrderDetailID($orderDetailID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceSwitchPortID`, "
            . "`ResourceSwitchID`, "
            . "`PortNumber`, "
            . "`PortType`, "
            . "`Uplink`, "
            . "`EnableResourcePort`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`SwitchName`, "
            . "`SwitchIP`, "
            . "`TotalPort`, "
            . "`SnmpCommuPublic`, "
            . "`SwitchType`, "
            . "`EnableResourceSW`, "
            . "`OrderID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_switch_port`"
            . "WHERE `OrderDetailID` = :orderDetailID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSwitchPorts($swID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceSwitchPortID`, "
            . "`ResourceSwitchID`, "
            . "`PortNumber`, "
            . "`PortType`, "
            . "`Uplink`, "
            . "`EnableResourcePort`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`SwitchName`, "
            . "`SwitchIP`, "
            . "`TotalPort`, "
            . "`SnmpCommuPublic`, "
            . "`SwitchType`, "
            . "`EnableResourceSW`, "
            . "`OrderID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_switch_port` ";
    if ($swID != "") {
        $SQLCommand.="WHERE `ResourceSwitchID` = :swID "
                . "ORDER BY `SwitchName`,`PortNumber` ASC ";
        $SQLPrepare = $connection->prepare($SQLCommand);
        $SQLPrepare->execute(array(":swID" => $swID));
    } else {
        $SQLCommand.="ORDER BY `SwitchName`,`PortNumber` ASC ";
        $SQLPrepare = $connection->prepare($SQLCommand);
        $SQLPrepare->execute();
    }

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSwitchValue() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `ResourceSwitchID`, `SwitchName`, `balance` "
            . "FROM `view_switch_port_balance` ";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getLastPosition($zone) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `Zone`, `Position`, `SubPosition` "
            . "FROM `resource_rack` "
            . "WHERE `Zone` LIKE :zone "
            . "ORDER BY `Position` DESC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":zone" => $zone));
    if ($SQLPrepare->rowCount() > 0) {
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result['Position'];
    } else
        return false;
}

function addRack($zone, $position, $subposition, $type, $size, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `resource_rack`( `Zone`, `Position`, `SubPosition`, `RackType`, `RackSize`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:zone,:position,:subposition,:type,:size,:personID,:personID)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":zone" => $zone, ":position" => $position, ":subposition" => $subposition, ":type" => $type, ":size" => $size, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getRacks() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `Zone`, `Position`, `RackType`, `RackSize` "
            . "FROM `resource_rack` "
            . "GROUP BY `Zone`, `Position` "
            . "ORDER BY `Zone`,`Position` ASC";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackByCusID($cusID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceRackID`, "
            . "`Zone`, "
            . "`Position`, "
            . "`SubPosition`, "
            . "`RackType`, "
            . "`RackSize`, "
            . "`EnableResourceRack`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`OrderID`, "
            . "`PackageID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_rack` "
            . "WHERE `CustomerID`= :cusID ";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackValue($rackType) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`Zone`, "
            . "`Position`, "
            . "`RackType`, "
            . "SUM(case when `OrderDetailID` IS NULL then 1 else 0 end) AS `balance` "
            . "FROM `view_rack` "
            . "WHERE `EnableResourceRack` = 1 AND `RackType` LIKE :rackType "
            . "GROUP BY `Zone`, `Position`";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":rackType" => $rackType));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRacksDetail($zone, $type) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceRackID`, "
            . "`Zone`, "
            . "`Position`, "
            . "`SubPosition`, "
            . "`RackType`, "
            . "`RackSize`, "
            . "`EnableResourceRack`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`OrderID`, "
            . "`PackageID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_rack` ";
    $SQLCommand .= "WHERE `Zone` LIKE :zone AND `RackType` LIKE :type ORDER BY `Zone`, `Position`, `SubPosition` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":zone" => $zone, ":type" => $type));
//    if ($zone == "%" && $type == "%") {
//        $SQLCommand .= "WHERE `Zone` LIKE :zone ORDER BY `Zone`, `Position`, `SubPosition` ASC";
//        $SQLPrepare = $connection->prepare($SQLCommand);
//        $SQLPrepare->execute(array(":zone" => $zone, ":type" => $type));
//    } else {
//        $SQLCommand .= "ORDER BY `Zone`, `Position`, `SubPosition` ASC";
//        $SQLPrepare = $connection->prepare($SQLCommand);
//        $SQLPrepare->execute();
//    }

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRacksReserve($zone, $position, $type) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceRackID`, "
            . "`Zone`, "
            . "`Position`, "
            . "`SubPosition`, "
            . "`RackType`, "
            . "`RackSize`, "
            . "`EnableResourceRack`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`OrderID`, "
            . "`PackageID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_rack` ";
    $SQLCommand .= "WHERE `Zone` LIKE :zone AND `RackType` LIKE :type AND `Position` LIKE :position ORDER BY `Zone`, `Position`, `SubPosition` ASC";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":zone" => $zone, ":type" => $type, ":position" => $position));
//    if ($zone == "%" && $type == "%") {
//        $SQLCommand .= "WHERE `Zone` LIKE :zone ORDER BY `Zone`, `Position`, `SubPosition` ASC";
//        $SQLPrepare = $connection->prepare($SQLCommand);
//        $SQLPrepare->execute(array(":zone" => $zone, ":type" => $type));
//    } else {
//        $SQLCommand .= "ORDER BY `Zone`, `Position`, `SubPosition` ASC";
//        $SQLPrepare = $connection->prepare($SQLCommand);
//        $SQLPrepare->execute();
//    }

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackByOrderDetailID($orderDetailID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceRackID`, "
            . "`Zone`, "
            . "`Position`, "
            . "`SubPosition`, "
            . "`RackType`, "
            . "`RackSize`, "
            . "`EnableResourceRack`, "
            . "`OrderDetailID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`OrderID`, "
            . "`PackageID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_rack` "
            . "WHERE `OrderDetailID` = :orderDetailID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function assignRack($rackID, $orderDetailID, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_rack` SET `OrderDetailID`= :orderDetailID ,`UpdateBy`= :personID "
            . "WHERE `ResourceRackID` = :rackID";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":rackID" => $rackID, ":orderDetailID" => $orderDetailID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignRackNull($rackID, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_rack` SET `OrderDetailID`= NULL,`UpdateBy`= :personID "
            . "WHERE `ResourceRackID`= :rackID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":rackID" => $rackID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getSummeryRack() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `RackType`, "
            . "SUM(case when `OrderDetailID`IS NOT NULL then 1 else 0 end) AS `use`, "
            . "COUNT(`RackType`) AS `total` "
            . "FROM `resource_rack` "
            . "WHERE 1 "
            . "GROUP BY `RackType` "
            . "ORDER BY `resource_rack`.`RackType` ASC";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSummeryIP() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`NetworkIP`, "
            . "`Subnet`, "
            . "`VlanID`, "
            . "SUM(case when `OrderDetailID`IS NOT NULL then 1 else 0 end) AS `use`, "
            . "COUNT(`IP`) AS `total` "
            . "FROM `resource_ip` "
            . "WHERE 1 "
            . "GROUP BY `NetworkIP`";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSummeryPort() {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceSwitchID`, "
            . "`SwitchName`, "
            . "`SwitchType`, "
            . "`use`, "
            . "`uplink`, "
            . "`TotalPort` "
            . "FROM `view_summery_port`";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getResourceReserve($orderDetailID) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT "
            . "(SELECT COUNT(`ResourceIpID`) FROM `resource_ip` WHERE `OrderDetailID`=:orderDetailID) AS `ip`, "
            . "(SELECT COUNT(`ResourceSwitchPortID`) FROM `resource_switch_port` WHERE `OrderDetailID`=:orderDetailID) AS `port`, "
            . "(SELECT COUNT(`ResourceRackID`)FROM `resource_rack` WHERE `OrderDetailID`=:orderDetailID) AS `rack`, "
            . "(SELECT COUNT(`ResourceServiceID`)FROM `resource_service` WHERE `OrderDetailID`=:orderDetailID) AS `service`";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function assignIP($ip, $orderDetailID, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_ip` "
            . "SET `OrderDetailID`=:orderDetailID,`UpdateBy`=:personID "
            . "WHERE `IP` LIKE :ip";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ip" => $ip, ":orderDetailID" => $orderDetailID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignIPNull($ip, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_ip` "
            . "SET `OrderDetailID`= NULL ,`UpdateBy`=:personID "
            . "WHERE `IP` LIKE :ip";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ip" => $ip, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignPort($portID, $orderDetailID, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_switch_port` SET `OrderDetailID`= :orderDetailID ,`UpdateBy`= :personID "
            . "WHERE `ResourceSwitchPortID` = :portID";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":portID" => $portID, ":orderDetailID" => $orderDetailID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignPortNull($portID, $personID) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_switch_port` SET `OrderDetailID`= NULL ,`UpdateBy`= :personID "
            . "WHERE `ResourceSwitchPortID` = :portID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":portID" => $portID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function addResourceAmount($PackageID, $IPAmount, $PortAmount, $RackAmount, $ServiceAmount) {
    global $connection;
    dbconnect();
    $SQLCommand = "INSERT INTO `resource_amount`(`PackageID`, `IPAmount`, `PortAmount`, `RackAmount`, `ServiceAmount`) "
            . "VALUES (:PackageID, :IPAmount, :PortAmount, :RackAmount, :ServiceAmount)";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array("PackageID" => $PackageID, "IPAmount" => $IPAmount, "PortAmount" => $PortAmount, "RackAmount" => $RackAmount, "ServiceAmount" => $ServiceAmount));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getResourceAmount($packageID) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceAmountID`, "
            . "`PackageID`, "
            . "`IPAmount`, "
            . "`PortAmount`, "
            . "`RackAmount`, "
            . "`ServiceAmount` "
            . "FROM `resource_amount` "
            . "WHERE `PackageID`= :packageID ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":packageID" => $packageID));
    return $SQLPrepare->fetch(PDO::FETCH_ASSOC);
}

function editResourceAmount($PackageID, $IPAmount, $PortAmount, $RackAmount, $ServiceAmount) {
    global $connection;
    dbconnect();
    $SQLCommand = "UPDATE `resource_amount` SET "
            . "`IPAmount`= :IPAmount,"
            . "`PortAmount`= :PortAmount,"
            . "`RackAmount`= :RackAmount,"
            . "`ServiceAmount`= :ServiceAmount "
            . "WHERE `PackageID`= :PackageID";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        "PackageID" => $PackageID,
        "IPAmount" => $IPAmount,
        "PortAmount" => $PortAmount,
        "RackAmount" => $RackAmount,
        "ServiceAmount" => $ServiceAmount
    ));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getNetworkLink($locationID) {
    $connection = dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceNetworkLinkID`, "
            . "`NetworkLink`, "
            . "`CoperateName`, "
            . "`ContactName`, "
            . "`Phone`, "
            . "`Email`, "
            . "`NetworkLinkStatus`, "
            . "`LocationID` "
            . "FROM `resource_network_link` "
            . "WHERE `LocationID` LIKE :location ";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":location" => $locationID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
