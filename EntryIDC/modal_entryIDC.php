<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Entry IDC</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Customers List </b>
                        <a href="#contact" onclick="getPerson('Staff','Vender');">(Vender</a>,
                        <a href="#contact" onclick="getPerson('Visitor','');">Visitor)</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTablesModalEntryIDC">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getCus = getCustomers();
//                                    echo "<pre>";
//                                    print_r($getCus);
//                                    echo "</pre>";
                                    foreach ($getCus as $value) {
                                        ?>
                                        <tr>
                                            <td><?php printf("%05d", $value['CustomerID']); ?></td>
                                            <td><?php echo $value['CustomerName']; ?></td>
                                            <td><?php echo $value['BusinessType']; ?></td>
                                            <td><a class="btn btn-info btn-sm" onclick="getContact('<?php echo $value['CustomerID']; ?>');" href="#contact">Select</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body" id="contact">
                <!-- show contact -->
            </div>
        </div>
    </div> 
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>
    $(document).ready(function () {
        $('#dataTablesModalEntryIDC').DataTable({
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 15, 25, 50, -1], [5, 10, 15, 25, 50, "All"]]
        });
    });
    function getContact(cusID) {
        $.get("../EntryIDC/action/entryIDC.content.php?para=getContact&type=Contact&cusID=" + cusID, function (data, status) {
            $("#contact").html(data);
        });
    }
    function getPerson(type, position) {
        $.get("../EntryIDC/action/entryIDC.content.php?para=getPerson&type=" + type + "&position=" + position, function (data, status) {
            $("#contact").html(data);
        });
    }
</script>