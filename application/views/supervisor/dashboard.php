


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="mini-stat clearfix bg-white">
                            <span class="mini-stat-icon bg-light"><i class="fa fa-money text-danger"></i></span>
                            <div class="mini-stat-info text-right text-muted">
                                <span class="counter text-danger"> &#8358; <?php echo number_format($dailyReport['SALES']); ?></span>
                                Daily Sales [<?php echo date('F d, Y');?>]
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="mini-stat clearfix bg-info">
                            <span class="mini-stat-icon bg-light"><i class="fa fa-money text-success"></i></span>
                            <div class="mini-stat-info text-right text-white">
                                <span class="counter text-white"><?php echo $dailyOrders; ?> Orders</span>
                                <?php echo date('F d, Y');?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="mini-stat clearfix bg-white">
                            <span class="mini-stat-icon bg-light"><i class="fa fa-money text-warning"></i></span>
                            <div class="mini-stat-info text-right text-muted">
                                <span class="counter text-warning">&#8358; <?php echo number_format($monthReport['SALES']) ; ?></span>
                                Sales for <?php echo date('F');?>
                            </div>
                        </div>
                    </div>
                   
                </div>

                

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


