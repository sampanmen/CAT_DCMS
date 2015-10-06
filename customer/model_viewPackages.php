<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$getPackage = getPackage($_GET['packageID']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel"><b>Packages</b></h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="form-group col-lg-6">
                        <label>ชื่อบริการ / Service Name</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['PackageName']; ?></p>
                    </div>   
                    <div class="form-group col-lg-6">
                        <label>รายละเอียด / Detail</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['PackageDetail']; ?></p>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>ประเภทบริการ / Type Service</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['PackageType']; ?></p>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>หมวดหมู่ / Category</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['PackageCategory']; ?></p>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน IP Addres</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['IPAmount']; ?> IP</p>    
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Port</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['PortAmount']; ?> Port</p>    
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Rack</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $getPackage['RackAmount']; ?> Rack</p>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>สถานะ</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p class="label label-<?php echo $getPackage['PackageStatus']=="active"?"success":"danger"; ?>"><?php echo $getPackage['PackageStatus']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>