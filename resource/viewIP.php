<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$networkID = isset($_GET['NetworkID']) ? $_GET['NetworkID'] : "";
$getIPs = getIPs($networkID);
?>
<p><a href="?">Home</a> > <b>IP Address</b></p>
<div class="row">
    <div class="col-lg-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Network IP </b><a href="../resource/modal_addIP.php" data-toggle="modal" data-target="#myModal">(Add)</a></h5>
            </div>      

            <div class="panel-body">
                <div class="form-group">
                    <select class="form-control" name="location" id="location2" onchange="showNetwork();">
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
                        showNetwork();
                        function showNetwork() {
                            var getLocation = $("#location2").val();
                            $.get("../resource/action/resource.content.showIP.php?LocationID=" + getLocation, function (data, status) {
                                $("#showNetwork").html(data);
                            });
                        }
                    </script>
                </div>
                <div class="dataTable_wrapper" id="showNetwork">
                    <!--show IP here-->
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>

    <!--IP-->
    <div class="col-lg-8"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>IP Address </b></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>IP Address</th>
                                <th>Network</th>
                                <th>Subnet</th>
                                <th>Vlan</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($getIPs as $value) {
                                $i++;
                                $valIP = $value['IP'];
                                $valNetworkIP = $value['NetworkIP'];
                                $valSubnet = $value['Subnet'];
                                $valVlan = $value['Vlan'];
                                $valCustomerName = $value['CustomerName'];
                                $valCustomerID = $value['CustomerID'];
                                $valStatusUsed = $value['StatusUsed'];
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $valIP; ?></td>
                                    <td><?php echo $valNetworkIP; ?></td>
                                    <td><?php echo $valSubnet; ?></td>
                                    <td><?php echo $valVlan; ?></td>
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