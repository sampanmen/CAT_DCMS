<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../account/function/account.func.inc.php';
require_once dirname(__FILE__) . '/../system/function.inc.php';

$Username = isset($_GET['Username']) ? $_GET['Username'] : $_SESSION['Account']['Username'];
$chkAdmin = isset($_GET['chkAdmin']) ? $_GET['chkAdmin'] : "";
?>
<form action="../account/action/account.action.php?para=changePassword&chkAdmin=<?php echo $chkAdmin; ?>" method="POST">
    <input type="hidden" value="" id="url" name="url">
    <script>
        $("#url").val(document.URL);
    </script>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Change Password</h4>
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
                            <input class="form-control" type="text" readonly name="username" id="username" value="<?php echo $Username; ?>"> 
                        </div>
                    </div>
                    <?php
                    if ($chkAdmin != "true") {
                        ?>
                        <div class="col-lg-12">  
                            <div class="col-lg-4">                                           
                                <label>Current Password</label>
                            </div>
                            <div class="form-group col-lg-8"> 
                                <input class="form-control" type="password" name="currentPassword" id="currentPassword"> 
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>New Password</label>
                        </div>
                        <div class="form-group col-lg-8"> 
                            <input class="form-control" type="password" name="newPassword" id="newPassword" onchange="checkPassword();"> 
                        </div>
                    </div>

                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Confirm New Password</label>
                        </div>
                        <div class="form-group col-lg-8"> 
                            <input class="form-control" type="password" id="confirmNewPassword" onchange="checkPassword();"> 
                        </div>
                    </div>

                    <script>
                        function checkPassword() {
                            var newPass = $("#newPassword").val();
                            var confirmPass = $("#confirmNewPassword").val();
                            if (newPass == confirmPass) {
                                $("#btn_submit").prop("disabled", false);
                            }
                            else {
                                $("#btn_submit").prop("disabled", true);
                            }
                        }
                    </script>
                </div>
            </div>
            <!-- /.row (nested) -->
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" id="btn_submit" disabled>Save</button>
</div>
</form>