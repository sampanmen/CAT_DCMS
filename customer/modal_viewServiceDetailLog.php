<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];
$packageCategoryID = isset($_GET['categoryID']) ? $_GET['categoryID'] : false;

$serviceDetailLog = getServiceDetailLog($cusID);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel"><b>Service History</b></h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12"> 
                    <table class="table table-hover" id="dataTablesLog">
                        <thead>
                            <tr>
                                <th>DateTime</th>
                                <th>ID</th>
                                <th>Package</th>
                                <!--<th>Category</th>-->
                                <th>Type</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Cause</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($serviceDetailLog as $value) {
                                if ($packageCategoryID !== false && $packageCategoryID != $value['PackageCategoryID']) {
                                    continue;
                                }
                                $valDateTime = $value['DateTimeAction'];
                                $valServiceDetailID = $value['ServiceDetailID'];
                                $valPackage = $value['PackageName'];
                                $valCategory = $value['PackageCategory'];
                                $valType = $value['PackageType'];
                                $valLocation = $value['Location'];
                                $valStatus = $value['Status'];
                                $valCause = $value['Cause'];
                                ?>
                                <tr>
                                    <td><?php echo $valDateTime; ?></td>
                                    <td><?php echo $valServiceDetailID; ?></td>
                                    <td><?php echo $valPackage; ?></td>
                                    <!--<td><?php echo $valCategory; ?></td>-->
                                    <td><?php echo $valType; ?></td>
                                    <td><?php echo $valLocation; ?></td>
                                    <td><label class="label label-<?php echo $valStatus == "Active" ? "success" : ($valStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $valStatus; ?></label></td>
                                    <td><?php echo $valCause; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <script>
                        $(document).ready(function () {
                            $('#dataTablesLog').DataTable({
                                responsive: true
                            });
                        });

                    </script>
                </div>
            </div>
        </div>
    </div> 
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>