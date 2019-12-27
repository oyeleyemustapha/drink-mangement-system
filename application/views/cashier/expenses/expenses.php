


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Expenses</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


          
                <div class="row">
                   

                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <button class="btn btn-primary mb-3" data-toggle="modal" href='#modal-id'>Add Expenses</button>

                                <div class="expensesDiv table-responsive"></div>
                                
                                
                               
                            </div>
                        </div>
                    </div>
                </div>

              

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->



<div id="modal-id" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Add Expenses</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <form method="post" autocomplete="off" id="expensesForm">
                                                          <div class="form-group">
                                                            <label>Title</label>
                                                              <input type="text" name="title" class="form-control form-control-lg" required="" autocomplete="off">
                                                          </div>

                                                          <div class="form-group">
                                                            <label>Amount</label>
                                                              <input type="number" name="amount" class="form-control form-control-lg" required="" autocomplete="off">
                                                          </div>

                                                         

                                                          <div class="form-group">
                                                            <label>Date</label>
                                                              <input type="date" name="date" class="form-control form-control-lg" required="" autocomplete="off">
                                                          </div>

                                                          <div class="form-group">
                                                            <label>Description</label>
                                                              <textarea name="description" class="form-control" autocomplete="off"></textarea>
                                                          </div>

                                                          <button class="btn btn-primary">Add</button>


                                                      </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->



<div id="modal-id2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Expense Information</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                     
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
