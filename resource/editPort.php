<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$p = "&modal=true";
$Permission = array("admin", "engineering");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$getPost = $_POST;
$getPostJson = json_encode($getPost);

$SwitchName = $_POST['name'];
$SwitchIP = $_POST['ip'];
$SwitchTypeID = $_POST['typeSW'];
$TotalPort = $_POST['port'];
$SwitchType = getSwitchTypeByID($SwitchTypeID)['SwitchType'];
?>
<p><a href="?">Home</a> > Switch&Port > <b>Add Port</b></p>
<div class="row">
    <form action="../resource/action/resource.action.php?para=addPort" method="POST">
        <div class="col-lg-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><b>Add Port </b></h5>
                </div>      

                <div class="panel-body">
                    <div>
                        <h4><b>Name:</b> <?php echo $SwitchName; ?></h4>
                        <h4><b>IP Address:</b> <?php echo $SwitchIP; ?></h4>
                        <h4><b>Type:</b> <?php echo $SwitchType; ?></h4>
                        <h4><b>Total: </b><?php echo $TotalPort; ?> Ports</h4>
                        <input type="hidden" id="switch" name="switch" value='<?php echo $getPostJson; ?>'>
                    </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Type</th>
                                    <th>Vlan</th>
                                    <th>Uplink</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 1; $i <= $TotalPort; $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td class="form-group">
                                            <select class="form-control" name="portType[<?php echo $i; ?>]">
                                                <?php
                                                $getTypes = getCatagory();
                                                foreach ($getTypes as $value) {
                                                    if ($value['Type'] != "Port") {
                                                        continue;
                                                    }
                                                    $valPackageCategory = $value['PackageCategory'];
                                                    $valPackageCategoryID = $value['PackageCategoryID'];
                                                    ?>
                                                    <option value="<?php echo $valPackageCategoryID; ?>"><?php echo $valPackageCategory; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="form-group">
                                            <input type="text" class="form-control" name="vlan[<?php echo $i; ?>]">
                                        </td>
                                        <td class="form-group">
                                            <input class="checkbox-inline" type="checkbox" name="uplink[<?php echo $i; ?>]">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
    </form>
</div>
