


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            
                            <h4 class="page-title">Change</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


               

                <div class="row">
                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="btn-group">
                                     <button class="btn btn-primary" data-toggle="modal" href='#myModal1'>Create Pin</button>
                                <button class="btn btn-info" data-toggle="modal" href='#myModal2'>Query Pin</button>
                                    <button class="btn btn-success" data-toggle="modal" href='#myModal3'>Record</button>
                                </div>
                                
                               
                                
                            </div>
                        </div>
                    </div>

                   
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                

                                <div class="unpaidChange"></div>
                               
                                
                            </div>
                        </div>
                    </div>

                   
                </div>

              

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


<div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Generate Pin</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" id="generatePinform" autocomplete="off">
                                                            

                                                           <div class="form-group">
                                                                 <input type="text" name="name" class="SearchSalesRecord form-control form-control-lg" placeholder="Name of Customer" required autocomplete="off">
                                                           </div>

                                                            <div class="form-group">
                                                                 <input type="text" name="phone" class="SearchSalesRecord form-control form-control-lg" placeholder="Phone Number of Customer" required autocomplete="off">
                                                           </div>
                                                           

                                                           <div class="form-group">
                                                                 <input type="text" name="amount" class="SearchSalesRecord form-control form-control-lg" placeholder="Change Amount" required autocomplete="off">
                                                           </div>

                                                           <button class="btn btn-primary">Generate</button>
                                                           
                                                          
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->


<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Query Pin</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                      
                                                            

                                                           <div class="form-group">
                                                                 <input type="text" name="pin" class="SearchPin form-control form-control-lg" placeholder="Type pin here" required>
                                                           </div>

                                                            
                                                           
                                                          
                                                      <div class="pinResult"></div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

<div id="myModal3" class="modal fade"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Change Report</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                      
                                                            

                                                           <form method="post" action="<?php echo base_url(); ?>change-report-individual" target="_blank">
                                                            <div class="form-group">
                                                        
                                                                <select name="staff" class="form-control" id="staff-List">
                                                                <option value=""></option>
                                                                <?php
                                                                  echo $staffList;
                                                                ?>
                                                              </select>
                                                           
                                                            </div>

                                                            <div class="form-group">
                                                                <select class="form-control" name="status" required>
                                                                    <option value="">Select Change Status</option>
                                                                    <option value="PAID">Paid</option>
                                                                     <option value="NOT PAID">Not Paid</option>
                                                                </select>
                                                            </div>

                                                            <button class="btn btn-primary">Generate</button>


                                                           </form>
                                                            
                                                           
                                                          
                                                      <div class="pinResult"></div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
<div id="payChangeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Pay Change</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                      
                                                            

                                                          
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
