<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk", "helpdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$getPersonID = $_GET['personID'];
$getCusID = $_GET['cusID'];

//get Contact
$getContact = getContactByPersonID($getPersonID);
$conFname = $getContact['Fname'];
$conLname = $getContact['Lname'];
$conPhone = $getContact['Phone'];
$conEmail = $getContact['Email'];
$conIDCard = $getContact['IDCard'];
$conContactType = $getContact['ContactType'];
$conStatus = $getContact['PersonStatus'];
?>
<form action="../customer/action/customer.action.php?para=editContact&personID=<?php echo $getPersonID; ?>&cusID=<?php echo $getCusID; ?>" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Contact</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ชื่อผู้ติดต่อ / Contact Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="name" value="<?php echo $conFname; ?>"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>นามสกุล / Surname</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="sname" value="<?php echo $conLname; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>โทรศัพท์ / Phone</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="phone" value="<?php echo $conPhone; ?>">                               
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>อีเมล์ / E-Mail</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="email" name="email" value="<?php echo $conEmail; ?>">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รหัสบัตรประชาชน / ID Card</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="idcard" value="<?php echo $conIDCard; ?>">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ประเภท / Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option <?php echo $conContactType == "Main" ? "selected" : ""; ?> value="Main">Main</option>
                                <option <?php echo $conContactType == "Secondary" ? "selected" : ""; ?> value="Secondary">Secondary</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>สถานะ / Status</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="status">
                                <option <?php echo $conStatus == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $conStatus == "Suppened" ? "selected" : ""; ?> value="Suppened">Suppened</option>
                                <option <?php echo $conStatus == "Deactive" ? "selected" : ""; ?> value="Deactive">Deactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รูปภาพ / Picture</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="file" name="file"  accept=".jpg">                                    
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
    <button type="submit" class="btn btn-primary">Save</button>
</div>
</form>