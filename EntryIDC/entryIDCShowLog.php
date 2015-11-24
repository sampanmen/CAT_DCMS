<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$getEntryNow = getEntryLog();
?>
<p><a href="?">Home</a> > <b>Entry IDC Log</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Entry IDC Log</b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                if ($getEntryNow != NULL) {
                    ?>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Organization</th>
                                    <th>Person</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>DateTime In</th>
                                    <th>DateTime Out</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getEntryNow as $value) {
                                    $valEntryID = $value['EntryID'];
                                    if ($value['CustomerName'] != NULL) {
                                        $valOrganization = $value['CustomerName'];
                                    } else {
                                        $valOrganization = "[" . $value['Organization'] . "] " . $value['Division'];
                                    }
                                    $valPersonName = $value['Fname'] . " " . $value['Lname'];
                                    $valPersonType = $value['TypePerson'];
                                    $valLocation = $value['Location'];
                                    $valDateTimeIN = $value['TimeIn'];
                                    $valDateTimeOUT = ($value['TimeOut'] == NULL) ? "n/a" : $value['TimeOut'];
                                    ?>
                                    <tr id="tr_showEntry_<?php echo $valEntryID; ?>">
                                        <td><?php echo $valOrganization; ?></td>
                                        <td><?php echo $valPersonName; ?></td>
                                        <td><?php echo $valPersonType; ?></td>
                                        <td><?php echo $valLocation; ?></td>
                                        <td><?php echo $valDateTimeIN; ?></td>
                                        <td><?php echo $valDateTimeOUT; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="?p=entryBeforePrint&entryID=<?php echo $valEntryID; ?>"><i class="glyphicon glyphicon-print"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    echo "<h3>No Entry Now!</h3>";
                }
                ?>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
