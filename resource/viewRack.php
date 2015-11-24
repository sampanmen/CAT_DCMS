<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$zone = (!isset($_GET['zone']) || $_GET['zone'] == "") ? "%" : $_GET['zone'];
$type = (!isset($_GET['type']) || $_GET['type'] == "") ? "%" : $_GET['type'];
?>

<p><a href="?">Home</a> > <b>Rack</b></p>
<div class="row">
    <div class="col-lg-4"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Rack </b><a href="../resource/model_addRack.php" data-toggle="modal" data-target="#myModal">(Add)</a></h5>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <select class="form-control" name="location" id="location" onchange="showNetwork();">
                        <option value="">Choose location</option>
                        <?php
                        $getLocationID = $_GET['LocationID'];
                        $getLocation = getLocation();
                        foreach ($getLocation as $value) {
                            $valLocationID = $value['LocationID'];
                            $valLocation = $value['Location'];
                            ?>
                            <option <?php echo $valLocationID == $getLocationID ? "selected" : ""; ?> value="<?php echo $valLocationID; ?>"><?php echo $valLocation; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="location" id="type" onchange="showRackPosition();">
                        <option value="">Choose type</option>
                        <?php
                        $getCateID = $_GET['Type'];
                        $Types = getCatagory();
                        foreach ($Types as $value) {
                            $valCateID = $value['PackageCategoryID'];
                            $valCate = $value['PackageCategory'];
                            $valType = $value['Type'];
                            if ($valType != "Rack") {
                                continue;
                            }
                            ?>
                            <option <?php echo $getCateID == $valCateID ? "selected" : ""; ?> value="<?php echo $valCateID; ?>"><?php echo $valCate; ?></option>
                        <?php } ?>
                    </select>

                </div>
                <!--                <div class="form-group">
                                    <button class="form-control btn btn-info" onclick="showRackPosition();">Get Rack Position</button>
                                </div>-->
                <script>
                    showRackPosition();
                    function showRackPosition() {
                        var getLocation = $("#location").val();
                        var getType = $("#type").val();
                        $.get("../resource/action/resource.content.showRackPosition.php?LocationID=" + getLocation + "&Type=" + getType, function (data, status) {
                            $("#showRackPosition").html(data);
                        });
                    }
                </script>
                <div class="dataTable_wrapper" id="showRackPosition">

                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    <div class="col-lg-8"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Rack</b></h5>
            </div>
            <div class="panel-body">

                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>Type Rack</th>
                                <th>Column</th>
                                <th>Row</th>
                                <th>Position</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getRackPositionID = isset($_GET['RackPositionID']) ? $_GET['RackPositionID'] : "";
                            $getRacks = getRackByRackPositionID($getRackPositionID);
                            foreach ($getRacks as $value) {
                                $valType = $value['RackType'];
                                $valCol = $value['Col'];
                                $valRow = $value['Row'];
                                $valPosition = $value['SubRackPosition'];
                                $valCustomerName = $value['CustomerName'];
                                $valCustomerID = $value['CustomerID'];
                                $valStatusUsed = $value['StatusUsed'];
                                ?>
                                <tr>
                                    <td><?php echo $valType; ?></td>
                                    <td><?php echo $valCol; ?></td>
                                    <td><?php echo $valRow; ?></td>
                                    <td><?php echo $valPosition; ?></td>
                                    <td><?php echo ($valCustomerName == NULL || $valStatusUsed == "Deactive") ? "NULL" : "<a target='_blank' href='?p=viewCus&cusID=" . $valCustomerID . "'>" . $valCustomerName . "</a>"; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
</div>
