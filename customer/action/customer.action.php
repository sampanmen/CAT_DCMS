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
    $resInsertCus = addCustomer($cus_status, $cus_name, $cus_bussTypeID, $cus_email, $cus_phone, $cus_fax, $cus_address, $cus_township, $cus_city, $cus_province, $cus_zipcode, $cus_country, $PersonID);
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
            header("location: ../../core/?p=viewCus&cusID=" . $resInsertCus . "&para=addCustomerCompleted");
        } else {
            header("location: ../../core/?p=cusHome&para=addCustomerFailed");
        }
    }
} else if ($para == "checkEmail") {
    $email = isset($_GET['email']) ? $_GET['email'] : "no email";
    echo checkEmail($email);
} else if ($para == "addPackage") {
    //package
    $PackageName = $_POST['name'];
    $PackageDetail = $_POST['detail'];
    $PackageType = $_POST['type'];
    $PackageCategoryID = $_POST['category'];
    $PackageStatus = $_POST['status'];
    $LocationID = $_POST['location'];

    //amount
    $ipAmount = $_POST['amount']['ip'];
    $portAmount = $_POST['amount']['port'];
    $rackAmount = $_POST['amount']['rack'];
    $serviceAmount = $_POST['amount']['service'];

    $resInsertPackage = addPackage($PackageName, $PackageDetail, $PackageType, $PackageCategoryID, $PackageStatus, $PersonID, $LocationID);
    if ($resInsertPackage) {
        echo "Add package completed.";
        $resInsertAmount = addResourceAmount($resInsertPackage, $ipAmount, $portAmount, $rackAmount, $serviceAmount);
        if ($resInsertAmount) {
            echo "Add amount completed.";
            header("location: ../../core/?p=packageHome&para=addPackageCompleted");
        } else {
            header("location: ../../core/?p=packageHome&para=addPackageFailed");
        }
    } else {
        header("location: ../../core/?p=packageHome&para=addPackageFailed");
    }
} else if ($para == "editPackage") {
    $packageID = $_GET['packageID'];
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $type = $_POST['type'];
    $categoryID = $_POST['category'];
    $status = $_POST['status'];
    $locationID = $_POST['location'];

    $ipAmount = $_POST['amount']['ip'];
    $portAmount = $_POST['amount']['port'];
    $rackAmount = $_POST['amount']['rack'];
    $serviceAmount = $_POST['amount']['service'];

    $resEditPackage = editPackage($packageID, $name, $detail, $type, $categoryID, $locationID, $status, $PersonID);
    $resEditAmount = editResourceAmount($packageID, $ipAmount, $portAmount, $rackAmount, $serviceAmount);
    if ($resEditPackage) {
        echo "Edit package completed.";
        if ($resEditAmount) {
            echo "Edit package amount completed.";
            header("location: ../../core/?p=packageHome&para=editPackageCompleted");
        } else {
            header("location: ../../core/?p=packageHome&para=editPackageAmountFailed");
        }
    } else {
        header("location: ../../core/?p=packageHome&para=editPackageFailed");
    }
} else if ($para == "addContact") {
    $con_name = $_POST['name'];
    $con_sname = $_POST['sname'];
    $con_phone = $_POST['phone'];
    $con_email = $_POST['email'];
    $con_idcard = $_POST['idcard'];
    $con_typePerson = "Contact";
    $con_typeContact = $_POST['type'];
    $con_statusPerson = "Active";
    $cusID = $_GET['cusID'];

    $resInsertPerson = addPerson($con_name, $con_sname, $con_phone, $con_email, $con_idcard, $con_typePerson, $con_statusPerson);
    $resInsertContact = addContact($cusID, $resInsertPerson, NULL, NULL, $con_typeContact);
    if ($resInsertContact) {
        move_uploaded_file($_FILES["file"]["tmp_name"], "../images/persons/" . $resInsertPerson . ".jpg");
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=addContactCompleted");
    } else {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=addContactFailed");
    }
} else if ($para == "editContact") {
    $cusID = $_GET['cusID'];
    $personID = $_GET['personID'];

    $con_name = $_POST['name'];
    $con_sname = $_POST['sname'];
    $con_phone = $_POST['phone'];
    $con_email = $_POST['email'];
    $con_idcard = $_POST['idcard'];
    $con_type = $_POST['type'];
    $con_status = $_POST['status'];

    $resEditPerson = editPerson($personID, $con_name, $con_sname, $con_phone, $con_email, $con_idcard, $con_type, $con_status);
    $resEditCon = editContactType($personID, $con_type);
    if (isset($_FILES)) {
        $uploadPic = move_uploaded_file($_FILES["file"]["tmp_name"], "../images/persons/" . $personID . ".jpg");
    }
    if ($resEditPerson || $resEditCon || $uploadPic) {
        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=editContactCompleted");
    } else {
//        header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=editContactFailed");
    }
} else if ($para == "addService") {
    $CustomerID = $_POST['cusID'];
    $package = $_POST['package'];
    $networkLink = $_POST['networkLink'];
    $Location = $_POST['location'];
    $CreateBy = $PersonID;

    $resService = addService($CustomerID, $Location, $CreateBy);
    if ($resService) {
        for ($i = 0; $i < count($package['amount']); $i++) {
            for ($j = 0; $j < $package['amount'][$i]; $j++) {
                $resServiceDetail = addServiceDetail($resService, $package['ID'][$i]);
                $resServiceDetailAction = addServiceDetailAction($resServiceDetail, "Active", "Create Service");
            }
        }
        // add network link detail
    }
    if ($resService) {
        header("location: ../../core/?p=viewCus&cusID=" . $CustomerID . "&para=addServiceCompleted");
    } else {
        header("location: ../../core/?p=viewCus&cusID=" . $CustomerID . "&para=addServiceFailed");
    }
} else if ($para == "editCustomer") {

    $cusID = $_GET['cusID'];

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
} else if ($para == "changeServiceDetailStatus") {
    $cusID = $_GET['cusID'];
    $arrServiceDetailID = $_POST['serviceDetailID'];
    $arrStatus = $_POST['status'];
    $arrCause = $_POST['cause'];

    $countItem = count($arrServiceDetailID);
    for ($i = 0; $i < $countItem; $i++) {
        addServiceDetailAction($arrServiceDetailID[$i], $arrStatus[$i], $arrCause[$i]);
    }

    header("location: ../../core/?p=viewCus&cusID=" . $cusID . "&para=AddServiceDetailStatusCompleted");
}