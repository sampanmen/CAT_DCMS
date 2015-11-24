<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../account/function/account.func.inc.php';
require_once dirname(__FILE__) . '/../system/function.inc.php';

$Username = $_SESSION['Account']['Username'];
$getAccounts = checkLogin($Username);
$PersonID = $getAccounts['PersonID'];
$Fname = $getAccounts['Fname'];
$Lname = $getAccounts['Lname'];
$Position = $getAccounts['Position'];
$Email = $getAccounts['Email'];
$Phone = $getAccounts['Phone'];
$EmployeeID = $getAccounts['EmployeeID'];
$TypePerson = $getAccounts['TypePerson'];
$Position = $getAccounts['Position'];
$Division = $getAccounts['Division'];
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Profile</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-7">
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Username: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $Username; ?></p> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Name: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo "$Fname  $Lname"; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Email: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $Email; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Phone: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $Phone; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>CAT ID: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $EmployeeID; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Position: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $Position; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Division: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $Division; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-4">                                           
                            <label>Type: </label>
                        </div>
                        <div class="col-lg-8"> 
                            <p><?php echo $TypePerson; ?></p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-5">
                    <?php
                    $images = '../customer/images/persons/' . $PersonID . ".jpg";
                    $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";
                    $showImage = "../system/image_1-1.php?url=" . $showImage;
                    ?>
                    <img class="img-thumbnail img-circle" src = "<?php echo $showImage; ?>" width="100%" height="" border="1">
                </div>
            </div>
        </div>
        <!-- /.row (nested) -->
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>