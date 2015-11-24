<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<p><a href="?">Home</a> > <b>Packages</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label>
                    Packages  <a href="../customer/modal_addPackags.php" data-toggle="modal" data-target="#myModal">  (Add)  </a>   
                </label>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <!--<th>ID Service</th>-->
                                <th>Name</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $services = getPackages();
                            foreach ($services as $package) {
                                $packageID = $package['PackageID'];
                                $packageName = $package['PackageName'];
                                $packageType = $package['PackageType'];
                                $packageCategory = $package['PackageCategory'];
                                $location = $package['Location'];
                                $packageStatus = $package['PackageStatus'];
                                ?>
                                <tr>
                                    <td><?php echo $packageName; ?></td>
                                    <td><?php echo $packageType; ?></td>
                                    <td><?php echo $packageCategory; ?></td>
                                    <td><?php echo $location; ?></td>
                                    <td><p class="label label-<?php echo $packageStatus == "Active" ? "success" : "danger"; ?>"><?php echo $packageStatus; ?></p></td>
                                    <td>
                                        <a href="../customer/modal_viewPackages.php?packageID=<?php echo $packageID; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">view</a>
                                        <a href="../customer/modal_editPackages.php?packageID=<?php echo $packageID; ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">Edit</a>
                                    </td>
                                </tr>                                                     
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>

    <!-- /.col-lg-8 -->

    <!--/.col-lg-4--> 
</div>
