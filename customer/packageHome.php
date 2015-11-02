<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<p><a href="?">Home</a> > <b>Packages</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label>
                    Packages  <a href="../customer/model_addPackags.php" data-toggle="modal" data-target="#myModal">  (Add)  </a>   
                </label>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <!--<th>ID Service</th>-->
                                <th>Service Name</th>
                                <th>Detail</th>
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
                                $packageDetail = $package['PackageDetail'];
                                $packageType = $package['PackageType'];
                                $packageCategory = $package['PackageCategory'];
                                $location = $package['Location'];
                                $packageStatus = $package['PackageStatus'];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $packageName; ?></td>
                                    <td><?php echo $packageDetail; ?></td>
                                    <td><?php echo $packageType; ?></td>
                                    <td><?php echo $packageCategory; ?></td>
                                    <td><?php echo $location; ?></td>
                                    <td><?php echo $packageStatus; ?></td>
                                    <td>
                                        <a href="../customer/model_viewPackages.php?packageID=<?php echo $packageID; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">view</a>
                                        <a href="../customer/model_editPackages.php?packageID=<?php echo $packageID; ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">Edit</a>
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
