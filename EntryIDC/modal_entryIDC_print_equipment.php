<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$pa = "&modal=true";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';
$entryID = $_GET['entryID'];
$getEntryDetail = getEntryByID($entryID);
$getZonesByEntryID = getZoneByEntryID($entryID);

$locationID = $getEntryDetail['LocationID'];
$getZones = getZoneByLocationID($locationID);

//echo "<pre>";
//print_r($getEntryDetail);
//echo "</pre>";

$location = $getEntryDetail['Location'];
$customerID = ($getEntryDetail['CustomerID'] != "") ? number_pad($getEntryDetail['CustomerID'], 5) : "";
$catEmpID = $getEntryDetail['EmployeeID'];
$VisitorCardID = $getEntryDetail['VisitorCardID'];
$IDCCard = $getEntryDetail['IDCCard'];
$IDCCardType = $getEntryDetail['IDCCardType'];
$IDCard = $getEntryDetail['IDCard'];
$personType = $getEntryDetail['TypePerson'];
$organization = $getEntryDetail['Organization'];
$division = $getEntryDetail['Division'];
$personID = $getEntryDetail['PersonID'];
$personFname = $getEntryDetail['Fname'];
$pseronLname = $getEntryDetail['Lname'];
$personEmail = $getEntryDetail['Email'];
$personPhone = $getEntryDetail['Phone'];
$personCompany = ($getEntryDetail['CustomerName'] != NULL) ? $getEntryDetail['CustomerName'] : "[$organization] $division";
$purpose = $getEntryDetail['Purpose'];
$internetAccount = ($getEntryDetail['InternetAccount'] != NULL) ? json_decode($getEntryDetail['InternetAccount'], true) : NULL;
$timeIN = $getEntryDetail['TimeIn'];
$timeOUT = $getEntryDetail['TimeOut'];

