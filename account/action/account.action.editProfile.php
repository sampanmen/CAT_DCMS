<?php

require_once dirname(__FILE__) . '/../../system/config.inc.php';
require_once dirname(__FILE__) . '/../function/account.func.inc.php';
require_once dirname(__FILE__) . '/../../system/function.inc.php';
session_start();

//get Username and PersonID
$Username = $_SESSION['Account']['Username'];
$getAccounts = checkLogin($Username);
$PersonID = $getAccounts['PersonID'];

//get Person
$getPersons = getPerson($PersonID);
$staffStatus = $getPersons['PersonStatus'];

//get Staff
$getStafff = getStaffByID($PersonID);
$StaffPositionID = $getStafff['StaffPositionID'];

$IDStaff = $_POST['IDStaff'];
$nameStaff = $_POST['nameStaff'];
$snameStaff = $_POST['snameStaff'];
$phoneStaff = $_POST['phoneStaff'];
$emailStaff = $_POST['emailStaff'];
$idcardStaff = $_POST['idcardStaff'];
$typestaff = "Staff";
//$positionStaffID = $_POST['positionStaffID'];
$divisionStaff = $_POST['divisionStaff'];
//$status = $_POST['status'];

$resEditPerson = editPerson($personID, $nameStaff, $snameStaff, $phoneStaff, $emailStaff, $idcardStaff, $typestaff, $staffStatus);
$resEditStaff = editStaff($personID, $IDStaff, $StaffPositionID, $divisionStaff);
if (isset($_FILES)) {
    $uploadPic = move_uploaded_file($_FILES["file"]["tmp_name"], "../../customer/images/persons/" . $PersonID . ".jpg");
}
if ($resEditPerson || $resEditStaff || $uploadPic) {
    header("location: ../../core/?p=home&PersonID=" . $PersonID . "&para=editProfileCompleted");
} else {
    header("location: ../../core/?p=home&para=editProfileFailed");
}