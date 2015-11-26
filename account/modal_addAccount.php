<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../account/function/account.func.inc.php';
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>
<form action="../account/action/account.action.php?para=addAccount" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Account</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Username</label>
                        </div>
                        <div class="form-group col-lg-8"> 
                            <input class="form-control" type="text" name="Username" required> 
                        </div>
                    </div>

                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Password</label>
                        </div>
                        <div class="form-group col-lg-8"> 
                            <input class="form-control" type="password" name="Password" id="password1" required onchange="checkPassword();"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Confirm Password</label>
                        </div>
                        <div class="form-group col-lg-8"> 
                            <input class="form-control" type="password" id="password2" required onchange="checkPassword();"> 
                        </div>
                    </div>
                    <script>
                        function checkPassword() {
                            var newPass = $("#password1").val();
                            var confirmPass = $("#password2").val();
                            if (newPass == confirmPass) {
                                $("#btn_submit").prop("disabled", false);
                            }
                            else {
                                $("#btn_submit").prop("disabled", true);
                            }
                        }
                    </script>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Owner</label>
                        </div>
                        <div class="form-group col-lg-8">
                            <select class="form-control" name="PersonID" required>
                                <option>Choose</option>
                                <?php
                                $getStaffCAT = getStaffCAT();
                                foreach ($getStaffCAT as $value) {
                                    $PersonID = $value['PersonID'];
                                    $Fname = $value['Fname'];
                                    $Lname = $value['Lname'];
                                    $Position = $value['Position'];
                                    ?>
                                    <option value="<?php echo $PersonID; ?>"><?php echo "($Position) $Fname $Lname"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (nested) -->
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" id="btn_submit" disabled>Add</button>
</div>
</form>