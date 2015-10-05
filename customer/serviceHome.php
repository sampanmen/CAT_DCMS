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
                                <th>ID Service</th>
                                <th>Service Name</th>
                                <th>Detail</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $services = getService();
                            foreach ($services as $service) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $service['ServiceID']; ?></td>
                                    <td><?php echo $service['NameService']; ?></td>
                                    <td><?php echo $service['Detail']; ?></td>
                                    <td><?php echo $service['ServiceType']; ?></td>
                                    <td><?php echo $service['Status']; ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="#">View</a>
                                        <a class="btn btn-warning" href="#">Edit</a>
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
