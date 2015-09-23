<div class="row">
    <form>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    ผู้ติดต่อ / Contact #1
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>ชื่อผู้ติดต่อ / Contact Name</label>
                                <input class="form-control" name="input[0]['name']" id="name_0">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>นามสกุล / Surname</label>
                                <input class="form-control" name="input[0]['sname']" id="sname_0">                                
                            </div>
                            <div class="form-group col-lg-4">
                                <label>โทรศัพท์ / Phone</label>
                                <input class="form-control" name="input[0]['phone']" id="phone_0">                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>อีเมล์ / E-Mail</label>
                                <input class="form-control" type="email" name="input[0]['email']" id="email_0">                                
                            </div>
                            <div class="form-group col-lg-4">
                                <label>รหัสผ่าน / Password</label>
                                <input class="form-control" type="password" name="input[0]['password']" id="password_0">                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>รูปภาพ / Picture</label>
                                <input type="file" name="input[0]['picture']" id="picture_0">                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="input[1][chk]" id="chk_1">ผู้ติดต่อ / Contact #2 <br>                
                    </label>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>ชื่อผู้ติดต่อ / Contact Name</label>
                                <input class="form-control" name="input[1]['name']" id="name_1">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>นามสกุล / Surname</label>
                                <input class="form-control" name="input[1]['sname']" id="sname_1">                                
                            </div>
                            <div class="form-group col-lg-4">
                                <label>โทรศัพท์ / Phone</label>
                                <input class="form-control" name="input[1]['phone']" id="phone_1">                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>อีเมล์ / E-Mail</label>
                                <input class="form-control" type="email" name="input[1]['email']" id="email_1">                                
                            </div>
                            <div class="form-group col-lg-4">
                                <label>รหัสผ่าน / Password</label>
                                <input class="form-control" type="password" name="input[1]['password']" id="password_1">                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>รูปภาพ / Picture</label>
                                <input type="file" name="input[1]['picture']" id="picture_1">                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="input[2][chk]" id="chk_2">ผู้ติดต่อ / Contact #3 <br>                
                    </label>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>ชื่อผู้ติดต่อ / Contact Name</label>
                                <input class="form-control" name="input[2]['name']" id="name_2">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>นามสกุล / Surname</label>
                                <input class="form-control" name="input[2]['sname']" id="sname_2">                                
                            </div>
                            <div class="form-group col-lg-4">
                                <label>โทรศัพท์ / Phone</label>
                                <input class="form-control" name="input[2]['phone']" id="phone_2">                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>อีเมล์ / E-Mail</label>
                                <input class="form-control" type="email" name="input[2]['email']" id="email_2">                                
                            </div>
                            <div class="form-group col-lg-4">
                                <label>รหัสผ่าน / Password</label>
                                <input class="form-control" type="password" name="input[2]['password']" id="password_2">                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-4">
                                <label>รูปภาพ / Picture</label>
                                <input type="file" name="input[2]['picture']" id="picture_2">                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

        <div class="text-center">
            <button type="button" class="btn btn-primary">CANCLE</button>
            <a type="submit" class="btn btn-primary" href="?p=addOrder">SAVE&NEXT</a>
            <br><br>
        </div>
    </form>
</div>
<script>
    document.getElementsByTagName("input[1]['cusName']").value = document.getElementsByTagName("input[0]['cusName']").value;
    //var isChk = $('#chkPost').is(':checked');
    $(document).ready(function () {
//        $("#cusName_2").prop('disabled', true);
    });

    function updateChk() {
        $(document).ready(function () {
            var isChk1 = $("#chk_1").is(':checked');
            var isChk2 = $("#chk_2").is(':checked');
            if (isChk1) {
                $("#name_1").prop('disabled', false);
                $("#sname_1").prop('disabled', false);
                $("#phone_1").prop('disabled', false);
                $("#email_1").prop('disabled', false);
                $("#password_1").prop('disabled', false);
                $("#picture_1").prop('disabled', false);
            }
            else {
                $("#name_1").prop('disabled', true);
                $("#sname_1").prop('disabled', true);
                $("#phone_1").prop('disabled', true);
                $("#email_1").prop('disabled', true);
                $("#password_1").prop('disabled', true);
                $("#picture_1").prop('disabled', true);
            }
            if (isChk2) {
                $("#name_2").prop('disabled', false);
                $("#sname_2").prop('disabled', false);
                $("#phone_2").prop('disabled', false);
                $("#email_2").prop('disabled', false);
                $("#password_2").prop('disabled', false);
                $("#picture_2").prop('disabled', false);
            }
            else {
                $("#name_2").prop('disabled', true);
                $("#sname_2").prop('disabled', true);
                $("#phone_2").prop('disabled', true);
                $("#email_2").prop('disabled', true);
                $("#password_2").prop('disabled', true);
                $("#picture_2").prop('disabled', true);
            }
        });
    }
    setInterval(updateChk, 100);
</script>