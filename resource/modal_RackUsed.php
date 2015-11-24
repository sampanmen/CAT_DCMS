<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Full Rack</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables">
                    <thead>
                        <tr>
                            <th>Zone</th>
                            <th>Position</th>
                            <th>SubPosition</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td>01</td>
                            <td>1</td>

                        </tr>                                                     
                        <tr>
                            <td>A</td>
                            <td>02</td>
                            <td>1</td>

                        </tr>          
                        <tr>
                            <td>Z</td>
                            <td>03</td>
                            <td>1</td>

                        </tr>          
                        <tr>
                            <td>Z</td>
                            <td>04</td>
                            <td>1</td>
                        </tr>          

                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>

        <!-- /.panel-body -->




    </div>
    <!-- /.row (nested) -->
</div> 




</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>