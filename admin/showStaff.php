<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>
                    Staff  <a href="../admin/model_addStaff.php" data-toggle="modal" data-target="#myModal"> (add staff)</a>
                </h5>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th width="70" class="text-center">Staff ID</th>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Staff Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php
                            $staff = getViewstaff();
                            foreach ($staff as $viewstaff) {
                                $EmployeeID = $viewstaff['EmployeeID'];
                                $Fname = $viewstaff['Fname'];
                                $Lname = $viewstaff['Lname'];
                                $Position = $viewstaff['Position'];
                                $statusLabel = $viewstaff['PersonStatus'] == "Active" ? "success" : ($viewstaff['PersonStatus'] == "Suppened" ? "warning" : "danger");
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $EmployeeID; ?></td>
                                    <td><?php echo $Fname; ?></td>
                                    <td><?php echo $Lname; ?></td>
                                    <td><?php echo $Position; ?></td>
                                    <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $viewstaff['PersonStatus']; ?></span></td>
                                    <td><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-wrench"></i></button>
                                        <button type="button" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button>
                                    </td>
                                </tr>                                                     
                            <?php } ?>
                        </tbody>                                         

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
