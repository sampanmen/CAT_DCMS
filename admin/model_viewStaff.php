<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';


$getPersonID = $_GET['PersonID'];

//get Person
$getStaffID = getStaffByID($getPersonID);
$staffFname = $getStaffID['Fname'];
$staffLname = $getStaffID['Lname'];
$staffPhone = $getStaffID['Phone'];
$staffEmail = $getStaffID['Email'];
$staffIDCard = $getStaffID['IDCard'];
//$staffType = $getPersons['ContactType'];
$staffStatus = $getStaffID['PersonStatus'];

//get staff
//$staffID = $getStaffID['staffID'];
$EmployeeID = $getStaffID['EmployeeID'];
$StaffPositionID = $getStaffID['StaffPositionID'];
$Position = $getStaffID['Position'];
$DivisionID = $getStaffID['DivisionID'];
$Division = $getStaffID['Division'];
$Organization = $getStaffID['Organization'];
?>

<!--<form method="POST" action="../admin/action/admin.action.php?para=editStaff&PersonID=<?php echo $getPersonID; ?>" enctype="multipart/form-data">-->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel"></h4>
</div>

<div class="modal-body">
    <div class="container-fluid">
        <div class="row">                       
            <div class="col-lg-12">

                <div class="col-lg-4 text-left">
                    <?php
                    $images = '../customer/images/persons/' . $getPersonID . ".jpg";
                    $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";
                    $images = '../customer/images/persons/' . $getPersonID . ".jpg";
                    $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";
                    $showImage = "../system/image_1-1.php?url=" . $showImage;
                    ?>
                    <img class="img-thumbnail " src = "<?php echo $showImage; ?>" width="100%" height="" border="1">
                </div>
                <div class="col-lg-8 text-left">
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>ID Staff:</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p> <?php echo $EmployeeID; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>Name:</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p>  <?php echo $staffFname . " " . $staffLname; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>Email:</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p> <?php echo $staffEmail; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>Phone:</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p> <?php echo $staffPhone; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>ID Card:</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p> <?php echo $staffIDCard; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>Position:</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p> <?php echo $Position; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>Divition :</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p> [<?php echo $Organization; ?>] <?php echo $Division; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <p><b>Status :</b> </p> 
                        </div>
                        <div class="col-lg-8">
                            <p class="label label-<?php echo $staffStatus == "Active" ? "success" : ($staffStatus == "Deactive" ? "danger" : "warning"); ?>"><?php echo $staffStatus; ?></p>
                        </div>
                    </div>






                </div>
            </div>
        </div>
    </div>




    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <!--</form>-->