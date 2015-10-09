<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$cusID = $_GET['cusID'];
$cus = getCustomer($cusID);
?>
<form action="../customer/action/customer.action.php?para=editCustomer&cusID=<?php echo $cusID; ?>" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Edit Customer</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">                      
                        <div class="form-group col-lg-3">
                            <p>ชื่อลูกค้า <br> Name</p>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="name" value="<?php echo $cus['CustomerName']; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>ประเภทธุรกิจ <br>Bussines Type</p>
                        </div>
                        <div class="form-group col-lg-3"> 
                            <select class="form-control" name="bussinessType">
                                <option <?php echo $cus['BusinessType'] == "กสท" ? "selected" : ""; ?> value="กสท">กสท</option>
                                <option <?php echo $cus['BusinessType'] == "นิติบุคคล" ? "selected" : ""; ?> value="นิติบุคคล">นิติบุคคล</option>
                                <option <?php echo $cus['BusinessType'] == "บุคคล" ? "selected" : ""; ?> value="บุคคล">บุคคล</option>                                 
                            </select>    
                        </div>
                        <div class="form-group col-lg-2">
                            <p>อีเมล์<br>E-Mail</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" type="email" name="email" value="<?php echo $cus['Email']; ?>">      
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>โทรศัพท์ <br>Phone</p>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="phone" value="<?php echo $cus['Phone']; ?>">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>แฟกต์  <br>Fax</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="fax" value="<?php echo $cus['Fax']; ?>">                                
                        </div>
                    </div>

                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>ที่อยู่ <br>Address</p>                                                               
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="address" value="<?php echo $cus['Address']; ?>">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>ตำบล <br>Tambol</p>                                                             
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="township" value="<?php echo $cus['Township']; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>อำเภอ <br>City</p>                          
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="city" value="<?php echo $cus['City']; ?>">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>จังหวัด <br>Province</p>                     
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="province" value="<?php echo $cus['Province']; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>รหัสไปรษณีย์  <br>Postalcode</p>                 
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="zipcode" value="<?php echo $cus['Zipcode']; ?>">                                
                        </div>

                        <div class="form-group col-lg-2">
                            <p>ประเทศ  <br>Country</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="country" value="<?php echo $cus['Country']; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>สถานะ <br>Status</p>
                        </div>
                        <div class="form-group col-lg-3"> 
                            <select class="form-control" name="status">
                                <option <?php echo $cus['CustomerStatus'] == "active" ? "selected" : ""; ?> value="active">Active</option>
                                <option <?php echo $cus['CustomerStatus'] == "suppened" ? "selected" : ""; ?> value="suppened">Suppened</option>
                                <option <?php echo $cus['CustomerStatus'] == "delete" ? "selected" : ""; ?> value="delete">Delete</option>
                            </select>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" value="">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>