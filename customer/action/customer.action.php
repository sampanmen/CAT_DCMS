<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";
if ($para == "addCustomer") {

    $cus_name = $_POST['cus']['name'];
    $status = "active";
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

    $resInsertCus = addCustomer("CUS", $status, $cus_name, $cus_bussType, $cus_email, $cus_phone, $cus_fax, $cus_address, $cus_township, $cus_city, $cus_province, $cus_zipcode, $cus_country, '1');
    if ($resInsertCus) {
        $countCon = count($con['name']);
        for ($i = 0; $i < $countCon; $i++) {
            $con_name = $con['name'][$i];
            $con_sname = $con['sname'][$i];
            $con_phone = $con['phone'][$i];
            $con_email = $con['email'][$i];
            $con_password = $con['password'][$i];
            $con_type = $con['type'][$i];
            $resInsertCon = addPerson($con_name, $con_sname, $con_phone, $con_email, $con_password, NULL, NULL, $con_type, NULL, $resInsertCus, "active");

//            echo "<pre>";
////            print_r($_FILES);
//            echo $resInsertCon."<br>";
//            echo "</pre>";
//            echo $_FILES["file"]["name"][$i]."<br>";
            move_uploaded_file($_FILES["file"]["tmp_name"][$i], "../images/persons/" . $resInsertCon . ".jpg");
        }
        if ($resInsertCon) {
            header("location: ../../core/?p=addOrder&cusID=" . $resInsertCus . "&para=addCustomerCompleted");
        } else {
            header("location: ../../core/?p=addOrder&para=addCustomerFailed");
        }
    }
} else if ($para == "checkEmail") {
    $email = isset($_GET['email']) ? $_GET['email'] : "no email";
    echo checkEmail($email);
} else if ($para == "addPackage") {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $ip = $_POST['ip'];
    $port = $_POST['port'];
    $rack = $_POST['rack'];
    $service = $_POST['service'];

    $resInsert = addPackage($name, $detail, $type, $category, $status, $ip, $port, $rack, $service, "-1");
    if ($resInsert) {
        header("location: ../../core/?p=serviceHome&para=addPackageCompleted");
    } else {
        header("location: ../../core/?p=serviceHome&para=addPackageFailed");
    }
} else if ($para == "editPackage") {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $ip = $_POST['ip'];
    $port = $_POST['port'];
    $rack = $_POST['rack'];
    $service = $_POST['service'];
    $packageID = $_GET['packageID'];

    $resEdit = editPackage($packageID, $name, $detail, $type, $category, $status, $ip, $port, $rack, $service, "-2");
    if ($resEdit) {
        header("location: ../../core/?p=serviceHome&para=editPackageCompleted");
    } else {
        header("location: ../../core/?p=serviceHome&para=editPackageFailed");
    }
} else if ($para == "addContact") {
    $con_name = $_POST['name'];
    $con_sname = $_POST['sname'];
    $con_phone = $_POST['phone'];
    $con_email = $_POST['email'];
    $con_password = $_POST['password'];
    $con_type = $_POST['type'];
    $cusID = $_GET['cusID'];
    $resInsertCon = addPerson($con_name, $con_sname, $con_phone, $con_email, $con_password, NULL, NULL, $con_type, NULL, $cusID, "active");
//    echo $resInsertCon;
    if ($resInsertCon) {
        move_uploaded_file($_FILES["file"]["tmp_name"], "../images/persons/" . $resInsertCon . ".jpg");
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=addContactCompleted");
    } else {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=addContactFailed");
    }
} else if ($para == "editContact") {
    $con_name = $_POST['name'];
    $con_sname = $_POST['sname'];
    $con_phone = $_POST['phone'];
    $con_email = $_POST['email'];
    $con_password = $_POST['password'];
    $con_type = $_POST['type'];
    $con_status = $_POST['status'];
    $cusID = $_GET['cusID'];
    $resInsertCon = editPerson($personID, $con_name, $con_sname, $con_phone, $con_email, $con_password, NULL, NULL, $con_type, NULL, $con_status);
//    echo $resInsertCon;
    if (isset($_FILES)) {
        $uploadPic = move_uploaded_file($_FILES["file"]["tmp_name"], "../images/persons/" . $personID . ".jpg");
    }
    if ($resInsertCon || $uploadPic) {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=editContactCompleted");
    } else {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=editContactFailed");
    }
} else if ($para == "addOrder") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $cusID = $_POST['cusID'];
    $oldID = $_POST['oldID'];
    $package = $_POST['package'];
    $bundle = $_POST['bundle'];
    $location = $_POST['location'];
    
    $res = addOrder("A", $oldID, $cusID, $location, "active", $personID, $bundle, $package);
    echo $res;
}
