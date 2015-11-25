<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$PersonID_login = $_SESSION['Account']['PersonID'];

if ($para == "getPackagesOnAddService") {
    $locationID = $_GET['locationID'];
    ?>
    <table class="table table-bordered table-striped table-hover" id="dataTables_addOrder">
        <thead>
            <tr>
                <th width="30px"> </th>
                <th>Name</th>
                <th>Category</th>
                <th>Type</th>
                <th width="100px">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $getPackages = getPackages();
            $i = 0;
            foreach ($getPackages as $value) {
                if ($value['PackageStatus'] != "Active" || $value['LocationID'] != $locationID) {
                    continue;
                }
                $packageID = $value['PackageID'];
                $packageName = $value['PackageName'];
                $packageCategory = $value['PackageCategory'];
                $packageType = $value['PackageType'];
                $i++;
                ?>
                <tr>
                    <td><input type="checkbox" onchange="chkk('<?php echo $i; ?>')" id="chkb_<?php echo $i; ?>"></td>
                    <td><?php echo $packageName; ?></td>
                    <td><?php echo $packageCategory; ?></td>
                    <td><?php echo $packageType; ?></td>
                    <td>
                        <input class="form-control" disabled id="amount_<?php echo $i; ?>" name="package[amount][]" type="number" value="1">
                        <input type="hidden" disabled id="packageID_<?php echo $i; ?>" value="<?php echo $packageID; ?>" name="package[ID][]" >
                    </td>
                </tr>
                <?php
            }
            ?>
        <script>
            function chkk(i) {
                if ($('#chkb_' + i).prop('checked')) {
                    $("#amount_" + i).prop('disabled', false);
                    $("#packageID_" + i).prop('disabled', false);
                }
                else {
                    $("#amount_" + i).prop('disabled', true);
                    $("#packageID_" + i).prop('disabled', true);
                }
            }
        </script>
    </tbody>
    </table>
    <?php
} else if ($para == "getNetworkLink") {
    $locationID = $_GET['locationID'];

    $networkLink = getNetworkLink($locationID);
    foreach ($networkLink as $value) {
        if ($value['Status'] != "Active") {
            continue;
        }
        $networkLinkID = $value['NetworkLinkID'];
        $networkLink = $value['NetworkLink'];
        ?>
        <option value="<?php echo $networkLinkID; ?>"><?php echo $networkLink; ?></option>
        <?php
    }
} else if ($para == "test") {
    $networkLink = getNetworkLink('%');
    print_r($networkLink);
}
?>