<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';
?>

<form action="../resource/action/resource.action.php?para=addResourceService" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Add</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="panel-body">
                <div class="row">

                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Services Name </label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <input class="form-control" name="servicename">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>detail</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <textarea class="form-control" name="servicedetail"></textarea>                         
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>location</label>
                        </div>
                        <div class="form-group col-lg-6"> 
                            <select class="form-control" name="servicelocation">
                                <?php
                                $loca = getLocation();
                                foreach ($loca as $value) {
                                    if ($value['Status'] == "Deactive")
                                        continue;
                                    ?>
                                    <option value="<?php echo $value['LocationID']; ?>"><?php echo $value['Location']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>จำนวน</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="serviceamount">                                
                        </div>
                    </div>
                    <div class="col-lg-12">  
                        <div class="col-lg-6">                                           
                            <label>Tag</label>
                        </div>
                        <div class="form-group col-lg-6">
                            <input class="form-control" name="servicetag">                                   
                        </div>
                    </div>



                </div>


            </div>







            <!-- /.row (nested) -->
        </div> 




    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Add</button>
</div>
</form>