<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$contactID = isset($_GET['contactID']) ? $_GET['contactID'] : "-1";

$getContact = getContactByPersonID($contactID);
$getCusRack = getRackByCusID($getContact['cusID']);
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
?>
<p><a href="?">Home</a> > <b>Entry IDC</b></p>
<div class="row">
    <form method="POST" action="../EntryIDC/action/entryIDC.action.php?para=addEntryIDC">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b>ข้อมูลกรณีไม่ใช่ผู้ติดต่อ</b></p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="col-lg-12">
                                <div class="form-group col-lg-6">
                                    <label class="radio-inline">                                    
                                        <!--<input type="radio" name="type">-->
                                        ลูกค้า / Customer <br>
                                    </label>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input class="form-control" name="cusID" value="<?php printf("%05d", $getContact['cusID']); ?>">
                                    <input type="hidden" name="conID" value="<?php echo $getContact['PersonID']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">
                                    <label class="radio-inline">
                                        <!--<input type="radio" name="type">-->
                                        พนักงาน กสท / CAT Employee <br>
                                    </label>
                                </div>
                                <div class="form-group col-lg-6">                               
                                    <input class="form-control" name="EmpID" value="<?php echo $getContact['CatEmpID']; ?>">                                
                                </div>
                            </div>

                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">                       
                                    <label class="radio-inline">                                    
                                        <!--<input type="radio" name="type">บุคคลทั่วไป / Other--> 
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
                                    <input class="form-control" name="IDCCard" value="<?php echo $getContact['IDCCard']; ?>">
                                </div>
                                <div class="form-group col-lg-1">  
                                    Type
                                </div>
                                <div class="form-group col-lg-2">                            
                                    <input class="form-control" name="IDCCardType" value="<?php echo $getContact['IDCCardType']; ?>">
                                </div>                           
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">  
                                    รหัสบัตรประชาชน / ID Card NO. / Passport ID                                                              
                                </div>
                                <div class="form-group col-lg-6">                           
                                    <input class="form-control" name="IDCard" value="<?php echo $getContact['IDCard']; ?>">                                
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="col-lg-12 text-center">
                                <img class="img-thumbnail" src = "../customer/images/persons/<?php echo $getContact['PersonID']; ?>.jpg" width="100%">
                            </div>
                        </div>

                        <div class="col-lg-12"><br><br>                       
                            <div class="form-group col-lg-1">  
                                ชื่อ/Name                                                              
                            </div>
                            <div class="form-group col-lg-2">                           
                                <input class="form-control" name="conName" value="<?php echo $getContact['Fname']; ?>">                                
                            </div>
                            <div class="form-group col-lg-2">  
                                นามสกุล/Lastname                                                              
                            </div>
                            <div class="form-group col-lg-2">                           
                                <input class="form-control" name="conLname" value="<?php echo $getContact['Lname']; ?>">                                
                            </div>
                            <div class="form-group col-lg-1">  
                                E-Mail                                                              
                            </div>
                            <div class="form-group col-lg-4">                           
                                <input class="form-control" name="conEmail" value="<?php echo $getContact['Email']; ?>">                                
                            </div>
                        </div>
                        <div class="col-lg-12">                      
                            <div class="form-group col-lg-1">  
                                ชื่อบริษัท                                                             
                            </div>
                            <div class="form-group col-lg-6">                           
                                <input class="form-control" name="cusName" value="<?php echo $getContact['cusName']; ?>">                                
                            </div>
                            <div class="form-group col-lg-1">  
                                โทร./Tel.                                                              
                            </div>
                            <div class="form-group col-lg-4">                           
                                <input class="form-control" name="conPhone" value="<?php echo $getContact['Phone']; ?>">                                
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
                            <button type="button" class="btn btn-info" onclick="$('#item').show();$('#btn_showItem').hide();">Add items</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="item">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>รายการอุปกรณ์ (Equipment List)</label>
                        </div>
                        <div class="panel-body">
                            <div class="row col-lg-12">
                                <table class="table table-bordered" id="">
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
                            <label>สำหรับเจ้าหน้าที่ </label>
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