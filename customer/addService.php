<div class="row">
    <form action="../customer/action/customer.action.php?para=addService" method="POST">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Service
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="form-group">
                                <label>ชื่อบริการ / Service Name</label>
                                <input class="form-control" name="name">                                
                            </div>   
                            <div class="form-group">
                                <label>รายละเอียด / Detail</label>
                                <textarea class="form-control" rows="3" name="detail"></textarea>                              
                            </div>
                        </div>
                        <div class="form-group col-lg-5">
                            <label>ประเภทบริการ / Type Service</label>
                            <select class="form-control" name="type">
                                <option value="main">Main Services</option>
                                <option value="add-on">Add-On Services</option>
                            </select>  
                        </div>
                        <div class="form-group col-lg-4">
                            <label>สถานะ</label> 
                            <select class="form-control" name="status">                                  
                                <option value="3">Active</option>
                                <option value="5">Not Active</option>
                            </select>   
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
            <div class="text-center">
                <button type="reset" class="btn btn-primary">CANCLE</button>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <br><br>
            </div>
        </div>
    </form>
</div>