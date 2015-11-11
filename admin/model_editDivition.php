<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$getDivisionID = $_GET['DivisionID'];


$getDivision = getDivitionByID($getDivisionID);
$division = $getDivision['Division'];
$organization = $getDivision['Organization'];
$address = $getDivision['Address'];
$status = $getDivision['Status'];


?>





<form method="POST" action="../admin/action/admin.action.php?para=editDivition&DivisionID=<?php echo $getDivisionID; ?>" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Divition</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Divition</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="divition" value="<?php echo $division; ?>" >
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Organization</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <select class="form-control" name="organization">
                                <option <?php echo $organization == "CAT" ? "selected" : ""; ?> value="CAT">CAT</option>
                                <option <?php echo $organization == "Vender" ? "selected" : ""; ?> value="Vender">Vender</option>
                            </select>
                                
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