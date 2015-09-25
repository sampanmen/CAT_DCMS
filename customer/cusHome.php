<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label>
                    Customer <a href="?p=addCus">(Add)</a>
                </label>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Business Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cus = getCustomer();
                            foreach ($cus as $value) {
                                $statusLabel = $value['Status']=="Active"?"success":($value['Status']=="Suppened"?"warning":"danger");
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $value['PrefixID'] . sprintf("%05d", $value['CustomerID']); ?></td>
                                    <td><?php echo $value['CustomerName']; ?></td>
                                    <td><?php echo $value['BusinessType']; ?></td>
                                    <td><span class="label label-<?php echo $statusLabel;?>"><?php echo $value['Status']; ?></span></td>
                                    <td>
                                        <a class="btn btn-primary" href="?p=viewCus&cusID=<?php echo $value['CustomerID']; ?>">View</a>
                                        <a class="btn btn-info" href="?p=addOrder&cusID=<?php echo $value['CustomerID']; ?>">Add Order</a>
                                        <!--<a class="btn btn-warning" href="">Edit</a>-->
                                    </td>
                                </tr>  
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
