<?php

// config database
define("DSN", 'mysql:host=localhost;dbname=cat_dcms');
define("DBUSER", 'cat');
define("DBPASS", '123456');
$connection;

function dbconnect() {
    global $connection;
    if (!$connection) {
        $connection = new PDO(DSN, DBUSER, DBPASS);
        $connection->query("SET NAMES UTF8");
    }
    return $connection;
}