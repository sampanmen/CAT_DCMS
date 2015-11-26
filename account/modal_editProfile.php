<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

//get Username and PersonID
$Username = $_SESSION['Account']['Username'];
$getAccounts = checkLogin($Username);
$PersonID = $getAccounts['PersonID'];

//get Person
$getPersons = getPerson($PersonID);
$staffFname = $getPersons['Fname'];
$staffLname = $getPersons['Lname'];
$staffPhone = $getPersons['Phone'];
$staffEmail = $getPersons['Email'];
$staffIDCard = $getPersons['IDCard'];
//$staffType = $getPersons['ContactType'];
$staffStatus = $getPersons['PersonStatus'];

//get staff

$getStafff = getStaffByID($PersonID);
//$staffID = $getStafff['staffID'];
$EmployeeID = $getStafff['EmployeeID'];
$StaffPositionID = $getStafff['StaffPositionID'];
$DivisionID = $getStafff['DivisionID'];
?>
<form method="POST" action="../account/action/account.action.editProfile.php" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel"></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">

                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ID Staff</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="IDStaff" value="<?php echo $EmployeeID; ?>"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="nameStaff" value="<?php echo $staffFname; ?>"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Surname</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="snameStaff" value="<?php echo $staffLname; ?>">    
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>โทรศัพท์ / Phone</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="phoneStaff" value="<?php echo $staffPhone; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>e-mail</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" type="email" name="emailStaff" value="<?php echo $staffEmail; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รหัสบัตรประชาชน / ID Card</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="idcardStaff" value="<?php echo $staffIDCard; ?>">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ตำแหน่ง / Position</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="positionStaffID" disabled>
                                <?php
                                $positon = getStaffPosition();
                                foreach ($positon as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option <?php echo $StaffPositionID == $value['StaffPositionID'] ? "selected" : ""; ?> value="<?php echo $value['StaffPositionID']; ?>"><?php echo $value['Position']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>แผนก / Division </label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="divisionStaff">
                                <?php
                                $division = getDivision();
                                foreach ($division as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option <?php echo $DivisionID == $value['DivisionID'] ? "selected" : ""; ?> value="<?php echo $value['DivisionID']; ?>">[<?php echo $value['Organization']; ?>] <?php echo $value['Division']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Status</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="status" disabled>
                                <option <?php echo $staffStatus == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $staffStatus == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รูปภาพ / Picture</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="file" name="file"  accept=".jpg">                                    
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
</form>