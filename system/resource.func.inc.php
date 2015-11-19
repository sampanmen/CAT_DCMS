<?php

function addIP($IPs, $NetworkID, $IPUsedID) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_ip`(`IP`, `NetworkID`, `IPUsedID`) "
            . "VALUES (:IP, :NetworkID, :IPUsedID )";
    $res = $con->prepare($sqlCommand);
    $countIP = count($IPs);
    for ($i = 0; $i < $countIP; $i++) {
        $res->execute(
                array(
                    ":IP" => $IPs[$i]['ip'],
                    ":NetworkID" => $NetworkID,
                    ":IPUsedID" => $IPUsedID
                )
        );
    }
    $rows = $res->rowCount();
    if ($rows > 0) {
        return $con->lastInsertId();
    } else {
        return false;
    }
}

function addIPNetwork($NetworkIP, $Subnet, $Vlan, $AmountIP, $Status, $LocationID, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_ip_network`(`NetworkIP`, `Subnet`, `Vlan`, `AmountIP`, `Status`, `LocationID`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:NetworkIP, :Subnet, :Vlan, :AmountIP, :Status, :LocationID, :CreateBy, :UpdateBy)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":NetworkIP" => $NetworkIP,
                ":Subnet" => $Subnet,
                ":Vlan" => $Vlan,
                ":AmountIP" => $AmountIP,
                ":Status" => $Status,
                ":LocationID" => $LocationID,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login
            )
    );
    $rows = $res->rowCount();
    if ($rows > 0) {
        return $con->lastInsertId();
    } else {
        return false;
    }
}

