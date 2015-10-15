<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$network = (isset($_GET['network']) && $_GET['network'] != "" ) ? $_GET['network'] : "%";
$getIPs = getIPs($network);

$getNetworks = getNetworks();
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
                            foreach ($getNetworks as $value) {
                                ?>
                                <tr>
                                    <td><a href="?p=viewIP&network=<?php echo $value['NetworkIP']; ?>"><?php echo $value['NetworkIP']; ?> / <?php echo $value['Subnet']; ?></a></td>
                                    <td><?php echo $value['VlanID']; ?></td>
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
                <h5><b>IP Address </b><a href="?p=viewIP">(show all)</a></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Network</th>
                                <th>Subnet</th>
                                <th>Vlan</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getIPs as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value['IP']; ?></td>
                                    <td><?php echo $value['NetworkIP']; ?></td>
                                    <td><?php echo $value['Subnet']; ?></td>
                                    <td><?php echo $value['VlanID']; ?></td>
                                    <td><?php echo $value['CustomerName'] == NULL ? "NULL" : "<a target='_blank' href='?p=viewCus&cusID=" . $value['CustomerID'] . "'>" . $value['CustomerName'] . "</a>"; ?></td>
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





<a href="../resource/model_manageIP.php" data-toggle="modal" data-target="#myModal">hhhhh</a>
<a href="../resource/model_managePort.php" data-toggle="modal" data-target="#myModal">hhhhh</a>
<a href="../resource/model_manageRack.php" data-toggle="modal" data-target="#myModal">hhhhh</a>