<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];
$equipmentID = $_GET['equipmentID'];
$getEntryNow = getEntryNowByCusID($cusID);
echo "<pre>";
//print_r($getEntryNow);
echo "</pre>";
?>
<form method="POST" action="../EntryIDC/action/entryIDC.action.php?para=getOutEquipment&equipmentID=<?php echo $equipmentID; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Get out Equipment</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Choose Entry </b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group">
                                <select class="form-control" name="entryID">
                                    <option value="">Choose</option>
                                    <?php
                                    foreach ($getEntryNow as $value) {
                                        $valFname = $value['Fname'];
                                        $valLname = $value['Lname'];
                                        $valEntryID = $value['EntryID'];
                                        $valTimeIN = $value['TimeIn'];
                                        $valIfOUT = $value['TimeOut'] == NULL ? "In IDC" : "Out IDC";
                                        ?>
                                        <option value="<?php echo $valEntryID; ?>"><?php echo $valTimeIN . " - " . $valFname . " " . $valLname . " (" . $valIfOUT . ")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info">Get Out</button>
    </div>
</form>