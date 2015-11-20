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

function getSwitchType() {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`SwitchTypeID`, "
            . "`SwitchType`, "
            . "`Status` "
            . "FROM `resource_switch_type` ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getSwitchTypeByID($SwitchTypeID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`SwitchTypeID`, "
            . "`SwitchType`, "
            . "`Status` "
            . "FROM `resource_switch_type` "
            . "WHERE `SwitchTypeID` = :SwitchTypeID ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":SwitchTypeID" => $SwitchTypeID
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getSwitchByLocationID($LocationID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`SwitchID`, "
            . "`SwitchName`, "
            . "`SwitchIP`, "
            . "`TotalPort`, "
            . "`SnmpCommuPublic`, "
            . "`SwitchTypeID`, "
            . "`SwitchType`, "
            . "`Brand`, "
            . "`Model`, "
            . "`SerialNo`, "
            . "`RackID`, "
            . "`Status`, "
            . "`LocationID` "
            . "FROM `view_resource_swicth` "
            . "WHERE `LocationID`=:LocationID ";
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

function getSwitchPorts($SwitchID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`SwitchID`, "
            . "`SwitchName`, "
            . "`TotalPort`, "
            . "`PortNumber`, "
            . "`PortTypeID`, "
            . "`PortType`, "
            . "`SwitchTypeID`, "
            . "`SwitchType`, "
            . "`RackID`, "
            . "`Status`, "
            . "`Uplink`, "
            . "`LocationID`, "
            . "`CustomerID`, "
            . "`CustomerName` "
            . "FROM `view_resource_port` "
            . "WHERE `SwitchID`=:SwitchID ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":SwitchID" => $SwitchID
            )
    );

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

function getRackTypeByCateID($cateID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`PackageCategoryID`, "
            . "`PackageCategory`, "
            . "`Type`, "
            . "`Status` "
            . "FROM `customer_package_category` "
            . "WHERE `PackageCategoryID`=:PackageCategoryID ";
    $SQLPrepare = $con->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":PackageCategoryID" => $cateID
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['PackageCategory'];
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

function getSummaryIPByLocationID($LocationID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`LocationID`, "
            . "`NetworkID`, "
            . "`NetworkIP`, "
            . "`Subnet`, "
            . "COUNT(`IPID`) AS `Total`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Active' THEN 1 ELSE 0 END) AS `Active`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Suppened' THEN 1 ELSE 0 END) AS `Suppened`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Deactive' THEN 1 ELSE 0 END) AS `Deactive` "
            . "FROM `view_resource_ip` "
            . "WHERE `LocationID`=:LocationID "
            . "GROUP BY `NetworkID`,`LocationID`";
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

function getSummaryPortByLocationID($LocationID) {
    $con = dbconnect();
    $SQLCommand = "SELECT "
            . "`LocationID`, "
            . "`SwitchID`, "
            . "`SwitchName`, "
            . "`SwitchType`, "
            . "COUNT(`SwitchPortID`) AS `Total`, "
            . "SUM(`Uplink`) AS `Uplink`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Active' THEN 1 ELSE 0 END) AS `Active`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Suppened' THEN 1 ELSE 0 END) AS `Suppened`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Deactive' THEN 1 ELSE 0 END) AS `Deactive` "
            . "FROM `view_resource_port` "
            . "WHERE `LocationID`=:LocationID GROUP BY `SwitchID`,`LocationID`";
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
            . "`NetworkLinkID`, "
            . "`NetworkLink`, "
            . "`CoperateName`, "
            . "`ContactName`, "
            . "`Phone`, "
            . "`Email`, "
            . "`Status`, "
            . "`LocationID`, "
            . "`NetworkLinkUsedID` "
            . "FROM `resource_network_link` "
            . "WHERE `LocationID` LIKE :location ";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":location" => $locationID
            )
    );
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

function getSummaryRackByLocatoinID($LocationID) {
    $connection = dbconnect();
    $SQLCommand = "SELECT "
            . "`LocationID`, "
            . "`RackTypeID`, "
            . "`RackType`, "
            . "COUNT(`RackPositionID`) AS `Total`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Active' THEN 1 ELSE 0 END) AS `Active`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Suppened' THEN 1 ELSE 0 END) AS `Suppened`, "
            . "SUM(CASE WHEN `StatusUsed` LIKE 'Deactive' THEN 1 ELSE 0 END) AS `Deactive` "
            . "FROM `view_resource_rack` "
            . "WHERE `LocationID`=:LocationID "
            . "GROUP BY `RackTypeID`,`LocationID`";
    $SQLPrepare = $connection->prepare($SQLCommand);
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
