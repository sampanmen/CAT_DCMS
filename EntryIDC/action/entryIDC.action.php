<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";
if ($para == "addEntryIDC") {
    $cusID = $_POST['cusID'];
    $EmpID = $_POST['EmpID'];
    $visitCard = $_POST['visitCard'];
    $IDCCard = $_POST['IDCCard'];
    $IDCCardType = $_POST['IDCCardType'];
    $IDCard = $_POST['IDCard'];
    $conName = $_POST['conName'];
    $conLname = $_POST['conLname'];
    $conEmail = $_POST['conEmail'];
    $cusName = $_POST['cusName'];
    $conPhone = $_POST['conPhone'];
    $purpose = $_POST['purpose'];
    $item_name = $_POST['item_name'];
    $item_brand = $_POST['item_brand'];
    $item_model = $_POST['item_model'];
    $item_serialno = $_POST['item_serialno'];
    $item_rackID = $_POST['item_rackID'];
    $internet_user = $_POST['internet_user'];
    $internet_pass = $_POST['internet_pass'];
    $area = $_POST['area'];
    $datetime = $_POST['datetime'];
    
}