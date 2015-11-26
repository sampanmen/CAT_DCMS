<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];

$serviceDetail = getServiceDetailByCustomerID($cusID);
?>
<form method="POST" action="../customer/action/customer.action.php?para=changeServiceDetailStatus&cusID=<?php echo $cusID; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel"><b>Service Change</b></h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th> </th>
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
                                $i = 0;
                                foreach ($serviceDetail as $value) {
                                    $i++;
                                    $valServiceDetailID = $value['ServiceDetailID'];
                                    $valPackage = $value['PackageName'];
                                    $valCategory = $value['PackageCategory'];
                                    $valType = $value['PackageType'];
                                    $valLocation = $value['Location'];
                                    $valStatus = $value['Status'];
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" id="chkb_<?php echo $i; ?>" onchange="chkk('<?php echo $i; ?>');"></td>
                                        <td><?php echo $valServiceDetailID; ?></td>
                                        <td><?php echo $valPackage; ?></td>
                                        <!--<td><?php echo $valCategory; ?></td>-->
                                        <td><?php echo $valType; ?></td>
                                        <td><?php echo $valLocation; ?></td>
                                        <td>
                                            <input disabled type="hidden" value="<?php echo $valServiceDetailID; ?>" name="serviceDetailID[]" id="serviceDetailID_<?php echo $i; ?>">
                                            <div class="form-group-sm has-<?php echo $valStatus == "Active" ? "success" : ($valStatus == "Suppened" ? "warning" : "error"); ?>">
                                                <select disabled class="form-control" name="status[]" id="status_<?php echo $i; ?>">
                                                    <option <?php echo $valStatus == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                                    <option <?php echo $valStatus == "Suppened" ? "selected" : ""; ?> value="Suppened">Suppened</option>
                                                    <option <?php echo $valStatus == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group-sm">
                                                <input disabled type="text" class="form-control" name="cause[]" id="cause_<?php echo $i; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <script>
                            function chkk(i) {
                                if ($('#chkb_' + i).prop('checked')) {
                                    $("#serviceDetailID_" + i).prop('disabled', false);
                                    $("#status_" + i).prop('disabled', false);
                                    $("#cause_" + i).prop('disabled', false);
                                }
                                else {
                                    $("#serviceDetailID_" + i).prop('disabled', true);
                                    $("#status_" + i).prop('disabled', true);
                                    $("#cause_" + i).prop('disabled', true);
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-info">Save</button>
</div>
</form>