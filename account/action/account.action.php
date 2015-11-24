<?php

require_once dirname(__FILE__) . '/../../system/config.inc.php';
require_once dirname(__FILE__) . '/../function/account.func.inc.php';
session_start();
$para = isset($_GET['para']) ? $_GET['para'] : "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//$PersonID_login = $_SESSION['Account']['PersonID'];

if ($para == "login") {
//    print_r($_POST);
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $loginResult = login($Username, $Password);
    if ($loginResult !== FALSE) {
        $getAccount = checkLogin($Username);
        $_SESSION['Account']['PersonID'] = $getAccount['PersonID'];
        $_SESSION['Account']['Username'] = $loginResult;
        if (isset($_POST['remember']) && $_POST['remember'] == "Remember") {
            setcookie("rememberUsername", $Username, time() + (3600 * 24 * 300), "/");
            setcookie("rememberPassword", $Password, time() + (3600 * 24 * 300), "/");
        } else {
            setcookie("rememberUsername", NULL, time() - 1, "/");
            setcookie("rememberPassword", NULL, time() - 1, "/");
        }
        echo "Yes.";
//        print_r($_SESSION);
        header("Location: ../../core/");
    } else {
        echo "No.";
        header("Location: ../../account/login.php?p=loginFalse");
    }
} else if ($para == "logout") {
    unset($_SESSION['Account']);
    header("Location: ../../account/login.php?p=logout");
} else if ($para == "addAccount") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $PersonID = $_POST['PersonID'];
    $addResult = addAccount($Username, $Password, $PersonID);
    if ($addResult) {
        header("Location: ../../core/?p=showAccount&para=addAccountCompleted");
    } else {
        header("Location: ../../core/?p=showAccount&para=addAccountError");
    }
} else if ($para == "changePassword") {
//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
    $Username = $_POST['username'];
    $currentPassword = isset($_POST['currentPassword']) ? $_POST['currentPassword'] : "";
    $newPassword = $_POST['newPassword'];
    $url = $_POST['url'];
    $chkAdmin = isset($_GET['chkAdmin']) ? $_GET['chkAdmin'] : "";

    $resLogin = login($Username, $currentPassword);
    if ($resLogin || $chkAdmin == "true") {
        $resChagePass = changePassword($Username, $newPassword);
        if ($resChagePass) {
            echo "change Pass";
            echo "<script>alert('Password is changed.');window.location.href = '$url';</script>";
//            header("Location: " . $url);
        } else {
            echo "change Error";
            echo "<script>alert('Changed password error.');window.location.href = '$url';</script>";
//            header("Location: " . $url);
        }
    } else {
        echo "login Error";
        echo "<script>alert('Changed password error. Your current password is wrong.');window.location.href = '$url';</script>";
//        header("Location: " . $url);
    }
} else if ($para == "deleteAccount") {
    $Username = $_GET['Username'];
    $resDelAccount = deleteAccount($Username);
    if ($resDelAccount) {
        header("Location: ../../core/?p=showAccount&para=delAccountCompleted");
    } else {
        header("Location: ../../core/?p=showAccount&para=delAccountError");
    }
}