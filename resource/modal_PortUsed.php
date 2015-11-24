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
    <h4 class="modal-title" id="gridSystemModalLabel">Switch 1</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables">
                    <thead>
                        <tr>
                            <th>Port No</th>
                            <th>Type</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>100</td>

                        </tr>                                                     
                        <tr>
                            <td>2</td>
                            <td>100</td>

                        </tr>          
                        <tr>
                            <td>3</td>
                            <td>10</td>

                        </tr>          
                        <tr>
                            <td>4</td>
                            <td>10</td>
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