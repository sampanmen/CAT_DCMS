<div class="row">
    <form>
        <div class="col-lg-6">  
            <!--Rack-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b> Rack</b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Position</th>                                 

                                </tr>
                            </thead>
                            <tbody>
                                <tr>                                  
                                    <td>Share Rack (2U/Server)</td>
                                    <td>1,1,1</td>                                   
                                </tr>                                                     
                                <tr>
                                    <td>Full Rack</td>
                                    <td>1,1,2</td>


                                </tr>          
                                <tr>
                                    <td>1/2 Rack</td>
                                    <td>1,1,3</td>

                                </tr>          
                                <tr>
                                    <td>Full Rack</td>
                                    <td>1,1,4</td>

                                </tr>          

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>



            <!--IP-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b> IP</b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables1">
                            <thead>
                                <tr>
                                    <th>Network IP</th>
                                    <th>Subnet</th>
                                    <th>Total</th>
                                    <th>Remain</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>192.168.2.0</td>
                                    <td>255.255.255.0</td>
                                    <td>256</td>
                                    <td>5</td>
                                </tr>                                                     
                                <tr>
                                    <td>192.168.3.0</td>
                                    <td>255.255.255.0</td>
                                    <td>256</td>
                                    <td>44</td>
                                </tr>          
                                <tr>
                                    <td>192.168.4.0</td>
                                    <td>255.255.255.0</td>
                                    <td>256</td>
                                    <td>90</td>
                                </tr>          
                                <tr>
                                    <td>192.168.7.0</td>
                                    <td>255.255.255.0</td>
                                    <td>256</td>
                                    <td>50</td> 

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>



        <div class="col-lg-6">
            <!--Servics-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>Servics</b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables2">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Detail</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room 1</td>
                                    <td>ห้องสำหรับประชุม</td>
                                    <td>Use</td>
                                </tr>                                                     

                                <tr>
                                    <td>Room 2</td>
                                    <td>ห้องสำหรับประชุม</td>
                                    <td>Use</td>
                                </tr>       
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>




            <!--Port-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>Port</b></h4>
                </div>      

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables3">
                            <thead>
                                <tr>
                                    <th>Name Switchs</th>
                                    <th>Total</th>
                                    <th>Remain</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Swith 1</td>
                                    <td>48</td>
                                    <td>6</td>

                                </tr>                                                     

                                <tr>
                                    <td>Swith 2</td>
                                    <td>48</td>
                                    <td>6</td>
                                </tr>          
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.row (nested) -->
            </div>






            <!-- /.panel-body -->
        </div>

    </form>
</div>



<script>
    $(document).ready(function () {
        $('#dataTables1').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables2').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables3').DataTable({
            responsive: true
        });
    });
</script>