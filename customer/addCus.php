<div class="row">
    <form id="addCusForm" action="" method="POST">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>
                        Add Customer
                    </label>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="alert alert-info text-center">
                                <br>ข้อมูลสำหรับติดต่อ<br>
                                Admin Contact Information<br><br>
                            </div>

                            <div class="form-group">
                                <label>ชื่อลูกค้า / Customer Name</label>
                                <input class="form-control" name="input[0]['cusName']" id="cusName_1">
                            </div>

                            <div class="form-group">
                                <label>ประเภทธุรกิจ / Bussiness Type</label>
                                <select class="form-control" name="input[0]['bussinessType']" id="bussinessType_1">
                                    <option>บุคคล</option>
                                    <option>นิติบุคคล</option>
                                </select>                               
                            </div>

                            <div class="form-group">
                                <label>อีเมล์ / E-Mail</label>
                                <input class="form-control" name="input[0]['email']" id="email_1">                                
                            </div>

                            <div class="form-group">
                                <label>โทรศัพท์ / Phone</label>
                                <input class="form-control" name="input[0]['phone']" id="phone_1">                                
                            </div>

                            <div class="form-group">
                                <label>แฟกต์ / Fax</label>
                                <input class="form-control" name="input[0]['fax']" id="fax_1">                                
                            </div>

                            <div class="form-group">
                                <label>ที่อยู่ / Address</label>
                                <input class="form-control" name="input[0]['address']" id="address_1">                                
                            </div>

                            <div class="form-group">
                                <label>ตำบล / Tambol</label>
                                <input class="form-control" name="input[0]['tambol']" id="tambol_1">                                
                            </div>

                            <div class="form-group">
                                <label>อำเภอ / City</label>
                                <input class="form-control" name="input[0]['city']" id="city_1">                                
                            </div>

                            <div class="form-group">
                                <label>จังหวัด / Province</label>
                                <input class="form-control" name="input[0]['province']" id="province_1">                                
                            </div>

                            <div class="form-group">
                                <label>รหัสไปรษณีย์ / Postalcode</label>
                                <input class="form-control" name="input[0]['postCode']" id="postCode_1">                                
                            </div>

                            <div class="form-group">
                                <label>ประเทศ / Country</label>
                                <input class="form-control" name="input[0]['country']" id="country_1">                                
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="alert alert-info text-center">
                                ข้อมูลสำหรับออกใบเสร็จ<br>
                                Billing Contact Information<br>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkBil" checked>เหมือนกับข้อมูลสำหรับติดต่อ <br>
                                    (Same as Admin Contact Information)
                                </label>
                            </div>

                            <div class="form-group">
                                <label>ชื่อลูกค้า / Customer Name</label>
                                <input class="form-control" name="input[1]['cusName']" id="cusName_2">
                            </div>

                            <div class="form-group">
                                <label>ประเภทธุรกิจ / Bussiness Type</label>
                                <select class="form-control" name="input[1]['bussinessType']" id="bussinessType_2">
                                    <option>บุคคล</option>
                                    <option>นิติบุคคล</option>
                                </select>                               
                            </div>

                            <div class="form-group">
                                <label>อีเมล์ / E-Mail</label>
                                <input class="form-control" name="input[1]['email']" id="email_2">                                
                            </div>

                            <div class="form-group">
                                <label>โทรศัพท์ / Phone</label>
                                <input class="form-control" name="input[1]['phone']" id="phone_2">                                
                            </div>

                            <div class="form-group">
                                <label>แฟกต์ / Fax</label>
                                <input class="form-control" name="input[1]['fax']" id="fax_2">                                
                            </div>

                            <div class="form-group">
                                <label>ที่อยู่ / Address</label>
                                <input class="form-control" name="input[1]['address']" id="address_2">                                
                            </div>

                            <div class="form-group">
                                <label>ตำบล / Tambol</label>
                                <input class="form-control" name="input[1]['tambol']" id="tambol_2">                                
                            </div>

                            <div class="form-group">
                                <label>อำเภอ / City</label>
                                <input class="form-control" name="input[1]['city']" id="city_2">                                
                            </div>

                            <div class="form-group">
                                <label>จังหวัด / Province</label>
                                <input class="form-control" name="input[1]['province']" id="province_2">                                
                            </div>

                            <div class="form-group">
                                <label>รหัสไปรษณีย์ / Postalcode</label>
                                <input class="form-control" name="input[1]['postCode']" id="postCode_2">                                
                            </div>

                            <div class="form-group">
                                <label>ประเทศ / Country</label>
                                <input class="form-control" name="input[1]['country']" id="country_2">                                
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="alert alert-info text-center">
                                ข้อมูลสำหรับไปรษณีย์<br>
                                Mailing Contact Information
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkPost" checked>เหมือนกับข้อมูลสำหรับติดต่อ <br>
                                    (Same as Admin Contact Information)
                                </label>

                            </div>

                            <div class="form-group">
                                <label>ชื่อลูกค้า / Customer Name</label>
                                <input class="form-control" name="input[2]['cusName']" id="cusName_3">
                            </div>

                            <div class="form-group">
                                <label>ประเภทธุรกิจ / Bussiness Type</label>
                                <select class="form-control" name="input[2]['bussinessType']" id="bussinessType_3">
                                    <option>บุคคล</option>
                                    <option>นิติบุคคล</option>
                                </select>                               
                            </div>

                            <div class="form-group">
                                <label>อีเมล์ / E-Mail</label>
                                <input class="form-control" name="input[2]['email']" id="email_3">                                
                            </div>

                            <div class="form-group">
                                <label>โทรศัพท์ / Phone</label>
                                <input class="form-control" name="input[2]['phone']" id="phone_3">                                
                            </div>

                            <div class="form-group">
                                <label>แฟกต์ / Fax</label>
                                <input class="form-control" name="input[2]['fax']" id="fax_3">                                
                            </div>

                            <div class="form-group">
                                <label>ที่อยู่ / Address</label>
                                <input class="form-control" name="input[2]['address']" id="address_3">                                
                            </div>

                            <div class="form-group">
                                <label>ตำบล / Tambol</label>
                                <input class="form-control" name="input[2]['tambol']" id="tambol_3">                                
                            </div>

                            <div class="form-group">
                                <label>อำเภอ / City</label>
                                <input class="form-control" name="input[2]['city']" id="city_3">                                
                            </div>

                            <div class="form-group">
                                <label>จังหวัด / Province</label>
                                <input class="form-control" name="input[2]['province']" id="province_3">                                
                            </div>

                            <div class="form-group">
                                <label>รหัสไปรษณีย์ / Postalcode</label>
                                <input class="form-control" name="input[2]['postCode']" id="postCode_3">                                
                            </div>

                            <div class="form-group">
                                <label>ประเทศ / Country</label>
                                <input class="form-control" name="input[2]['country']" id="country_3">                                
                            </div>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="text-center">
            <button type="reset" class="btn btn-primary">CANCLE</button>
            <a type="submit" class="btn btn-primary" href="?p=addContact">NEXT</a>
            <br><br>
        </div>
    </form>
    <!-- /.col-lg-12 -->
