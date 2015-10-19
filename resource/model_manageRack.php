<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$orderDetailID = $_GET['orderDetailID'];
$used = $_GET['used'];
$assign = $_GET['assign'];
$racktype = $_GET['PackageCategory'];
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
                    $.get("../resource/action/resource.content.php?para=manageRack_used&orderDetailID=<?php echo $orderDetailID; ?>", function (data, status) {
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
                        <option value=",">Choose</option>
                        <?php
                        $getRacks = getRackValue($racktype);
                        foreach ($getRacks as $value) {
                            ?>
                            <option value="<?php echo $value['Zone']; ?>,<?php echo $value['Position']; ?>"><?php echo $value['Zone'] . $value['Position'] . " (" . $value['balance'] . ")"; ?></option>
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
                        var tmp = $("#position").val();
                        var res = tmp.split(",");
                        var zone = res[0];
                        var position = res[1];
                        var rackType = "<?php echo $racktype; ?>";
                        var orderDetailID = <?php echo $orderDetailID; ?>;
                        $.get("../resource/action/resource.content.php?para=manageRack_reserve&orderDetailID=" + orderDetailID + "&racktype=" + rackType + "&used=<?php echo $used; ?>&assign=<?php echo $assign; ?>&zone=" + zone + "&position=" + position, function (data, status) {
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