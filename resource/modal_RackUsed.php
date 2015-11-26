<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$CustomerID = $_GET['CustomerID'];
$RackTypeID = $_GET['RackTypeID'];
$getRack = getRackByCustomerID($CustomerID);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Show Your Rack</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($getRack as $value) {
                            if ($value['RackTypeID'] != $RackTypeID) {
                                continue;
                            }
                            $valCol = $value['Col'];
                            $valRow = $value['Row'];
                            $valSubPositioin = $value['SubRackPosition'];
                            $valLocation = $value['Location'];
                            ?>
                            <tr>
                                <td><?php echo $valCol . $valRow . "-" . $valSubPositioin; ?></td>
                                <td><?php echo $valLocation; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div>
    </div><!-- /.row (nested) -->
</div> 




</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>