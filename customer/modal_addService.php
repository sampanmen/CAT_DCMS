<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];
$location = getLocation();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Service Registration</h4>
</div>
<form action="../customer/action/customer.action.php?para=addService" method="POST">
    <div class="modal-body">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <div class="form-group col-lg-3">
                                    <label>ID Customer </label>
                                    <h2><b><?php echo sprintf("%05d", $cusID); ?></b></h2>
                                    <!--<input class="form-control" value="<?php // echo sprintf("%05d", $cusID);                       ?>" type="text" disabled>-->
                                    <input type="hidden" name="cusID" value="<?php echo $cusID; ?>">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group col-lg-6">
                                    <label>สถานที่ / Location</label>
                                    <select class="form-control" name="location" id="location" onchange="showPackages();
                                            showNetworkLink();">
                                        <option selected value="">Choose</option>
                                        <?php
                                        foreach ($location as $value) {
                                            if ($value['Status'] == "Deactive")
                                                continue;
                                            ?>
                                            <option value="<?php echo $value['LocationID']; ?>"><?php echo $value['Location']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="panel-body">
                                        <label>บริการ / Packages</label>
                                        <div class="dataTable_wrapper" id="getPackages">
                                            <!--packages-->
                                        </div>
                                        <script>
                                            showPackages();
                                            function showPackages() {
                                                var locationID = $("#location").val();
                                                if (locationID != "") {
                                                    $.get("../customer/action/customer.content.php?para=getPackagesOnAddService&locationID=" + locationID, function (data, status) {
                                                        $("#getPackages").html(data);
                                                    });
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label>Network Link</label>
                                        <select multiple class="form-control" name="networkLink[]" required id="networkLink">
                                            <!--NetworkLink-->
                                        </select>
                                        <script>
                                            showNetworkLink();
                                            function showNetworkLink() {
                                                var locationID = $("#location").val();
                                                if (locationID != "") {
                                                    $.get("../customer/action/customer.content.php?para=getNetworkLink&locationID=" + locationID, function (data, status) {
                                                        $("#networkLink").html(data);
                                                    });
                                                }
                                            }
                                        </script>
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
        <button type="submit" class="btn btn-primary">Save</button>
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