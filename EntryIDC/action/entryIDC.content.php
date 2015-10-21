<?php
require_once dirname(__FILE__) . '/../../system/function.inc.php';

$para = isset($_GET['para']) ? $_GET['para'] : "";
$personID = "-1";

if ($para = "getContact") {
    $cusID = $_GET['cusID'];
    $getContacts = getContactByCustomer($cusID);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Contact
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php
            foreach ($getContacts as $value) {
                ?>
                <div class="col-lg-4">
                    <a href="?p=entryIDCForm&contactID=<?php echo $value['PersonID']; ?>">
                        <img class="img-thumbnail" width="100%" src="../customer/images/persons/<?php echo $value['PersonID']; ?>.jpg">
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
}
?>