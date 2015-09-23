<?php
include_once 'config.inc.php';

// function DB
function dbconnect() {
    global $connection;
    if (!$connection) {
        $connection = new PDO(DSN, DBUSER, DBPASS);
        $connection->query("SET NAMES UTF8");
    }
}

function addCus($input){
    global $connection;
    dbconnect();
    
    // Create CUS ID
    $SQLCommand = "INSERT INTO `customer` (`ID_Customer`, `Prefix`, `Status`) VALUES (NULL, :prefix, :status);";
    $SQLPrepare = $connection->prepare($SQLCommand);
    $SQLPrepare->execute(array(":prefix"=>"CUS",":status"=>"1"));
    $cusID = $SQLPrepare->lastInsertId();
    
    $SQLCommand = "";
    
    
}