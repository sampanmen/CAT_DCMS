<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$PersonID_login = "-1";

if ($para == "manageIP_reserve") {
    $networkID = $_GET['networkID'];
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $used = $_GET['used'];
    $assign = $_GET['assign'];
    $balance = $assign - $used;
    $ips = getIPs($networkID);
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
                if ($value['StatusUsed'] != NULL && $value['StatusUsed'] != "Deactive") {
                    continue;
                }
                $i++;
                $ip = $value['IP'];
                $ipid = $value['IPID'];
                $networkID = $value['NetworkID'];
                $networkIP = $value['NetworkIP'];
                $subnet = $value['Subnet'];
                $vlan = $value['Vlan'];
                $customerName = $value['CustomerName'];
                $statusUsed = $value['StatusUsed'];
                ?>
                <tr id="tr_<?php echo $i; ?>">
                    <td><button type="button" id="btn_<?php echo $i; ?>" onclick="assignIP('<?php echo $i; ?>', '<?php echo $ipid; ?>')" class="btn btn-success btn-circle"><i class="glyphicon-plus"></i></button></td>
                    <td><?php echo $ip; ?></td>
                    <td><?php echo $networkIP; ?></td>
                    <td><?php echo $subnet; ?></td>
                    <td><?php echo $vlan; ?></td>
                    <td><?php echo ($customerName == NULL || $statusUsed == "Deactive") ? "NULL" : $customerName; ?></td>
                </tr>
            <?php } ?>
        <script>
            var j = <?php echo $balance; ?>;
            function assignIP(i, ipid) {
                if (j > 0) {
                    $("#btn_" + i).hide();
                    $.get("../resource/action/resource.action.assign.php?para=assignIP&ipid=" + ipid + "&ServiceDetailID=<?php echo $ServiceDetailID; ?>", function (data, status) {
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

            $(document).ready(function () {
                $('#tableAssign').DataTable({
                    responsive: true
                });
            });
        </script>

    </tbody>
    </table>
    <?php
} else if ($para == "manageIP_used") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $ips = getIPsByServiceDetailID($ServiceDetailID);
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
                if ($value['StatusUsed'] == "Deactive") {
                    continue;
                }
                $i++;
                $ipid = $value['IPID'];
                $ip = $value['IP'];
                $network = $value['NetworkIP'];
                $subnet = $value['Subnet'];
                $vlan = $value['Vlan'];
                $cusName = $value['CustomerName'];
                ?>
                <tr>
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if (confirm('Are you sure to Delete this IP')) {
                                assignIPNull('<?php echo $i; ?>', '<?php echo $ipid; ?>')
                            }
                            ;" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $ip; ?></td>
                    <td><?php echo $network; ?></td>
                    <td><?php echo $subnet; ?></td>
                    <td><?php echo $vlan; ?></td>
                    <td><?php echo $cusName; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignIPNull(j, ipNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.assign.php?para=assignIPNull&ServiceDetailID=<?php echo $ServiceDetailID; ?>&ip=" + ipNull, function (data, status) {
                    //                    alert(data);
                });
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "managePort_reserve") {
    $switchID = $_GET['SwitchID'];
    $ServiceDetailID = $_GET['ServiceDetailID'];
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
                if ($value['StatusUsed'] != NULL && $value['StatusUsed'] != "Deactive") {
                    continue;
                }
                $i++;
                $portID = $value['SwitchPortID'];
                $statusUsed = $value['StatusUsed'];
                $switchName = $value['SwitchName'];
                $portNumber = $value['PortNumber'];
                $portType = $value['PortType'];
                $customerName = $value['CustomerName'];
                ?>
                <tr id="tr_<?php echo $i; ?>">
                    <td><button type="button" id="btn_<?php echo $i; ?>" onclick="assignPort('<?php echo $i; ?>', '<?php echo $portID; ?>')" class="btn btn-success btn-circle"><i class="glyphicon-plus"></i></button></td>
                    <td><?php echo $switchName; ?></td>
                    <td><?php echo $portNumber; ?></td>
                    <td><?php echo $portType; ?></td>
                    <td><?php echo ($customerName == NULL || $statusUsed == "Deactive") ? "NULL" : $customerName; ?></td>
                </tr>
            <?php } ?>
        <script>
            var j = <?php echo $balance; ?>;
            function assignPort(i, portID) {
                if (j > 0) {
                    $("#btn_" + i).hide();
                    $.get("../resource/action/resource.action.assign.php?para=assignPort&portID=" + portID + "&ServiceDetailID=<?php echo $ServiceDetailID; ?>", function (data, status) {
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
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $ports = getPortByServiceDetailID($ServiceDetailID);
    ?>
    <table class="table table-bordered" id="dataTables">
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
                if ($value['StatusUsed'] == "Deactive") {
                    continue;
                }
                $i++;
                $switchName = $value['SwitchName'];
                $portID = $value['SwitchPortID'];
                $portNumber = $value['PortNumber'];
                $portType = $value['PortType'];
                $customerName = $value['CustomerName'];
                ?>
                <tr>
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if (confirm('Are you sure to Delete this Port')) {
                                assignPortNull('<?php echo $i; ?>', '<?php echo $portID; ?>');
                            }
                            ;" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $switchName; ?></td>
                    <td><?php echo $portNumber; ?></td>
                    <td><?php echo $portType; ?></td>
                    <td><?php echo $customerName; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignPortNull(j, portNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.assign.php?para=assignPortNull&ServiceDetailID=<?php echo $ServiceDetailID; ?>&portID=" + portNull, function (data, status) {
                    //                    alert(data);
                });
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "manageRack_reserve") {
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $used = $_GET['used'];
    $assign = $_GET['assign'];
    $balance = $assign - $used;
    $rackTypeID = $_GET['racktypeID'];
    $RackPositionID = $_GET['rackPositionID'];
    $getRacks = getRacksReserve($RackPositionID, $rackTypeID);
    ?>
    <table class="table table-striped table-bordered table-hover" id="tableAssign">
        <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Column</th>
                <th>Row</th>
                <th>Position</th>
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
                $RackID = $value['RackID'];
                $RackType = $value['RackType'];
                $Col = $value['Col'];
                $Row = $value['Row'];
                $subPosition = $value['SubRackPosition'];
                $CustomerName = $value['CustomerName'];
                $statusUsed = $value['StatusUsed'];
                ?>
                <tr id="tr_<?php echo $i; ?>">
                    <td><button type="button" id="btn_<?php echo $i; ?>" onclick="assignRack('<?php echo $i; ?>', '<?php echo $RackID; ?>')" class="btn btn-success btn-circle"><i class="glyphicon-plus"></i></button></td>
                    <td><?php echo $RackType; ?></td>
                    <td><?php echo $Col; ?></td>
                    <td><?php echo $Row; ?></td>
                    <td><?php echo $subPosition; ?></td>
                    <td><?php echo ($CustomerName == NULL || $statusUsed == "Deactive") ? "NULL" : $CustomerName; ?></td>
                </tr>
            <?php } ?>
        <script>
            var j = <?php echo $balance; ?>;
            function assignRack(i, rackID) {
                if (j > 0) {
                    $("#btn_" + i).hide();
                    $.get("../resource/action/resource.action.assign.php?para=assignRack&SubRackID=" + rackID + "&ServiceDetailID=<?php echo $ServiceDetailID; ?>", function (data, status) {
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
    //RackUsed
    $ServiceDetailID = $_GET['ServiceDetailID'];
    $racks = getRackByServiceDetailID($ServiceDetailID);
    ?>
    <table class="table  table-bordered " id="tableUsed">
        <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Column</th>
                <th>Row</th>
                <th>Position</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($racks as $value) {
                $i++;
                if ($value['StatusUsed'] == "Deactive") {
                    continue;
                }
                $RackID = $value['RackID'];
                $RackType = $value['RackType'];
                $Col = $value['Col'];
                $Row = $value['Row'];
                $subPosition = $value['SubRackPosition'];
                $CustomerName = $value['CustomerName'];
                ?>
                <tr>
                    <td><button type="button" id="btnUse_<?php echo $i; ?>" onclick="if (confirm('Are you sure to Delete this Rack')) {
                                assignRackNull('<?php echo $i; ?>', '<?php echo $RackID; ?>');
                            }
                            ;" class="btn btn-danger btn-circle"><i class="glyphicon-minus"></i></button></td>
                    <td><?php echo $RackType; ?></td>
                    <td><?php echo $Col; ?></td>
                    <td><?php echo $Row; ?></td>
                    <td><?php echo $subPosition; ?></td>
                    <td><?php echo $CustomerName; ?></td>
                </tr>
            <?php } ?>
        <script>
            function assignRackNull(j, rackNull) {
                $("#btnUse_" + j).hide();
                $.get("../resource/action/resource.action.assign.php?para=assignRackNull&ServiceDetailID=<?php echo $ServiceDetailID; ?>&SubRackID=" + rackNull, function (data, status) {
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