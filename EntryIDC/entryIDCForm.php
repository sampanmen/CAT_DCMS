<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$getPersonID = isset($_GET['personID']) ? $_GET['personID'] : "-1";
$getPersonType = isset($_GET['type']) ? $_GET['type'] : "";
$getPosition = isset($_GET['position']) ? $_GET['position'] : "";
$getCusID = isset($_GET['cusID']) ? $_GET['cusID'] : "";
$isPerson = isset($_GET['isPerson']) ? $_GET['isPerson'] : "1";

if ($getPersonType == "Contact") {
    $getPerson = getContactByPersonID($getPersonID);
} else if ($getPersonType == "Staff") {
    $getPerson = getStaff($getPersonID);
} else {
    $getPerson = getPerson($getPersonID);
}

//echo "<pre>";
//print_r($getPerson);
//echo "</pre>";

$valCustomerID = ($getCusID != "") ? number_pad($getCusID, 5) : "";
$valCustomerName = isset($getPerson['CustomerName']) ? $getPerson['CustomerName'] : "";
$valPersonID = isset($getPerson['PersonID']) ? $getPerson['PersonID'] : "";
$valCatEmpID = isset($getPerson['EmployeeID']) ? $getPerson['EmployeeID'] : "";
$valIDCCard = isset($getPerson['IDCCard']) ? $getPerson['IDCCard'] : "";
$valIDCCardType = isset($getPerson['IDCCardType']) ? $getPerson['IDCCardType'] : "";
$valIDCard = isset($getPerson['IDCard']) ? $getPerson['IDCard'] : "";
$valFname = isset($getPerson['Fname']) ? $getPerson['Fname'] : "";
$valLname = isset($getPerson['Lname']) ? $getPerson['Lname'] : "";
$valEmail = isset($getPerson['Email']) ? $getPerson['Email'] : "";
$valPhone = isset($getPerson['Phone']) ? $getPerson['Phone'] : "";

