<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$PersonID = "-1";
if ($para == "addCustomer") {
    $cus_name = $_POST['cus']['name'];
    $cus_status = "Active";
    $cus_bussTypeID = $_POST['cus']['bussinessTypeID'];
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
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $resInsertCus = addCustomer($cus_status, $cus_name, $cus_bussTypeID, $cus_email, $cus_phone, $cus_fax, $cus_address, $cus_township, $cus_city, 
            $cus_province, $cus_zipcode, $cus_country, $PersonID);
    if ($resInsertCus) {
//        $resInsertCon = true;
        $countCon = count($con['name']);
        echo $countCon . " <br>";
        for ($i = 0; $i < $countCon; $i++) {
            $con_name = $con['name'][$i];
            $con_sname = $con['sname'][$i];
            $con_phone = $con['phone'][$i];
            $con_email = $con['email'][$i];
            $con_idcard = $con['IDCard'][$i];
            $con_personType = "Contact";
            $con_contactType = "Main";
            $con_status = "Active";
            $resInsertPerson = addPerson($con_name, $con_sname, $con_phone, $con_email, $con_idcard, $con_personType, $con_status);
            $resInsertPersonContact = addContact($resInsertCus, $resInsertPerson, NULL, NULL, $con_contactType);
//            echo $resInsertCon . "<br>.";
//            echo "///";
//            echo "<pre>";
////            print_r($_FILES);
//            echo $resInsertCon."<br>";
//            echo "</pre>";
//            echo $_FILES["file"]["name"][$i]."<br>";
            move_uploaded_file($_FILES["file"]["tmp_name"][$i], "../images/persons/" . $resInsertPerson . ".jpg");
        }
        if ($resInsertPerson) {
            header("location: ../../core/?p=addOrder&cusID=" . $resInsertCus . "&para=addCustomerCompleted");
        } else {
            header("location: ../../core/?p=cusHome&para=addCustomerFailed");
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
    $personID = $_GET['personID'];
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
    $cusID = $_POST['cusID'];
    $oldID = $_POST['oldID'];
    $package = $_POST['package'];
    $bundle = $_POST['bundle'];
    $location = $_POST['location'];

    $res = addOrder("A", $oldID, $cusID, $location, "active", $personID, $bundle, $package);
    if ($res) {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=addOrderCompleted");
    } else {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=addOrderFailed");
    }
} else if ($para == "editCustomer") {
//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";

    $cus_name = $_POST['name'];
    $cus_bussType = $_POST['bussinessType'];
    $cus_email = $_POST['email'];
    $cus_phone = $_POST['phone'];
    $cus_fax = $_POST['fax'];
    $cus_address = $_POST['address'];
    $cus_township = $_POST['township'];
    $cus_city = $_POST['city'];
    $cus_province = $_POST['province'];
    $cus_zipcode = $_POST['zipcode'];
    $cus_country = $_POST['country'];
    $cus_status = $_POST['status'];
    $cusID = $_GET['cusID'];

    $res = editCustomer($cusID, $cus_status, $cus_name, $cus_bussType, $cus_email, $cus_phone, $cus_fax, $cus_address, $cus_township, $cus_city, $cus_province, $cus_zipcode, $cus_country, $personID);
    if ($res) {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=editOrderCompleted");
    } else {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=editOrderFailed");
    }
} else if ($para == "changeStatusOrderDetail") {
    $status = $_POST['status'];
    $orderDetailID = $_GET['orderDetailID'];
    $orderID = $_GET['orderID'];
    $cusID = $_GET['cusID'];
    $res = editStatusOrderDetail($orderDetailID, $status);
    if ($res) {
        header("location: ../../core/?p=orderDetail&orderID=" . $orderID . "&cusID=" . $cusID . "&para=editStatusCompleted");
    } else {
        header("location: ../../core/?p=orderDetail&orderID=" . $orderID . "&cusID=" . $cusID . "&para=editStatusFailed");
    }
} else if ($para == "addOrderDetail") {
    echo "<pre>";
    print_r($_POST);
    print_r($_GET);
    echo "</pre>";
    $package = $_POST['package'];
    $orderID = $_GET['orderID'];
    $cusID = $_GET['cusID'];
    $status = "active";
    $res = addOrderDetail($orderID, $package, $status, $personID);

    if ($res) {
        header("location: ../../core/?p=orderDetail&orderID=" . $orderID . "&cusID=" . $cusID . "&para=AddOrderDetailCompleted");
    } else {
        header("location: ../../core/?p=orderDetail&orderID=" . $orderID . "&cusID=" . $cusID . "&para=AddOrderDetailFailed");
    }
}