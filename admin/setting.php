
<div class="row">
    <div class="col-lg-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Staff</b><a href="?p=showStaff"> (show Staff)</a></h5>
            </div>      
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="70" class="text-center">ID</th>
                                <th>Position</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><a href="../admin/model_editPosition.php" data-toggle="modal" data-target="#myModal">Admin</a></td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Operater</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="nameStaff" ></td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>delete</option>
                                    </select>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <!--Category Package-->
    <div class="col-lg-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Package Category</b></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="70" class="text-center">ID</th>
                                <th>Catagory</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><a href="../admin/model_editCat.php" data-toggle="modal" data-target="#myModal">1/2 Rack</a></td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>1/4 Rack</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Shered Rack Rack</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr> 
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="category" ></td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                               
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    
    
    
    
    
    
    <!--Zone-->
    <div class="col-lg-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Zone</b></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="70"class="text-center">ID</th>
                                <th>Zone</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><a href="../admin/model_editZone.php" data-toggle="modal" data-target="#myModal">VIP1</a></td>
                                <td >Nonthaburi</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>VIP2</td>
                                <td>Nonthaburi</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="nameZone" ></td>
                                 <td><select class="form-control">
                                        <option>Nonthaburi</option>
                                        <option>Bangrak</option>
                                        <option>Srirscha</option>

                                    </select>
                                </td>
                                <td><select class="form-control">
                                          <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                                
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    
    
    
    
<!--location-->
    <div class="col-lg-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Location</b></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="70"class="text-center">ID</th>
                                <th>Location</th>
                                <th>Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><a href="../admin/model_editLocation.php" data-toggle="modal" data-target="#myModal">Nonthaburi</a></td>
                                <td>lk;lkldk;dlkfjhkjklmvkxvz.</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Bangruk</td>
                                <td>sdhjfghjkjkll</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td ><input class="form-control" name="idLoca" ></td>
                                <td><textarea class="form-control" name="adressLoca" ></textarea></td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>
                                    </select>
                                </td>
                                
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    
    
    <!--business-->
    <div class="col-lg-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><b>Business Type</b></h5>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="70" class="text-center">ID</th>
                                <th>Business</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><a href="../admin/model_editBusi.php" data-toggle="modal" data-target="#myModal">กสท</a></td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>นิติบุคคล</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>ส่วนบุคคล</td>
                                <td><label class="label label-success">active</label></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr> 
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="businessType" ></td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                               
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
</div>

