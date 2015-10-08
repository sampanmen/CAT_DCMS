<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];
?>
<div class="row">
    <form action="../customer/action/customer.action.php?para=addOrder" method="POST">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Order Registration
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-3">
                                <label>ID Customer</label>
                                <input class="form-control" value="<?php echo sprintf("%05d", $cusID); ?>" type="text" disabled>
                                <input type="hidden" name="cusID" value="<?php echo $cusID; ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>ID Customer Old</label>
                                <input class="form-control" value="" type="text" name="oldID">
                                
                            </div>

                            <div class="form-group">
                                <div class="panel-body">
                                    <div class="row col-lg-12">
                                        <label>บริการ / Packages</label>
                                        <table class="table table-bordered" id="dataTables">
                                            <tr>
                                                <th width="5%"> </th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Type</th>
                                                <th width="15%">จำนวน / Total</th>
                                            </tr>
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
                            <div class="form-group col-lg-6">
                                <div class="form-group">
                                    <label>Bundle Network</label>
                                    <select multiple class="form-control" name="bundle[]">
                                        <option value="IDC Only">IDC Only</option>
                                        <option value="ATM">ATM</option>
                                        <option value="Leased Line">Leased Line</option>
                                        <option value="Coperate">Coperate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>สถานที่ / Location</label>
                                <select class="form-control" name="location">
                                    <option value="IDC Nonthaburi">IDC Nonthaburi</option>
                                </select>
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
        <div class="text-center">
            <button type="reset" class="btn btn-primary">CANCLE</button>
            <button type="submit" class="btn btn-primary">NEXT</button>
            <br><br>
        </div>
    </form>
</div>
