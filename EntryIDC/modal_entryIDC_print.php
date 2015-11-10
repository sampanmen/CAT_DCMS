<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
$entryID = $_GET['entryID'];
$getEntryDetail = getEntryByID($entryID);
$getZones = getEntryZone($entryID);
$internetAccount = json_decode($getEntryDetail['InternetAccount'], true);
//echo "<pre>";
//print_r($getZones);
//echo "</pre>";
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
                            <img src = "../EntryIDC/action/images/200px-CATTelecom_Logo.png" height="30">
                        </div>
                        <div class="col-print-8 text-center">                                                                                  
                            <h4>
                                <b>
                                    แบบฟอร์มการเข้าใช้ศูนย์บริการ Internet Data Center ศูนย์โทรคมนาคม นนทบุรี
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
                                    CAT-IDC Nonthaburi Entry Form</b>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 ddd">                             
                    <div class="col-lg-12">                       
                        <div class="col-print-12 text-right">  
                            <p>Order No...................</p>                                                             
                        </div>
                    </div>

                    <div class="col-lg-12">                      
                        <div class="col-print-2">  
                            <p>วันที่ (Date)</p>
                        </div>
                        <div class="col-print-10">
                            <p><?php echo date("d/m/Y"); ?></p>
                        </div><br><br>
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
                                        <p>[ <?php echo $getEntryDetail['CustomerID'] != "" ? "/" : "_"; ?> ] ลูกค้า / Customer</p>
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php printf("%05d", $getEntryDetail['CustomerID']); ?></p>
                                    </div>
                                </div>

                                <div class="col-print-12">                       
                                    <div class="col-print-8">                                  
                                        <p>[ <?php echo $getEntryDetail['EmpID'] != "" ? "/" : "_"; ?> ] พนักงาน กสท / CAT Employee</p>                               
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $getEntryDetail['EmpID']; ?></p>
                                    </div>
                                </div>

                                <div class="col-print-12">                       
                                    <div class="col-print-8">                                    
                                        <p>[ _ ] บุคคลทั่วไป / Other</p>
                                    </div>
                                </div>

                                <div class="col-print-12">                       
                                    <div class="col-print-8">
                                        หมายเลขบัตรผ่านอาคาร / Visitor Card NO.                                                               
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $getEntryDetail['VisitorCardID']; ?></p>
                                    </div>
                                </div>
                                <div class="col-print-12">                       
                                    <div class="col-print-8">                           
                                        หมายเลขบัตรผ่าน IDC / IDC Card NO.                                                               
                                    </div>                                                     
                                    <div class="col-print-4">
                                        <p><?php echo $getEntryDetail['IDCCard']; ?> Type: <?php echo $getEntryDetail['IDCCardType']; ?></p>
                                    </div>
                                </div>
                                <div class="col-print-12">                       
                                    <div class="col-print-8">  
                                        รหัสบัตรประชาชน / ID Card NO. / Passport ID                                                              
                                    </div>
                                    <div class="col-print-4">
                                        <p><?php echo $getEntryDetail['IDCard']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-print-3">
                                <div class="col-lg-6 text-left">
                                    <img src="../customer/images/persons/<?php echo $getEntryDetail['PersonID']; ?>.jpg" width="" height="130" border="1">
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
                                <p class=""><?php echo $getEntryDetail['Fname'] . " " . $getEntryDetail['Lname']; ?></p>                       
                            </div>                       
                            <div class="col-print-1">  
                                <p>E-Mail </p>                                                             
                            </div>
                            <div class="col-print-3">                           
                                <p><?php echo $getEntryDetail['Email']; ?></p>                               
                            </div>
                        </div>
                        <div class="col-print-12">                      
                            <div class="col-print-3">  
                                <p>ชื่อบริษัท (Company Name)</p>                                                             
                            </div>
                            <div class="col-print-5">                           
                                <p><?php echo $getEntryDetail['CustomerName']; ?></p>                                
                            </div>
                            <div class="col-print-1">  
                                <p>โทร.(tel.)</p>                                                              
                            </div>
                            <div class="col-lg-3">                           
                                <p><?php echo $getEntryDetail['Phone']; ?></p>                                
                            </div>
                        </div>
                        <div class="col-print-12">                      
                            <div class="col-print-4">  
                                <p>วัตถุประสงค์ (Purpose of Entry)</p>                                                            
                            </div>
                            <div class="col-print-8">                           
                                <p><?php echo $getEntryDetail['Purpose']; ?></p>                                
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
                            (<?php echo $getEntryDetail['Fname'] . " " . $getEntryDetail['Lname']; ?>)
                        </p>
                    </div>
                    <div class="col-print-12 text-center ddd ddd1 ">                    
                        <p><b>
                                สำหรับเจ้าหน้าที่ (For Staff Only)</b>
                        </p>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->

            <!--เจ้าหน้าที่-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div>
                                <p>พื้นที่เข้าใช้บริการ<br><br>
                                    <span style="margin-left:2em">ส่วน ศศ.(IDC ศูนย์โทรคมนาคม นนทบุรี)</span><br><br>
                                </p>
                            </div>
                            <div class="col-print-10">
                                <p>[ <?php echo $internetAccount['user'] != "" ? "/" : "_"; ?> ] Internet Account  <?php if ($internetAccount['user'] != "") { ?>( Username: <?php echo $internetAccount['user']; ?> Password: <?php echo $internetAccount['pass'].")"; ?> <?php } ?></p>    
                            </div>
                            <!--IDC-->
                            <div class="col-print-12">
                                <?php
                                foreach ($getZones as $value) {
                                    ?>
                                    <div class="col-print-2">                               
                                        <p>[ / ] <?php echo $value['Zone']; ?></p>                             
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <div class="col-print-12 text-center ddd3 ">
                        <div class="col-print-6">                                
                            <p>เวลาเข้า <?php echo $getEntryDetail['TimeIn'] != "" ? $getEntryDetail['TimeIn'] : "..............................."; ?> น.</p>
                        </div>
                        <div class="col-print-6">
                            <p>เวลาออก <?php echo $getEntryDetail['TimeOut'] != "" ? $getEntryDetail['TimeOut'] : "..............................."; ?> น.</p>
                        </div>
                    </div>


                    <div class="col-print-12 text-center ddd">                    
                        <p>
                            ลงชื่อ (Sign)......................................................... เจ้าหน้าที่
                        </p>
                    </div>
                    <div class="col-print-12 text-center ddd1">                    
                        <p>
                            (.........................................................)
                        </p>
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
