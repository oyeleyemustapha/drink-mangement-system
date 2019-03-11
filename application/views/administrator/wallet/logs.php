


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Wallet Transactions</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


          
                <div class="row">
                   

                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                

                                <div class="table-responsive col-lg-8 offset-lg-2">

                                  <?php

                                  

                                    if($log){

                                      echo"<h3 class='text-center'>Wallet Transaction History for Wallet ".$log[0]->WALLET_NUMBER."</h3>";

                                      echo'<br><table class="walletlog table table-striped table-hover">
                                    <thead>
                                      <tr>
                                        <th>ID</th>
                                        <th>AMOUNT</th>
                                        <th>TYPE</th>
                                        <th>DATE</th>
                                      </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;

                                    foreach ($log as $log) {
                                      if($log->TYPE=="Credit"){
                                        $status="<span class='badge badge-success'>Credit</span>";
                                      }
                                      else{
                                        $status="<span class='badge badge-danger'>Debit</span>";
                                      }
                                      echo"
                                        <tr>
                                        <td>$counter</td>
                                        <td>".number_format($log->AMOUNT)."</td>
                                        <td>$status</td>
                                        <td>".date('F d, Y', strtotime($log->DATE))."</td>
                                      </tr>
                                      ";
                                      $counter++;
                                    }



                                    echo'</tbody>
                                  </table>';

                                    }


                                  ?>
                                  


                                  
                                      
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

              

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


