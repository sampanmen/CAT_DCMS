<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];
$orderID = $_GET['orderID'];
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Order Packages Registration</h4>
</div>
<form action="../customer/action/customer.action.php?para=addOrderDetail&orderID=<?php echo $orderID; ?>&cusID=<?php echo $cusID; ?>" method="POST">
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-3">
                                    <label>ID Customer</label>
                                    <input class="form-control" value="<?php echo sprintf("%05d", $cusID); ?>" type="text" disabled>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Order ID</label>
                                    <input class="form-control" value="<?php echo sprintf("%05d", $orderID); ?>" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="panel-body">
                                        <label>บริการ / Packages</label>
                                        <div class="dataTable_wrapper">
                                            <table class="table table-bordered table-striped table-hover" id="dataTables_addOrder">
                                                <thead>
                                                    <tr>
                                                        <th width="30px"> </th>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>Type</th>
                                                        <th width="100px">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $getPackages = getPackagesActive();
                                                    $i = 0;
                                                    foreach ($getPackages as $value) {
                                                        $i++;
                                                        ?>
                                                        <tr>
                                                            <td><input type="checkbox" onchange="chkk('<?php echo $i; ?>')" id="chkb_<?php echo $i; ?>"></td>
                                                            <td><?php echo $value['PackageName']; ?></td>
                                                            <td><?php echo $value['PackageCategory']; ?></td>
                                                            <td><?php echo $value['PackageType']; ?></td>
                                                            <td>
                                                                <input class="form-control" disabled id="amount_<?php echo $i; ?>" name="package[amount][]" type="number">
                                                                <input type="hidden" disabled id="packageID_<?php echo $i; ?>" value="<?php echo $value['PackageID']; ?>" name="package[ID][]" >
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                <script>
                                                    function chkk(i) {
                                                        if ($('#chkb_' + i).prop('checked')) {
                                                            $("#amount_" + i).prop('disabled', false);
                                                            $("#packageID_" + i).prop('disabled', false);
                                                        }
                                                        else {
                                                            $("#amount_" + i).prop('disabled', true);
                                                            $("#packageID_" + i).prop('disabled', true);
                                                        }
                                                    }
                                                </script>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>
<script>
//    $(document).ready(function () {
//        $('#dataTables_addOrder').DataTable({
//            responsive: true
//        });
//    });
//    $('body').on('hidden.bs.modal', '.modal', function () {
//        $(this).removeData('bs.modal');
//    });
</script>