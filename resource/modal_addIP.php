<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "helpdesk", "engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<form method="POST" action="../resource/action/resource.action.php?para=addIP">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add IP</h4>
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
                            <input class="form-control" name="network">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Subnet</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <select class="form-control" name="subnet">
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Vlan</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="number" class="form-control" name="vlan">                                
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>