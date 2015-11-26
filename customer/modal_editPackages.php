<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$packageID = $_GET['packageID'];

$getPackage = getPackage($packageID);
$packageName = $getPackage['PackageName'];
$packageDetail = $getPackage['PackageDetail'];
$packageType = $getPackage['PackageType'];
$packageCategoryID = $getPackage['PackageCategoryID'];
$packageCategory = $getPackage['PackageCategory'];
$locationID = $getPackage['LocationID'];
$location = $getPackage['Location'];
$packageStatus = $getPackage['PackageStatus'];

$getResourceAmount = getResourceAmount($packageID);
$ipAmount = $getResourceAmount['IPAmount'];
$serviceAmount = $getResourceAmount['ServiceAmount'];
$rackAmount = $getResourceAmount['RackAmount'];
$portAmount = $getResourceAmount['PortAmount'];

$packageCategory = getPackageCategory();
$location = getLocation();
?>
<form action="../customer/action/customer.action.php?para=editPackage&packageID=<?php echo $packageID; ?>" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Edit Packages</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="form-group">
                                <label>ชื่อบริการ / Service Name</label>
                                <input class="form-control" name="name" value="<?php echo $packageName; ?>">                                
                            </div>   
                            <div class="form-group">
                                <label>รายละเอียด / Detail</label>
                                <textarea class="form-control" rows="3" name="detail"><?php echo $packageDetail; ?></textarea>                              
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>ประเภทบริการ / Type Service</label>
                            <select class="form-control" name="type">
                                <option <?php echo $packageType == 'Main' ? "selected" : ""; ?> value="Main">Main</option>
                                <option <?php echo $packageType == 'Add-on' ? "selected" : ""; ?> value="Add-on">Add-On</option>
                            </select>  
                        </div>
                        <div class="form-group col-lg-6">
                            <label>หมวดหมู่ / Category</label> 
                            <select class="form-control" name="category">
                                <?php
                                foreach ($packageCategory as $value) {
                                    if ($value['Status'] == "Deactive") {
                                        continue;
                                    }
                                    $varCategoryID = $value['PackageCategoryID'];
                                    $varCategory = $value['PackageCategory'];
                                    ?>
                                    <option <?php echo $varCategoryID == $packageCategoryID ? "selected" : ""; ?> value="<?php echo $varCategoryID; ?>"><?php echo $varCategory; ?></option>
                                <?php } ?>
                            </select>   
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน IP Addres</label>
                            <input class="form-control" name="amount[ip]" value="<?php echo $ipAmount; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Port</label>
                            <input class="form-control" name="amount[port]" value="<?php echo $portAmount; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Rack</label>
                            <input class="form-control" name="amount[rack]" value="<?php echo $rackAmount; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Service</label>
                            <input class="form-control" name="amount[service]" value="<?php echo $serviceAmount; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Location</label>
                            <select class="form-control" name="location">                                  
                                <?php
                                foreach ($location as $value) {
                                    if ($value['Status'] == "Deactive") {
                                        continue;
                                    }
                                    $varLocationID = $value['LocationID'];
                                    $varLocation = $value['Location'];
                                    ?>
                                    <option <?php echo $varLocationID == $locationID ? "selected" : ""; ?> value="<?php echo $varLocationID; ?>"><?php echo $varLocation; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Status</label>
                            <select class="form-control" name="status">                                  
                                <option <?php echo $getPackage['PackageStatus'] == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $getPackage['PackageStatus'] == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
                            </select>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div> 
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>