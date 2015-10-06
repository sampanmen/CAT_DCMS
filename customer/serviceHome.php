<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $services = getPackages();
                            foreach ($services as $service) {
                                ?>
                                <tr class="odd gradeX">
                                    <!--<td><?php //echo $service['PackageID']; ?></td>-->
                                    <td><?php echo $service['PackageName']; ?></td>
                                    <td><?php echo $service['PackageDetail']; ?></td>
                                    <td><?php echo $service['PackageType']; ?></td>
                                    <td><?php echo $service['PackageCategory']; ?></td>
                                    <td><?php echo $service['PackageStatus']; ?></td>
                                    <td>
                                        <a href="../customer/model_viewPackages.php?packageID=<?php echo $service['PackageID']; ?>" class="btn btn-primary" data-toggle="modal" data-target="#myModal">view</a>
                                        <a href="../customer/model_editPackages.php?packageID=<?php echo $service['PackageID']; ?>" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Edit</a>
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
