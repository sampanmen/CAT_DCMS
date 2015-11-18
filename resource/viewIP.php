<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$networkID = isset($_GET['NetworkID']) ? $_GET['NetworkID'] : "";
$getIPs = getIPs($networkID);
?>
<p><a href="?">Home</a> > <b>IP Address</b></p>
<div class="row">
    <div class="col-lg-3"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Network IP </b><a href="../resource/model_addIP.php" data-toggle="modal" data-target="#myModal">(Add)</a></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Network</th>
                                <th>Vlan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getNetworks = getNetworks();
                            foreach ($getNetworks as $value) {
                                $valNetworkID = $value['NetworkID'];
                                $valNetwork = $value['NetworkIP'];
                                $valSubnet = $value['Subnet'];
                                $valVlan = $value['Vlan'];
                                $valStatus = $value['Status'];
                                ?>
                                <tr <?php echo $networkID == $valNetworkID ? 'class="active"' : ""; ?>>
                                    <td><a href="?p=viewIP&NetworkID=<?php echo $valNetworkID; ?>" class="text-<?php echo $valStatus == "Active" ? "success" : "danger"; ?>"><?php echo $valNetwork; ?> / <?php echo $valSubnet; ?></a></td>
                                    <td><?php echo $valVlan; ?></td>
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

    <!--IP-->
    <div class="col-lg-9"> 
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
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $valIP; ?></td>
                                    <td><?php echo $valNetworkIP; ?></td>
                                    <td><?php echo $valSubnet; ?></td>
                                    <td><?php echo $valVlan; ?></td>
                                    <td><?php echo $valCustomerName == NULL ? "NULL" : "<a target='_blank' href='?p=viewCus&cusID=" . $valCustomerID . "'>" . $valCustomerName . "</a>"; ?></td>
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