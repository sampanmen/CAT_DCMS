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

function getIPs($network) {
    global $connection;
    dbconnect();
    $SQLCommand = "SELECT `IP`, `NetworkIP`, `Subnet`, `VlanID`, `EnableResourceIP`, "
            . "`OrderDetailID`, `DateTimeCreate`, `DateTimeUpdate`, `CreateBy`, "
            . "`UpdateBy`, `OrderID`, `PackageID`, `CustomerID`, `Location`, "
            . "`CustomerName`, `BusinessType` "
            . "FROM `view_ip` WHERE `NetworkIP` LIKE :network ";
//    echo $SQLCommand;
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":network" => $network));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}