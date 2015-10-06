<?php
require_once dirname(__FILE__) . '/../system/function.inc.php';

$cusID = $_GET['cusID'];
$getCus = getCustomer($cusID);
?>
<!--Customer Detail-->
<div class="row">
    <form>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>
                        Customer Detail        
                    </label>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">                            
                            <h1><b><?php echo $getCus['PrefixID'] . sprintf("%05d", $getCus['CustomerID']); ?></b></h1>
                        </div>
                        <div class="col-lg-12">
                            <?php $statusLabel = $getCus['CustomerStatus'] == "active" ? "success" : ($getCus['CustomerStatus'] == "suppened" ? "warning" : "danger"); ?>
                            <label>Status</label>
                            <p class="label label-<?php echo $statusLabel; ?>"><?php echo $getCus['CustomerStatus']; ?></p>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>


            <!--Company Detail-->  

            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>
                        ข้อมูลบริษัท / Company Detail
                        <a href="../customer/model_EditCus.php" data-toggle="modal" data-target="#myModal-lg">  (Edit)  </a>                     
                    </label>                   
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">                       
                            <div class="form-group col-lg-6">
                                <label>ชื่อ / Name</label>      
                            </div>
                            <div class="form-group  col-lg-6">                               
                                <?php echo $getCus['CustomerName']; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">                       
                            <div class="form-group col-lg-6">
                                <label>ประเภทธุรกิจ / Business Type</label>
                            </div>
                            <div class="form-group col-lg-6">                               
                                <?php echo $getCus['BusinessType']; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">                       
                            <div class="form-group col-lg-6">
                                <label>อีเมล์ / E-Mail</label>
                            </div>
                            <div class="form-group col-lg-6">                               
                                <?php echo $getCus['Email']; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">                       
                            <div class="form-group col-lg-6">
                                <label>โทรศัพท์ / Phone</label>
                            </div>
                            <div class="form-group col-lg-6">                               
                                <?php echo $getCus['Phone']; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">                       
                            <div class="form-group col-lg-6">
                                <label>แฟกต์ / Fax.</label>
                            </div>
                            <div class="form-group col-lg-6">                               
                                <?php echo $getCus['Fax']; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">                       
                            <div class="form-group col-lg-6">
                                <label>ที่อยู่ / Address</label>
                            </div>
                            <div class="form-group col-lg-6">                               
                                <?php echo $getCus['Address'] . " <br>ตำบล/Tambol: " . $getCus['Township'] . " <br>อำเภอ/City: " . $getCus['City'] . " <br>จังหวัด/Province: " . $getCus['Province'] . " <br>รหัสไปรษณีย์/Postalcode: " . $getCus['Zipcode'] . " <br>ประเทศ/Country: " . $getCus['Country']; ?>
                            </div>

                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->


            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>
                        ข้อมูลผู้ติดต่อ / Contact Detail
                        <a href="../customer/model_addContact.php?cusID=<?php echo $getCus['CustomerID']; ?>" data-toggle="modal" data-target="#myModal">  (Add)  </a>
                    </label>
                </div>
                <div class="panel-body">
                    <div class="row">                       
                        <div class="col-lg-12">

                            <?php
                            $getContact = getContactByCustomer($cusID);
                            foreach ($getContact as $value) {
                                ?>
                                <div class=" well well-sm col-lg-12 ">
                                    <div class="col-lg-4 text-left">
                                        <img src = "../customer/images/persons/<?php echo $value['PersonID']; ?>.jpg" width="100%" height="" border="1">
                                    </div>
                                    <div class="col-lg-8 text-left">                      

                                        <p><b>Name:</b> <?php echo $value['Fname'] . " " . $value['Lname']; ?></p>
                                        <p><b>Email:</b> <?php echo $value['Email']; ?></p>
                                        <p><b>Phone:</b> <?php echo $value['Phone']; ?></p>
                                        <p><b>Type:</b> <?php echo $value['TypePerson']; ?></p>
                                        <div class="text-right">
                                            <a href="../customer/model_editContact.php?personID=<?php echo $value['PersonID']; ?>&cusID=<?php echo $getCus['CustomerID']; ?>" data-toggle="modal" data-target="#myModal">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
            </div>
        </div>
        <!--Order Detail-->  
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b> Order Detail
                            <a href="../core/?p=addOrder" >(ADD)</a></b>                   
                    </p>
                </div>                

                <div class="panel-body">
                    <div class="row">                       
                        <div class="col-lg-12">
                            <div class=" well well-sm col-lg-12 ">
                                <div class="col-lg-12">

                                    <div class="col-lg-4">                        
                                        <h3><b>00001  </b> </h3>  
                                    </div>

                                </div>

                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <p><b>Date:</b></p>      
                                    </div>
                                    <div class="col-lg-8">                               
                                        22/09/2558                               
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <p><b>Total Packages:</b></p>      
                                    </div>
                                    <div class="col-lg-8">                               
                                        <p><font size="3"><b>3</b></font> /5                                
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <p><b>Status:</b></p>      
                                    </div>
                                    <div class="col-lg-3">                               
                                        <p class="label label-success">Active</p>                               
                                    </div>
                                    <div class="col-lg-3">                               
                                        <p></p>                               
                                    </div>
                                    <div class="col-lg-2">                               
                                        <p><a href="../core/?p=orderPackagesHis" >Detail</a></p>                               
                                    </div>
                                </div>
                            </div>


                            <div class="well well-sm  col-lg-12">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">                        
                                        <h3><b>00002  </b> </h3>  
                                    </div>

                                </div>

                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <p><b>Date:</b></p>      
                                    </div>
                                    <div class="col-lg-8">                               
                                        22/09/2558                               
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <p><b>Total Packages:</b></p>      
                                    </div>
                                    <div class="col-lg-8">                               
                                        <p><font size="3"><b>3</b></font> /5                                
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <p><b>Status:</b></p>      
                                    </div>
                                    <div class="col-lg-3">                               
                                        <p class="label label-success">Active</p>                               
                                    </div>
                                    <div class="col-lg-3">                               
                                        <p></p>                               
                                    </div>
                                    <div class="col-lg-2">                               
                                        <p><a href="../core/?p=orderPackagesHis" >Detail</a></p>                               
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>

            <!-- Contact Detail -->

        </div> 

        <!-------IP-->
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b> IP</b> </p>
                </div>                

                <div class="panel-body">                   
                    <table class="table ">

                        <tbody>
                            <tr>
                                <td>158.168.1.0</td>
                                <td><a href="../customer/model_IP.php"  data-toggle="modal" data-target="#myModal">10</a></td>

                            </tr>                                                     
                            <tr>
                                <td>158.168.2.0</td>
                                <td><a href="../customer/model_IP.php" data-toggle="modal" data-target="#myModal">10</a></td>

                            </tr>          
                            <tr>
                                <td>158.168.3.0</td>
                                <td><a href="../customer/model_IP.php" data-toggle="modal" data-target="#myModal">2</a></td>

                            </tr>          
                            <tr>
                                <td>158.168.4.0</td>
                                <td><a href="../customer/model_IP.php" data-toggle="modal" data-target="#myModal">3</a></td>

                            </tr>          

                        </tbody>
                    </table>

                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>

            <!-- Contact Detail -->

        </div> 

        <!-------Rack-->
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b> Rack</b> </p>
                </div>                

                <div class="panel-body">                   
                    <table class="table ">

                        <tbody>
                            <tr>
                                <td>Full Rack</td>
                                <td><a href="../customer/model_Rack.php"  data-toggle="modal" data-target="#myModal">2</a></td>

                            </tr>                                                     
                            <tr>
                                <td>1/2 Rack</td>
                                <td><a href="../customer/model_Rack.php" data-toggle="modal" data-target="#myModal">2</a></td>

                            </tr>          
                            <tr>
                                <td>1/4 Rack</td>
                                <td><a href="../customer/model_Rack.php" data-toggle="modal" data-target="#myModal">1</a></td>

                            </tr>          
                            <tr>
                                <td>Shared Rack</td>
                                <td><a href="../customer/model_Rack.php" data-toggle="modal" data-target="#myModal">3</a></td>

                            </tr>          

                        </tbody>
                    </table>

                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>

            <!-- Contact Detail -->

        </div> 


        <!------Port-->
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b>Port</b> </p>
                </div>                

                <div class="panel-body">                   
                    <table class="table ">

                        <tbody>
                            <tr>
                                <td>Switch 1</td>
                                <td><a href="../customer/model_Port.php"  data-toggle="modal" data-target="#myModal">7</a></td>

                            </tr>                                                     
                            <tr>
                                <td>Switch 2</td>
                                <td><a href="../customer/model_Port.php" data-toggle="modal" data-target="#myModal">4</a></td>

                            </tr>          
                            <tr>
                                <td>Switch 3</td>
                                <td><a href="../customer/model_Port.php" data-toggle="modal" data-target="#myModal">5</a></td>

                            </tr>          
                            <tr>
                                <td>Switch 5</td>
                                <td><a href="../customer/model_Port.php" data-toggle="modal" data-target="#myModal">2</a></td>

                            </tr>          

                        </tbody>
                    </table>

                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>

            <!-- Contact Detail -->

        </div> 

    </form>
</div>