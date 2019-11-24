


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Sales</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


          
                <div class="row">
                   

                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                

                                <div class="reports">
                                  
                                  <h4 class="text-center mb-3">POST SALES FOR THE DAY</h4>


                                  <div class="col-lg-8 offset-lg-2">
                                    <form method="post" id="PostSales">
                                                          

                                                            <div class="form-group">
                                                              
                                                                  
                                                                <select name="staff" class="form-control" id="staff-List1" required="">
                                                                      <option value="">Select Staff</option>
                                                                <?php
                                                                  echo $staffList;
                                                                ?>
                                                              </select>
                                                           
                                                            </div>

                                                            <div class="allocatedProducts"></div>

                                                            
                                                           

                                                           
                                                       </form>
                                  </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

              

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


