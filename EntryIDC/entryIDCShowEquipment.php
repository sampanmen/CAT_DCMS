<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$getEquipments = getEquipments();
?>
<p><a href="?">Home</a> > <b>Entry IDC Log</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Entry IDC Log</b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                if ($getEntryNow != NULL) {
                    ?>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
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
                                    $valEquipmentID = $value['EquipmentID'];
                                    $valEquipment = $value['Equipment'];
                                    $valBrand = $value['Brand'];
                                    $valModel = $value['Model'];
                                    $valSerialNo = $value['SerialNo'];
                                    $valRack = $value['Col'].$value['Row']."-".$value['PositionRack'];
                                    $valDateTimeIN = $value['DateTime'];
                                    ?>
                                    <tr>
                                        <td><?php echo $valEquipment; ?></td>
                                        <td><?php echo $valBrand; ?></td>
                                        <td><?php echo $valSerialNo; ?></td>
                                        <td><?php echo $valRack; ?></td>
                                        <td><?php echo $valDateTimeIN; ?></td>
                                        <td>
                                            <!--<a class="btn btn-info btn-sm" href="?p=entryBeforePrint&entryID=<?php echo $valEntryID; ?>"><i class="glyphicon glyphicon-print"></i></a>-->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    echo "<h3>No Entry Now!</h3>";
                }
                ?>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
