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
            <th>Switch name</th>
            <!--<th>IP</th>-->
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $LocationID = $_GET['LocationID'];
        $getSwitch = getSwitchByLocationID($LocationID);
        foreach ($getSwitch as $value) {
            $valSwitchID = $value['SwitchID'];
            $valSwicthName = $value['SwitchName'];
            $valSwitchIP = $value['SwitchIP'];
            $valSwitchType = $value['SwitchType'];
            $valStatus = $value['Status'];
            ?>
            <tr>
                <td><?php echo "<a href='?p=viewPort&LocationID=$LocationID&SwitchID=$valSwitchID' class='text-" . ($valStatus == "Active" ? "success" : "danger") . "' >$valSwicthName</a>"; ?></td>
                <!--<td><?php // echo $valSwitchIP;     ?></td>-->
                <td><?php echo $valSwitchType; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>