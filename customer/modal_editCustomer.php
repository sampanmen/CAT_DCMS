<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$cusID = $_GET['cusID'];

//start Customer
$getCus = getCustomer($cusID);
$cusStatus = $getCus['CustomerStatus'];
$statusLabel = $cusStatus == "Active" ? "success" : ($cusStatus == "Suppened" ? "warning" : "danger");
$cusName = $getCus['CustomerName'];
$cusBussType = $getCus['BusinessType'];
$cusBussTypeID = $getCus['BusinessTypeID'];
$cusEmail = $getCus['Email'];
$cusPhone = $getCus['Phone'];
$cusFax = $getCus['Fax'];
$cusAddress = $getCus['Address'];
$cusTownship = $getCus['Township'];
$cusCity = $getCus['City'];
$cusProvince = $getCus['Province'];
$cusZipcode = $getCus['Zipcode'];
$cusCountry = $getCus['Country'];
//end Customer
//get Business type
$getBusinessType = getBusinessType();
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
                            <input class="form-control" name="name" value="<?php echo $cusName; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>ประเภทธุรกิจ <br>Bussines Type</p>
                        </div>
                        <div class="form-group col-lg-3"> 
                            <select class="form-control" name="bussinessType">
                                <?php
                                foreach ($getBusinessType as $value) {
                                    if ($value['Status'] != "Active") {
                                        continue;
                                    }
                                    $businessType = $value['BusinessType'];
                                    $businessTypeID = $value['BusinessTypeID'];
                                    ?>
                                    <option <?php echo $cusBussTypeID == $businessTypeID ? "selected" : ""; ?> value="<?php echo $businessTypeID; ?>"><?php echo $businessType; ?></option>
                                <?php } ?>
                            </select>    
                        </div>
                        <div class="form-group col-lg-2">
                            <p>อีเมล์<br>E-Mail</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" type="email" name="email" value="<?php echo $cusEmail; ?>">      
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>โทรศัพท์ <br>Phone</p>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="phone" value="<?php echo $cusPhone; ?>">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>แฟกต์  <br>Fax</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="fax" value="<?php echo $cusFax; ?>">                                
                        </div>
                    </div>

                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>ที่อยู่ <br>Address</p>                                                               
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="address" value="<?php echo $cusAddress; ?>">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>ตำบล <br>Tambol</p>                                                             
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="township" value="<?php echo $cusTownship; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>อำเภอ <br>City</p>                          
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="city" value="<?php echo $cusCity; ?>">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>จังหวัด <br>Province</p>                     
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="province" value="<?php echo $cusProvince; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>รหัสไปรษณีย์  <br>Postalcode</p>                 
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="zipcode" value="<?php echo $cusZipcode; ?>">                                
                        </div>

                        <div class="form-group col-lg-2">
                            <p>ประเทศ  <br>Country</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="country" value="<?php echo $cusCountry; ?>">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>สถานะ <br>Status</p>
                        </div>
                        <div class="form-group col-lg-3"> 
                            <select class="form-control" name="status">
                                <option <?php echo $cusStatus == "Active" ? "selected" : ""; ?> value="Active">Active</option>
                                <option <?php echo $cusStatus == "Suppened" ? "selected" : ""; ?> value="Suppened">Suppened</option>
                                <option <?php echo $cusStatus == "Delete" ? "selected" : ""; ?> value="Delete">Delete</option>
                            </select>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>