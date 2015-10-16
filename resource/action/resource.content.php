<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "manageIP_reserve") {
    $network = $_GET['network'];
    $orderDetailID = $_GET['orderDetailID'];
    $used = $_GET['used'];
    $assign = $_GET['assign'];
    $balance = $assign - $used;
    $ips = getIPs($network);
    ?>
    <table class="table table-striped table-bordered table-hover" id="tableAssign">
        <thead>
            <tr>
                <th></th>
                <th>IP Address</th>
                <th>Network</th>
                <th>Subnet</th>
                <th>Vlan</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($ips as $value) {
                if ($value['CustomerName'] != NULL) {
                    continue;
                }
                $i++;
                ?>
                <tr id="tr_<?php echo $i; ?>">
                    <td><button type="button" id="btn_<?php echo $i; ?>" onclick="assignIP('<?php echo $i; ?>', '<?php echo $value['IP']; ?>')" class="btn btn-success btn-circle"><i class="glyphicon-plus"></i></button></td>
                    <td><?php echo $value['IP']; ?></td>
                    <td><?php echo $value['NetworkIP']; ?></td>
                    <td><?php echo $value['Subnet']; ?></td>
                    <td><?php echo $value['VlanID']; ?></td>
                    <td><?php echo $value['CustomerName'] == NULL ? "NULL" : $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            var j = <?php echo $balance; ?>;
            function assignIP(i, ip) {
                if (j > 0) {
                    $("#btn_" + i).hide();
                    $.get("../resource/action/resource.action.php?para=assignIP&ip=" + ip + "&orderDetailID=<?php echo $orderDetailID; ?>", function (data, status) {
//                        alert(data);
                        j--;
                    });
                }
                else
                    alert("Not assign IP");
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "manageIP_used") {
    $orderDetailID = $_GET['orderDetailID'];
    $ips = getIPsByOrderDetailID($orderDetailID);
    ?>
    <table class="table  table-bordered " id="dataTables">
        <thead>
            <tr>
                <th></th>
                <th>IP Address</th>
                <th>Network</th>
                <th>Subnet</th>
                <th>Vlan</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($ips as $value) {
                $i++;
                ?>
                <tr>
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if(confirm('Are you sure to Delete this IP')){assignIPNull('<?php echo $i; ?>', '<?php echo $value['IP']; ?>')};" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $value['IP']; ?></td>
                    <td><?php echo $value['NetworkIP']; ?></td>
                    <td><?php echo $value['Subnet']; ?></td>
                    <td><?php echo $value['VlanID']; ?></td>
                    <td><?php echo $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignIPNull(j,ipNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.php?para=assignIPNull&ip=" + ipNull, function (data, status) {
//                    alert(data);
                });
            }
        </script>
    </tbody>
    </table>
    <?php
}

