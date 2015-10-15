<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$summeryRack = getSummeryRack();
$summeryIP = getSummeryIP();
?>
<p><a href="?">Home</a> > <b>Resource Summery</b></p>
<div class="row">
    <form>
        <div class="col-lg-6">  
            <!--Rack-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>Rack </b><a href="../resource/model_addRack.php" data-toggle="modal" data-target="#myModal">  (Add)  </a></h4>
                </div>      

                <div class="panel-body">
                    <?php
                    foreach ($summeryRack as $value) {
                        ?>
                        <div class="well-sm col-lg-12 ">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <p><a href="?p=viewRack&type=<?php echo $value['RackType']; ?>"><?php echo $value['RackType']; ?></a></p>      
                                </div>
                                <div class="col-lg-2">
                                    <p>use</p>
                                </div>
                                <div class="col-lg-2">
                                    <p><font size="3" COLOR=red><b><?php echo $value['use']; ?></b></font></p>
                                </div>
                                <div class="col-lg-2">
                                    <p>total</p>
                                </div>
                                <div class="col-lg-2">                               
                                    <p><font size="3" COLOR=green><b><?php echo $value['total']; ?></b></font></p>                              
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!--IP-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>IP </b><a href="../resource/model_addIP.php" data-toggle="modal" data-target="#myModal">(Add)</a></h4>
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables1">
                            <thead>
                                <tr>
                                    <th>Network IP</th>
                                    <th>Use</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($summeryIP as $value) {
                                    ?>
                                    <tr>
                                        <td><a href="?p=viewIP&network=<?php echo $value['NetworkIP']; ?>"><?php echo $value['NetworkIP']; ?> / <?php echo $value['Subnet']; ?></a></td>
                                        <td><?php echo $value['use']; ?></td>
                                        <td><?php echo $value['total']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!--Servics-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>Servics
                            <a href="../resource/model_addService.php" data-toggle="modal" data-target="#myModal">  (Add)  </a>
                        </b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables2">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Detail</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room 1</td>
                                    <td>ห้องสำหรับประชุม</td>
                                    <td>Use</td>
                                </tr>                                                     

                                <tr>
                                    <td>Room 2</td>
                                    <td>ห้องสำหรับประชุม</td>
                                    <td>Use</td>
                                </tr>       
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>




            <!--Port-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>Port
                            <a href="../resource/model_addPort.php" data-toggle="modal" data-target="#myModal">  (Add)  </a>
                        </b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables3">
                            <thead>
                                <tr>
                                    <th>Name Switchs</th>
                                    <th>Total</th>
                                    <th>Use</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Swith 1</td>
                                    <td>48</td>
                                    <td>6</td>

                                </tr>                                                     

                                <tr>
                                    <td>Swith 2</td>
                                    <td>48</td>
                                    <td>6</td>
                                </tr>          
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>






            <!-- /.panel-body -->
        </div>

    </form>
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