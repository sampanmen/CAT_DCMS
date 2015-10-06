<?php

$user = "cat";
$pass = "123456";
$dbh = new PDO('mysql:host=localhost', $user, $pass);
$sql = file_get_contents('MySQL_install.sql');
$qr = $dbh->exec($sql);

if ($dbh->errorInfo()[0] == "0") {
    echo "INSTALL COMPLETED.<br>";
    $sql = file_get_contents('MySQL_data.sql');
    $qr = $dbh->exec($sql);
    if($dbh->errorInfo()[0] == "0"){
        echo "IMPORT DATA COMPLETED.<br>";
    }
} else {
    echo "INSTALL FAILED.";
    echo "<pre>";
    print_r($dbh->errorInfo());
    echo "</pre>";
}