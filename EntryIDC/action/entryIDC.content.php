<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$PersonID_login = $_SESSION['Account']['PersonID'];


if ($para == "getCustomer") {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Customers List</b>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTablesModalEntryIDC">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getCus = getCustomers();
                        foreach ($getCus as $value) {
                            ?>
                            <tr>
                                <td><?php printf("%05d", $value['CustomerID']); ?></td>
                                <td><?php echo $value['CustomerName']; ?></td>
                                <td><?php echo $value['BusinessType']; ?></td>
                                <td><a class="btn btn-info btn-sm" onclick="getContact('<?php echo $value['CustomerID']; ?>');" href="#person">Select</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} else if ($para == "getDivision") {
    $getOrgani = $_GET['organi'];
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>CAT Divisions List</b>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTablesModalEntryIDC">
                    <thead>
                        <tr>
                            <th>Division</th>
                            <th>Type</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getDivision = getDivision();
                        foreach ($getDivision as $value) {
                            $valDivisionID = $value['DivisionID'];
                            $valDivision = $value['Division'];
                            $valOrgani = $value['Organization'];
                            if ($valOrgani != $getOrgani) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td><?php echo $valDivision; ?></td>
                                <td><?php echo $valOrgani; ?></td>
                                <td><a class="btn btn-info btn-sm" onclick="getStaff('<?php echo $valDivisionID; ?>');" href="#person">Select</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} else if ($para == "getContact") {
    $cusID = $_GET['cusID'];
    $getContacts = getContactByCustomer($cusID);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Contact </b>
            <!--<a href="?p=entryIDCForm&type=Contact&cusID=<?php // echo $cusID; ?>&isPerson=0">(Other)</a>-->
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php
            foreach ($getContacts as $value) {
                if ($value['PersonStatus'] != "Active") {
                    continue;
                }
                ?>
                <div class="col-lg-4">
                    <a href="?p=entryIDCForm&personID=<?php echo $value['PersonID']; ?>&cusID=<?php echo $cusID; ?>&type=Contact&isPerson=1">
                        <?php
                        $images = '../customer/images/persons/' . $value['PersonID'] . ".jpg";
                        $showImage = file_exists('../' . $images) ? $images : "../customer/images/persons/noPic.jpg";
                        $showImage = "../system/image_1-1.php?url=" . $showImage;
//                        echo $showImage;
                        ?>
                        <img class="img-thumbnail img-circle" width="100%" src="<?php echo $showImage; ?>">
                    </a>
                    <h4><?php echo $value['Fname'] . " " . $value['Lname']; ?></h4>
                    <p>Email: <?php echo $value['Email']; ?></p>
                    <p>Phone: <?php echo $value['Phone']; ?></p>
                    <p>IDC Card: <?php echo $value['IDCCard']; ?> Type: <?php echo $value['IDCCardType']; ?></p>
                    <p>ID Card: <?php echo $value['IDCard']; ?></p>
                    <p>Type: <?php echo $value['TypePerson']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
} else if ($para == "getStaff") {
    $getDivisionID = $_GET['division'];
    $getPerson = getStaffByDivision($getDivisionID);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>CAT Employee </b>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php
            foreach ($getPerson as $value) {
                $valFname = $value['Fname'];
                $valLname = $value['Lname'];
                $valEmail = $value['Email'];
                $valPhone = $value['Phone'];
                $valIDCard = $value['IDCard'];
                $valEmpID = isset($value['EmployeeID']) ? $value['EmployeeID'] : "n/a";
                $valType = $value['TypePerson'];
                $valPosition = isset($value['Position']) ? $value['Position'] : "";
                ?>
                <div class="col-lg-4">
                    <a href="?p=entryIDCForm&personID=<?php echo $value['PersonID']; ?>&type=Staff&isPerson=1">
                        <?php
                        $images = '../customer/images/persons/' . $value['PersonID'] . '.jpg';
                        $showImage = file_exists('../' . $images) ? $images : "../customer/images/persons/noPic.jpg";
                        $showImage = "../system/image_1-1.php?url=" . $showImage;
                        ?>
                        <img class="img-thumbnail img-circle" width="100%" src="<?php echo $showImage; ?>">
                    </a>

                    <h4><?php echo $valFname . " " . $valLname; ?></h4>
                    <p>Email: <?php echo $valEmail; ?></p>
                    <p>Phone: <?php echo $valPhone; ?></p>
                    <p>CAT ID: <?php echo $valEmpID; ?></p>
                    <p>ID Card: <?php echo $valIDCard; ?></p>
                    <p>Type: <?php echo $valType; ?></p>
                    <?php if ($valPosition != "") { ?>
                        <p>Position: <?php echo $valPosition; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
} else if ($para == "getZone") {
    $locationID = $_GET['locationID'];
    $getZones = getZoneByLocationID($locationID);
    echo '<p><b>Zone</b></p>';
    echo $getZones==NULL?"<p>N/A</p>":"";
    foreach ($getZones as $value) {
        $valZoneID = $value['EntryZoneID'];
        $valZone = $value['EntryZone'];
        $valStatus = $value['Status'];
        if ($valStatus != "Active") {
            continue;
        }
        ?>
        <div class="form-group col-lg-2">
            <label class="checkbox-inline">                                    
                <input type="checkbox" value="<?php echo $valZoneID; ?>" name="area[]"><?php echo $valZone; ?>
            </label>                                
        </div>
        <?php
    }
}
?>