<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$getPackage = getPackage($_GET['packageID']);
?>
<form action="../customer/action/customer.action.php?para=editPackage&packageID=<?php echo $_GET['packageID']; ?>" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Edit Packages</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="form-group">
                                <label>ชื่อบริการ / Service Name</label>
                                <input class="form-control" name="name" value="<?php echo $getPackage['PackageName']; ?>">                                
                            </div>   
                            <div class="form-group">
                                <label>รายละเอียด / Detail</label>
                                <textarea class="form-control" rows="3" name="detail"><?php echo $getPackage['PackageDetail']; ?></textarea>                              
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>ประเภทบริการ / Type Service</label>
                            <select class="form-control" name="type">
                                <option value="main">Main Services</option>
                                <option value="add-on">Add-On Services</option>
                            </select>  
                        </div>
                        <div class="form-group col-lg-6">
                            <label>หมวดหมู่ / Category</label> 
                            <select class="form-control" name="category">                                  
                                <option <?php echo $getPackage['PackageCategory'] == "full rack" ? "selected" : ""; ?> value="full rack">Full Rack</option>
                                <option <?php echo $getPackage['PackageCategory'] == "1/2 rack" ? "selected" : ""; ?> value="1/2 rack">1/2 Rack</option>
                                <option <?php echo $getPackage['PackageCategory'] == "1/4 rack" ? "selected" : ""; ?> value="1/4 rack">1/4 Rack</option>
                                <option <?php echo $getPackage['PackageCategory'] == "shared rack" ? "selected" : ""; ?> value="shared rack">Shared Rack</option>
                                <option <?php echo $getPackage['PackageCategory'] == "firewall" ? "selected" : ""; ?> value="firewall">Firewall</option>
                                <option <?php echo $getPackage['PackageCategory'] == "room" ? "selected" : ""; ?> value="room">Room</option>
                                <option <?php echo $getPackage['PackageCategory'] == "add-on" ? "selected" : ""; ?> value="add-on">Add on</option>
                            </select>   
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน IP Addres</label> 
                            <input class="form-control" name="ip" value="<?php echo $getPackage['IPAmount']; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Port</label> 
                            <input class="form-control" name="port" value="<?php echo $getPackage['PortAmount']; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Rack</label> 
                            <input class="form-control" name="rack" value="<?php echo $getPackage['RackAmount']; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Service</label> 
                            <input class="form-control" name="service" value="<?php echo $getPackage['ServiceAmount']; ?>">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>สถานะ</label>
                            <select class="form-control" name="status">                                  
                                <option <?php echo $getPackage['PackageStatus'] == "active" ? "selected" : ""; ?> value="active">Active</option>
                                <option <?php echo $getPackage['PackageStatus'] == "not active" ? "selected" : ""; ?> value="not active">Not Active</option>
                            </select>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div> 
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>