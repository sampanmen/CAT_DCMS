<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$swID = (isset($_GET['swID'])) ? $_GET['swID'] : "";
$sw = getSwitchs();
$swPort = getSwitchPorts($swID);
?>
<p><a href="?">Home</a> > <b>Switch&Port</b></p>
<div class="row">
    <form> 
        <div class="col-lg-5"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><b>Switch</b> <a href="../resource/model_addPort.php" data-toggle="modal" data-target="#myModal">(Add)</a></h5>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Switch name</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($sw as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo "<a href='?p=viewPort&swID=" . $value['ResourceSwitchID'] . "'>" . $value['SwitchName'] . "</a>"; ?></td>
                                        <td><?php echo $value['SwitchIP']; ?></td>
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


        <div class="col-lg-7"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><b>Port </b><a href="?p=viewPort">(Show All)</a></h5>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Switch name</th>
                                    <th>Port No.</th>
                                    <th>Type</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($swPort as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['SwitchName']; ?></td>
                                        <td><?php echo $value['PortNumber']; ?></td>
                                        <td><?php echo $value['PortType']; ?></td>
                                        <td>
                                            <?php echo $value['Uplink'] == 1 ? "Uplink" : $value['CustomerName']; ?>
                                        </td>
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
                                            <th>Switch name</th>
                                            <th>Port</th>
                                            <th>Vlan</th>
                                            <th>Type</th>
                                            <th>Customer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>switch 1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>100</td>
                                            <td>Thailand HaHa</td>
                                        </tr>                                                     
                                       <tr>
                                            <td>switch 1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>100</td>
                                            <td>Thailand HaHa</td>
                                        </tr>                             
                                        <tr>
                                            <td>switch 1</td>
                                            <td>3</td>
                                            <td>1</td>
                                            <td>100</td>
                                            <td></td>
                                        </tr>                            
                                       <tr>
                                            <td>switch 1</td>
                                            <td>4</td>
                                            <td>1</td>
                                            <td>100</td>
                                            <td></td>
                                        </tr>                
                                        <tr>
                                            <td>switch 1</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>100</td>
                                            <td>Thailand HaHa</td>
                                        </tr>                      
                                        <tr>
                                            <td>switch 1</td>
                                            <td>6</td>
                                            <td>1</td>
                                            <td>100</td>
                                            <td>Thailand HaHa</td>
                                        </tr>                  
                                        
        
                                    </tbody>
                                </table>
                            </div>
                             /.table-responsive 
                        </div>
                    </div>-->
</div>
</form>

</div>
