<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<div class="row">
    <!-- Nav tabs -->
    <?php
    $tab = isset($_GET['tab']) ? $_GET['tab'] : "staffposition";
    ?>
    <ul class="nav nav-tabs">
        <li class="<?php echo $tab == "staffposition" ? "active" : ""; ?>"><a href="#staffposition" data-toggle="tab" aria-expanded="<?php echo $tab == "staffposition" ? "true" : "false"; ?>">Position</a>
        </li>
        <li class="<?php echo $tab == "category" ? "active" : ""; ?>"><a href="#category" data-toggle="tab" aria-expanded="<?php echo $tab == "category" ? "true" : "false"; ?>">Package Category</a>
        </li>
        <li class="<?php echo $tab == "businesstype" ? "active" : ""; ?>"><a href="#businesstype" data-toggle="tab" aria-expanded="<?php echo $tab == "businesstype" ? "true" : "false"; ?>">Businesstype</a>
        </li>
        <li class="<?php echo $tab == "location" ? "active" : ""; ?>"><a href="#location" data-toggle="tab" aria-expanded="<?php echo $tab == "location" ? "true" : "false"; ?>">Location</a>
        </li>
        <li class="<?php echo $tab == "zone" ? "active" : ""; ?>"><a href="#zone" data-toggle="tab" aria-expanded="<?php echo $tab == "zone" ? "true" : "false"; ?>">Zone</a>
        </li>
        <li class="<?php echo $tab == "division" ? "active" : ""; ?>"><a href="#division" data-toggle="tab" aria-expanded="<?php echo $tab == "division" ? "true" : "false"; ?>">Division</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade <?php echo $tab == "staffposition" ? "in active" : ""; ?>" id="staffposition">
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
        <div class="tab-pane fade <?php echo $tab == "category" ? "in active" : ""; ?>" id="category">
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
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cat = getCatagory();
                                        foreach ($cat as $pacCat) {
                                            $PackageCategoryID = $pacCat['PackageCategoryID'];
                                            $PackageCategory = $pacCat['PackageCategory'];
                                            $valType = $pacCat['Type'];
                                            $statusLabel = $pacCat['Status'] == "Active" ? "success" : ($pacCat['Status'] == "Suppened" ? "warning" : "danger");
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $PackageCategoryID; ?></td>
                                                <td><a href="../admin/model_editCat.php?PackageCategoryID=<?php echo $pacCat['PackageCategoryID']; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $PackageCategory; ?></a></td>                                      
                                                <td><?php echo $valType; ?></td>
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $pacCat['Status']; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr> 
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td><input class="form-control" name="category" ></td>
                                            <td>
                                                <select class="form-control" name="type">
                                                    <option>Choose</option>
                                                    <option value="Rack">Rack</option>
                                                    <option value="IP Address">IP Address</option>
                                                    <option value="Port">Port</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="status">
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
        <div class="tab-pane fade <?php echo $tab == "businesstype" ? "in active" : ""; ?>" id="businesstype">
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
        <div class="tab-pane fade <?php echo $tab == "location" ? "in active" : ""; ?>" id="location">
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
        <div class="tab-pane fade <?php echo $tab == "zone" ? "in active" : ""; ?>" id="zone">
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


        <div class="tab-pane fade <?php echo $tab == "division" ? "in active" : ""; ?>" id="division">
            <br>
            <div class="col-lg-9"> 
                <div class="panel panel-default" id="division">
                    <div class="panel-heading">
                        <h5><b>Division</b></h5>
                    </div>  
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <form method="POST" action="../admin/action/admin.action.php?para=addDivision">
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
                                        $Division = getDivision();
                                        foreach ($Division as $divi) {
                                            $DivisionID = $divi['DivisionID'];
                                            $Division = $divi['Division'];
                                            $Organization = $divi['Organization'];
                                            $Address = $divi['Address'];
                                            $status = $divi['Status'];
                                            $statusLabel = $status == "Active" ? "success" : ($status == "Suppened" ? "warning" : "danger");
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $DivisionID; ?></td>
                                                <td><a href="../admin/model_editDivision.php?DivisionID=<?php echo $DivisionID; ?>"  data-toggle="modal" data-target="#myModal"><?php echo $Division; ?></a></td>
                                                <td><?php echo $Organization ?></td>
                                                <td><?php echo $Address ?></td>
                                                <td><span class="label label-<?php echo $statusLabel; ?>"><?php echo $status; ?></span></td>
                                            </tr>                                                     
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center"><button type="submit" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>
                                            <td ><div class="form-group form-group-sm"><input class="form-control" name="division" ></div></td>
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

