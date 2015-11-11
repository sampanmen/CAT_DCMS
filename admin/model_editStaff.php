<form method="POST" action="">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">0001</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Staff ID</label>
                        </div>
                        <div class="form-group col-lg-3"> 
                             00001
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                             Thidarat
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Surname</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                             Changkaew
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>e-mail</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="staffemail" type="email" >
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Position</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option value="">Admin</option>
                                <option value="">Service Desk</option>   
                                <option value="">Operater</option>
                                <option value="">Support Team</option>     
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Status</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option value="">Active</option>
                                <option value="">NonActive</option> 
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>