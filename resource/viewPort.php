<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$swID = (isset($_GET['swID'])) ? $_GET['swID'] : "";
?>
<p><a href="?">Home</a> > <b>Switch&Port</b></p>
<div class="row">
    <div class="col-lg-4"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Switch</b> <a href="../resource/modal_addSwitch.php" data-toggle="modal" data-target="#myModal">(Add)</a></h5>
            </div>      

            <div class="panel-body">
                <div class="form-group">
                    <select class="form-control" name="location" id="location2" onchange="showSwitch();">
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
                    <script>
                        showSwitch();
                        function showSwitch() {
                            var getLocation = $("#location2").val();
                            $.get("../resource/action/resource.content.showSwitch.php?LocationID=" + getLocation, function (data, status) {
                                $("#showSwitch").html(data);
                            });
                        }
                    </script>
                </div>
                <div class="dataTable_wrapper" id="showSwitch">
                    <!--Show Switch-->
                </div>
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>

    <div class="col-lg-8"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Port </b></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>Switch name</th>
                                <th>Port No.</th>
                                <th>Type</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getSwitchID = isset($_GET['SwitchID']) ? $_GET['SwitchID'] : "";
                            $swPort = getSwitchPorts($getSwitchID);
                            foreach ($swPort as $value) {
                                $valSwitchName = $value['SwitchName'];
                                $valPortNumber = $value['PortNumber'];
                                $valPortType = $value['PortType'];
                                $valCustomerID = $value['CustomerID'];
                                $valCustomerName = $value['CustomerName'];
                                $valUplink = $value['Uplink'];
                                $valStatusUsed = $value['StatusUsed'];
                                ?>
                                <tr>
                                    <td><?php echo $valSwitchName; ?></td>
                                    <td><?php echo $valPortNumber; ?></td>
                                    <td><?php echo $valPortType; ?></td>
                                    <td>
                                        <?php echo ($valUplink == 1) ? "Uplink" : (($valCustomerName == NULL || $valStatusUsed == "Deactive") ? "NULL" : "<a target='_blank' href='?p=viewCus&cusID=" . $valCustomerID . "'>" . $valCustomerName . "</a>"); ?>
                                    </td>
                                </tr> 
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.row (nested) -->
        </div><!-- /.panel-body -->
    </div>
</div>
