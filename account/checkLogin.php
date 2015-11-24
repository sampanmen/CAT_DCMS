<?php

require_once dirname(__FILE__) . '/../account/function/account.func.inc.php';
require_once dirname(__FILE__) . '/../system/function.inc.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//$Permission = array("frontdesk");
isset($link) ? $link : $link = "../account/login.php";
isset($pa) ? $pa : $pa = "";
if (isset($_SESSION['Account'])) {
    $Username = $_SESSION['Account']['Username'];
    $account = checkLogin($Username);
    if ($account !== FALSE) {
        $Position = $account['Position'];
        $chkPermission = array_search($Position, $Permission);
        if ($chkPermission === FALSE) {
            header("Location: " . $link . "?p=PermissionDenied" . $pa);
        }
    } else {
//        echo "noPermission";
        header("Location: " . $link . "?p=noPermission" . $pa);
    }
} else {
    header("Location: " . $link . "?p=noSessioin" . $pa);
}
?>