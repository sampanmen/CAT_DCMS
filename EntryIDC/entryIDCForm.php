<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$contactID = $_GET['contactID'];

?>
<div class="row">
    <form>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b>ข้อมูลกรณีไม่ใช่ผู้ติดต่อ</b></p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-5">
                                <label class="radio-inline">                                    
                                    <input type="radio" name="type">ลูกค้า / Customer <br>                
                                </label>                                
                            </div>
                            <div class="form-group col-lg-5">                               
                                <input class="form-control">                                
                            </div>
                        </div>

                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-5">
                                <label class="radio-inline">                                    
                                    <input type="radio" name="type">พนักงาน กสท / CAT Employee <br>                
                                </label>                                   
                            </div>
                            <div class="form-group col-lg-5">                               
                                <input class="form-control">                                
                            </div>
                        </div>

                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-5">                       
                                <label class="radio-inline">                                    
                                    <input type="radio" name="type">บุคคลทั่วไป / Other <br>                
                                </label>                                    
                            </div>
                        </div>
                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-5"><br>
                                หมายเลขบัตรผ่านอาคาร / Visitor Card NO.                                                               
                            </div>
                            <div class="form-group col-lg-5"><br>                               
                                <input class="form-control">                                
                            </div>
                        </div>
                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-5">                           
                                หมายเลขบัตรผ่าน IDC / IDC Card NO.                                                               
                            </div>                                                     
                            <div class="form-group col-lg-3">                            
                                <input class="form-control">
                            </div>
                            <div class="form-group col-lg-1">  
                                Type
                            </div>
                            <div class="form-group col-lg-1">                            
                                <input class="form-control">
                            </div>                           
                        </div>
                        <div class="col-lg-10">                       
                            <div class="form-group col-lg-5">  
                                รหัสบัตรประชาชน / ID Card NO. / Passport ID                                                              
                            </div>
                            <div class="form-group col-lg-5">                           
                                <input class="form-control">                                
                            </div>

                        </div>
                        <div class="col-lg-12"><br><br>                       
                            <div class="form-group col-lg-1">  
                                ชื่อ/Name                                                              
                            </div>
                            <div class="form-group col-lg-2">                           
                                <input class="form-control">                                
                            </div>
                            <div class="form-group col-lg-2">  
                                นามสกุล/Lastname                                                              
                            </div>
                            <div class="form-group col-lg-2">                           
                                <input class="form-control">                                
                            </div>
                            <div class="form-group col-lg-1">  
                                E-Mail                                                              
                            </div>
                            <div class="form-group col-lg-4">                           
                                <input class="form-control">                                
                            </div>

                        </div>
                        <div class="col-lg-12">                      
                            <div class="form-group col-lg-1">  
                                ชื่อบริษัท                                                             
                            </div>
                            <div class="form-group col-lg-6">                           
                                <input class="form-control">                                
                            </div>
                            <div class="form-group col-lg-1">  
                                โทร./Tel.                                                              
                            </div>
                            <div class="form-group col-lg-4">                           
                                <input class="form-control">                                
                            </div>

                        </div>
                        <div class="col-lg-12">                      
                            <div class="form-group col-lg-1">  
                                วัตถุประสงค์                                                            
                            </div>
                            <div class="form-group col-lg-11">                           
                                <input class="form-control"><br><br>                                
                            </div>
                        </div>
                    </div>
                </div>




                <!--อุปกรณ์--> 
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>รายการอุปกรณ์ (Equipment List)</label>
                        </div>

                        <div class="panel-body">
                            <div class="row col-lg-12">
                                <table class="table table-bordered" id="dataTables">

                                    <tr>
                                        <th></th>
                                        <th>ชื้ออุปกรณ์ (Equipment)</th>
                                        <th>ยี่ห้อ(Brand)</th>
                                        <th>รุ่น (Model)</th>
                                        <th>Serial No/Remake</th>
                                        <th >Rack Number</th>

                                    </tr>

                                    <tbody>

                                        <tr>       
                                            <td><input type="checkbox"></td>                                    
                                            <td>NoteBook</td>
                                            <td>Aser</td>
                                            <td>Aspire</td>
                                            <td>1234567890</td>
                                            <td>A01</td>

                                        </tr> 

                                        <tr>       
                                            <td><button type="button" class="btn btn-info btn-circle"><i class="glyphicon-plus"></i></button></td>                                    
                                            <td><input class="form-control"></td>
                                            <td><input class="form-control"></td>
                                            <td><input class="form-control"></td>
                                            <td><input class="form-control"></td>
                                            <td><select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option> 
                                                </select> 
                                            </td>

                                        </tr> 
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>


                <!--เจ้าหน้าที่-->   


                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>สำหรับเจ้าหน้าที่ </label>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10">                       
                                    <div class="form-group col-lg-3">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Customer Room <br>                
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-7">                                  
                                        <textarea class="form-control" rows="1"></textarea>                               
                                    </div>
                                </div>

                                <!--IDC-->
                                <div class="col-lg-12"><br>                       
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">IDC1               
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">IDC2               
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">NOC                 
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Power               
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Meeting                
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Manager                
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Core Network              
                                        </label>                                
                                    </div>
                                </div>

                                <!--VIP-->
                                <div class="col-lg-12">                       
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP1               
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP2                
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP3                  
                                        </label>                                
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP4                
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP5                 
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP6                 
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">VIP7              
                                        </label>                                
                                    </div>
                                </div>

                                <div class="col-lg-12">                       
                                    <div class="form-group col-lg-1">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Office               
                                        </label>                                
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label class="checkbox-inline">                                    
                                            <input type="checkbox">Temp Office                
                                        </label>                                
                                    </div>  
                                </div>

                                <div class="col-lg-7">                       
                                    <div class="form-group col-lg-3"><br>
                                        <label>เวลาเข้า</label>                                                                                                           
                                    </div><br>
                                    <div class="form-group col-lg-3">
                                        <select class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>                                 
                                        </select>               
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <select class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>                                 
                                        </select> <br>              
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>


                <div class="text-center">
                    <button type="button" class="btn btn-primary">CANCLE</button>
                    <a class="btn btn-primary" href="?p=entryBeforePrint" target="_blank">Save</a>
                    <br><br>
                </div>
                <!-- /.panel -->

            </div> 
        </div>





    </form>
</div>