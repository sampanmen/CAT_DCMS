<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$packageCategory = getPackageCategory();
$location = getLocation();
?>
<form action="../customer/action/customer.action.php?para=addPackage" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Packages</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="form-group">
                                <label>ชื่อบริการ / Service Name</label>
                                <input class="form-control" name="name">                                
                            </div>   
                            <div class="form-group">
                                <label>รายละเอียด / Detail</label>
                                <textarea class="form-control" rows="3" name="detail"></textarea>                              
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>ประเภทบริการ / Type Service</label>
                            <select class="form-control" name="type">
                                <option value="Main">Main</option>
                                <option value="Add-on">Add-on</option>
                            </select>  
                        </div>
                        <div class="form-group col-lg-6">
                            <label>หมวดหมู่ / Category</label>
                            <select class="form-control" name="category">
                                <?php
                                foreach ($packageCategory as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['PackageCategoryID']; ?>"><?php echo $value['PackageCategory']; ?></option>
                                <?php } ?>
                            </select>   
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน IP Addres</label> 
                            <input class="form-control" type="number" name="amount[ip]" value="0">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Port</label> 
                            <input class="form-control" type="number" name="amount[port]" value="0">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Rack</label>
                            <input class="form-control" type="number" name="amount[rack]" value="0">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>จำนวน Service</label> 
                            <input class="form-control" type="number" name="amount[service]" value="0">    
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Location</label>
                            <select class="form-control" name="location">                                  
                                <?php
                                foreach ($location as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['LocationID']; ?>"><?php echo $value['Location']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Status</label>
                            <select class="form-control" name="status">                                  
                                <option selected value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
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