<?php
echo'

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>'.$title.' | Drinks Management System</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="'.base_url().'assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'assets/css/icons.css" rel="stylesheet" type="text/css" />
         <link href="'.base_url().'assets/plugins/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
         <link href="'.base_url().'assets/css/animate.css" rel="stylesheet" type="text/css" />
         <link href="'.base_url().'assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
         <link href="'.base_url().'assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
         <link href="'.base_url().'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'assets/css/style.css" rel="stylesheet" type="text/css" />
    </head>


    <body>

        <!-- Loader -->
         <!-- Loader -->
        <div id="preloader" class="preloader">
        <h2 class="text-center" style="margin-top: 20%;"><i class="fa fa-spinner fa-spin fa-2x"></i><br> Please Wait</h2>

        </div>


        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                   


                    <div class="menu-extras topbar-custom">

                        

                        <ul class="list-inline float-right mb-0">
                            
                           
                            <!-- User-->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="'.base_url().'assets/images/user.png" alt="user" class="rounded-circle">

                                    '.$_SESSION["name"].'
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                                <a class="dropdown-item" href="'.base_url().'supervisor/profile"><i class="dripicons-user text-muted"></i> Profile</a>
                                
                                    
                                   <a class="dropdown-item" href="'.base_url().'logout"><i class="dripicons-exit text-muted"></i> Logout</a>
                                </div>
                            </li>
                            <li class="menu-item list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>
                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">



                            <li class="has-submenu">
                                <a href="'.base_url().'supervisor"><i class="ti-home"></i>Dashboard</a>
                            </li>

                            <li class="has-submenu">
                                <a href="'.base_url().'supervisor/products"><i class="ti-money"></i>Products</a>
                            </li>

                            <li class="has-submenu">
                                <a href="'.base_url().'supervisor/stock"><i class="ti-shopping-cart-full"></i>Stock</a>
                            </li>

                            <li class="has-submenu">
                                <a href="'.base_url().'supervisor/sales"><i class="ti-pencil"></i>Post Closing Stock</a>
                            </li>

                            <li class="has-submenu">
                                <a href="'.base_url().'supervisor/expenses"><i class="ti-money"></i>Expenses</a>
                            </li>

                            <li class="has-submenu">
                                <a href="'.base_url().'supervisor/reports"><i class="ti-bar-chart"></i>Reports</a>
                            </li>

                           

                            

                        </ul>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
';
?>