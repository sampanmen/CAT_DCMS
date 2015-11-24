<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/config.inc.php';
require_once dirname(__FILE__) . '/function/account.func.inc.php';
?>
<p><a href="?">Home</a> > <b>Show Account</b></p>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Account</b> <a href="../account/modal_addAccount.php" data-toggle="modal" data-target="#myModal">(Add)</a>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Employee ID</th>
                                <th>Division</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getAccounts = getAccount();
                            foreach ($getAccounts as $value) {
                                $PersonID = $value['PersonID'];
                                $Username = $value['Username'];
                                $Fname = $value['Fname'];
                                $Lname = $value['Lname'];
                                $Position = $value['Position'];
                                $EmpID = $value['EmployeeID'];
                                $Division = $value['Division'];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $Username; ?></td>
                                    <td><?php echo $Fname . " " . $Lname; ?></td>
                                    <td><?php echo $Position; ?></td>
                                    <td><?php echo $EmpID; ?></td>
                                    <td><?php echo $Division; ?></td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="../account/modal_changePassword.php?Username=<?php echo $Username; ?>&chkAdmin=true" data-toggle="modal" data-target="#myModal">Change Password</a>
                                        <a onclick="return confirm('You are sure Delete this Account.');" class="btn btn-warning btn-sm" href="../account/action/account.action.php?para=deleteAccount&Username=<?php echo $Username; ?>">Delete</a>
                                    </td>
                                </tr>  
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>