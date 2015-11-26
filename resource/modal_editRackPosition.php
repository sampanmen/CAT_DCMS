<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$RackPositionID = $_GET['RackPositionID'];
$getRackPosition = getRackPositionByID($RackPositionID);
$Col = $getRackPosition['Col'];
$Row = $getRackPosition['Row'];
$PackageCategoryID = $getRackPosition['PackageCategoryID'];
$RackSize = $getRackPosition['RackSize'];
$Status = $getRackPosition['Status'];
$LocationID = $getRackPosition['LocationID'];
?>
<form method="POST" action="../resource/action/resource.action.edit.php?para=editRackPosition&RackPositionID=<?php echo $RackPositionID; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Rack</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Rack Size</label>
                        </div>
                        <div class="form-group col-lg-3"> 
                            <input class="form-control" type="number" name="size" value="<?php echo $RackSize; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">
                            <label>Rack Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type" disabled>
                                <?php
                                $getTypes = getCatagory();
                                foreach ($getTypes as $value) {
                                    if ($value['Type'] != "Rack") {
                                        continue;
                                    }
                                    $valPackageCategory = $value['PackageCategory'];
                                    $valPackageCategoryID = $value['PackageCategoryID'];
                                    ?>
                                    <option <?php echo $PackageCategoryID == $valPackageCategoryID ? "selected" : ""; ?> value="<?php echo $valPackageCategoryID; ?>"><?php echo $valPackageCategory; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Location</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="location" id="location2" onchange="showCol();" disabled>
                                <option value="">Choose</option>
                                <?php
                                $getLocation = getLocation();
                                foreach ($getLocation as $value) {
                                    $valLocationID = $value['LocationID'];
                                    $valLocation = $value['Location'];
                                    ?>
                                    <option <?php echo $LocationID == $valLocationID ? "selected" : ""; ?> value="<?php echo $valLocationID; ?>"><?php echo $valLocation; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Rack Column</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="col" id="Col2" value="<?php echo $Col; ?>" required>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Rack Row</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="row" type="number" value="<?php echo $Row; ?>" required>                                   
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Status</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <select class="form-control" name="status">
                                <option <?php echo $Status == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $Status == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
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