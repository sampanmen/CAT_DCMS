<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$PersonID_login = $_SESSION['Account']['PersonID'];

?>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Type Rack</th>
            <th>Position</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $getLocationID = $_GET['LocationID'];
        $getRackType = $_GET['Type'];
        $getRacksPosition = getRackPositionByLocationIDandType($getLocationID, $getRackType);
        foreach ($getRacksPosition as $value) {
            $valCol = $value['Col'];
            $valRow = $value['Row'];
            $valRackType = $value['PackageCategory'];
            $valRackPositionID = $value['RackPositionID'];
            $valStatus = $value['Status'];
            ?>
            <tr>
                <td><?php echo $valRackType; ?></td>
                <td><a href="?p=viewRack&Type=<?php echo $getRackType; ?>&LocationID=<?php echo $getLocationID; ?>&RackPositionID=<?php echo $valRackPositionID; ?>" class="text-<?php echo $valStatus == "Active" ? "success" : "danger"; ?>"><?php echo $valCol . $valRow; ?></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>