<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$getStaffPositionID = $_GET['StaffPositionID'];

//get position
$getPosition = getStaffPositionByID($getStaffPositionID);
$position = $getPosition['Position'];
$status = $getPosition['Status'];

?>

<form method="POST" action="../admin/action/admin.action.php?para=editPosition&StaffPositionID=<?php echo $getStaffPositionID; ?>" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Admin</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">

                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Position</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="position" value="<?php echo $position; ?>">                                 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Status</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="status">
                                <option <?php echo $status == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $status == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
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