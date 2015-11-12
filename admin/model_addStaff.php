<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

?>


<form action="../admin/action/admin.action.php?para=addStaff" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Staff</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ID Staff</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="IDStaff"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ชื่อพนักงาน / Staff Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="nameStaff"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>นามสกุล / Surname</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="snameStaff">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>โทรศัพท์ / Phone</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="phoneStaff">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>อีเมล์ / E-Mail</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="email" name="emailStaff">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รหัสบัตรประชาชน / ID Card</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="idcardStaff">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ตำแหน่ง / Position</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="positionStaff">
                                <?php
                                $positon = getStaffPosition();
                                foreach ($positon as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['StaffPositionID']; ?>"><?php echo $value['Position']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Divition / Position</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="divitionStaff">
                                <?php
                                $positon = getDivition();
                                foreach ($positon as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['DivisionID']; ?>">[<?php echo $value['Organization']; ?>] <?php echo $value['Division']; ?></option>
                                <?php } ?>
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
    <button type="submit" class="btn btn-primary">Add</button>
</div>
</form>