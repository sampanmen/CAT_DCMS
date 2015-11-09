<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
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
                            <?php
                            $staff = getStaffPosition();
                            foreach ($staff as $staffPo) {
                                $StaffPositionID = $staffPo['StaffPositionID'];
                                $Position = $staffPo['Position'];
                                $statusLabel = $staffPo['Status'] == "Active" ? "success" : ($staffPo['Status'] == "Suppened" ? "warning" : "danger");
                               
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $StaffPositionID; ?></td>
                                    <td><?php echo $Position; ?></td>
                                    <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $staffPo['Status']; ?></span></td>
                                </tr>                                                     
                            <?php } ?>
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
                            <?php
                            $cat = getCatagory();
                            foreach ($cat as $pacCat) {
                                $PackageCategoryID = $pacCat['PackageCategoryID'];
                                $PackageCategory = $pacCat['PackageCategory'];
                                $statusLabel = $pacCat['Status'] == "Active" ? "success" : ($pacCat['Status'] == "Suppened" ? "warning" : "danger");
                               
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $PackageCategoryID; ?></td>
                                    <td><?php echo $PackageCategory; ?></td>
                                    <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $pacCat['Status']; ?></span></td>
                                </tr>                                                     
                            <?php } ?>
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
                        <?php
                            $zones = getZone();
//                            print_r($zones);
                            foreach ($zones as $Zone) {
                                $EntryZoneID = $Zone['EntryZoneID'];
                                $EntryZone = $Zone['EntryZone'];
                                $Location = $Zone['Location'];
                                $statusLabel = $Zone['Status'] == "Active" ? "success" : ($Zone['Status'] == "Suppened" ? "warning" : "danger");
                               
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $EntryZoneID; ?></td>
                                    <td><?php echo $EntryZone; ?></td>
                                    <td><?php echo $Location ?></td>
                                    <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $Zone['Status']; ?></span></td>
                                </tr>                                                     
                            <?php } ?>
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
                            <?php
                            $loca = getLocation();
                            foreach ($loca as $locav) {
                                $LocationID = $locav['LocationID'];
                                $Location = $locav['Location'];
                                $Address = $locav['Address'];
                                $statusLabel = $locav['Status'] == "Active" ? "success" : ($locav['Status'] == "Suppened" ? "warning" : "danger");
                               
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $LocationID; ?></td>
                                    <td><?php echo $Location; ?></td>
                                    <td><?php echo $Address ?></td>
                                    <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $locav['Status']; ?></span></td>
                                </tr>                                                     
                            <?php } ?>
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
                            <?php
                            $business = getBusinessType();
                            foreach ($business as $bus) {
                               
                                $BusinessTypeID = $bus['BusinessTypeID'];
                                $BusinessType = $bus['BusinessType'];  
                                $statusLabel = $bus['Status'] == "Active" ? "success" : ($bus['Status'] == "Suppened" ? "warning" : "danger");
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $BusinessTypeID; ?></td>
                                    <td><?php echo $BusinessType; ?></td>
                                    <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $bus['Status']; ?></span></td>
                                </tr>                                                     
                            <?php } ?>
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

