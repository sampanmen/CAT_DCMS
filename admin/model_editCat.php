<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$getPackageCategoryID = $_GET['PackageCategoryID'];

//get position
$getCatagory = getCatagoryByID($getPackageCategoryID);
$packageCategory = $getCatagory['PackageCategory'];
$packageCategoryType = $getCatagory['Type'];
$status = $getCatagory['Status'];
?>



<form method="POST" action="../admin/action/admin.action.php?para=editCategory&PackageCategoryID=<?php echo $getPackageCategoryID; ?>" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Catagory</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">

                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Catagory</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="packageCategory" value="<?php echo $packageCategory; ?>" >  
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option>Choose</option>
                                <option <?php echo $packageCategoryType=="Rack"?"selected":""; ?> value="Rack">Rack</option>
                                <option <?php echo $packageCategoryType=="IP Address"?"selected":""; ?> value="IP Address">IP Address</option>
                                <option <?php echo $packageCategoryType=="Port"?"selected":""; ?> value="Port">Port</option>
                                <option <?php echo $packageCategoryType=="Other"?"selected":""; ?> value="Other">Other</option>
                            </select>
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