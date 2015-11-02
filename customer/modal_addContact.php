<form action="../customer/action/customer.action.php?para=addContact&cusID=<?php echo $_GET['cusID'];?>" method="POST" enctype="multipart/form-data">
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
                            <input class="form-control" name="name"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>นามสกุล / Surname</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="sname">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>โทรศัพท์ / Phone</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="phone">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>อีเมล์ / E-Mail</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="email" name="email">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>รหัสบัตรประชาชน / ID Card</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="text" name="idcard">                                   
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>ประเภท / Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option selected value="Main">Main</option>
                                <option value="Secondary">Secondary</option>
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