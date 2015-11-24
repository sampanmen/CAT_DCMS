<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<form method="POST" action="?p=addPort">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Port</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Switch Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="name"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>IP Address</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="ip">                        
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>SNMP Community</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="password" name="commu">                                
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="typeSW">
                                <?php
                                $getSwitchType = getSwitchType();
                                foreach ($getSwitchType as $value) {
                                    if ($value['Status'] != "Active") {
                                        continue;
                                    }
                                    $valSwitchTypeID = $value['SwitchTypeID'];
                                    $valSwitchType = $value['SwitchType'];
                                    ?>
                                    <option value="<?php echo $valSwitchTypeID; ?>"><?php echo $valSwitchType; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Number of Port</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="number" name="port">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Location</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="Location">
                                <option value="">Choose</option>
                                <?php
                                $getLocation = getLocation();
                                foreach ($getLocation as $value) {
                                    $valLocationID = $value['LocationID'];
                                    $valLocation = $value['Location'];
                                    ?>
                                    <option value="<?php echo $valLocationID; ?>"><?php echo $valLocation; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Brand</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="brand">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Model</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="model">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Serial No</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="serialNo">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Rack</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="rackID">
                                <option value="">n/a</option>
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