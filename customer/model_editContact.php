<form action="../customer/action/customer.action.php?para=editContact&personID=<?php echo $_GET['personID'];?>&cusID=<?php echo $_GET['cusID'];?>" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Contact</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <?php 
                    require_once dirname(__FILE__) . '/../system/function.inc.php';
                    $getPerson = getPerson($_GET['personID']);
                    ?>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ชื่อผู้ติดต่อ / Contact Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="name" value="<?php echo $getPerson['Fname']; ?>"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>นามสกุล / Surname</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="sname" value="<?php echo $getPerson['Lname']; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>โทรศัพท์ / Phone</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="phone" value="<?php echo $getPerson['Phone']; ?>">                               
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>อีเมล์ / E-Mail</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="email" name="email" value="<?php echo $getPerson['Email']; ?>">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รหัสผ่าน / Password</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="password" name="password" value="<?php echo $getPerson['Password']; ?>">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ประเภท / Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option <?php echo $getPerson['TypePerson']=="contact"?"selected":""; ?> value="contact">contact</option>
                                <option <?php echo $getPerson['TypePerson']=="subcontact"?"selected":""; ?> value="subcontact">subcontact</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>สถานะ / Status</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="status">
                                <option <?php echo $getPerson['PersonStatus']=="active"?"selected":""; ?> value="active">active</option>
                                <option <?php echo $getPerson['PersonStatus']=="not active"?"selected":""; ?> value="not active">not active</option>
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