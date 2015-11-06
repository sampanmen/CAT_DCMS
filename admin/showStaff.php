
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
                            <tr>
                                <td class="text-center">00001</td>
                                <td>Thidarat</td>
                                <td>Changkaew</td>
                                <td>Manager</td>
                                <td ><p class="label label-success">Active </p></td> 
                                <td><a href="../admin/model_editStaff.php" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-circle"><i class="glyphicon-wrench"></i></a></button>
                                    <button type="button" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">00002</td>
                                <td>Supakit</td>
                                <td>tanyang</td>
                                <td>Manager</td>
                                <td ><p class="label label-danger">No Active </p></td> 
                                <td><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-wrench"></i></button>
                                    <button type="button" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">00003</td>
                                <td>Sampan</td>
                                <td>Saraneeyapong</td>
                                <td>Manager</td>
                                <td ><p class="label label-success">Active</p></td> 
                                <td><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-wrench"></i></button>
                                    <button type="button" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button>
                                </td>
                            </tr>
                        </tbody>                                         

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
