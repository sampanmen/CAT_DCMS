<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("admin", "frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$LocationID_Session = isset($_SESSION['LocationID']) ? $_SESSION['LocationID'] : 1;
$LocationID = isset($_GET['LocationID']) ? $_GET['LocationID'] : $LocationID_Session;
$summaryRack = getSummaryRackByLocatoinID($LocationID);
$summaryIP = getSummaryIPByLocationID($LocationID);
$summaryPort = getSummaryPortByLocationID($LocationID);
?>
<p><a href="?">Home</a> > <b>Resource Summary</b></p>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b>Location</b></h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <select class="form-control" name="location" id="location" onchange="window.location.href = this.value">
                        <option value="">Choose location</option>
                        <?php
                        $getLocationID = $LocationID;
                        $getLocation = getLocation();
                        foreach ($getLocation as $value) {
                            $valLocationID = $value['LocationID'];
                            $valLocation = $value['Location'];
                            ?>
                            <option <?php echo $valLocationID == $getLocationID ? "selected" : ""; ?> value="?p=resourceHome&LocationID=<?php echo $valLocationID; ?>"><?php echo $valLocation; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <script>
                    function selectedLocation() {

                    }
                </script>
            </div>
        </div>
        <!--Rack-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b>Rack </b><a href="../resource/modal_addRack.php" data-toggle="modal" data-target="#myModal">  (Add)  </a></h4>
            </div>      

            <div class="panel-body">
                <?php
                foreach ($summaryRack as $value) {
                    $valRackType = $value['RackType'];
                    $valRackTypeID = $value['RackTypeID'];
                    $valRackActive = $value['Active'];
                    $valRackSuppened = $value['Suppened'];
                    $valRackDeactive = $value['Deactive'];
                    $valRackTotal = $value['Total'];
                    $valRackUsed = $valRackActive + $valRackSuppened;
                    ?>
                    <div class="well-sm col-lg-12 ">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <p><a href="?p=viewRack&Type=<?php echo $valRackTypeID; ?>&LocationID=<?php echo $LocationID; ?>"><?php echo $value['RackType']; ?></a></p>      
                            </div>
                            <div class="col-lg-2">
                                <p>use</p>
                            </div>
                            <div class="col-lg-2">
                                <p><font size="3" COLOR="#0B610B"><b><?php echo $valRackUsed; ?></b></font></p>
                            </div>
                            <div class="col-lg-2">
                                <p>total</p>
                            </div>
                            <div class="col-lg-2">                               
                                <p><font size="3" COLOR=green><b><?php echo $valRackTotal; ?></b></font></p>                              
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!--IP-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b>IP </b><a href="../resource/modal_addIP.php" data-toggle="modal" data-target="#myModal">(Add)</a></h4>
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
                            foreach ($summaryIP as $value) {
                                $valNetworkID = $value['NetworkID'];
                                $valNetworkIP = $value['NetworkIP'];
                                $valSubnet = $value['Subnet'];
                                $valIPActive = $value['Active'];
                                $valIPSuppened = $value['Suppened'];
                                $valIPDeactive = $value['Deactive'];
                                $valIPTotal = $value['Total'];
                                $valIPUsed = $valIPActive + $valIPSuppened;
                                ?>
                                <tr>
                                    <td><a href="?p=viewIP&NetworkID=<?php echo $valNetworkID; ?>&LocationID=<?php echo $LocationID; ?>"><?php echo $valNetworkIP; ?> / <?php echo $valSubnet; ?></a></td>
                                    <td><?php echo $valIPUsed; ?></td>
                                    <td><?php echo $valIPTotal; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!--Port-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b>Port </b><a href="../resource/modal_addSwitch.php" data-toggle="modal" data-target="#myModal">(Add)</a></h4>
            </div>      

            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Uplink</th>
                                <th>Use</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($summaryPort as $value) {
                                $valSwitchID = $value['SwitchID'];
                                $valSwitchUplink = $value['Uplink'];
                                $valSwitchActive = $value['Active'];
                                $valSwitchSuppened = $value['Suppened'];
                                $valSwitchDeactive = $value['Deactive'];
                                $valSwitchTotal = $value['Total'];
                                $valSwitchUsed = $valIPActive + $valIPSuppened;
                                ?>
                                <tr>
                                    <td><?php echo "<a href='?p=viewPort&LocationID=$LocationID&SwitchID=$valSwitchID'>" . $value['SwitchName'] . "</a>"; ?></td>
                                    <td><?php echo $valSwitchUplink; ?></td>
                                    <td><?php echo $valSwitchUsed; ?></td>
                                    <td><?php echo $valSwitchTotal; ?></td>
                                </tr>                                                     
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--Servics-->
<!--        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><b>Servics
                        <a href="../resource/modal_addService.php" data-toggle="modal" data-target="#myModal">  (Add)  </a>
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
                 /.table-responsive 
            </div>
             /.row (nested) 
        </div>-->
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