<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk", "helpdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$ServiceDetailID = $_GET['ServiceDetailID'];
$locationID = $_GET['LocationID'];
$used = $_GET['used'];
$assign = $_GET['assign'];
$racktypeID = $_GET['racktypeID'];
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Rack</h4>
</div>

<div class="container-fluid"><br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6><b>Rack Used</b></h6>
        </div>      
        <div class="panel-body">
            <div class="dataTable_wrapper" id="rackUsed">
                <!-- table rack used-->
            </div>
            <script>
                showRackUsed();
                function showRackUsed() {
                    $.get("../resource/action/resource.content.php?para=manageRack_used&ServiceDetailID=<?php echo $ServiceDetailID; ?>", function (data, status) {
                        $("#rackUsed").html(data);
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
            </div><br>
            <div class="col-lg-12">
                <div class=" col-lg-2">
                    <p>Position</p>
                </div>
                <div class=" col-lg-6">
                    <select id="position" onchange="getRackReserve();">
                        <option>Choose</option>
                        <?php
                        $getRacks = getRackValueByServiceDetailID($racktypeID, $locationID);
                        echo "<pre>";
                        print_r($getRacks);
                        echo "</pre>";
                        foreach ($getRacks as $value) {
                            $col = $value['Col'];
                            $row = $value['Row'];
                            $rackPositionID = $value['RackPositionID'];
                            $Status = $value['Status'];
                            if ($Status == "Deactive") {
                                continue;
                            }
                            ?>
                            <option value="<?php echo $rackPositionID; ?>"><?php echo $col . $row; ?></option>
                        <?php } ?>
                    </select>    
                </div>
            </div>

            <div class="panel-body">
                <div class="dataTable_wrapper" id="rackReserve">
                    <!-- table rack reserve-->
                </div>
                <script>
                    function getRackReserve() {
                        var rackPositionID = $("#position").val();
                        var rackTypeID = "<?php echo $racktypeID; ?>";
                        var ServiceDetailID = <?php echo $ServiceDetailID; ?>;
                        $.get("../resource/action/resource.content.php?para=manageRack_reserve&ServiceDetailID=" + ServiceDetailID + "&racktypeID=" + rackTypeID + "&used=<?php echo $used; ?>&assign=<?php echo $assign; ?>&rackPositionID=" + rackPositionID, function (data, status) {
                            $("#rackReserve").html(data);
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