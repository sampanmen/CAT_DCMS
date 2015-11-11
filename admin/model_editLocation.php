<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$getLocationID = $_GET['LocationID'];

//get position
$getLocation = getLocationByID($getLocationID);
$location = $getLocation['Location'];
$address = $getLocation['Address'];
$status = $getLocation['Status'];

?>





<form method="POST" action="../admin/action/admin.action.php?para=editLocation&LocationID=<?php echo $getLocationID; ?>" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Location</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Location</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                              <input class="form-control" name="location" value="<?php echo $location; ?>" >  
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Address</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <textarea class="form-control" name="address"><?php echo $address; ?></textarea>
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