<?php

set_time_limit(60 * 60);

$connection = null;
$server = 'mysql:host=localhost';
$user = "cat";
$pass = "123456";
$db = 'cat_dcms2';
$dbh = dbconnect();

if (chkDatabase($db)) {
    echo "<p>Your Database is exist.</p>";
} else {
    echo "<p>Database Name : OK.</p>";
    if (createDatabase($db)) {
        echo "<p>Create your Database is Completed.</p>";
        $sqlInstall = file_get_contents('MySQL_install.sql');
        if(importDatabase($db, $sqlInstall)){
            echo "<p>Import Database completed.</p>";
        }
        else{
            echo "<p>Import Database not completed.</p>";
        }
    } else {
        echo "<p>Create your Database isn't Completed.</p>";
    }
}

//$qr = $dbh->exec("DROP DATABASE `cat_dcms`;");
//$qr = $dbh->exec("SET NAMES UTF8");
//$sql = file_get_contents('MySQL_install.sql');
//$qr = $dbh->exec($sql);
//if ($dbh->errorInfo()[0] == "0") {
//    echo "INSTALL COMPLETED.<br>";
//    $sql = file_get_contents('MySQL_data.sql');
//    $qr = $dbh->exec($sql);
//    if($dbh->errorInfo()[0] == "0"){
//        echo "IMPORT DATA COMPLETED.<br>";
//    }
//} else {
//    echo "INSTALL FAILED.";
//    echo "<pre>";
//    print_r($dbh->errorInfo());
//    echo "</pre>";
//}
// db connect
function dbconnect() {
    global $connection;
    global $server;
    global $user;
    global $pass;
    if (!$connection) {
        $connection = new PDO($server, $user, $pass);
        $connection->query("SET NAMES UTF8");
    }
    return $connection;
}

//check db exists
function chkDatabase($databaseName) {
    $con = dbconnect();
    $SQLShowDB = "SHOW DATABASES LIKE :db ";
    $SQLPrepare = $con->prepare($SQLShowDB);
    $SQLPrepare->execute(
            array(
                ":db" => $databaseName
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//create db
function createDatabase($databaseName) {
    $con = dbconnect();
    $SQLShowDB = "CREATE SCHEMA IF NOT EXISTS `$databaseName` DEFAULT CHARACTER SET utf8";
    $SQLPrepare = $con->prepare($SQLShowDB);
    $SQLPrepare->execute();
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//drop db
function dropDatabase($databaseName) {
    $con = dbconnect();
    $SQLShowDB = "DROP DATABASE :db ";
    $SQLPrepare = $con->prepare($SQLShowDB);
    $SQLPrepare->execute(
            array(
                ":db" => $databaseName
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function importDatabase($databaseName, $sqlImport) {
    global $server;
    $serverTmp = $server;
    $server = $server . ";dbname=" . $databaseName;

    $con = dbconnect();
    $sql = file_get_contents('MySQL_install.sql');
    $con->exec($sql);

    $server = $serverTmp;
    if ($con->errorInfo()[0] == "0") {
        return TRUE;
    } else {
        return FALSE;
    }
}
