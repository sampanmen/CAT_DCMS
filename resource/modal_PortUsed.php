<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$CustomerID = $_GET['CustomerID'];
$SwitchID = $_GET['SwitchID'];
$getPort = getPortByCustomerID($CustomerID);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Show Your Port</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables">
                    <thead>
                        <tr>
                            <th>Switch</th>
                            <th>Port No</th>
                            <th>Type</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($getPort as $value) {
                            if ($value['SwitchID'] != $SwitchID) {
                                continue;
                            }
                            $valSwitchName = $value['SwitchName'];
                            $valPortNumber = $value['PortNumber'];
                            $valPortType = $value['PortType'];
                            $valLocation = $value['Location'];
                            ?>
                            <tr>
                                <td><?php echo $valSwitchName; ?></td>
                                <td><?php echo $valPortNumber; ?></td>
                                <td><?php echo $valPortType; ?></td>
                                <td><?php echo $valLocation; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div><!-- /.panel-body -->
    </div>
    <!-- /.row (nested) -->
</div> 




</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>