//$getCusRack = getRackByCusID($getPerson['CustomerID']);
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
?>
<p><a href="?">Home</a> > <a href="?p=entryIDCShow">Show Entry IDC</a> > <b>Entry IDC</b></p>
<div class="row">
    <form method="POST" action="../EntryIDC/action/entryIDC.action.php?para=addEntryIDC">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>ข้อมูลเพิ่มเติม </b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="col-lg-12">
                                <div class="form-group col-lg-6">
                                    <label class="radio-inline">                                    
                                        <input <?php echo $getPersonType == 'Contact' ? "checked" : ""; ?> type="radio" name="type">
                                        ลูกค้า / Customer <br>
                                    </label>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input class="form-control" name="cusID" value="<?php echo $valCustomerID; ?>">
                                    <input type="hidden" name="conID" value="<?php echo $valPersonID; ?>">
                                </div>
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">
                                    <label class="radio-inline">
                                        <input <?php echo $getPersonType == 'Staff' ? "checked" : ""; ?> type="radio" name="type">
                                        พนักงาน กสท / CAT Employee <br>
                                    </label>
                                </div>
                                <div class="form-group col-lg-6">                               
                                    <input class="form-control" name="EmpID" value="<?php echo $valCatEmpID; ?>">                                
                                </div>
                            </div>

                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">                       
                                    <label class="radio-inline">                                    
                                        <input <?php echo $getPersonType == 'Visitor' ? "checked" : ""; ?> type="radio" name="type">บุคคลทั่วไป / Other 
                                        <br>                
                                    </label>                                    
                                </div>
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6"><br>
                                    หมายเลขบัตรผ่านอาคาร / Visitor Card NO.                                                               
                                </div>
                                <div class="form-group col-lg-6"><br>                               
                                    <input class="form-control" name="visitCard">                                
                                </div>
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">                           
                                    หมายเลขบัตรผ่าน IDC / IDC Card NO.                                                               
                                </div>                                                     
                                <div class="form-group col-lg-3">                            
                                    <input class="form-control" name="IDCCard" value="<?php echo $valIDCCard; ?>">
                                </div>
                                <div class="form-group col-lg-1">  
                                    Type
                                </div>
                                <div class="form-group col-lg-2">                            
                                    <input class="form-control" name="IDCCardType" value="<?php echo $valIDCCardType; ?>">
                                </div>                           
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">  
                                    รหัสบัตรประชาชน / ID Card NO. / Passport ID                                                              
                                </div>
                                <div class="form-group col-lg-6">                           
                                    <input class="form-control" name="IDCard" value="<?php echo $valIDCard; ?>">                                
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="col-lg-12 text-center">
                                <?php
                                $images = '../customer/images/persons/' . $valPersonID . ".jpg";
                                $showImage = file_exists($images) ? $images : "../customer/images/persons/noPic.jpg";
                                ?>
                                <img class="img-thumbnail" src="<?php echo $showImage; ?>" width="100%">

                            </div>
                        </div>

                        <div class="col-lg-12"><br><br>                       
                            <div class="form-group col-lg-1">  
                                ชื่อ/Name                                                              
                            </div>
                            <div class="form-group col-lg-2">                           
                                <input class="form-control" name="conName" value="<?php echo $valFname; ?>">                                
                            </div>
                            <div class="form-group col-lg-2">  
                                นามสกุล/Lastname                                                              
                            </div>
                            <div class="form-group col-lg-2">                           
                                <input class="form-control" name="conLname" value="<?php echo $valLname; ?>">                                
                            </div>
                            <div class="form-group col-lg-1">  
                                E-Mail                                                              
                            </div>
                            <div class="form-group col-lg-4">                           
                                <input class="form-control" name="conEmail" value="<?php echo $valEmail; ?>">                                
                            </div>
                        </div>
                        <div class="col-lg-12">                      
                            <div class="form-group col-lg-1">  
                                ชื่อบริษัท                                                             
                            </div>
                            <div class="form-group col-lg-6">                           
                                <input class="form-control" name="cusName" value="<?php echo $valCustomerName; ?>">                                
                            </div>
                            <div class="form-group col-lg-1">  
                                โทร./Tel.                                                              
                            </div>
                            <div class="form-group col-lg-4">                           
                                <input class="form-control" name="conPhone" value="<?php echo $valPhone; ?>">                                
                            </div>
                        </div>
                        <div class="col-lg-12">                      
                            <div class="form-group col-lg-1">  
                                วัตถุประสงค์                                                            
                            </div>
                            <div class="form-group col-lg-11">                           
                                <input class="form-control" name="purpose">
                                <br><br>                                
                            </div>
                        </div>
                    </div>
                </div>

                <!--อุปกรณ์-->
                <div class="panel-body" id="btn_showItem">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-info" onclick="$('#item').show();
                                    $('#btn_showItem').hide();">Add items</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="item">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>รายการอุปกรณ์ (Equipment List) </b>
                        </div>
                        <div class="panel-body">
                            <div class="row col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>ชื้ออุปกรณ์ (Equipment)</th>
                                            <th>ยี่ห้อ(Brand)</th>
                                            <th>รุ่น (Model)</th>
                                            <th>Serial No/Remake</th>
                                            <th>Rack</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbItem">
                                        <!--show item-->
                                    </tbody>
                                    <tfoot>
                                        <tr>       
                                            <td>
                                                <button type="button" class="btn btn-info btn-circle" onclick="addItem();"><i class="glyphicon-plus"></i></button>
                                            </td>                                    
                                            <td>
                                                <input class="form-control" id="item_name">
                                            </td>
                                            <td>
                                                <input class="form-control" id="item_brand">
                                            </td>
                                            <td>
                                                <input class="form-control" id="item_model">
                                            </td>
                                            <td>
                                                <input class="form-control" id="item_serialNo">
                                            </td>
                                            <td>
                                                <select class="form-control" id="item_rack">
                                                    <?php
                                                    foreach ($getCusRack as $value) {
                                                        $rackPosition = $value['Zone'] . $value['Position'] . "-" . $value['SubPosition'];
                                                        ?>
                                                        <option value="<?php echo $value['ResourceRackID'] . "," . $rackPosition; ?>"><?php echo $rackPosition; ?></option>
                                                    <?php } ?>
                                                </select> 
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <script>
                                        $('#item').hide();
                                        var itemNo = 0;
                                        function addItem() {
                                            itemNo++;
                                            var item_name = $("#item_name").val();
                                            var item_brand = $("#item_brand").val();
                                            var item_model = $("#item_model").val();
                                            var item_serialNo = $("#item_serialNo").val();
                                            var item_rack = $("#item_rack").val();
                                            var item_rack_arr = item_rack.split(',');

                                            var ItemHTML = '<tr id="trItem_' + itemNo + '">' +
                                                    '<td><button type="button" class="btn btn-danger btn-circle" onclick="removeItem(\'trItem_' + itemNo + '\')"><i class="glyphicon-minus"></i></button></td>' +
                                                    '<td>' + item_name + '<input type="hidden" name="item_name[]" value="' + item_name + '"></td>' +
                                                    '<td>' + item_brand + '<input type="hidden" name="item_brand[]" value="' + item_brand + '"></td>' +
                                                    '<td>' + item_model + '<input type="hidden" name="item_model[]" value="' + item_model + '"></td>' +
                                                    '<td>' + item_serialNo + '<input type="hidden" name="item_serialno[]" value="' + item_serialNo + '"></td>' +
                                                    '<td>' + item_rack_arr[1] + '<input type="hidden" name="item_rackID[]" value="' + item_rack_arr[0] + '"></td>' +
                                                    '</tr>';
                                            $("#tbItem").append(ItemHTML);

                                            $("#item_name").val('');
                                            $("#item_brand").val('');
                                            $("#item_model").val('');
                                            $("#item_serialNo").val('');
                                            $("#item_rack").val('');
                                        }

                                        function removeItem(id) {
                                            $("#" + id).html("");
                                        }
                                    </script>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--เจ้าหน้าที่-->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>สำหรับเจ้าหน้าที่ </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline">
                                            <input type="checkbox">Internet Account               
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Username:</label>
                                        <input type="text" class="form-control" name="internet_user">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Password:</label>
                                        <input type="text" class="form-control" name="internet_pass">
                                    </div>
                                </div>
                                <!--IDC-->
                                <div class="col-lg-12"><br>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Customer Room" name="area[]">Customer Room               
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="IDC1" name="area[]">IDC1               
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="IDC2" name="area[]">IDC2               
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="NOC" name="area[]">NOC
                                        </label>
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Power" name="area[]">Power
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Meeting" name="area[]">Meeting
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Manager" name="area[]">Manager
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Core Network" name="area[]">Core Network
                                        </label>                                
                                    </div>
                                </div>
                                <!--VIP-->
                                <div class="col-lg-12">                       
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP1" name="area[]">VIP1
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP2" name="area[]">VIP2
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP3" name="area[]">VIP3
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP4" name="area[]">VIP4
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP5" name="area[]">VIP5
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP6" name="area[]">VIP6
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="VIP7" name="area[]">VIP7
                                        </label>                                
                                    </div>
                                </div>
                                <div class="col-lg-12">                       
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Office" name="area[]">Office
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox" value="Temp Office" name="area[]">Temp Office
                                        </label>                                
                                    </div>  
                                </div>
                                <div class="col-lg-5">
                                    <label>เวลาเข้า</label>
                                    <div class="input-group">
                                        <input type='text' class="form-control" id='datetimein' name="datetime">
                                        <span class="input-group-addon" onclick="javascript:NewCssCal('datetimein', 'yyyyMMdd', 'dropdown', true, '24', true);" style="cursor:pointer">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="text-center">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <br><br>
                </div>
                <!-- /.panel -->
            </div> 
        </div>
    </form>
</div>