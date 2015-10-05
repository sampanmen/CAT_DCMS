<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel"><b>Packages</b></h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="form-group col-lg-6">
                        <label>ชื่อบริการ / Service Name</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <input class="form-control">                                 
                    </div>   
                    <div class="form-group col-lg-6">
                        <label>รายละเอียด / Detail</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <textarea class="form-control" rows="3" name="detail"></textarea>    
                    </div>
                    <div class="form-group col-lg-6">
                        <label>ประเภทบริการ / Type Service</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <select class="form-control" name="type">
                            <option value="main">Main Services</option>
                            <option value="add-on">Add-On Services</option>
                        </select> 
                    </div>
                    <div class="form-group col-lg-6">
                        <label>หมวดหมู่ / Category</label>
                    </div>
                    <div class="form-group col-lg-6">
                        <select class="form-control" name="status">                                  
                            <option>Full Rack</option>
                            <option>1/2 Rack</option>
                            <option>1/4 Rack</option>
                            <option>Shared Rack</option>
                        </select>  
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน IP Addres</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <input class="form-control">         
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Port</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <input class="form-control">           
                    </div>
                    <div class="form-group col-lg-6">
                        <label>จำนวน Rack</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <input class="form-control">          
                    </div>
                    <div class="form-group col-lg-6">
                        <label>สถานะ</label> 
                    </div>
                    <div class="form-group col-lg-6">
                        <select class="form-control" name="status">                                  
                            <option value="3">Active</option>
                            <option value="5">Not Active</option>
                        </select>  
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     <button type="button" class="btn btn-primary">Save changes</button>
</div>