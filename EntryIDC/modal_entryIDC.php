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
                        <b>Choose Type </b>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <a href="#customer" class="btn btn-info btn-lg" onclick="getCustomer();">Customer</a>
                        <a href="#catDivision" class="btn btn-info btn-lg" onclick="getDivision('CAT');">CAT Employee</a>
                        <a href="#catDivision" class="btn btn-info btn-lg" onclick="getDivision('Vender');">Vender</a>
                        <!--<a type="button" class="btn btn-primary btn-lg">Outsource</a>-->
                    </div>
                </div>
            </div>

            <div class="panel-body" id="customer">
                <!--show Customer or CAT Division-->
            </div>

            <div class="panel-body" id="person">
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
    function getCustomer() {
        $('#person').hide();
        $('#customer').show();
        $.get("../entryIDC/action/entryIDC.content.php?para=getCustomer", function (data, status) {
            $("#customer").html(data);
        });
    }
    function getDivision(organi) {
        $('#person').hide();
        $('#customer').show();
        $.get("../entryIDC/action/entryIDC.content.php?para=getDivision&organi=" + organi, function (data, status) {
            $("#customer").html(data);
        });
    }
    function getContact(cusID) {
        $('#person').show();
        $.get("../entryIDC/action/entryIDC.content.php?para=getContact&type=Contact&cusID=" + cusID, function (data, status) {
            $("#person").html(data);
        });
    }
    function getStaff(division) {
        $('#person').show();
        $.get("../entryIDC/action/entryIDC.content.php?para=getStaff&division=" + division, function (data, status) {
            $("#person").html(data);
        });
    }
</script>
