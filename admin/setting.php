
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
                                <td><label class="label label-success">active</label>   
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Operater</td>
                                <td><label class="label label-success">active</label>  
                                </td>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td >Nonthaburi</td>
                                <td >lk;lkldk;dlk</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Bangruk</td>
                                <td>sdhjfghjkjkll</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="IDlocation" ></td>
                                <td><input class="form-control" name="location" ></td>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>1/2 Rack</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>1/4 Rack</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Shered Rack Rack</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr> 
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="IDCategory" ></td>
                                <td><input class="form-control" name="packagecategory" ></td>
                               
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
                                <td >VIP1</td>
                                <td >Nonthaburi</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>VIP2</td>
                                <td>Nonthaburi</td>
                                <td><select class="form-control">
                                        <option>active</option>
                                        <option>suspend</option>
                                        <option>delete</option>

                                    </select>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center"><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                <td><input class="form-control" name="IDzone" ></td>
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
    
    
    
    
    
    
    
    
</div>

