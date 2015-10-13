<form method="POST" action="../resource/action/resource.action.php?para=addSwitch">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Port</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Switch Name</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="name"> 
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>IP Address</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="ip">                        
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>SNMP Community</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="password" name="commu">                                
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label>Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option value="switch">Switch</option>
                                <option value="gateway">Gateway</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label>Number of Port</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" type="number" name="port">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label>Uplink Port</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="uplink" placeholder="example: 1,2,3">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label>Vlan</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="vlan" placeholder="example: 100,200,300">
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