$getEquipments = getEquipmentByEntryID($entryID);
?>
<!-- jQuery -->
<script src="../bower_components/jquery/dist/jQuery.print.js"></script>
<style>
    @font-face {
        font-family: 'THSarabunNewRegular';
        src: url('../font/THSarabunNew/thsarabunnew.eot');
        src: url('../font/THSarabunNew/thsarabunnew.eot') format('embedded-opentype'),
            url('../font/THSarabunNew/thsarabunnew.woff') format('woff'),
            url('../font/THSarabunNew/thsarabunnew.ttf') format('truetype'),
            url('../font/THSarabunNew/thsarabunnew.svg#THSarabunNewRegular') format('svg');
    }

    #print_out {
        font-family: THSarabunNewRegular;
        font-size: 1.5em;
        line-height: 0.75em;
    }


    .underline1 {
        width: 80%;
        padding: 0px;
        border: 1px;
        border-color: #a7b5ce;
        border-style: none none dotted none;
        margin: 0;
    }
    .ddd {
        padding: 30px 0px 0px 0px;
        border: 0px;
        border-color: #a7b5ce;
        border-style: none none dotted none;
        margin: 0;
    }
    .ddd1 {
        padding: 0px 0px 20px 0px;
        border: 0px;
        border-color: #a7b5ce;
        border-style: none none dotted none;
        margin: 0;
    }
    .ddd2 {
        padding: 0px 0px 40px 0px;
        border: 0px;
        border-color: #a7b5ce;
        border-style: none none dotted none;
        margin: 0;
    }
    .ddd3 {
        padding: 20px 0px 0px 0px;
        border: 0px;
        border-color: #a7b5ce;
        border-style: none none dotted none;
        margin: 0;
    }


    .col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:16%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:33%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:50%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:92%; float:left;}
    .col-print-12{width:100%; float:left;}
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Entry IDC</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div id="print_out">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-print-12 ddd3">
                        <div class="col-print-2 text-right">
                            <img src = "https://upload.wikimedia.org/wikipedia/th/thumb/a/ad/CATTelecom_Logo.png/200px-CATTelecom_Logo.png" height="30">
                        </div>
                        <div class="col-print-8 text-center">                                                                                  
                            <h4>
                                <b>
                                    แบบฟอร์มอุปกรณ์เข้า-ออกศูนย์บริการ Internet Data Center (<?php echo $location; ?>)
                                </b>
                            </h4>
                        </div>
                    </div>
                    <div class="col-print-12">
                        <div class="col-print-2 ">
                            .
                        </div>
                        <div class="col-print-8 text-center ddd2 ">                  
                            <h4>
                                <b>
                                    <?php echo $location; ?> Equipment Movement Form
                                </b>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 ddd">                             
                    <div class="col-lg-6">                      
                        <div class="col-print-2">  
                            <p>วันที่ (Date)</p>
                        </div>
                        <div class="col-print-10">
                            <p><?php echo date("d/m/Y"); ?></p>
                        </div><br><br>
                    </div>

                    <div class="col-lg-6">                       
                        <div class="col-print-12 text-right">  
                            <p>Entry No <?php echo $entryID; ?></p>                                                             
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">                   
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-print-9">
                                <div class="col-print-12">                       
                                    <div class="col-print-8">                                   
                                        <p>[ <?php echo $personType == "Contact" ? "/" : "_"; ?> ] ลูกค้า / Customer</p>
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $customerID; ?></p>
                                    </div>
                                </div>

                                <div class="col-print-12">                       
                                    <div class="col-print-8">                                  
                                        <p>[ <?php echo ($personType == "Staff" && $organization == "CAT") ? "/" : "_"; ?> ] พนักงาน กสท / CAT Employee</p>                               
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $catEmpID; ?></p>
                                    </div>
                                </div>

                                <div class="col-print-12">                       
                                    <div class="col-print-8">                                    
                                        <p>[ <?php echo ($personType == "Staff" && $organization == "Vender") ? "/" : "_"; ?> ] บุคคลทั่วไป / Other</p>
                                    </div>
                                </div>

                                <div class="col-print-12">                       
                                    <div class="col-print-8">
                                        หมายเลขบัตรผ่านอาคาร / Visitor Card NO.                                                               
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $VisitorCardID; ?></p>
                                    </div>
                                </div>
                                <div class="col-print-12">                       
                                    <div class="col-print-8">                           
                                        หมายเลขบัตรผ่าน IDC / IDC Card NO.                                                               
                                    </div>                                                     
                                    <div class="col-print-4">
                                        <p><?php echo $IDCCard; ?> Type: <?php echo $IDCCardType; ?></p>
                                    </div>
                                </div>
                                <div class="col-print-12">                       
                                    <div class="col-print-8">  
                                        รหัสบัตรประชาชน / ID Card NO. / Passport ID                                                              
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $IDCard; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-print-3">
                                <div class="col-lg-10 text-left">
                                    <?php
                                    $images = '../customer/images/persons/' . $personID . ".jpg";
                                    $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";
                                    ?>
                                    <img class="img-thumbnail" src="<?php echo $showImage; ?>" width="100%">
                                </div>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.row (nested) -->
                    </div> 

                    <div>
                        <div class="col-print-12">                      
                            <div class="col-print-3">  
                                <p>ชื่อ - นามสกุล(Name)</p>                                                             
                            </div>
                            <div class="col-print-5">                           
                                <p class=""><?php echo $personFname . " " . $pseronLname; ?></p>                       
                            </div>                       
                            <div class="col-print-1">  
                                <p>E-Mail </p>                                                             
                            </div>
                            <div class="col-print-3">                           
                                <p><?php echo $personEmail; ?></p>                               
                            </div>
                        </div>
                        <div class="col-print-12">                      
                            <div class="col-print-3">  
                                <p>ชื่อบริษัท (Company Name)</p>                                                             
                            </div>
                            <div class="col-print-5">                           
                                <p><?php echo $personCompany; ?></p>                                
                            </div>
                            <div class="col-print-1">  
                                <p>โทร.(tel.)</p>                                                              
                            </div>
                            <div class="col-lg-3">                           
                                <p><?php echo $personPhone; ?></p>                                
                            </div>
                        </div>
                        <div class="col-print-12">                      
                            <div class="col-print-4">  
                                <p>วัตถุประสงค์ (Purpose of Entry)</p>                                                            
                            </div>
                            <div class="col-print-8">                           
                                <p><?php echo $purpose; ?></p>                                
                            </div><br><br>
                        </div>
                    </div>
                    <div class="col-print-12 text-center ddd">                    
                        <p>
                            ลงชื่อ (Sign)......................................................... ผู้ใช้บริการ (Customer)
                        </p>
                    </div>
                    <div class="col-print-12 text-center ddd2">                    
                        <p>
                            (<?php echo $personFname . " " . $pseronLname; ?>)
                        </p>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->

            <div>
                <p><b>รายการอุปกรณ์ (Equipment)</b></p>
            </div>

            <div class="row col-lg-12">
                <table class="table table-bordered" id="dataTables2">
                    <tbody> 
                        <tr>
                            <th width="10%" class=" text-center">IN/OUT</th>
                            <th width="30%" class=" text-center">Equipment</th>
                            <th width="20%" class=" text-center">Brand/Model</th>
                            <th width="30%" class=" text-center">Serial No/Remake</th>
                            <th width="10%" class=" text-center">Rack</th>
                        </tr>
                        <?php
                        foreach ($getEquipments as $value) {
                            $valEntryID_IN = $value['EntryID_IN'];
                            $valEntryID_OUT = $value['EntryID_OUT'];
                            $valEquipment = $value['Equipment'];
                            $valBrand = $value['Brand'];
                            $valModel = $value['Model'];
                            $valSerialNo = $value['SerialNo'];
                            $valCol = $value['Col'];
                            $valRow = $value['Row'];
                            $valSubRackPosition = $value['SubRackPosition'];
                            ?>
                            <tr>
                                <td><?php echo $valEntryID_IN == $entryID ? "IN" : ($valEntryID_OUT == $entryID ? "OUT" : ""); ?></td>
                                <td><?php echo $valEquipment; ?></td>
                                <td><?php echo $valBrand . "/" . $valModel; ?></td>
                                <td><?php echo $valSerialNo; ?></td>
                                <td><?php echo $valCol . $valRow . "-" . $valSubRackPosition; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--เจ้าหน้าที่-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-print-12 text-center ddd3 ">
                        <div class="col-print-6">                                
                            <p>เวลาเข้า <?php echo $timeIN != "" ? $timeIN : "..............................."; ?> น.</p>
                        </div>
                        <div class="col-print-6">
                            <p>เวลาออก <?php echo $timeOUT != "" ? $timeOUT : "..............................."; ?> น.</p>
                        </div>
                    </div>

                    <div class="col-print-12 text-center ddd">                    
                        <p class="col-print-6">
                            ลงชื่อ (Sign)........................................................ เจ้าหน้าที่
                        </p>
                        <p class="col-print-6">
                            ลงชื่อ (Sign)......................................................... เจ้าหน้าที่ตรวจสอบ 
                        </p>
                    </div>
                    <div class="col-print-12 text-center ddd1">                    
                        <p class="col-print-6">
                            (.........................................................)
                        </p>
                        <div class="col-print-6  ddd1">  
                            <p class="col-print-8 text-right">
                                (.........................................................)&nbsp;&nbsp;&nbsp;      
                            </p>
                            <p class="col-print-4 text-left">
                                วันที่..................
                            </p>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="text-center">
    <input type="button" class="btn btn-info btn-sm" value="Print" id="printHere">
</div>-->
<div class="modal-footer">
    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
    <input type="button" class="btn btn-info" value="Print" id="printHere">
</div>
<script type="text/javascript">
    $("#printHere").click(function () {
        $("#print_out").print();
    });
</script>
