<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$networkID = isset($_GET['NetworkID']) ? $_GET['NetworkID'] : "";

$getNetwork = getNetworksByID($networkID);

$NetworkIP = $getNetwork['NetworkIP'];
$Subnet = $getNetwork['Subnet'];
$Vlan = $getNetwork['Vlan'];
$AmountIP = $getNetwork['AmountIP'];
$LocationID = $getNetwork['LocationID'];
$Status = $getNetwork['Status'];
?>
<form method="POST" action="../resource/action/resource.action.edit.php?para=editNetwork&NetworkID=<?php echo $networkID; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Edit Network</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Network IP</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="network" value="<?php echo $NetworkIP; ?>" disabled>                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Subnet</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" type="text" value="<?php echo $Subnet; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Vlan</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="number" class="form-control" name="vlan" value="<?php echo $Vlan; ?>">                                
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