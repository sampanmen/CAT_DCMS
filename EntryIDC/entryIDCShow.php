<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$getEntryIDCNow = getEntryIDCNow();
?>
<p><a href="?">Home</a> > <b>Show Entry IDC</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label>
                    Entry <a href="../EntryIDC/modal_entryIDC.php" data-toggle="modal" data-target="#myModal-lg">(Add)</a>
                </label>               
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Contact Name</th>
                                <th>DateTime In</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($getEntryIDCNow as $value) {
                                ?>
                                <tr id="tr_showEntry_<?php echo $value['EntryIDCID']; ?>">
                                    <td><?php echo printf("%05d", $value['CustomerID']); ?></td>
                                    <td><?php echo $value['CustomerName']; ?></td>
                                    <td><?php echo $value['Fname'] . " " . $value['Lname']; ?></td>
                                    <td><?php echo $value['TimeIn']; ?></td>
                                    <td>
                                        <button type="button" onclick="if (confirm('Are you sure to Checkout.')) {
                                                        checkOut('<?php echo $value['EntryIDCID']; ?>');
                                                    }" class="btn btn-warning btn-sm">Out</button>
                                        <button type="button" class="btn btn-info btn-sm">View</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <script>
                        function checkOut(id) {
                            $.get("../EntryIDC/action/entryIDC.action.php?para=checkOut&entryID=" + id, function (data, status) {
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
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>

