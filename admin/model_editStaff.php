
<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$getPersonID = $_GET['PersonID'];


$getPer = getPerson($getPersonID);
$Fname = $getPer['Fname'];
$Lname = $getPer['Lname'];
$Phone = $getPer['Phone'];
$Email = $getPer['Email'];
$IDCard = $getPer['IDCard'];
$TypePerson = $getPer['TypePerson'];
$PersonStatus = $getPer['PersonStatus'];

$getStaff = getStaffByID($getPersonID);
$staffID = $getStaff['staffID'];
$EmployeeID = $getStaff['EmployeeID'];
$StaffPositionID = $getStaff['StaffPositionID'];
$DivisionID = $getStaff['DivisionID'];

?>







<form method="POST" action="../admin/action/admin.action.php?para=editStaff&PersonID=<?php echo $getPersonID; ?>" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">0001</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                               <input class="form-control" name="nameStaff" value="<?php echo $Fname; ?>"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Surname</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                             <input class="form-control" name="snameStaff" value="<?php echo $Lname; ?>">    
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>โทรศัพท์ / Phone</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="phoneStaff" value="<?php echo $Phone; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>e-mail</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                              <input class="form-control" type="email" name="emailStaff" value="<?php echo $Email; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รหัสบัตรประชาชน / ID Card</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="idcardStaff" value="<?php echo $IDCard; ?>">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ตำแหน่ง / Position</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="positionStaffID" >
                                <?php
                                $positon = getStaffPosition();
                                foreach ($positon as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['StaffPositionID']; ?>"><?php echo $value['Position']; ?></option>
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
                                $positon = getDivision();
                                foreach ($positon as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['DivisionID']; ?>">[<?php echo $value['Organization']; ?>] <?php echo $value['Division']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Status</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="status">
                                <option <?php echo $value == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $value == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
                            </select>
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