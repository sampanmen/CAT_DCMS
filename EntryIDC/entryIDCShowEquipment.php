<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("admin", "frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$getEquipments = getEquipments();
?>
<p><a href="?">Home</a> > <b>Equipments</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Equipments </b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                if ($getEquipments != NULL) {
                    ?>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Equipment</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>SerialNo</th>
                                    <th>Rack</th>
                                    <th>DateTime In</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getEquipments as $value) {
                                    $valCusID = $value['CustomerID'];
                                    $valCusName = $value['CustomerName'];
                                    $valEquipmentID = $value['EquipmentID'];
                                    $valEquipment = $value['Equipment'];
                                    $valBrand = $value['Brand'];
                                    $valModel = $value['Model'];
                                    $valSerialNo = $value['SerialNo'];
                                    $valRack = $value['Col'] . $value['Row'] . "-" . $value['SubRackPosition'];
                                    $valDateTimeIN = $value['TimeIN'];
                                    $valDateTimeOUT = $value['TimeOUT'];
                                    $valEntryID_IN = $value['EntryID_IN'];
                                    $valEntryID_OUT = $value['EntryID_OUT'];
                                    if ($valDateTimeOUT != NULL) {
                                        continue;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $valCusName; ?></td>
                                        <td><?php echo $valEquipment; ?></td>
                                        <td><?php echo $valBrand; ?></td>
                                        <td><?php echo $valModel; ?></td>
                                        <td><?php echo $valSerialNo; ?></td>
                                        <td><?php echo $valRack; ?></td>
                                        <td><?php echo $valDateTimeIN; ?></td>
                                        <td>
                                            <?php
                                            if ($valEntryID_OUT == NULL) {
                                                ?>
                                                <a href="../EntryIDC/modal_equipmentOut.php?equipmentID=<?php echo $valEquipmentID; ?>&cusID=<?php echo $valCusID; ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">OUT</a>
                                            <?php } else { ?>
                                                Ready for out <a href="../EntryIDC/action/entryIDC.action.php?para=cancelGetOutEquipment&equipmentID=<?php echo $valEquipmentID; ?>" data-toggle="modal" data-target="#myModal">(Cancel)</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    echo "<h3>No Equipment Now!</h3>";
                }
                ?>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
<script>
    $('body').on('hidden.bs.modal', '.modal', function () {
        location.reload();
    });
</script>