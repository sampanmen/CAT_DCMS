<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "addStaffposition") {
//    print_r($_POST);
    $position=$_POST['position'];
    $status=$_POST['status'];
    $res=  addPosition($position, $status);
    if ($res) {
            header("location: ../../core/?p=setting&para=addPositionCompleted");
        } else {
            header("location: ../../core/?p=setting&para=addPositionFailed");
        }
   
} else if ($para == "checkOut") {
    
}