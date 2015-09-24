<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";

if ($para == "addCustomer") {

    $cus_name = $_POST['cus']['name'];
    $cus_bussType = $_POST['cus']['bussinessType'];
    $cus_email = $_POST['cus']['email'];
    $cus_phone = $_POST['cus']['phone'];
    $cus_fax = $_POST['cus']['fax'];
    $cus_address = $_POST['cus']['address'];
    $cus_township = $_POST['cus']['township'];
    $cus_city = $_POST['cus']['city'];
    $cus_province = $_POST['cus']['province'];
    $cus_zipcode = $_POST['cus']['zipcode'];
    $cus_country = $_POST['cus']['country'];
    $con = $_POST['con'];

    $resInsertCus = insertCustomer("CUS", $cus_name, $cus_email, $cus_phone, $cus_fax, $cus_address, $cus_township, $cus_city, $cus_province, $cus_zipcode, $cus_country, $cus_bussType);
    if ($resInsertCus) {
        $countCon = count($con['name']);
        for($i=0;$i<$countCon;$i++) {
            $con_name = $con['name'][$i];
            $con_sname = $con['sname'][$i];
            $con_phone = $con['phone'][$i];
            $con_email = $con['email'][$i];
            $con_password = $con['password'][$i];
//            $con_file;
            $resInsertCon = insertPerson($con_name, $con_sname, $con_phone, $con_email, $con_password, "contact", NULL, NULL, $resInsertCus);
        }
        if($resInsertCon){
            header("location: ../../core/?p=addOrder&para=addCustomerComplete");
        }
    }
}
else if($para == "checkEmail"){
    $email = isset($_GET['email'])?$_GET['email']:"no email";
    echo checkEmail($email);
}
else if($para == "getBussinessTypeHTML"){
    getBussinessTypeHTML();
}