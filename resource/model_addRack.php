<?php ?>
<form method="POST" action="../resource/action/resource.action.php?para=addRack">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add Rack</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Rack Size</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <select class="form-control" name="size">
                                <option value="45">45 U</option>
                                <option value="42">42 U</option>
                                <option value="39">39 U</option>
                                <option value="36">36 U</option>
                                <option value="27">27 U</option>
                                <option value="15">15 U</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">
                            <label>Rack Type</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <select class="form-control" name="type">
                                <option value="full rack">Full Rack</option>
                                <option value="1/2 rack">1/2 Rack</option>   
                                <option value="1/4 rack">1/4 Rack</option>
                                <option value="shared rack">Shared Rack</option>     
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Rack Zone</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <select class="form-control" name="zone" id="zone1" onchange="chkZone();">
                                <option selected value="">Other</option>
                                <option value="A">A</option>
                            </select>                                 
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="zone" id="zone2" required>
                        </div>
                        <script>
                            function chkZone() {
                                var zone1 = $("#zone1").val();
                                $("#zone2").val(zone1);
                            }
                        </script>
                    </div>
                    <!--                    <div class="col-lg-12">  
                                            <div class="col-lg-6">                                           
                                                <label>Rack Position</label>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input class="form-control" name="position">                                   
                                            </div>
                                        </div>-->
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label>Amount</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input class="form-control" name="amount" type="number" value="1" required>                                   
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