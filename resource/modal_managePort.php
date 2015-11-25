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
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Port</h4>
</div>

<div class="container-fluid"><br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6><b>Port Used</b></h6>
        </div>      
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <div class="dataTable_wrapper" id="portUsed">
                    <!-- table port used-->
                </div>
                <script>
                    showPortUsed();
                    function showPortUsed() {
                        $.get("../resource/action/resource.content.php?para=managePort_used&ServiceDetailID=<?php echo $ServiceDetailID; ?>", function (data, status) {
                            $("#portUsed").html(data);
                        });
                    }
                </script>
            </div>
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
                    <p>Switch</p>
                </div>
                <div class=" col-lg-6">
                    <select id="switchID" onchange="getPortReserve();">
                        <option value="">Choose</option>
                        <?php
                        $getSwitchsValue = getSwitchValueByLocation($locationID);
                        foreach ($getSwitchsValue as $value) {
                            $switchID = $value['SwitchID'];
                            $switchName = $value['SwitchName'];
                            $switchIP = $value['SwitchIP'];
                            $switchType = $value['SwitchType'];
                            $Status = $value['Status'];
                            if ($Status == "Deactive") {
                                continue;
                            }
                            ?>
                            <option value="<?php echo $switchID; ?>"><?php echo $switchName . " ($switchType)"; ?></option>
                        <?php } ?>
                    </select>    
                </div>
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper" id="portReserve">
                    <!-- table port reserve-->
                </div>
                <script>
                    function getPortReserve() {
                        var switchID = $("#switchID").val();
                        var ServiceDetailID = <?php echo $ServiceDetailID; ?>;
                        $.get("../resource/action/resource.content.php?para=managePort_reserve&ServiceDetailID=" + ServiceDetailID + "&SwitchID=" + switchID + "&used=<?php echo $used; ?>&assign=<?php echo $assign; ?>", function (data, status) {
                            $("#portReserve").html(data);
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
    <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
    <!--<button type="button" class="btn btn-primary">Save</button>-->
</div>
<script>
    $('body').on('hidden.bs.modal', '.modal', function () {
        location.reload();
    });
</script>