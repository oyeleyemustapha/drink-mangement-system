


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Sales Reports</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


          
                <div class="row">
                   

                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                              <div class="btn-group">


                                


                                      <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal5">Sales Sheet</button><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Daily Sales Report</button>


                                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2">Monthly Sales Report</button>

                                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal3">Annual Sales Report</button>


                                  <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal4">Staff Sales Report</button>
                                   
                                  
                                </div>

                                <?php


                                  if($daily_report){

                                    echo'
                                      <div class="table-responsive">
                                        <h4 class="text-center mb-3 mt-5">Sales Report for '.date("F d, Y", strtotime($daily_report[0]->DATE)).'</h4>
                                        <table class="table table-striped table-bordered salesTable">
                                            <thead>
                                              <tr>
                                                <th>ID</th>
                                                <th>PRODUCT</th>
                                                <th>QUANTITY SOLD</th>
                                                <th>AMOUNT</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    ';

                                    $counter=1;
                                    $total_amt=0;
                                    foreach ($daily_report as $report) {

                                      $amount=$report->SALES * $report->SALES_PRICE;
                                      $total_amt+=$amount;
                                      echo"
                                        <tr>
                                        <td>$counter</td>
                                        <td>$report->PRODUCT_NAME</td>
                                        <td>$report->SALES</td>
                                        <td>  &#8358; ".number_format($amount)."</td>
                                      </tr>

                                      ";
                                      $counter++;
                                    }


                                    echo'
                                    

                                    </tbody>
                                  </table>

                                  <div class="col-lg-8 offset-lg-2 mt-4">
                                  <table class="table table-striped">
                                  <tbody>
                                  <tr>

                                      <td colspan="3"><strong>TOTAL SALES</strong></td>
                                      <td>&#8358; '.number_format( $total_amt).'</td>
                                    </tr>
                                  </tbody>
                                  </table>
                                  </div>
                                </div>';
                                  }

                                ?>



                                
                                      
                                    

                                <div class="reports"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>

              

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


<div id="myModal5" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">SALES SHEET</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" action="<?php echo base_url(); ?>sales-sheet" target="_blank">

                                                        
                                                            <div class="form-group">
                                                                 <div class="input-group">
                                                             <div class="input-group-addon">Date</div>
                                                             <input type="date" name="date" class="form-control" required="">
                                                           </div>
                                                           </div>

                                                           
                                                           <button class="btn btn-danger">Generate</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
<!-- sample modal content -->
                                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Daily Sales Reports</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" action="<?php echo base_url(); ?>daily-sales-reports" target="_blank">
                                                           <div class="form-group">
                                                               <input type="text" name="date" class="form-control date" required="" autocomplete="off">
                                                           </div>

                                                           <button class="btn btn-danger">Generate</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->


 <div id="myModal4" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Staff Sales Reports</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" action="<?php echo base_url(); ?>staff-sales" target="_blank">

                                                        <div class="form-group">
                                                          <select class="form-control" required="" name="staff">
                                                            <?php echo $staffList; ?>
                                                          </select>
                                                        </div>
                                                            <div class="form-group">
                                                                 <div class="input-group">
                                                             <div class="input-group-addon">Date</div>
                                                             <input type="date" name="date" class="form-control" required="">
                                                           </div>
                                                           </div>

                                                           
                                                           <button class="btn btn-danger">Generate</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
<!-- sample modal content -->
                                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Daily Sales Reports</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" action="<?php echo base_url(); ?>daily-sales-reports" target="_blank">
                                                           <div class="form-group">
                                                               <input type="text" name="date" class="form-control date" required="" autocomplete="off">
                                                           </div>

                                                           <button class="btn btn-danger">Generate</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->





 <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Monthly Sales Reports</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" action="<?php echo base_url(); ?>monthly-sales-reports" target="_blank">
                                                            <div class="form-group">
                                                                 <div class="input-group">
                                                             <div class="input-group-addon">Month</div>
                                                             <select name="month" class="form-control" required="">
                                                                 <?php echo $month; ?>
                                                               </select>
                                                           </div>
                                                           </div>

                                                           <div class="form-group">
                                                                 <div class="input-group">
                                                             <div class="input-group-addon">Year</div>
                                                             <select name="year" class="form-control" required="">
                                                                 <?php echo $year; ?>
                                                               </select>
                                                           </div>
                                                           </div>
                                                           <button class="btn btn-danger">Generate</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->


<div id="myModal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Annual Sales Reports</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" action="<?php echo base_url(); ?>annual-sales-reports" target="_blank">
                                                            

                                                           <div class="form-group">
                                                                 <div class="input-group">
                                                             <div class="input-group-addon">Year</div>
                                                             <select name="year" class="form-control" required="">
                                                                 <?php echo $year; ?>
                                                               </select>
                                                           </div>
                                                           </div>
                                                           <button class="btn btn-danger">Generate</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->



