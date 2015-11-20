<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$PersonID_login = "-1";

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
                        showIPUsed();
                        if (j <= 0) {
                            $("#Reserve").hide();
                        }
                    });
                }
                else {
                    alert("Not assign IP");
                    $("#Reserve").hide();
                    showIPUsed();
                }
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
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if (confirm('Are you sure to Delete this IP')) {
                                assignIPNull('<?php echo $i; ?>', '<?php echo $value['IP']; ?>')
                            }
                            ;" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $value['IP']; ?></td>
                    <td><?php echo $value['NetworkIP']; ?></td>
                    <td><?php echo $value['Subnet']; ?></td>
                    <td><?php echo $value['VlanID']; ?></td>
                    <td><?php echo $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignIPNull(j, ipNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.php?para=assignIPNull&ip=" + ipNull, function (data, status) {
                    //                    alert(data);
                });
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "managePort_reserve") {
    $switchID = $_GET['switchID'];
    $orderDetailID = $_GET['orderDetailID'];
    $used = $_GET['used'];
    $assign = $_GET['assign'];
    $balance = $assign - $used;
    $ports = getSwitchPorts($switchID);
    ?>
    <table class="table table-striped table-bordered table-hover" id="tableAssign">
        <thead>
            <tr>
                <th></th>
                <th>Switch</th>
                <th>Port</th>
                <th>Type</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($ports as $value) {
                if ($value['CustomerName'] != NULL) {
                    continue;
                }
                $i++;
                ?>
                <tr id="tr_<?php echo $i; ?>">
                    <td><button type="button" id="btn_<?php echo $i; ?>" onclick="assignPort('<?php echo $i; ?>', '<?php echo $value['ResourceSwitchPortID']; ?>')" class="btn btn-success btn-circle"><i class="glyphicon-plus"></i></button></td>
                    <td><?php echo $value['SwitchName']; ?></td>
                    <td><?php echo $value['PortNumber']; ?></td>
                    <td><?php echo $value['PortType']; ?></td>
                    <td><?php echo $value['CustomerName'] == NULL ? "NULL" : $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            var j = <?php echo $balance; ?>;
            function assignPort(i, portID) {
                if (j > 0) {
                    $("#btn_" + i).hide();
                    $.get("../resource/action/resource.action.php?para=assignPort&portID=" + portID + "&orderDetailID=<?php echo $orderDetailID; ?>", function (data, status) {
                        j--;
                        showPortUsed();
                        if (j <= 0) {
                            $("#Reserve").hide();
                        }
                    });
                }
                else {
                    alert("Not assign Port");
                    $("#Reserve").hide();
                    showPortUsed();
                }
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "managePort_used") {
    $orderDetailID = $_GET['orderDetailID'];
    $ports = getPortByOrderDetailID($orderDetailID);
    ?>
    <table class="table  table-bordered " id="dataTables">
        <thead>
            <tr>
                <th></th>
                <th>Switch</th>
                <th>Port</th>
                <th>Type</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($ports as $value) {
                $i++;
                ?>
                <tr>
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if (confirm('Are you sure to Delete this Port')) {
                                assignPortNull('<?php echo $i; ?>', '<?php echo $value['ResourceSwitchPortID']; ?>');
                            }
                            ;" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $value['SwitchName']; ?></td>
                    <td><?php echo $value['PortNumber']; ?></td>
                    <td><?php echo $value['PortType']; ?></td>
                    <td><?php echo $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignPortNull(j, portNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.php?para=assignPortNull&portID=" + portNull, function (data, status) {
                    //                    alert(data);
                });
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "manageRack_reserve") {
    $orderDetailID = $_GET['orderDetailID'];
    $used = $_GET['used'];
    $assign = $_GET['assign'];
    $balance = $assign - $used;
    $rackType = $_GET['racktype'];
    $zone = $_GET['zone'];
    $position = $_GET['position'];
    $getRacks = getRacksReserve($zone, $position, $rackType);
    ?>
    <table class="table table-striped table-bordered table-hover" id="tableAssign">
        <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Zone</th>
                <th>Position</th>
                <th>Subposition</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($getRacks as $value) {
                if ($value['CustomerName'] != NULL) {
                    continue;
                }
                $i++;
                ?>
                <tr id="tr_<?php echo $i; ?>">
                    <td><button type="button" id="btn_<?php echo $i; ?>" onclick="assignRack('<?php echo $i; ?>', '<?php echo $value['ResourceRackID']; ?>')" class="btn btn-success btn-circle"><i class="glyphicon-plus"></i></button></td>
                    <td><?php echo $value['RackType']; ?></td>
                    <td><?php echo $value['Zone']; ?></td>
                    <td><?php echo $value['Position']; ?></td>
                    <td><?php echo $value['SubPosition']; ?></td>
                    <td><?php echo $value['CustomerName'] == NULL ? "NULL" : $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            var j = <?php echo $balance; ?>;
            function assignRack(i, rackID) {
                if (j > 0) {
                    $("#btn_" + i).hide();
                    $.get("../resource/action/resource.action.php?para=assignRack&rackID=" + rackID + "&orderDetailID=<?php echo $orderDetailID; ?>", function (data, status) {
                        j--;
                        showRackUsed();
                        if (j <= 0) {
                            $("#Reserve").hide();
                        }
                    });
                }
                else {
                    alert("Not assign Rack");
                    $("#Reserve").hide();
                    showRackUsed();
                }
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "manageRack_used") {
    $orderDetailID = $_GET['orderDetailID'];
    $racks = getRackByOrderDetailID($orderDetailID);
    ?>
    <table class="table  table-bordered " id="tableUsed">
        <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Zone</th>
                <th>Position</th>
                <th>Subposition</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($racks as $value) {
                $i++;
                ?>
                <tr>
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if (confirm('Are you sure to Delete this Rack')) {
                                assignRackNull('<?php echo $i; ?>', '<?php echo $value['ResourceRackID']; ?>');
                            }
                            ;" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $value['RackType']; ?></td>
                    <td><?php echo $value['Zone']; ?></td>
                    <td><?php echo $value['Position']; ?></td>
                    <td><?php echo $value['SubPosition']; ?></td>
                    <td><?php echo $value['CustomerName']; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignRackNull(j, rackNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.php?para=assignRackNull&rackID=" + rackNull, function (data, status) {
                    //                    alert(data);
                });
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "getRacksColumn") {
    $LocationID = $_GET['LocationID'];
    ?>
    <option selected value="">Other</option>
    <?php
    $getCols = getRacksColumn($LocationID);
    foreach ($getCols as $value) {
        $valCol = $value['Col'];
        ?>
        <option value="<?php echo $valCol; ?>"><?php echo $valCol; ?></option>
        <?php
    }
}