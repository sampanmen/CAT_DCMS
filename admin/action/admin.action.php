<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "addStaffposition") {
//    print_r($_POST);
    $position = $_POST['position'];
    $status = $_POST['status'];
    $res = addPosition($position, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addPositionCompleted");
    } else {
        header("location: ../../core/?p=setting&para=addPositionFailed");
    }
} else if ($para == "addBusinesstype") {
    //   print_r($_POST);
    $businesstype = $_POST['businessType'];
    $status = $_POST['status'];
    $res = addBusinesstype($businesstype, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addPositionCompleted#Businesstype");
    } else {
        header("location: ../../core/?p=setting&para=addPositionFailed#Businesstype");
    }
}else if ($para == "addLocation") {
    //   print_r($_POST);
    $location = $_POST['location'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    
    $res = addLocation($location,$address, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addPositionCompleted#location");
    } else {
        header("location: ../../core/?p=setting&para=addPositionFailed#location");
    }
}else if ($para == "addPacCatagory") {
    //   print_r($_POST);
    $category = $_POST['category'];
    $status = $_POST['status'];
    
    $res = addPacCatagory($category, $status) ;
    if ($res) {
        header("location: ../../core/?p=setting&para=addPositionCompleted#CatagoryPackage");
    } else {
        header("location: ../../core/?p=setting&para=addPositionFailed#CatagoryPackage");
    }
}
else if ($para == "addZone") {
    //   print_r($_POST);
    $zone = $_POST['zone'];
    $locazone = $_POST['locazone'];
    $status = $_POST['status'];
    
    $res = addZone($zone, $locazone, $status) ;
    if ($res) {
        header("location: ../../core/?p=setting&para=addPositionCompleted#zone");
    } else {
        header("location: ../../core/?p=setting&para=addPositionFailed#zone");
    }
}