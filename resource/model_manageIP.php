<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$orderDetailID = $_GET['orderDetailID'];
$used = $_GET['used'];
$assign = $_GET['assign'];

$getNetworks = getNetworksValue();
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
                $.get("../resource/action/resource.content.php?para=manageIP_used&orderDetailID=<?php echo $orderDetailID; ?>", function (data, status) {
                    $("#ipUsed").html(data);
                });
            </script>
        </div>   
    </div>
    <?php
    if ($assign - $used > 0) {
        ?>
        <div class="panel panel-default">
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
                            ?>
                            <option value="<?php echo $value['NetworkIP']; ?>"><?php echo $value['NetworkIP'] . " (" . $value['balance'] . ")"; ?></option>
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
                        var orderDetailID = <?php echo $orderDetailID; ?>;
                        $.get("../resource/action/resource.content.php?para=manageIP_reserve&orderDetailID=" + orderDetailID + "&network=" + network+"&used=<?php echo $used; ?>&assign=<?php echo $assign; ?>", function (data, status) {
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