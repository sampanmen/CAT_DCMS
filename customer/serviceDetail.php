<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$serviceID = $_GET['serviceID'];
$cusID = $_GET['cusID'];
//print_r($getOrderDetailMain);
$getServiceDetailMain = getServiceDetailByServiceID($serviceID, "Main");
$getServiceDetailAddOn = getServiceDetailByServiceID($serviceID, "Add-on");
?>

<p><a href="?">Home</a> > <a href="?p=cusHome">Customers</a> > <a href="?p=viewCus&cusID=<?php echo $cusID; ?>">Customer Detail</a> > <b>Service Detail</b></p>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b> Main Packages</b></h4>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th width="25%">Name</th>
                                <th width="15%">Category</th>
                                <th width="15%">Status</th>
                                <th width="10%">Rack</th>
                                <th width="10%">Port</th>
                                <th width="10%">IP</th>
                                <th width="15%"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getServiceDetailMain as $value) {
                                $packageID = $value['PackageID'];
                                $serviceDetailID = $value['ServiceDetailID'];

//                                $resourceReserve = getResourceReserve($value['OrderDetailID']);
                                $package = getPackage($packageID); //Get package
                                $serviceDetailStatus = getServiceDetailStatus($serviceDetailID);

                                $packageName = $package['PackageName'];
                                $packageCategory = $package['PackageCategory'];
                                ?>
                                <tr>
                                    <td><?php echo $packageName; ?></td>
                                    <td><?php echo $packageCategory; ?></td>
                                    <td><p class="label label-<?php echo $serviceDetailStatus == "Active" ? "success" : ($serviceDetailStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $serviceDetailStatus; ?></p></td>
                                    <td>
                                        <a href="../resource/model_manageRack.php?orderDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $resourceReserve['rack']; ?>&assign=<?php echo $value['RackAmount']; ?>&PackageCategory=<?php echo rawurlencode($value['PackageCategory']); ?>" data-toggle="modal" data-target="#myModal">
                                            <?php // echo $resourceReserve['rack'] . "/" . $value['RackAmount'];   ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_managePort.php?orderDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $resourceReserve['port']; ?>&assign=<?php echo $value['PortAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php // echo $resourceReserve['port'] . "/" . $value['PortAmount'];   ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_manageIP.php?orderDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $resourceReserve['ip']; ?>&assign=<?php echo $value['IPAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php // echo $resourceReserve['ip'] . "/" . $value['IPAmount'];   ?>
                                        </a>
                                    </td>
                                    <td>
                                        <!--<a href="../customer/modal_viewServiceDetail.php?serviceDetailID=<?php // echo $serviceDetailID; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">view</a>-->
                                        <a href="../customer/modal_editServiceDetailStatus.php?serviceDetailID=<?php echo $serviceDetailID; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">status</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b> Add-on Packages</b></h4>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th width="25%">Name</th>
                                <th width="15%">Category</th>
                                <th width="15%">Status</th>
                                <th width="10%">Rack</th>
                                <th width="10%">Port</th>
                                <th width="10%">IP</th>
                                <th width="15%"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getServiceDetailAddOn as $value) {
                                $packageID = $value['PackageID'];
                                $serviceDetailID = $value['ServiceDetailID'];

//                                $resourceReserve = getResourceReserve($value['OrderDetailID']);
                                $package = getPackage($packageID); //Get package
                                $serviceDetailStatus = getServiceDetailStatus($serviceDetailID);

                                $packageName = $package['PackageName'];
                                $packageCategory = $package['PackageCategory'];
                                ?>
                                <tr>
                                    <td><?php echo $packageName; ?></td>
                                    <td><?php echo $packageCategory; ?></td>
                                    <td><p class="label label-<?php echo $serviceDetailStatus == "Active" ? "success" : ($serviceDetailStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $serviceDetailStatus; ?></p></td>
                                    <td>
                                        <a href="../resource/model_manageRack.php?orderDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $resourceReserve['rack']; ?>&assign=<?php echo $value['RackAmount']; ?>&PackageCategory=<?php echo rawurlencode($value['PackageCategory']); ?>" data-toggle="modal" data-target="#myModal">
                                            <?php // echo $resourceReserve['rack'] . "/" . $value['RackAmount'];   ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_managePort.php?orderDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $resourceReserve['port']; ?>&assign=<?php echo $value['PortAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php // echo $resourceReserve['port'] . "/" . $value['PortAmount'];   ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/model_manageIP.php?orderDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $resourceReserve['ip']; ?>&assign=<?php echo $value['IPAmount']; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php // echo $resourceReserve['ip'] . "/" . $value['IPAmount'];   ?>
                                        </a>
                                    </td>
                                    <td>
                                        <!--<a href="../customer/modal_viewServiceDetail.php?serviceDetailID=<?php // echo $serviceDetailID; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">view</a>-->
                                        <a href="../customer/modal_editServiceDetailStatus.php?serviceDetailID=<?php echo $serviceDetailID; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">status</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



