<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("admin", "frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$customerID = $_GET['CustomerID'];
$getServiceDetail = getServiceDetailByCustomerID($customerID);
?>

<p><a href="?">Home</a> > <a href="?p=cusHome">Customers</a> > <a href="?p=viewCus&cusID=<?php echo $customerID; ?>">Customer Detail</a> > <b>Resource</b></p>
<div class="row">
    <div class="col-lg-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b> Main Packages</b></h4>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th width="30%">Name</th>
                                <th width="15%">Category</th>
                                <th width="10%">Status</th>
                                <th width="5%">Rack</th>
                                <th width="5%">Port</th>
                                <th width="8%">IP</th>
                                <th width="27%">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getServiceDetail as $value) {
                                $serviceDetailStatus = $value['Status'];
                                $packageType = $value['PackageType'];
                                if ($serviceDetailStatus == "Deactive" || $packageType != "Main") {
                                    continue;
                                }
                                $locationID = $value['LocationID'];
                                $Location = $value['Location'];
                                $serviceDetailID = $value['ServiceDetailID'];
                                $packageID = $value['PackageID'];
                                $packageName = $value['PackageName'];
                                $packageCategoryID = $value['PackageCategoryID'];
                                $packageCategory = $value['PackageCategory'];

                                $getResourceAmount = getResourceAmount($packageID);
                                $resourceAmountIP = $getResourceAmount['IPAmount'];
                                $resourceAmountPort = $getResourceAmount['PortAmount'];
                                $resourceAmountRack = $getResourceAmount['RackAmount'];

                                $resourceReserve = getResourceReserve($serviceDetailID);
                                $reserveIP = $resourceReserve['ip'];
                                $reservePort = $resourceReserve['port'];
                                $reserveRack = $resourceReserve['rack'];
                                ?>
                                <tr>
                                    <td><?php echo $packageName; ?></td>
                                    <td><?php echo $packageCategory; ?></td>
                                    <td><p class="label label-<?php echo $serviceDetailStatus == "Active" ? "success" : ($serviceDetailStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $serviceDetailStatus; ?></p></td>
                                    <td>
                                        <a href="../resource/modal_manageRack.php?ServiceDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $reserveRack; ?>&assign=<?php echo $resourceAmountRack; ?>&racktypeID=<?php echo rawurlencode($packageCategoryID); ?>&LocationID=<?php echo $locationID; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $reserveRack . "/" . $resourceAmountRack; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/modal_managePort.php?ServiceDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $reservePort; ?>&assign=<?php echo $resourceAmountPort; ?>&LocationID=<?php echo $locationID; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $reservePort . "/" . $resourceAmountPort; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/modal_manageIP.php?ServiceDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $reserveIP; ?>&assign=<?php echo $resourceAmountIP; ?>&LocationID=<?php echo $locationID; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $reserveIP . "/" . $resourceAmountIP; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $Location; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b> Add-on Packages</b></h4>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th width="30%">Name</th>
                                <th width="15%">Category</th>
                                <th width="10%">Status</th>
                                <th width="5%">Rack</th>
                                <th width="5%">Port</th>
                                <th width="8%">IP</th>
                                <th width="27%">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getServiceDetail as $value) {
                                $serviceDetailStatus = $value['Status'];
                                $packageType = $value['PackageType'];
                                if ($serviceDetailStatus == "Deactive" || $packageType != "Add-on") {
                                    continue;
                                }
                                $locationID = $value['LocationID'];
                                $Location = $value['Location'];
                                $serviceDetailID = $value['ServiceDetailID'];
                                $packageID = $value['PackageID'];
                                $packageName = $value['PackageName'];
                                $packageCategoryID = $value['PackageCategoryID'];
                                $packageCategory = $value['PackageCategory'];

                                $getResourceAmount = getResourceAmount($packageID);
                                $resourceAmountIP = $getResourceAmount['IPAmount'];
                                $resourceAmountPort = $getResourceAmount['PortAmount'];
                                $resourceAmountRack = $getResourceAmount['RackAmount'];

                                $resourceReserve = getResourceReserve($serviceDetailID);
                                $reserveIP = $resourceReserve['ip'];
                                $reservePort = $resourceReserve['port'];
                                $reserveRack = $resourceReserve['rack'];
                                ?>
                                <tr>
                                    <td><?php echo $packageName; ?></td>
                                    <td><?php echo $packageCategory; ?></td>
                                    <td><p class="label label-<?php echo $serviceDetailStatus == "Active" ? "success" : ($serviceDetailStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $serviceDetailStatus; ?></p></td>
                                    <td>
                                        <a href="../resource/modal_manageRack.php?ServiceDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $reserveRack; ?>&assign=<?php echo $resourceAmountRack; ?>&racktypeID=<?php echo rawurlencode($packageCategoryID); ?>&LocationID=<?php echo $locationID; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $reserveRack . "/" . $resourceAmountRack; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/modal_managePort.php?ServiceDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $reservePort; ?>&assign=<?php echo $resourceAmountPort; ?>&LocationID=<?php echo $locationID; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $reservePort . "/" . $resourceAmountPort; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../resource/modal_manageIP.php?ServiceDetailID=<?php echo $serviceDetailID; ?>&used=<?php echo $reserveIP; ?>&assign=<?php echo $resourceAmountIP; ?>&LocationID=<?php echo $locationID; ?>" data-toggle="modal" data-target="#myModal">
                                            <?php echo $reserveIP . "/" . $resourceAmountIP; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $Location; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



