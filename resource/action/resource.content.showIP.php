<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$PersonID_login = "-1";
?>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Network</th>
            <th>Vlan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $getLocationID = $_GET['LocationID'];
        $getNetworks = getNetworksByLocationID($getLocationID);
        foreach ($getNetworks as $value) {
            $valNetworkID = $value['NetworkID'];
            $valNetwork = $value['NetworkIP'];
            $valSubnet = $value['Subnet'];
            $valVlan = $value['Vlan'];
            $valStatus = $value['Status'];
            ?>
            <tr>
                <td><a href="?p=viewIP&NetworkID=<?php echo $valNetworkID; ?>&LocationID=<?php echo $getLocationID; ?>" class="text-<?php echo $valStatus == "Active" ? "success" : "danger"; ?>"><?php echo $valNetwork; ?> / <?php echo $valSubnet; ?></a></td>
                <td><?php echo $valVlan; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>