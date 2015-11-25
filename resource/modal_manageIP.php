<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$ServiceDetailID = $_GET['ServiceDetailID'];
$locationID = $_GET['LocationID'];
$used = $_GET['used'];
$assign = $_GET['assign'];

$getNetworks = getNetworksValue($locationID);
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">IP</h4>
</div>

<div class="container-fluid"><br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6><b>IP Address Used</b></h6>
        </div>      

        <div class="panel-body">
            <div class="dataTable_wrapper" id="ipUsed">
                <!-- table ip used-->
            </div>
            <script>
                showIPUsed();
                function showIPUsed() {
                    $.get("../resource/action/resource.content.php?para=manageIP_used&ServiceDetailID=<?php echo $ServiceDetailID; ?>&LocationID=<?php echo $locationID; ?>", function (data, status) {
                        $("#ipUsed").html(data);
                    });
                }
            </script>
        </div>   
    </div>
    <?php
    if ($assign - $used > 0) {
        ?>
        <div class="panel panel-default" id="Reserve">
            <div class="panel-heading">
                <h6><b>Select</b></h6>
            </div>  
            <br>
            <div class="col-lg-12">
                <div class=" col-lg-2">
                    <p>Network</p>
                </div>
                <div class=" col-lg-6">
                    <select id="network" onchange="getIPReserve();">
                        <option>Choose Network</option>
                        <?php
                        foreach ($getNetworks as $value) {
                            $networkID = $value['NetworkID'];
                            $networkIP = $value['NetworkIP'];
                            $subnet = $value['Subnet'];
                            $vlan = $value['Vlan'];
                            ?>
                            <option value="<?php echo $networkID; ?>"><?php echo $networkIP . "/" . $subnet; ?></option>
                        <?php } ?>
                    </select>    
                </div>
            </div>

            <div class="panel-body">
                <div class="dataTable_wrapper" id="ipReserve">
                    <!-- table ip reserve-->
                </div>
                <script>
                    function getIPReserve() {
                        var network = $("#network").val();
                        var ServiceDetailID = <?php echo $ServiceDetailID; ?>;
                        $.get("../resource/action/resource.content.php?para=manageIP_reserve&ServiceDetailID=" + ServiceDetailID + "&networkID=" + network + "&used=<?php echo $used; ?>&assign=<?php echo $assign; ?>", function (data, status) {
                            $("#ipReserve").html(data);
                        });
                    }
                </script>
            </div>
        </div>
        <?php
    } else {
        echo "<p class='label label-success'>Assign Completed.</p><br><br>";
    }
    ?>
</div>

<div class="modal-footer">
    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
    <a href="" class="btn btn-primary">Close</a>
</div>
<script>
    $('body').on('hidden.bs.modal', '.modal', function () {
        location.reload();
    });
</script>