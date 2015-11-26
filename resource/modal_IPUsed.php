<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$CustomerID = $_GET['CustomerID'];
$NetworkID = $_GET['NetworkID'];
$getIP = getIPByCustomerID($CustomerID);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Show Your IP Address</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Subnet</th>
                                <th>Vlan</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getIP as $value) {
                                if ($NetworkID != $value['NetworkID']) {
                                    continue;
                                }
                                $valIP = $value['IP'];
                                $valNetworkIP = $value['NetworkIP'];
                                $valSubnet = $value['Subnet'];
                                $valVlan = $value['Vlan'];
                                $valLocation = $value['Location'];
                                ?>
                                <tr>
                                    <td><?php echo $valIP; ?></td>
                                    <td><?php echo $valSubnet; ?></td>
                                    <td><?php echo $valVlan; ?></td>
                                    <td><?php echo $valLocation; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
    <!-- /.row (nested) -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>