<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$getSwitchID = isset($_GET['SwitchID']) ? $_GET['SwitchID'] : "";

$getSwitch = getSwitchByID($getSwitchID);

$SwitchName = $getSwitch['SwitchName'];
$SwitchIP = $getSwitch['SwitchIP'];
$TotalPort = $getSwitch['TotalPort'];
$SnmpCommuPublic = $getSwitch['SnmpCommuPublic'];
$SwitchTypeID = $getSwitch['SwitchTypeID'];
$Brand = $getSwitch['Brand'];
$Model = $getSwitch['Model'];
$SerialNo = $getSwitch['SerialNo'];
$RackID = $getSwitch['RackID'];
$Status = $getSwitch['Status'];
$LocationID = $getSwitch['LocationID'];
?>
<form method="POST" action="../resource/action/resource.action.edit.php?para=editSwitch&SwitchID=<?php echo $getSwitchID; ?>">
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
                            <input class="form-control" name="name" value="<?php echo $SwitchName; ?>"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>IP Address</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="ip" value="<?php echo $SwitchIP; ?>">                        
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>SNMP Community</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="password" name="commu" value="<?php echo $SnmpCommuPublic; ?>">                                
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
                                    <option <?php echo $SwitchTypeID == $valSwitchTypeID ? "selected" : ""; ?> value="<?php echo $valSwitchTypeID; ?>"><?php echo $valSwitchType; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Number of Port</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="number" name="port" value="<?php echo $TotalPort; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Location</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="Location" disabled>
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
                            <label>Brand</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="brand" value="<?php echo $Brand; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Model</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="model" value="<?php echo $Model; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Serial No</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="serialNo" value="<?php echo $SerialNo; ?>">
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