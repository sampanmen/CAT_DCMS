<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$swID = (isset($_GET['swID'])) ? $_GET['swID'] : "";
$sw = getSwitchs();
$swPort = getSwitchPorts($swID);
?>
<p><a href="?">Home</a> > <b>Switch&Port</b></p>
<div class="row">
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
                            $i = 0;
                            foreach ($swPort as $value) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $value['SwitchName']; ?></td>
                                    <td><?php echo $value['PortNumber']; ?></td>
                                    <td ondblclick="editPortType('<?php echo $value['ResourceSwitchPortID']; ?>', '<?php echo $i; ?>');">
                                        <p id="portType_txt_<?php echo $i; ?>"><?php echo $value['PortType']; ?></p>
                                        <input style="display: none;" id="portType_in_<?php echo $i; ?>" onchange="savePortType('<?php echo $value['ResourceSwitchPortID']; ?>', this, '<?php echo $i; ?>')" type="text" value="<?php echo $value['PortType']; ?>">
                                    </td>
                                    <td>
                                        <?php echo $value['Uplink'] == 1 ? "Uplink" : $value['CustomerName']; ?>
                                    </td>
                                </tr> 
                            <?php } ?>
                        <script>
                            function editPortType(idPort, i) {
//                                alert(idPort + " " + i);
                                $("#portType_txt_" + i).hide();
                                $("#portType_in_" + i).show();
                            }
                            function savePortType(idPort, data, i) {
                                $("#portType_txt_" + i).html($("#portType_in_" + i).val());
                                $("#portType_txt_" + i).show();
                                $("#portType_in_" + i).hide();
                            }
                        </script>
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
