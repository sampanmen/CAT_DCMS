<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$packageID = $_GET['packageID'];

$getPackage = getPackage($packageID);
$packageName = $getPackage['PackageName'];
$packageDetail = $getPackage['PackageDetail'];
$packageType = $getPackage['PackageType'];
$packageCategory = $getPackage['PackageCategory'];
$location = $getPackage['Location'];
$packageStatus = $getPackage['PackageStatus'];

$getResourceAmount = getResourceAmount($packageID);
$ipAmount = $getResourceAmount['IPAmount'];
$serviceAmount = $getResourceAmount['ServiceAmount'];
$rackAmount = $getResourceAmount['RackAmount'];
$portAmount = $getResourceAmount['PortAmount'];
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
                        <p><?php echo $packageName; ?></p>
                    </div>   
                    <div class="form-group col-lg-6">
                        <label>รายละเอียด / Detail</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $packageDetail; ?></p>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>ประเภทบริการ / Type Service</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $packageType; ?></p>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>หมวดหมู่ / Category</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $packageCategory; ?></p>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน IP Addres</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $ipAmount; ?> IP</p>    
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Port</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $portAmount; ?> Port</p>    
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Rack</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $rackAmount; ?> Rack</p>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Service</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $serviceAmount; ?> Service</p>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Location</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p><?php echo $location; ?></p>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Status</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <p class="label label-<?php echo $packageStatus == "Active" ? "success" : "danger"; ?>"><?php echo $packageStatus; ?></p>
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