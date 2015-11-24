<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<form method="POST" action="../resource/action/resource.action.php?para=addRack">
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
                            <input class="form-control" type="number" name="size" value="42">
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">
                            <label>Rack Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <?php
                                $getTypes = getCatagory();
                                foreach ($getTypes as $value) {
                                    if ($value['Type'] != "Rack") {
                                        continue;
                                    }
                                    $valPackageCategory = $value['PackageCategory'];
                                    $valPackageCategoryID = $value['PackageCategoryID'];
                                    ?>
                                    <option value="<?php echo $valPackageCategoryID; ?>"><?php echo $valPackageCategory; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Location</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="location" id="location2" onchange="showCol();">
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
                            <label>Rack Column</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <select class="form-control" id="Col1" onchange="chkCol();">

                            </select>                                 
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="col" id="Col2" required>
                        </div>
                        <script>
                            function chkCol() {
                                var zone1 = $("#Col1").val();
                                $("#Col2").val(zone1);
                            }
                            function showCol() {
                                var locationID = $("#location2").val();
                                $.get("../resource/action/resource.content.php?para=getRacksColumn&LocationID=" + locationID, function (data, status) {
                                    $("#Col1").html(data);
                                });
                            }
                        </script>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <label>Amount</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="amount" type="number" value="1" required>                                   
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