</div>
<script>
    document.getElementsByTagName("input[1]['cusName']").value = document.getElementsByTagName("input[0]['cusName']").value;
    //var isChk = $('#chkPost').is(':checked');
    $(document).ready(function () {
//        $("#cusName_2").prop('disabled', true);
    });

    function updateChk() {
        $(document).ready(function () {
            var isChkBil = $("#chkBil").is(':checked');
            var isChkPost = $("#chkPost").is(':checked');
            if (isChkBil) {
                $("#cusName_2").prop('disabled', true);
                $("#bussinessType_2").prop('disabled', true);
                $("#email_2").prop('disabled', true);
                $("#phone_2").prop('disabled', true);
                $("#fax_2").prop('disabled', true);
                $("#address_2").prop('disabled', true);
                $("#tambol_2").prop('disabled', true);
                $("#city_2").prop('disabled', true);
                $("#province_2").prop('disabled', true);
                $("#postCode_2").prop('disabled', true);
                $("#country_2").prop('disabled', true);
            }
            else{
                $("#cusName_2").prop('disabled', false);
                $("#bussinessType_2").prop('disabled', false);
                $("#email_2").prop('disabled', false);
                $("#phone_2").prop('disabled', false);
                $("#fax_2").prop('disabled', false);
                $("#address_2").prop('disabled', false);
                $("#tambol_2").prop('disabled', false);
                $("#city_2").prop('disabled', false);
                $("#province_2").prop('disabled', false);
                $("#postCode_2").prop('disabled', false);
                $("#country_2").prop('disabled', false);
            }
            if (isChkPost) {
                $("#cusName_3").prop('disabled', true);
                $("#bussinessType_3").prop('disabled', true);
                $("#email_3").prop('disabled', true);
                $("#phone_3").prop('disabled', true);
                $("#fax_3").prop('disabled', true);
                $("#address_3").prop('disabled', true);
                $("#tambol_3").prop('disabled', true);
                $("#city_3").prop('disabled', true);
                $("#province_3").prop('disabled', true);
                $("#postCode_3").prop('disabled', true);
                $("#country_3").prop('disabled', true);
            }
            else{
                $("#cusName_3").prop('disabled', false);
                $("#bussinessType_3").prop('disabled', false);
                $("#email_3").prop('disabled', false);
                $("#phone_3").prop('disabled', false);
                $("#fax_3").prop('disabled', false);
                $("#address_3").prop('disabled', false);
                $("#tambol_3").prop('disabled', false);
                $("#city_3").prop('disabled', false);
                $("#province_3").prop('disabled', false);
                $("#postCode_3").prop('disabled', false);
                $("#country_3").prop('disabled', false);
            }
        });
    }
    setInterval(updateChk, 100);
</script>