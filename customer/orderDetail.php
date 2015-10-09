<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$orderID = $_GET['orderID'];
$cusID = $_GET['cusID'];
$getOrderDetailMain = getOrderDetailByOrderID($orderID, 'main');
$getOrderDetailAddOn = getOrderDetailByOrderID($orderID, 'add-on');
?>
<p><a href="?">Home</a> > <a href="?p=cusHome">Customers</a> > <a href="?p=viewCus&cusID=<?php echo $cusID; ?>">Customer Detail</a> > <b>Order Detail</b> > <a href="../customer/model_addOrderDetail.php?cusID=<?php echo $cusID; ?>&orderID=<?php echo $orderID; ?>" data-toggle="modal" data-target="#myModal-lg">Add Packages</a></p>
<div class="row">
    <form>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b> Main Packages</b></h4>
                </div>      

                <div class="panel-body">

                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getOrderDetailMain as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value['DateTime']; ?></td>
                                    <td><?php echo $value['PackageName']; ?></td>
                                    <td><?php echo $value['PackageCategory']; ?></td>
                                    <td><p class="label label-<?php echo $value['OrderDetailStatus'] == "active" ? "success" : ($value['OrderDetailStatus'] == "suppened" ? "warning" : "danger"); ?>"><?php echo $value['OrderDetailStatus']; ?></p></td>
                                    <td><a href="../customer/model_ChangeStatusPack.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">view</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>



        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b> Add-On Packages</b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables2">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getOrderDetailAddOn as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['DateTime']; ?></td>
                                        <td><?php echo $value['PackageName']; ?></td>
                                        <td><?php echo $value['PackageCategory']; ?></td>
                                        <td><p class="label label-<?php echo $value['OrderDetailStatus'] == "active" ? "success" : ($value['OrderDetailStatus'] == "suppened" ? "warning" : "danger"); ?>"><?php echo $value['OrderDetailStatus']; ?></p></td>
                                        <td><a href="../customer/model_ChangeStatusPack.php?orderDetailID=<?php echo $value['OrderDetailID']; ?>&cusID=<?php echo $cusID; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">view</a></td>
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
    </form>
</div>



