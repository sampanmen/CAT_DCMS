<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$cusID = $_GET['cusID'];

$getContact = getContactByCustomer($cusID);
$getServiceDetailCountCategory = getServiceDetailCountByCategory($cusID);

//get service detail summary
$getServiceDetailSummary = getServiceDetailSummary($cusID);
$summaryTotal = $getServiceDetailSummary['total'];
$summaryMain = $getServiceDetailSummary['sumMain'];
$summaryAddon = $getServiceDetailSummary['sumAddOn'];
$summaryActive = $getServiceDetailSummary['sumActive'];
$summarySuppened = $getServiceDetailSummary['sumSuppened'];
$summaryDeactive = $getServiceDetailSummary['sumDeactive'];

//start Customer
$getCus = getCustomer($cusID);
$cusID = $getCus['CustomerID'];
$cusStatus = $getCus['CustomerStatus'];
$statusLabel = $cusStatus == "Active" ? "success" : ($cusStatus == "Suppened" ? "warning" : "danger");
$cusName = $getCus['CustomerName'];
$cusBissType = $getCus['BusinessType'];
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

$getServices = getServiceByCustomerID($cusID);
$getServiceDetail = getServiceDetailByCustomerID($cusID);
?>

<p><a href="?">Home</a> > <a href="?p=cusHome">Customers</a> > <b>Customer Detail</b></p>
<!--Customer Detail-->
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Customer Detail</b>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">                            
                        <h1><b><?php echo sprintf("%05d", $cusID); ?></b></h1>
                    </div>
                    <div class="col-lg-12">
                        <label>Status</label>
                        <p class="label label-<?php echo $statusLabel; ?>"><?php echo $cusStatus; ?></p>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>

        <!--Company Detail-->  
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>ข้อมูลบริษัท / Company Detail</b>
                <a href="../customer/modal_editCustomer.php?cusID=<?php echo $cusID; ?>" data-toggle="modal" data-target="#myModal-lg"> (Edit)</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">                       
                        <div class="form-group col-lg-4">
                            <label>Name</label>      
                        </div>
                        <div class="form-group  col-lg-8">                               
                            <?php echo $cusName; ?>
                        </div>
                    </div>
                    <div class="col-lg-12">                       
                        <div class="form-group col-lg-4">
                            <label>Business Type</label>
                        </div>
                        <div class="form-group col-lg-8">                               
                            <?php echo $cusBissType; ?>
                        </div>
                    </div>
                    <div class="col-lg-12">                       
                        <div class="form-group col-lg-4">
                            <label>E-Mail</label>
                        </div>
                        <div class="form-group col-lg-8">                               
                            <?php echo $cusEmail; ?>
                        </div>
                    </div>
                    <div class="col-lg-12">                       
                        <div class="form-group col-lg-4">
                            <label>Phone</label>
                        </div>
                        <div class="form-group col-lg-8">                               
                            <?php echo $cusPhone; ?>
                        </div>
                    </div>
                    <div class="col-lg-12">                       
                        <div class="form-group col-lg-4">
                            <label>Fax.</label>
                        </div>
                        <div class="form-group col-lg-8">                               
                            <?php echo $cusFax; ?>
                        </div>
                    </div>
                    <div class="col-lg-12">                       
                        <div class="form-group col-lg-4">
                            <label>Address</label>
                        </div>
                        <div class="form-group col-lg-8">                               
                            <?php echo $cusAddress . " <br>ตำบล/Tambol: " . $cusTownship . " อำเภอ/City: " . $cusCity . " <br>จังหวัด/Province: " . $cusProvince . " รหัสไปรษณีย์/Postalcode: " . $cusZipcode . " <br>ประเทศ/Country: " . $cusCountry; ?>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>ข้อมูลผู้ติดต่อ / Contact Detail</b>
                <a href="../customer/modal_addContact.php?cusID=<?php echo $getCus['CustomerID']; ?>" data-toggle="modal" data-target="#myModal">  (Add)  </a>
            </div>
            <div class="panel-body">
                <div class="row">                       
                    <div class="col-lg-12">
                        <?php
                        foreach ($getContact as $value) {
                            $conFname = $value['Fname'];
                            $conLname = $value['Lname'];
                            $conEmail = $value['Email'];
                            $conPhone = $value['Phone'];
                            $conIDCard = $value['IDCard'];
                            $conTypeContact = $value['ContactType'];
                            $conTypePerson = $value['TypePerson'];
                            $conPersonID = $value['PersonID'];
                            $conCusID = $value['CustomerID'];
                            $personStatus = $value['PersonStatus'];
                            ?>
                            <div class=" well well-sm col-lg-12 ">
                                <div class="col-lg-4 text-left">
                                    <?php
//                                    $images = '../customer/images/persons/' . $value['PersonID'] . ".jpg";
//                                    $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";

                                    $images = '../customer/images/persons/' . $value['PersonID'] . ".jpg";
                                    $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";
                                    $showImage = "../system/image_1-1.php?url=" . $showImage;
//                        echo $showImage;
                                    ?>
                                    <img class="img-thumbnail img-circle" src = "<?php echo $showImage; ?>" width="100%" height="" border="1">
                                </div>
                                <div class="col-lg-8 text-left">                      
                                    <p><b>Name:</b> <?php echo $conFname . " " . $conLname; ?></p>
                                    <p><b>Email:</b> <?php echo $conEmail; ?></p>
                                    <p><b>Phone:</b> <?php echo $conPhone; ?></p>
                                    <p><b>ID Card:</b> <?php echo $conIDCard; ?></p>
                                    <p><b>Type:</b> <?php echo $conTypeContact; ?></p>
                                    <p class="label label-<?php echo $personStatus == "Active" ? "success" : ($personStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $personStatus; ?></p>
                                    <div class="text-right">
                                        <a href="../customer/modal_editContact.php?personID=<?php echo $value['PersonID']; ?>&cusID=<?php echo $getCus['CustomerID']; ?>" data-toggle="modal" data-target="#myModal">Edit</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
        </div>
    </div>

    <!--Service Panel-->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Service </b>
                <a href="../customer/modal_addService.php?cusID=<?php echo $cusID; ?>" data-toggle="modal" data-target="#myModal-lg">(Add</a>,
                <a href="../customer/modal_viewServiceDetailChange.php?cusID=<?php echo $cusID; ?>" data-toggle="modal" data-target="#myModal-lg">Change</a>,
                <a href="../customer/modal_viewServiceDetailLog.php?cusID=<?php echo $cusID; ?>" data-toggle="modal" data-target="#myModal-lg">History)</a>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#summary" data-toggle="tab" aria-expanded="true">Summary</a>
                    </li>
                    <li class=""><a href="#main" data-toggle="tab" aria-expanded="false">Main Package</a>
                    </li>
                    <li class=""><a href="#addon" data-toggle="tab" aria-expanded="false">Add on Package</a>
                    </li>
                    <li class=""><a href="#category" data-toggle="tab" aria-expanded="false">Category</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="summary">
                        <!--<h4>Summary</h4>-->
                        <br>

                        <div class="col-lg-6">
                            <div class="col-lg-8"><b>Total service</b></div>
                            <div class="col-lg-4"><p style="font-size:1.3em" class="label label-info"><?php echo $summaryTotal; ?></p></div><br><br>

                            <div class="col-lg-8"><b>Main / Add on</b></div>
                            <div class="col-lg-4"><p style="font-size:1em" class="label label-default"><?php echo $summaryMain . " / " . $summaryAddon; ?></p></div>
                        </div>

                        <div class="col-lg-6">
                            <div class="col-lg-12"><b>Active </b><p class="label label-success"><?php echo $summaryActive; ?></p></div>
                            <div class="col-lg-12"><b>Suppened </b><p class="label label-warning"><?php echo $summarySuppened; ?></p></div>
                            <div class="col-lg-12"><b>Deactive </b><p class="label label-danger"><?php echo $summaryDeactive; ?></p></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="main">
                        <!--<h4>Main</h4>--><br>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>DateTime</th>
                                    <th>Package</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getServiceDetail as $value) {
                                    if ($value['PackageType'] != "Main" || $value['Status'] == "Deactive") {
                                        continue;
                                    }
                                    $valTime = $value['DateTimeAction'];
                                    $valPackageID = $value['PackageID'];
                                    $valPackage = $value['PackageName'];
                                    $valCategory = $value['PackageCategory'];
                                    $valStatus = $value['Status'];
                                    ?>
                                    <tr>
                                        <td><?php echo $valTime; ?></td>
                                        <td><?php echo $valPackage; ?></td>
                                        <td><?php echo $valCategory; ?></td>
                                        <td><label class="label label-<?php echo $valStatus == "Active" ? "success" : ($valStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $valStatus; ?></label></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="addon">
                        <!--<h4>Add on</h4>--><br>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>DateTime</th>
                                    <th>Package</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($getServiceDetail as $value) {
                                    if ($value['PackageType'] != "Add-on" || $value['Status'] == "Deactive") {
                                        continue;
                                    }
                                    $valTime = $value['DateTimeAction'];
                                    $valPackageID = $value['PackageID'];
                                    $valPackage = $value['PackageName'];
                                    $valCategory = $value['PackageCategory'];
                                    $valStatus = $value['Status'];
                                    ?>
                                    <tr>
                                        <td><?php echo $valTime; ?></td>
                                        <td><?php echo $valPackage; ?></td>
                                        <td><?php echo $valCategory; ?></td>
                                        <td><label class="label label-<?php echo $valStatus == "Active" ? "success" : ($valStatus == "Suppened" ? "warning" : "danger"); ?>"><?php echo $valStatus; ?></label></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="category">
                        <!--<h4>Category</h4>--><br>
                        <div class="list-group">
                            <?php
                            foreach ($getServiceDetailCountCategory as $value) {
                                $varCategory = $value['PackageCategory'];
                                $varCategoryID = $value['PackageCategoryID'];
                                $varCountCategoryActive = $value['sumActive'];
                                $varCountCategorySuppened = $value['sumSuppened'];
                                $varCountCategoryDeactive = $value['sumDeactive'];
                                ?>
                                <a href="../customer/modal_viewServiceDetailLog.php?cusID=<?php echo $cusID; ?>&categoryID=<?php echo $varCategoryID; ?>" class="list-group-item" data-toggle="modal" data-target="#myModal-lg">
                                    <?php echo $varCategory; ?>
                                    <span class="badge alert-danger"><?php echo $varCountCategoryDeactive; ?></span>
                                    <span class="badge alert-warning"><?php echo $varCountCategorySuppened; ?></span>
                                    <span class="badge alert-success"><?php echo $varCountCategoryActive; ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Resource</b> <a href="?p=serviceDetail&CustomerID=<?php echo $cusID; ?>">(Show All)</a>
            </div>                
            <div class="panel-body">

            </div><!-- /.panel-body -->
        </div><!-- Contact Detail -->
    </div>

    <!-------IP-->
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>IP</b>
            </div>                
            <div class="panel-body">
                <table class="table ">
                    <tbody>
                        <tr>
                            <td>158.168.1.0</td>
                            <td><a href="../resource/modal_IPUsed.php"  data-toggle="modal" data-target="#myModal">10</a></td>
                        </tr>                                                     
                        <tr>
                            <td>158.168.2.0</td>
                            <td><a href="../resource/modal_IPUsed.php" data-toggle="modal" data-target="#myModal">10</a></td>
                        </tr>          
                        <tr>
                            <td>158.168.3.0</td>
                            <td><a href="../resource/modal_IPUsed.php" data-toggle="modal" data-target="#myModal">2</a></td>
                        </tr>          
                        <tr>
                            <td>158.168.4.0</td>
                            <td><a href="../resource/modal_IPUsed.php" data-toggle="modal" data-target="#myModal">3</a></td>
                        </tr>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- Contact Detail -->
    </div>

    <!-------Rack-->
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Rack</b>
            </div>                
            <div class="panel-body">                   
                <table class="table ">
                    <tbody>
                        <tr>
                            <td>Full Rack</td>
                            <td><a href="../resource/modal_RackUsed.php"  data-toggle="modal" data-target="#myModal">2</a></td>
                        </tr>                                                     
                        <tr>
                            <td>1/2 Rack</td>
                            <td><a href="../resource/modal_RackUsed.php" data-toggle="modal" data-target="#myModal">2</a></td>
                        </tr>          
                        <tr>
                            <td>1/4 Rack</td>
                            <td><a href="../resource/modal_RackUsed.php" data-toggle="modal" data-target="#myModal">1</a></td>
                        </tr>          
                        <tr>
                            <td>Shared Rack</td>
                            <td><a href="../resource/modal_RackUsed.php" data-toggle="modal" data-target="#myModal">3</a></td>
                        </tr>          
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- Contact Detail -->
    </div> 

    <!------Port-->
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Port</b>
            </div>                
            <div class="panel-body">                   
                <table class="table ">
                    <tbody>
                        <tr>
                            <td>Switch 1</td>
                            <td><a href="../resource/modal_PortUsed.php"  data-toggle="modal" data-target="#myModal">7</a></td>
                        </tr>                                                     
                        <tr>
                            <td>Switch 2</td>
                            <td><a href="../resource/modal_PortUsed.php" data-toggle="modal" data-target="#myModal">4</a></td>
                        </tr>          
                        <tr>
                            <td>Switch 3</td>
                            <td><a href="../resource/modal_PortUsed.php" data-toggle="modal" data-target="#myModal">5</a></td>
                        </tr>          
                        <tr>
                            <td>Switch 5</td>
                            <td><a href="../resource/modal_PortUsed.php" data-toggle="modal" data-target="#myModal">2</a></td>
                        </tr>          
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- Contact Detail -->
    </div>
</div>