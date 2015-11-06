<form action="../customer/action/customer.action.php?para=addCustomer" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Customer</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12" id="ddd">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Customer
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">                      
                                            <div class="form-group col-lg-3"><br>
                                                <p>ชื่อลูกค้า<br>Customer Name</p>
                                            </div>
                                            <div class="form-group col-lg-9"><br> 
                                                <input class="form-control" name="cus[name]">
                                            </div>
                                        </div>

                                        <div class="col-lg-12"> 
                                            <div class="form-group col-lg-3">
                                                <p>ประเภทธุรกิจ<br>Bussiness Type</p>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <select class="form-control" name="cus[bussinessTypeID]" id="cusBissinessType">
                                                    <option selected value="1">กสท</option>
                                                    <option value="2">นิติบุคคล</option>
                                                    <option value="3">บุคคล</option>
                                                </select>    
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <p>อีเมล์<br>E-Mail</p>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input class="form-control" type="email" name="cus[email]">      
                                            </div>
                                        </div>

                                        <div class="col-lg-12"> 
                                            <div class="form-group col-lg-3">
                                                <p>โทรศัพท์<br>Phone</p>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input class="form-control" name="cus[phone]">                                
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <p>แฟกต์<br>Fax</p>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input class="form-control" name="cus[fax]">                                
                                            </div>
                                        </div>

                                        <div class="col-lg-12"> 
                                            <div class="form-group col-lg-3">
                                                <p>ที่อยู่<br>Address</p>                                                               
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input class="form-control" name="cus[address]">                                
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <p>ตำบล<br>Tambol</p>                                                             
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input class="form-control" name="cus[township]">                                
                                            </div>
                                        </div>

                                        <div class="col-lg-12"> 
                                            <div class="form-group col-lg-3">
                                                <p>อำเภอ<br>City</p>                          
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input class="form-control" name="cus[city]">                                
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <p>จังหวัด<br>Province</p>                     
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input class="form-control" name="cus[province]">                                
                                            </div>
                                        </div>

                                        <div class="col-lg-12"> 
                                            <div class="form-group col-lg-3">
                                                <p>รหัสไปรษณีย์<br>Postalcode</p>                 
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input class="form-control" name="cus[zipcode]">                                
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <p>ประเทศ<br>Country</p>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input class="form-control" name="cus[country]">                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    ผู้ติดต่อ / Contact 
                                    <a href="javascript:addCus();">(Add)</a>  
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">                      
                                            <div class="form-group col-lg-3"><br>
                                                <p>ชื่อผู้ติดต่อ<br>Contact Name</p>                  
                                            </div>
                                            <div class="form-group col-lg-3"><br>
                                                <input class="form-control" name="con[name][]">
                                            </div>
                                            <div class="form-group col-lg-2"><br>
                                                <p>นามสกุล<br>Surname</p>                     
                                            </div>
                                            <div class="form-group col-lg-4"><br>
                                                <input class="form-control" name="con[sname][]">                                
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group col-lg-3">
                                                <p>โทรศัพท์<br>Phone</p>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input class="form-control" name="con[phone][]">                                
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <p>อีเมล์<br>E-Mail</p>                      
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input class="form-control" type="email" name="con[email][]" onchange="checkEmail(this.value)">          
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group col-lg-3">
                                                <p>รหัสบัตรประชาชน<br>ID Card</p>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input class="form-control" type="text" name="con[IDCard][]">      
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <p>รูปภาพ<br>Picture</p>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input type="file" name="file[]" accept=".jpg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
        <br>
        <div id="alertEmail"></div>
    </div>
</form>

<div id="addCus" style="display: none;">
    <div class="panel panel-default">
        <div class="panel-heading">
            ผู้ติดต่อ / Contact 
            <a href="javascript:addCus();">(Add)</a>  
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">                      
                    <div class="form-group col-lg-3"><br>
                        <p>ชื่อผู้ติดต่อ<br>Contact Name</p>                  
                    </div>
                    <div class="form-group col-lg-3"><br>
                        <input class="form-control" name="con[name][]">
                        <input type="hidden" value="contact" name="con[type][]">
                    </div>
                    <div class="form-group col-lg-2"><br>
                        <p>นามสกุล<br>Surname</p>                     
                    </div>
                    <div class="form-group col-lg-4"><br>
                        <input class="form-control" name="con[sname][]">                                
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group col-lg-3">
                        <p>โทรศัพท์<br>Phone</p>
                    </div>
                    <div class="form-group col-lg-3">
                        <input class="form-control" name="con[phone][]">                                
                    </div>
                    <div class="form-group col-lg-2">
                        <p>อีเมล์<br>E-Mail</p>                      
                    </div>
                    <div class="form-group col-lg-4">
                        <input class="form-control" type="email" name="con[email][]" onchange="checkEmail(this.value)">          
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group col-lg-3">
                        <p>รหัสบัตรประชาชน<br>ID Card</p>
                    </div>
                    <div class="form-group col-lg-3">
                        <input class="form-control" type="text" name="con[IDCard][]">      
                    </div>
                    <div class="form-group col-lg-2">
                        <p>รูปภาพ<br>Picture</p>
                    </div>
                    <div class="form-group col-lg-3">
                        <input type="file" name="file[]" accept=".jpg">   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var count = 1;
    function addCus() {
        count++;
        var htmlAddCus = $("#addCus").html();
        $("#ddd").append(htmlAddCus);
    }

//    function checkEmail(email) {
        //alert(email);
//        $.get("../customer/action/customer.action.php?para=checkEmail&email=" + email, function (data, status) {
//            //alert("Data: " + data + "\nStatus: " + status);
//            if (data == "1") {
//                $("#btnSubmit").prop('disabled', true);
//                $("#alertEmail").append("<p class=\"label label-danger\" id=\"alertEmail\">" + email + " อีเมล์ซ้ำ กรุณาเปลี่ยนอีเมล์</p><br>");
//                alert(email + " E-Mail นี้ถูกใช้งานแล้ว");
//            }
//            else {
//                $("#btnSubmit").prop('disabled', false);
//                $("#alertEmail").html("");
//                //alert(email + " E-Mail นี้ใช้งานได้");
//            }
//        })
//    }

    //    $.get("../customer/action/customer.action.php?para=getBussinessTypeHTML", function (data, status) {
    //            //alert("Data: " + data + "\nStatus: " + status);
    //            $("#cusBissinessType").append(data);
    //        })
    //    $("#cusBissinessType").html();
</script>