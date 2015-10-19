<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$orderID = $_GET['orderID'];
$cusID = $_GET['cusID'];
$getOrderDetailMain = getOrderDetailByOrderID($orderID, 'main');
$getOrderDetailAddOn = getOrderDetailByOrderID($orderID, 'add-on');
//print_r($getOrderDetailMain);
?>

<p><a href="?">Home</a> > <a href="?p=cusHome">Customers</a> > <a href="?p=viewCus&cusID=<?php echo $cusID; ?>">Customer Detail</a> > <b>Order Detail</b> > <a href="../customer/model_addOrderDetail.php?cusID=<?php echo $cusID; ?>&orderID=<?php echo $orderID; ?>" data-toggle="modal" data-target="#myModal-lg">Add Packages</a></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b> Main Packages</b></h4>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="35%">Name</th>
                                <th width="10%">Category</th>
                                <th width="10%">Status</th>
                                <th width="5%">Rack</th>
                                <th width="5%">Port</th>
                                <th width="5%">IP</th>
                                <th width="10%"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getOrderDetailMain as $value) {
                                $resourceReserve = getResourceReserve($value['OrderDetailID']);
                                ?>
                                <tr>
                                    <td><?php echo $value['DateTime']; ?></td>
                                    <td><?php echo $value['PackageName']; ?></td>
                                    <td><?php echo $value['PackageCategory']; ?></td>
                                    <td><p class="label label-<?php echo $value['OrderDetailStatus'] == "active" ? "success" : ($value['OrderDetailStatus'] == "suppened" ? "warning" : "danger"); ?>"><?php echo $value['OrderDetailStatus']; ?></p></td>
                                    <td>
                                        <a href="../resource/model_manageRack.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&used=<?php echo $resourceReserve['rack']; ?>&assign=<?php echo $value['RackAmount']; ?>&PackageCategory=<?php echo rawurlencode($value['PackageCategory']); ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $resourceReserve['rack'] . "/" . $value['RackAmount']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_managePort.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&used=<?php echo $resourceReserve['port']; ?>&assign=<?php echo $value['PortAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $resourceReserve['port'] . "/" . $value['PortAmount']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_manageIP.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&used=<?php echo $resourceReserve['ip']; ?>&assign=<?php echo $value['IPAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $resourceReserve['ip'] . "/" . $value['IPAmount']; ?>
                                        </a>
                                    </td>
                                    <td><a href="../customer/model_ChangeStatusPack.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">view</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b> Add-On Packages</b></h4>
            </div>      
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables2">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="35%">Name</th>
                                <th width="10%">Category</th>
                                <th width="10%">Status</th>
                                <th width="5%">Rack</th>
                                <th width="5%">Port</th>
                                <th width="5%">IP</th>
                                <th width="10%"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getOrderDetailAddOn as $value) {
                                $resourceReserve = getResourceReserve($value['OrderDetailID']);
                                ?>
                                <tr>
                                    <td><?php echo $value['DateTime']; ?></td>
                                    <td><?php echo $value['PackageName']; ?></td>
                                    <td><?php echo $value['PackageCategory']; ?></td>
                                    <td><p class="label label-<?php echo $value['OrderDetailStatus'] == "active" ? "success" : ($value['OrderDetailStatus'] == "suppened" ? "warning" : "danger"); ?>"><?php echo $value['OrderDetailStatus']; ?></p></td>
                                    <td>
                                        <a href="../resource/model_manageRack.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&used=<?php echo $resourceReserve['rack']; ?>&assign=<?php echo $value['RackAmount']; ?>&PackageCategory=<?php echo rawurlencode($value['PackageCategory']); ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $resourceReserve['rack'] . "/" . $value['RackAmount']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_managePort.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&used=<?php echo $resourceReserve['port']; ?>&assign=<?php echo $value['PortAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $resourceReserve['port'] . "/" . $value['PortAmount']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_manageIP.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&used=<?php echo $resourceReserve['ip']; ?>&assign=<?php echo $value['IPAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $resourceReserve['ip'] . "/" . $value['IPAmount']; ?>
                                        </a>
                                    </td>
                                    <td><a href="../customer/model_ChangeStatusPack.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">view</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