function addIPUsed($IPID, $Status, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_ip_used`(`IPID`, `Status`, `CreateBy`, `UpdateBy`) "
            . "VALUES (:IPID, :Status, :CreateBy, :UpdateBy)";
    $res = $con->prepare($sqlCommand);
    foreach ($ipArr as $ip) {
        $res->execute(
                array(
                    ":IPID" => $IPID,
                    ":Status" => $Status,
                    ":CreateBy" => $PersonID_login,
                    ":UpdateBy" => $PersonID_login
                )
        );
    }
    $rows = $res->rowCount();
    if ($rows > 0) {
        return $con->lastInsertId();
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
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`NetworkID`, "
            . "`NetworkIP`, "
            . "`Subnet`, "
            . "`Vlan`, "
            . "`AmountIP`, "
            . "`Status`, "
            . "`LocationID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy` "
            . "FROM `resource_ip_network` "
            . "ORDER BY `NetworkIP` ASC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getNetworksByLocationID($LocationID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`NetworkID`, "
            . "`NetworkIP`, "
            . "`Subnet`, "
            . "`Vlan`, "
            . "`AmountIP`, "
            . "`Status`, "
            . "`LocationID`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy` "
            . "FROM `resource_ip_network` "
            . "WHERE `LocationID`=:LocationID "
            . "ORDER BY `NetworkIP` ASC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":LocationID" => $LocationID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getNetworksValue() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`NetworkIP`, "
            . "SUM(case when `OrderDetailID` IS NULL then 1 else 0 end) AS `balance` "
            . "FROM `resource_ip` "
            . "GROUP BY `NetworkIP` "
            . "ORDER BY `NetworkIP` ASC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getIPs($networkID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`IPID`, "
            . "`IP`, "
            . "`NetworkID`, "
            . "`IPUsedID`, "
            . "`NetworkIP`, "
            . "`Subnet`, "
            . "`Vlan`, "
            . "`LocationID`, "
            . "`Status`, "
            . "`ServiceDetailID`, "
            . "`PackageID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_resource_ip` "
            . "WHERE `NetworkID` = :networkID "
            . "ORDER BY `IPID` ASC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":networkID" => $networkID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getIPsByOrderDetailID($orderDetailID) {
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function addSwitch($SwitchName, $SwitchIP, $TotalPort, $SnmpCommuPublic, $SwitchTypeID, $Brand, $Model, $SerialNo, $RackID, $Status, $LocationID, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_switch`(`SwitchName`, `SwitchIP`, `TotalPort`, `SnmpCommuPublic`, `SwitchTypeID`, `Brand`, `Model`, `SerialNo`, `RackID`, `Status`, `CreateBy`, `UpdateBy`, `LocationID`) "
            . "VALUES (:SwitchName, :SwitchIP, :TotalPort, :SnmpCommuPublic, :SwitchTypeID, :Brand, :Model, :SerialNo, :RackID, :Status, :CreateBy, :UpdateBy, :LocationID)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":SwitchName" => $SwitchName,
                ":SwitchIP" => $SwitchIP,
                ":TotalPort" => $TotalPort,
                ":SnmpCommuPublic" => $SnmpCommuPublic,
                ":SwitchTypeID" => $SwitchTypeID,
                ":Brand" => $Brand,
                ":Model" => $Model,
                ":SerialNo" => $SerialNo,
                ":RackID" => $RackID,
                ":Status" => $Status,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":LocationID" => $LocationID
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addSwitchPort($SwitchID, $PortNumber, $PortType, $PortVlan, $Uplink, $SwitchPortUsedID, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_switch_port`(`SwitchID`, `PortNumber`, `PortType`, `PortVlan`, `Uplink`, `CreateBy`, `UpdateBy`, `SwitchPortUsedID`) "
            . "VALUES (:SwitchID, :PortNumber, :PortType, :PortVlan, :Uplink, :CreateBy, :UpdateBy, :SwitchPortUsedID)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":SwitchID" => $SwitchID,
                ":PortNumber" => $PortNumber,
                ":PortType" => $PortType,
                ":PortVlan" => $PortVlan,
                ":Uplink" => $Uplink,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":SwitchPortUsedID" => $SwitchPortUsedID
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addSwitchPortUsed($ServiceDetailID, $PortID, $Status, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_switch_port_used`(`ServiceDetailID`, `PortID`, `CreateBy`, `UpdateBy`, `Status`) "
            . "VALUES (:ServiceDetailID, :PortID, :CreateBy, :UpdateBy, :Status)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":ServiceDetailID" => $ServiceDetailID,
                ":PortID" => $PortID,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":Status" => $Status
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addServiceResource($Name, $Detail, $Tag, $Status, $LocationID, $ServiceUsedID, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_service`(`Name`, `Detail`, `Tag`, `Status`, `LocationID`, `CreateBy`, `UpdateBy`, `ServiceUsedID`) "
            . "VALUES (:Name, :Detail, :Tag, :Status, :LocationID, :CreateBy, :UpdateBy, :ServiceUsedID)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":Name" => $Name,
                ":Detail" => $Detail,
                ":Tag" => $Tag,
                ":Status" => $Status,
                ":LocationID" => $LocationID,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":ServiceUsedID" => $ServiceUsedID
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addServiceResourceUsed($ServiceDetailID, $ResourceServiceID, $Status, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_service_used`(`ServiceDetailID`, `ResourceServiceID`, `CreateBy`, `UpdateBy`, `Status`) "
            . "VALUES (:ServiceDetailID, :ResourceServiceID, :CreateBy, :UpdateBy, :Status)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":ServiceDetailID" => $ServiceDetailID,
                ":ResourceServiceID" => $ResourceServiceID,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":Status" => $Status
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addRack($RackPositionID, $SubRackPosition, $RackUsedID) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_rack`(`RackPositionID`, `SubRackPosition`, `RackUsedID`) "
            . "VALUES (:RackPositionID, :SubRackPosition, :RackUsedID)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":RackPositionID" => $RackPositionID,
                ":SubRackPosition" => $SubRackPosition,
                ":RackUsedID" => $RackUsedID
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addRackPosition($Col, $Row, $RackType, $RackSize, $Status, $RackKey, $LocationID, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_rack_position`(`Col`, `Row`, `PackageCategoryID`, `RackSize`, `Status`, `CreateBy`, `UpdateBy`, `RackKey`, `LocationID`) "
            . "VALUES (:Col, :Row, :RackType, :RackSize, :Status, :CreateBy, :UpdateBy, :RackKey, :LocationID)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":Col" => $Col,
                ":Row" => $Row,
                ":RackType" => $RackType,
                ":RackSize" => $RackSize,
                ":Status" => $Status,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":RackKey" => $RackKey,
                ":LocationID" => $LocationID
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function addRackUsed($ServiceDetailID, $SubRackID, $Status, $PersonID_login) {
    $con = dbconnect();
    $sqlCommand = "INSERT INTO `resource_rack_used`(`ServiceDetailID`, `SubRackID`, `CreateBy`, `UpdateBy`, `Status`) "
            . "VALUES (:ServiceDetailID, :SubRackID, :CreateBy, :UpdateBy, :Status)";
    $res = $con->prepare($sqlCommand);
    $res->execute(
            array(
                ":ServiceDetailID" => $ServiceDetailID,
                ":SubRackID" => $SubRackID,
                ":CreateBy" => $PersonID_login,
                ":UpdateBy" => $PersonID_login,
                ":Status" => $Status
            )
    );

    if ($res->rowCount() > 0) {
        return $con->lastInsertId();
    } else
        return false;
}

function getSwitchs() {
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPortByOrderDetailID($orderDetailID) {
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSwitchPorts($swID) {
    $con = dbconnect();
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
        $SQLPrepare = $con->prepare($SQLCommand);
        $SQLPrepare->execute(array(":swID" => $swID));
    } else {
        $SQLCommand.="ORDER BY `SwitchName`,`PortNumber` ASC ";
        $SQLPrepare = $con->prepare($SQLCommand);
        $SQLPrepare->execute();
    }

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSwitchValue() {
    $con = dbconnect();
    $SQLCommand = "SELECT `ResourceSwitchID`, `SwitchName`, `balance` "
            . "FROM `view_switch_port_balance` ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getLastRow($column, $LocationID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`Col`, "
            . "`Row` "
            . "FROM `resource_rack_position` "
            . "WHERE `Col` LIKE :Col AND `LocationID`=:LocationID "
            . "ORDER BY `RackPositionID` DESC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":Col" => $column,
                ":LocationID" => $LocationID
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else
        return false;
}

function getRacks() {
    $con = dbconnect();
    $SQLCommand = "SELECT `Zone`, `Position`, `RackType`, `RackSize` "
            . "FROM `resource_rack` "
            . "GROUP BY `Zone`, `Position` "
            . "ORDER BY `Zone`,`Position` ASC";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackByRackPositionID($RackPositionID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`RackID`, "
            . "`RackPositionID`, "
            . "`Col`, "
            . "`Row`, "
            . "`SubRackPosition`, "
            . "`RackTypeID`, "
            . "`RackType`, "
            . "`RackSize`, "
            . "`Status`, "
            . "`RackUsedID`, "
            . "`ServiceDetailID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_resource_rack` "
            . "WHERE `RackPositionID`=:RackPositionID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":RackPositionID" => $RackPositionID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackPositionByLocationIDandType($LocationID, $RackType) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`RackPositionID`, "
            . "`Col`, "
            . "`Row`, "
            . "`customer_package_category`.`PackageCategoryID`, "
            . "`customer_package_category`.`PackageCategory`, "
            . "`RackSize`, "
            . "`resource_rack_position`.`Status`, "
            . "`DateTimeCreate`, "
            . "`DateTimeUpdate`, "
            . "`CreateBy`, "
            . "`UpdateBy`, "
            . "`RackKey`, "
            . "`LocationID` FROM "
            . "`resource_rack_position` "
            . "JOIN `customer_package_category` "
            . "ON `customer_package_category`.`PackageCategoryID`=`resource_rack_position`.`PackageCategoryID` "
            . "WHERE `resource_rack_position`.`PackageCategoryID`=:PackageCategoryID AND `LocationID`=:LocationID ";
//    echo $SQLCommand;
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PackageCategoryID" => $RackType,
                ":LocationID" => $LocationID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRacksColumn($locationID) {
    $con = dbconnect();
    $SQLCommand = "SELECT DISTINCT `Col` FROM `resource_rack_position` WHERE `LocationID` = :LocationID ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":LocationID" => $locationID
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackByCusID($cusID) {
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":cusID" => $cusID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRackValue($rackType) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`Zone`, "
            . "`Position`, "
            . "`RackType`, "
            . "SUM(case when `OrderDetailID` IS NULL then 1 else 0 end) AS `balance` "
            . "FROM `view_rack` "
            . "WHERE `EnableResourceRack` = 1 AND `RackType` LIKE :rackType "
            . "GROUP BY `Zone`, `Position`";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":rackType" => $rackType));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getRacksPosition($col, $type) {
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
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
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
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
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function assignRack($rackID, $orderDetailID, $personID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_rack` SET `OrderDetailID`= :orderDetailID ,`UpdateBy`= :personID "
            . "WHERE `ResourceRackID` = :rackID";
//    echo $SQLCommand;
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":rackID" => $rackID, ":orderDetailID" => $orderDetailID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignRackNull($rackID, $personID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_rack` SET `OrderDetailID`= NULL,`UpdateBy`= :personID "
            . "WHERE `ResourceRackID`= :rackID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":rackID" => $rackID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function getSummeryRack() {
    $con = dbconnect();
    $SQLCommand = "SELECT `RackType`, "
            . "SUM(case when `OrderDetailID`IS NOT NULL then 1 else 0 end) AS `use`, "
            . "COUNT(`RackType`) AS `total` "
            . "FROM `resource_rack` "
            . "WHERE 1 "
            . "GROUP BY `RackType` "
            . "ORDER BY `resource_rack`.`RackType` ASC";
//    echo $SQLCommand;
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSummeryIP() {
    $con = dbconnect();
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
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSummeryPort() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`ResourceSwitchID`, "
            . "`SwitchName`, "
            . "`SwitchType`, "
            . "`use`, "
            . "`uplink`, "
            . "`TotalPort` "
            . "FROM `view_summery_port`";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getResourceReserve($orderDetailID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "(SELECT COUNT(`ResourceIpID`) FROM `resource_ip` WHERE `OrderDetailID`=:orderDetailID) AS `ip`, "
            . "(SELECT COUNT(`ResourceSwitchPortID`) FROM `resource_switch_port` WHERE `OrderDetailID`=:orderDetailID) AS `port`, "
            . "(SELECT COUNT(`ResourceRackID`)FROM `resource_rack` WHERE `OrderDetailID`=:orderDetailID) AS `rack`, "
            . "(SELECT COUNT(`ResourceServiceID`)FROM `resource_service` WHERE `OrderDetailID`=:orderDetailID) AS `service`";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":orderDetailID" => $orderDetailID));
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function assignIP($ip, $orderDetailID, $personID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_ip` "
            . "SET `OrderDetailID`=:orderDetailID,`UpdateBy`=:personID "
            . "WHERE `IP` LIKE :ip";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ip" => $ip, ":orderDetailID" => $orderDetailID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignIPNull($ip, $personID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_ip` "
            . "SET `OrderDetailID`= NULL ,`UpdateBy`=:personID "
            . "WHERE `IP` LIKE :ip";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":ip" => $ip, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignPort($portID, $orderDetailID, $personID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_switch_port` SET `OrderDetailID`= :orderDetailID ,`UpdateBy`= :personID "
            . "WHERE `ResourceSwitchPortID` = :portID";
//    echo $SQLCommand;
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":portID" => $portID, ":orderDetailID" => $orderDetailID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function assignPortNull($portID, $personID) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_switch_port` SET `OrderDetailID`= NULL ,`UpdateBy`= :personID "
            . "WHERE `ResourceSwitchPortID` = :portID";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(":portID" => $portID, ":personID" => $personID));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}

function addResourceAmount($PackageID, $IPAmount, $PortAmount, $RackAmount, $ServiceAmount) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `resource_amount`(`PackageID`, `IPAmount`, `PortAmount`, `RackAmount`, `ServiceAmount`) "
            . "VALUES (:PackageID, :IPAmount, :PortAmount, :RackAmount, :ServiceAmount)";
    $SQLPrepare = $con->prepare($SQLCommand);
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
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(array(":packageID" => $packageID));
    return $SQLPrepare->fetch(PDO::FETCH_ASSOC);
}

function editResourceAmount($PackageID, $IPAmount, $PortAmount, $RackAmount, $ServiceAmount) {
    $con = dbconnect();
    $SQLCommand = "UPDATE `resource_amount` SET "
            . "`IPAmount`= :IPAmount,"
            . "`PortAmount`= :PortAmount,"
            . "`RackAmount`= :RackAmount,"
            . "`ServiceAmount`= :ServiceAmount "
            . "WHERE `PackageID`= :PackageID";
    $SQLPrepare = $con->prepare($SQLCommand);
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

function addResourceService($name, $detail, $tag, $personID, $enableResourceService, $dateTimeCreate, $dateTimeUpdate, $createBy, $updateBy, $locationID) {
    $con = dbconnect();
    $SQLCommand = "INSERT INTO `resource_service`(`Name`, `Detail`, `Tag`, `PersonID`, `EnableResourceService`, `DateTimeCreate`, `DateTimeUpdate`, `CreateBy`, `UpdateBy`, `LocationID`)"
            . "VALUES (:name,:detail,:tag,:personID,:enableResourceService,:dateTimeCreate,:dateTimeUpdate,:createBy,:updateBy,:locationID)";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(array(
        ":name" => $name,
        ":detail" => $detail,
        ":tag" => $tag,
        ":personID" => $personID,
        ":enableResourceService" => $enableResourceService,
        ":dateTimeCreate" => $dateTimeCreate,
        ":dateTimeUpdate" => $dateTimeUpdate,
        ":createBy" => $createBy,
        ":updateBy" => $updateBy,
        ":locationID" => $locationID
    ));

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else
        return false;
}
