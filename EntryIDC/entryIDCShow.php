<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$getEntryNow = getEntryNow();
?>
<p><a href="?">Home</a> > <b>Show Entry IDC</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Show Entry</b>
                <a href="../EntryIDC/modal_entryIDC.php" data-toggle="modal" data-target="#myModal-lg">(Add)</a>        
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                if ($getEntryNow != NULL) {
                    ?>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr>
                                    <th>Organization</th>
                                    <th>Person</th>
                                    <th>Type</th>
                                    <th>Purpose</th>
                                    <th>DateTime In</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getEntryNow as $value) {
                                    $valEntryID = $value['EntryID'];
                                    if ($value['CustomerName'] != NULL) {
                                        $valOrganization = $value['CustomerName'];
                                    } else {
                                        $valOrganization = "[" . $value['Organization'] . "] " . $value['Division'];
                                    }
                                    $valPersonName = $value['Fname'] . " " . $value['Lname'];
                                    $valPersonType = $value['TypePerson'];
                                    $valPurpose = $value['Purpose'];
                                    $valDateTimeIN = $value['TimeIn'];
                                    ?>
                                    <tr id="tr_showEntry_<?php echo $valEntryID; ?>">
                                        <td><?php echo $valOrganization; ?></td>
                                        <td><?php echo $valPersonName; ?></td>
                                        <td><?php echo $valPersonType; ?></td>
                                        <td><?php echo $valPurpose; ?></td>
                                        <td><?php echo $valDateTimeIN; ?></td>
                                        <td>
                                            <button type="button" onclick="if (confirm('Are you sure to Checkout.')) {
                                                                checkOut('<?php echo $valEntryID; ?>');
                                                            }" class="btn btn-warning btn-sm">Out</button>
                                            <a class="btn btn-info btn-sm" href="?p=entryBeforePrint&entryID=<?php echo $valEntryID; ?>">View</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <script>
                            function checkOut(id) {
                                $.get("../entryIDC/action/entryIDC.action.php?para=checkOut&entryID=" + id, function (data, status) {
                                    if (data == '1') {
                                        $('#tr_showEntry_' + id).hide();
                                    }
                                    else {
                                        alert("Can't Checkout.");
                                    }
                                });
                            }
                        </script>
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
