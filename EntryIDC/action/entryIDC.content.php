<?php

require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para == "getContact") {
    $cusID = $_GET['cusID'];
    $getContacts = getContactByCustomer($cusID);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Contact </b>
            <a href="?p=entryIDCForm&type=Contact&cusID=<?php echo $cusID; ?>&isPerson=0">(Other)</a>
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
} else if ($para == "getPerson") {
    $getType = $_GET['type'];
    $position = isset($_GET['position']) ? $_GET['position'] : "";
    if ($getType == "Staff") {
        $getPerson = getStaffByPosition($position);
    } else if ($getType == "Visitor") {
        $getPerson = getPersonByType($getType);
    }
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b><?php echo $getType; ?> </b>
            <a href="?p=entryIDCForm&type=<?php echo $getType; ?>&position=<?php echo $position; ?>&isPerson=0">(Other)</a>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php
            foreach ($getPerson as $value) {
                ?>
                <div class="col-lg-4">
                    <a href="?p=entryIDCForm&personID=<?php echo $value['PersonID']; ?>&type=<?php echo $getType; ?>&isPerson=1">
                        <?php
                        $images = '../customer/images/persons/' . $value['PersonID'] . '.jpg';
                        $showImage = file_exists('../' . $images) ? $images : "../customer/images/persons/noPic.jpg";
                        $showImage = "../system/image_1-1.php?url=" . $showImage;
                        ?>
                        <img class="img-thumbnail img-circle" width="100%" src="<?php echo $showImage; ?>">
                    </a>

                    <h4><?php echo $value['Fname'] . " " . $value['Lname']; ?></h4>
                    <p>Email: <?php echo $value['Email']; ?></p>
                    <p>Phone: <?php echo $value['Phone']; ?></p>
                    <p>ID Card: <?php echo $value['IDCard']; ?></p>
                    <p>Type: <?php echo $value['TypePerson']; ?></p>
                    <?php if (isset($value['Position'])) { ?>
                        <p>Position: <?php echo $value['Position']; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>