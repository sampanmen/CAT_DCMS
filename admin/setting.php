<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#staffposition" data-toggle="tab" aria-expanded="true">Position</a>
        </li>
        <li class=""><a href="#category" data-toggle="tab" aria-expanded="false">Category</a>
        </li>
        <li class=""><a href="#businesstype" data-toggle="tab" aria-expanded="false">Businesstypee</a>
        </li>
        <li class=""><a href="#location" data-toggle="tab" aria-expanded="false">location</a>
        </li>
        <li class=""><a href="#zone" data-toggle="tab" aria-expanded="false">Zone</a>
        </li>
        <li class=""><a href="#divition" data-toggle="tab" aria-expanded="false">Divition</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="staffposition">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5><b>Staff</b><a href="?p=showStaff"> (show Staff)</a></h5>
                    </div>      
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addStaffposition">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
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
                                                <td><a href="../admin/model_editPosition.php?StaffPositionID=<?php echo $staffPo['StaffPositionID']; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $Position; ?></a></td>
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $staffPo['Status']; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>

                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td><div class="form-group form-group-sm"><input class="form-control" name="position" required></div></td>
                                            <td><div class="form-group form-group-sm">
                                                    <select class="form-control" name="status">
                                                        <option value="Active">Active</option>
                                                        <option value="Deactive">Deactive</option>
                                                    </select></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="category">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default" id="CatagoryPackage">
                    <div class="panel-heading">
                        <h5><b>Package Category</b></h5>
                    </div>    
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addPacCatagory">
                                <table class="table table-striped table-bordered table-hover" id="dataTables1">
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
                                                <td><a href="../admin/model_editCat.php?PackageCategoryID=<?php echo $pacCat['PackageCategoryID']; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $PackageCategory; ?></a></td>                                      
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $pacCat['Status']; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr> 
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td><input class="form-control" name="category" ></td>
                                            <td><select class="form-control" name="status">
                                                    <option value="Active">Active</option>
                                                    <option value="Deactive">Deactive</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>

        </div>
        <div class="tab-pane fade" id="businesstype">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default" id="Businesstype">
                    <div class="panel-heading">
                        <h5><b>Business Type</b></h5>
                    </div>      

                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addBusinesstype">
                                <table class="table table-striped table-bordered table-hover"id="dataTables2">
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
                                                <td><a href="../admin/model_editBusi.php?BusinessTypeID=<?php echo $bus['BusinessTypeID']; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $BusinessType; ?></a></td>         
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $bus['Status']; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr> 
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td><input class="form-control" name="businessType" ></td>
                                            <td><select class="form-control" name="status">
                                                    <option value="Active">Active</option>
                                                    <option value="Deactive">Deactive</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>

        </div>
        <div class="tab-pane fade" id="location">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default" id="location">
                    <div class="panel-heading">
                        <h5><b>Location</b></h5>
                    </div>  
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addLocation">
                                <table class="table table-striped table-bordered table-hover"id="dataTables3">
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
                                                <td><a href="../admin/model_editLocation.php?LocationID=<?php echo $locav['LocationID']; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $Location; ?></a></td>
                                                <td><?php echo $Address ?></td>
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $locav['Status']; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td ><div class="form-group form-group-sm"><input class="form-control" name="location" ></div></td>
                                            <td><div class="form-group form-group-sm"><textarea class="form-control" name="address" ></textarea></div></td>
                                            <td><div class="form-group form-group-sm">
                                                    <select class="form-control" name="status">
                                                        <option value="Active">Active</option>
                                                        <option value="Deactive">Deactive</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>

        </div>
        <div class="tab-pane fade" id="zone">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default" id="zone">
                    <div class="panel-heading">
                        <h5><b>Zone</b></h5>
                    </div>     
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addZone">
                                <table class="table table-striped table-bordered table-hover" id="dataTables4">
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
                                                <td><a href="../admin/model_editZone.php?EntryZoneID=<?php echo $Zone['EntryZoneID']; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $EntryZone; ?></a></td> 
                                                <td><?php echo $Location ?></td>
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $Zone['Status']; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td><div class="form-group form-group-sm"><input class="form-control " name="zone" ></div></td>
                                            <td><div class="form-group form-group-sm">
                                                    <select class="form-control" name="locazone">
                                                        <?php
                                                        $loca = getLocation();
                                                        foreach ($loca as $value) {
                                                            if ($value['Status'] == "Deactive")
                                                                continue;
                                                            ?>
                                                            <option value="<?php echo $value['LocationID']; ?>"><?php echo $value['Location']; ?></option>
                                                        <?php } ?>
                                                    </select> </div>  
                                            </td>
                                            <td><div class="form-group form-group-sm">
                                                    <select class="form-control" name="status">
                                                        <option value="Active">Active</option>
                                                        <option value="Deactive">Deactive</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="tab-pane fade" id="divition">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default" id="divition">
                    <div class="panel-heading">
                        <h5><b>Divition</b></h5>
                    </div>  
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addDivition">
                                <table class="table table-striped table-bordered table-hover"id="dataTables5">
                                    <thead>
                                        <tr>
                                            <th width="70"class="text-center">ID</th>
                                            <th>Division</th>
                                            <th>Organization</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>                            
                                        <?php
                                        $Divition = getDivition();
                                        foreach ($Divition as $divi) {
                                            $DivisionID = $divi['DivisionID'];
                                            $Division = $divi['Division'];
                                            $Organization = $divi['Organization'];
                                            $Address = $divi['Address'];
                                            $status = $divi['Status'];
                                            $statusLabel = $status == "Active" ? "success" : ($status == "Suppened" ? "warning" : "danger");
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $DivisionID; ?></td>
                                                <td><a href="../admin/model_editDivition.php?DivisionID=<?php echo $DivisionID; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $Division; ?></a></td>
                                                <td><?php echo $Organization ?></td>
                                                <td><?php echo $Address ?></td>
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $status; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td ><div class="form-group form-group-sm"><input class="form-control" name="divition" ></div></td>
                                            <td ><div class="form-group form-group-sm">
                                             <select class="form-control" name="organization">
                                                        <option value="CAT">CAT</option>
                                                        <option value="Vender">Vender</option>
                                                    </select></div></td>
                                            <td><div class="form-group form-group-sm"><textarea class="form-control" name="address" ></textarea></div></td>
                                            <td><div class="form-group form-group-sm">
                                                    <select class="form-control" name="status">
                                                        <option value="Active">Active</option>
                                                        <option value="Deactive">Deactive</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>

        </div>







    </div>




</div>

<script>
    $(document).ready(function () {
        $('#dataTables1').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables2').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables3').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables4').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables5').DataTable({
            responsive: true
        });
    });
</script>

