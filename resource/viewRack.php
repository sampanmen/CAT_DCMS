<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$zone = (!isset($_GET['zone']) || $_GET['zone'] == "") ? "%" : $_GET['zone'];
$type = (!isset($_GET['type']) || $_GET['type'] == "") ? "%" : $_GET['type'];
//echo $zone;
$getRacks = getRacks();
$getRacksDetail = getRacksDetail($zone, $type);
?>

<p><a href="?">Home</a> > <b>Rack</b></p>
<div class="row">
    <form>
        <div class="col-lg-4"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><b>Rack </b><a href="../resource/model_addRack.php" data-toggle="modal" data-target="#myModal">(Add)</a></h5>
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Type Rack</th>
                                    <th>Zone</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getRacks as $value) {
                                    ?>
                                    <tr>
                                        <td><a href="?p=viewRack&type=<?php echo $value['RackType']; ?>"><?php echo $value['RackType']; ?></a></td>
                                        <td><a href="?p=viewRack&zone=<?php echo $value['Zone']; ?>"><?php echo $value['Zone']; ?></a></td>
                                        <td><?php echo $value['Position']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <div class="col-lg-8"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><b>Rack</b> <a href="?p=viewRack">(show all)</a></h5>
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Type Rack</th>
                                    <th>Zone</th>
                                    <th>Position</th>
                                    <th>Subposition</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getRacksDetail as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['RackType']; ?></td>
                                        <td><?php echo $value['Zone']; ?></td>
                                        <td><?php echo $value['Position']; ?></td>
                                        <td><?php echo $value['SubPosition']; ?></td>
                                        <td><?php echo $value['CustomerName'] == NULL ? "NULL" : "<a target='_blank' href='?p=viewCus&cusID=" . $value['CustomerID'] . "'>" . $value['CustomerName'] . "</a>"; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>























        <!--        <div class="col-lg-12">
                 
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Type Rack</th>
                                            <th>Zone</th>
                                            <th>Position</th>
                                            <th>Customer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Full Rack</td>
                                            <td>A</td>
                                            <td>01</td>
                                            <td>Thailand HaHa</td>
                                        </tr>                                                     
                                       <tr>
                                            <td>Full Rack</td>
                                            <td>A</td>
                                            <td>02</td>
                                            <td>Thailand HaHa</td>
                                        </tr>                            
                                       <tr>
                                            <td>Full Rack</td>
                                            <td>A</td>
                                            <td>03</td>
                                            <td></td>
                                        </tr>                            
                                       <tr>
                                            <td>Full Rack</td>
                                            <td>A</td>
                                            <td>04</td>
                                            <td></td>
                                        </tr>                 
                                        <tr>
                                            <td>Full Rack</td>
                                            <td>A</td>
                                            <td>05</td>
                                            <td></td>
                                        </tr>                       
                                        <tr>
                                            <td>Full Rack</td>
                                            <td>A</td>
                                            <td>06</td>
                                            <td></td>
                                        </tr>                   
                                        
        
                                    </tbody>
                                </table>
                            </div>
                             /.table-responsive 
                        </div>
                    </div>-->
    </form>

</div>
