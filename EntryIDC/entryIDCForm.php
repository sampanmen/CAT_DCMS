<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$getPersonID = isset($_GET['personID']) ? $_GET['personID'] : "-1";
$getPersonType = isset($_GET['type']) ? $_GET['type'] : "";
$getPosition = isset($_GET['position']) ? $_GET['position'] : "";
$getCusID = isset($_GET['cusID']) ? $_GET['cusID'] : "";
$isPerson = isset($_GET['isPerson']) ? $_GET['isPerson'] : "0";

if ($getPersonType == "Contact") {
    $getPerson = getContactByPersonID($getPersonID);
} else if ($getPersonType == "Staff") {
    $getPerson = getStaff($getPersonID);
} else {
    $getPerson = getPerson($getPersonID);
}

// set $valCustomerName
if (isset($getPerson['CustomerName'])) {
    $valCustomerName = $getPerson['CustomerName'];
} else if (isset($getPerson['Organization'])) {
    $valCustomerName = "[" . $getPerson['Organization'] . "] " . $getPerson['Division'];
} else {
    $valCustomerName = "";
}

$valCustomerID = ($getCusID != "") ? number_pad($getCusID, 5) : "";
$valPersonID = isset($getPerson['PersonID']) ? $getPerson['PersonID'] : "";
$valCatEmpID = isset($getPerson['EmployeeID']) ? $getPerson['EmployeeID'] : "";
$valIDCCard = isset($getPerson['IDCCard']) ? $getPerson['IDCCard'] : "";
$valIDCCardType = isset($getPerson['IDCCardType']) ? $getPerson['IDCCardType'] : "";
$valIDCard = isset($getPerson['IDCard']) ? $getPerson['IDCard'] : "";
$valFname = isset($getPerson['Fname']) ? $getPerson['Fname'] : "";
$valLname = isset($getPerson['Lname']) ? $getPerson['Lname'] : "";
$valEmail = isset($getPerson['Email']) ? $getPerson['Email'] : "";
$valPhone = isset($getPerson['Phone']) ? $getPerson['Phone'] : "";

$para = isset($_GET['para']) ? $_GET['para'] : "";

//$getCusRack = getRackByCusID($getPerson['CustomerID']);
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
?>
<p><a href="?">Home</a> > <a href="?p=entryIDCShow">Show Entry IDC</a> > <b>Entry IDC</b></p>
<div class="row">

    <form method="POST" action="../EntryIDC/action/entryIDC.action.php?para=addEntryIDC&personType=<?php echo $getPersonType; ?>&isPerson=<?php echo $isPerson; ?>">
        <div class="col-lg-12">
            <?php
            if ($para == "addEntryError") {
                ?>
                <div class="alert alert-danger" role="alert">
                    <b>Error:</b> Can't add Entry IDC, please try again.
                </div>
            <?php } ?>
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
                                        <input <?php echo $getPersonType == 'Contact' ? "checked" : ""; ?> <?php echo $isPerson == '1' ? "disabled" : ""; ?> type="radio" name="type">
                                        ลูกค้า / Customer <br>
                                    </label>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input class="form-control" name="cusID" value="<?php echo $valCustomerID; ?>" <?php echo!($getPersonType == 'Contact') ? "disabled" : ""; ?>>
                                    <input type="hidden" name="personID" value="<?php echo $valPersonID; ?>">
                                </div>
                            </div>
                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">
                                    <label class="radio-inline">
                                        <input <?php echo ($getPersonType == 'Staff' && $valCatEmpID != "") ? "checked" : ""; ?> <?php echo $isPerson == '1' ? "disabled" : ""; ?> type="radio" name="type">
                                        พนักงาน กสท / CAT Employee <br>
                                    </label>
                                </div>
                                <div class="form-group col-lg-6">                               
                                    <input class="form-control" name="EmpID" value="<?php echo $valCatEmpID; ?>" <?php echo!($getPersonType == 'Staff' && $valCatEmpID != "") ? "disabled" : ""; ?>>                                
                                </div>
                            </div>

                            <div class="col-lg-12">                       
                                <div class="form-group col-lg-6">                       
                                    <label class="radio-inline">                                    
                                        <input <?php echo ($getPersonType == 'Visitor' || ($getPersonType == 'Staff' && $valCatEmpID == "")) ? "checked" : ""; ?> <?php echo $isPerson == '1' ? "disabled" : ""; ?> type="radio" name="type">บุคคลทั่วไป / Other 
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
                                <input class="form-control" readonly name="cusName" value="<?php echo $valCustomerName; ?>">                                
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
                                                    <option selected value="-1,n/a">n/a</option>
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
                                    <div class="form-group col-lg-3">
                                        <label for="location">Location</label>
                                        <select class="form-control" id="location" name="locationID" onchange="getZones();">
                                            <option selected value="0">Choose Location</option>
                                            <?php
                                            $getLocations = getLocation();
//                                            print_r($getLocations);
                                            foreach ($getLocations as $value) {
                                                $valLocationID = $value['LocationID'];
                                                $valLocation = $value['Location'];
                                                ?>
                                                <option value="<?php echo $valLocationID; ?>"><?php echo $valLocation; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            function getZones() {
                                                var locatID = $("#location").val();
                                                $.get("../entryIDC/action/entryIDC.content.php?para=getZone&locationID=" + locatID, function (data, status) {
                                                    $("#zones").html(data);
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <p><b>Internet</b></p>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="chk" id="chkInternetAccount" onchange="chkInternet();">Internet Account               
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Username:</label>
                                        <input disabled type="text" class="form-control" name="internet[user]" id="internet_user">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Password:</label>
                                        <input disabled type="text" class="form-control" name="internet[pass]" id="internet_pass">
                                    </div>
                                    <script>
                                        function chkInternet() {
                                            var chkInternet = $("#chkInternetAccount").prop("checked");
                                            if (chkInternet) {
                                                $("#internet_user").prop("disabled", false);
                                                $("#internet_pass").prop("disabled", false);
                                            }
                                            else {
                                                $("#internet_user").prop("disabled", true);
                                                $("#internet_pass").prop("disabled", true);
                                            }
                                        }
                                    </script>
                                </div>
                                <!--Zone-->
                                <div class="col-lg-12">
                                    <div class="form-group col-lg-12" id="zones">
                                        <!--Get Zones-->
                                    </div>
                                </div><!--End Zone-->

                                <!--Date Time-->
                                <div class='col-lg-12'>
                                    <div class="form-group col-lg-3">
                                        <label for="datetimepicker1">เวลาเข้า</label>
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="datetimeIN">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker1').datetimepicker({
                                            format: "YYYY/MM/DD HH:mm:ss"
                                        });
                                    });
                                </script><!--End Date Time-->
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
