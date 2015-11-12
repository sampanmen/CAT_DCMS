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
        header("location: ../../core/?p=setting&para=addStaffpositionCompleted");
    } else {
        header("location: ../../core/?p=setting&para=addStaffpositionFailed");
    }
} else if ($para == "addBusinesstype") {
    //   print_r($_POST);
    $businesstype = $_POST['businessType'];
    $status = $_POST['status'];
    $res = addBusinesstype($businesstype, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addBusinesstypeCompleted#Businesstype");
    } else {
        header("location: ../../core/?p=setting&para=addBusinesstypeFailed#Businesstype");
    }
} else if ($para == "addLocation") {
    //   print_r($_POST);
    $location = $_POST['location'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $res = addLocation($location, $address, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addLocationCompleted#location");
    } else {
        header("location: ../../core/?p=setting&para=addLocationFailed#location");
    }
} else if ($para == "addPacCatagory") {
    //   print_r($_POST);
    $category = $_POST['category'];
    $status = $_POST['status'];

    $res = addPacCatagory($category, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addPacCatagoryCompleted#CatagoryPackage");
    } else {
        header("location: ../../core/?p=setting&para=addPacCatagoryFailed#CatagoryPackage");
    }
} else if ($para == "addDivision") {
    //   print_r($_POST);
    $division = $_POST['division'];
    $organization = $_POST['organization'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $res = addDivision($division, $organization, $address, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addDivisionCompleted#division");
    } else {
        header("location: ../../core/?p=setting&para=addDivisionFailed#division");
    }
} else if ($para == "addZone") {
    //   print_r($_POST);
    $zone = $_POST['zone'];
    $locazone = $_POST['locazone'];
    $status = $_POST['status'];

    $res = addZone($zone, $locazone, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addZoneCompleted#zone");
    } else {
        header("location: ../../core/?p=setting&para=addZoneFailed#zone");
    }
} else if ($para == "editPosition") {
    //   print_r($_POST);
    $staffPositionID = $_GET['StaffPositionID'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    $res = editPosition($staffPositionID, $position, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=editPositionCompleted");
    } else {
        header("location: ../../core/?p=setting&para=editPositionFailed");
    }
} else if ($para == "editCategory") {
    //   print_r($_POST);
    $packageCategoryID = $_GET['PackageCategoryID'];
    $packageCategory = $_POST['packageCategory'];
    $status = $_POST['status'];

    $res = editCategory($packageCategoryID, $packageCategory, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=editCategoryCompleted");
    } else {
        header("location: ../../core/?p=setting&para=editCategoryFailed");
    }
} else if ($para == "editLocation") {
    //   print_r($_POST);
    $locationID = $_GET['LocationID'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $res = editLocation($locationID, $location, $address, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=editLocationCompleted");
    } else {
        header("location: ../../core/?p=setting&para=editLocationFailed");
    }
} else if ($para == "editBusinesstype") {
    //   print_r($_POST);
    $businessTypeID = $_GET['BusinessTypeID'];
    $businessType = $_POST['businessType'];
    $status = $_POST['status'];

    $res = editBusinesstype($businessTypeID, $businessType, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=editBusinesstypeCompleted");
    } else {
        header("location: ../../core/?p=setting&para=editBusinesstypeFailed");
    }
} else if ($para == "editZone") {
    //   print_r($_POST);
    $entryZoneID = $_GET['EntryZoneID'];
    $zone = $_POST['zone'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    $res = editZone($entryZoneID, $zone, $location, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=editZoneCompleted");
    } else {
        header("location: ../../core/?p=setting&para=editZoneFailed");
    }
} else if ($para == "addStaff") {
    //   print_r($_POST);
    $IDStaff = $_POST['IDStaff'];
    $nameStaff = $_POST['nameStaff'];
    $snameStaff = $_POST['snameStaff'];
    $phoneStaff = $_POST['phoneStaff'];
    $emailStaff = $_POST['emailStaff'];
    $idcardStaff = $_POST['idcardStaff'];
    $positionStaff = $_POST['positionStaff'];
    $file = $_POST['file'];
    $status = $_POST['status'];

    $res = addStaff($IDStaff, $nameStaff, $snameStaff, $phoneStaff, $emailStaff, $idcardStaff, $positionStaff, $file, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=addaddStaffCompleted");
    } else {
        header("location: ../../core/?p=setting&para=addaddStaffFailed");
    }
} else if ($para == "editDivision") {
    //   print_r($_POST);
    $divisionID = $_GET['DivisionID'];

    $division = $_POST['division'];
    $organization = $_POST['organization'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $res = editDivision($divisionID, $division, $organization, $address, $status);
    if ($res) {
        header("location: ../../core/?p=setting&para=editDivisionCompleted");
    } else {
        header("location: ../../core/?p=setting&para=editDivisionFailed");
    }
} else if ($para == "addStaff") {
    $IDStaff = $_POST['IDStaff'];
    $nameStaff = $_POST['nameStaff'];
    $snameStaff = $_POST['snameStaff'];
    $phoneStaff = $_POST['phoneStaff'];
    $emailStaff = $_POST['emailStaff'];
    $idcardStaff = $_POST['idcardStaff'];
    $personType = "Staff";
    $positionStaff = $_POST['positionStaff'];
    $divisionStaff = $_POST['divisionStaff'];
    $status = $_POST['status'];
    $con = $_POST['con'];
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $resInsertStaff = addPerson($IDStaff, $nameStaff, $snameStaff, $phoneStaff, $emailStaff, $idcardStaff, $personType, $positionStaff, $status, $PersonID);
    if ($resInsertStaff) {
//        $resInsertCon = true;
        $resInsertPersonContact = addStaff($resInsertCus, $resInsertPerson, NULL, NULL, $con_contactType);
//            echo $resInsertCon . "<br>.";
//            echo "///";
//            echo "<pre>";
////            print_r($_FILES);
//            echo $resInsertCon."<br>";
//            echo "</pre>";
//            echo $_FILES["file"]["name"][$i]."<br>";
        move_uploaded_file($_FILES["file"]["tmp_name"][$i], "../../customer/images/persons/" . $resInsertPerson . ".jpg");

        if ($resInsertPerson) {
            header("location: ../../core/?p=viewCus&cusID=" . $resInsertCus . "&para=addCustomerCompleted");
        } else {
            header("location: ../../core/?p=cusHome&para=addCustomerFailed");
        }
    }
}