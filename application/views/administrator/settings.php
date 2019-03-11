


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Store Settings</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


          
                <div class="row">
                   

                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">

                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Change Store Name</button>

                                    <a href="<?php echo base_url() ?>export-records" target="_blank" class="btn btn-info btn-sm">Export Records</a>
                                </h4>

                               
                                <?php

                                if($cafeteria){
                                  echo "
                                  <p class='text-center'><img src='".base_url()."assets/images/dish.png'></p>

                                  <h2 class='text-center'>".strtoupper($store->STORE_NAME)."</h2>
                                  <div class='col-lg-8 offset-lg-2'>
                                        <ul class='list-group'>
                                            <li class='list-group-item'><i class='fa-2x fa fa-mobile fa-fw'></i> Phone :  $store->PHONE</li>
                                            <li class='list-group-item'><i class='fa-2x fa fa-map-marker fa-fw'></i> Address :  $store->ADDRESS</li>
                                            <li class='list-group-item'><i class='fa-2x fa fa-envelope fa-fw'></i> Email :  $store->EMAIL</li>
                                        </ul>

                                  </div>




                                  ";
                                }

                                ?>

                                
                            </div>
                        </div>
                    </div>
                </div>

              

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


<!-- sample modal content -->
                                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Cafeteria Name</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form method="post" id="updateCafeteriaName">
                                                          

                                                           <div class="form-group">
                                                               <input type="text" name="name" class="form-control" placeholder="Cafeteria Name" required="" value="<?php echo $cafeteria->NAME; ?>">
                                                           </div>

                                                           <div class="form-group">
                                                               <input type="text" name="phone" class="form-control" placeholder="Phone Number" required="" value="<?php echo $cafeteria->PHONE; ?>">
                                                           </div>
                                                            <div class="form-group">
                                                               <input type="text" name="address" class="form-control" placeholder="Address" required="" value="<?php echo $cafeteria->ADDRESS; ?>">
                                                           </div>

                                                            <div class="form-group">
                                                               <input type="text" name="email" class="form-control" placeholder="Email Address" value="<?php echo $cafeteria->EMAIL; ?>">
                                                           </div>

                                                           
                                                           <button class="btn btn-danger">Update</button>
                                                       </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->



