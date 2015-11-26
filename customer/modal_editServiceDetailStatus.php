<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("admin", "frontdesk");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$orderDetailID = $_GET['orderDetailID'];
$cusID = $_GET['cusID'];
//$OrderDetailPackage = getOrderDetailPackageByID($orderDetailID);
//print_r($OrderDetailPackage);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Order Package Detail</h4>
</div>
<form action="../customer/action/customer.action.php?para=changeStatusOrderDetail&orderDetailID=<?php echo $orderDetailID; ?>&cusID=<?php echo $cusID; ?>&orderID=<?php echo $OrderDetailPackage['OrderID']; ?>" method="POST">
    <div class="modal-body">
        <div class="container-fluid">
            <div class="col-lg-12">  
                <div class="col-lg-5">
                    <p><b>Order ID:</b></p>      
                </div>
                <div class="col-lg-7">                               
                    <?php echo sprintf("%05d", $OrderDetailPackage['OrderID']); ?>
                </div>
            </div>
            <div class="col-lg-12">  
                <div class="col-lg-5">
                    <p><b>Package:</b></p>      
                </div>
                <div class="col-lg-7">                               
                    <?php echo $OrderDetailPackage['PackageName']; ?>
                </div>
            </div>
            <div class="col-lg-12">  
                <div class="col-lg-5">
                    <p><b>Type:</b></p>      
                </div>
                <div class="col-lg-7">                               
                    <?php echo $OrderDetailPackage['PackageType']; ?>
                </div>
            </div>
            <div class="col-lg-12">  
                <div class="col-lg-5">
                    <p><b>Category:</b></p>      
                </div>
                <div class="col-lg-7">                               
                    <?php echo $OrderDetailPackage['PackageCategory']; ?>
                </div>
            </div>
            <div class="col-lg-12">  
                <div class="col-lg-5">
                    <p><b>Date Update:</b></p>      
                </div>
                <div class="col-lg-7">                               
                    <?php echo $OrderDetailPackage['DateTime']; ?>
                </div>
            </div>
            <div class="col-lg-12">  
                <div class="col-lg-5">
                    <p><b>Status</b></p>      
                </div>
                <div class="col-lg-7">                               
                    <select name="status">
                        <option <?php echo $OrderDetailPackage['OrderDetailStatus'] == "active" ? "selected" : ""; ?> value="active">Active</option>
                        <option <?php echo $OrderDetailPackage['OrderDetailStatus'] == "suppened" ? "selected" : ""; ?> value="suppened">Suppened</option>
                        <option <?php echo $OrderDetailPackage['OrderDetailStatus'] == "delete" ? "selected" : ""; ?> value="delete">Delete</option>
                    </select> 

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>