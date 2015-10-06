<form>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Customer</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">                      
                        <div class="form-group col-lg-3">
                            <p>ชื่อลูกค้า <br> Name</p>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="name">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>ประเภทธุรกิจ  Bussines</p>
                        </div>
                        <div class="form-group col-lg-3"> 
                            <select class="form-control" name="bussinessType">
                                <option selected value="กสท">กสท</option>
                                <option value="นิติบุคคล">นิติบุคคล</option>
                                <option value="บุคคล">บุคคล</option>                                 
                            </select>    
                        </div>
                        <div class="form-group col-lg-2">
                            <p>อีเมล์<br>E-Mail</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" type="email" name="email">      
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>โทรศัพท์ <br>  Phone</p>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="phone">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>แฟกต์  Fax</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="fax">                                
                        </div>
                    </div>

                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>ที่อยู่ <br> Address</p>                                                               
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="address">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>ตำบล <br> Tambol</p>                                                             
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="township">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>อำเภอ <br> City</p>                          
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="city">                                
                        </div>
                        <div class="form-group col-lg-2">
                            <p>จังหวัด <br> Province</p>                     
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="province">                                
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-3">
                            <p>รหัสไปรษณีย์  Postalcode</p>                 
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="zipcode">                                
                        </div>

                        <div class="form-group col-lg-2">
                            <p>ประเทศ  Country</p>
                        </div>
                        <div class="form-group col-lg-4">
                            <input class="form-control" name="country">                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" value="">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>