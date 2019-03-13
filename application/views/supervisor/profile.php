


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Profile</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


          
                <div class="row">
                   

                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">

                                 
                                </h4>

                               
                                <?php

                                if($profile){
                                  echo "
                                 
                                  <h2 class='text-center'>My Profile</h2>
                                  <div class='col-lg-8 offset-lg-2'>
                                        <form method='post' id='updateProfile'>
                                          <div class='form-group'>
                                            <label>Name</label>
                                            <input type='text' class='form-control form-control-lg' name='name' value='$profile->NAME' required>
                                          </div>

                                           <div class='form-group'>
                                            <label>Username</label>
                                            <input type='text' class='form-control form-control-lg' name='username' value='$profile->USERNAME' required>
                                          </div>

                                           <div class='form-group'>
                                            <label>Password</label>
                                            <input type='password' class='form-control form-control-lg' name='password'  required>
                                          </div>

                                          <div class='form-group'>
                                            <label>Confirm Password</label>
                                            <input type='password' class='form-control form-control-lg' name='cpassword'  required>
                                          </div>

                                          <button class='btn btn-danger'>Update</button>
                                        </form>
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


