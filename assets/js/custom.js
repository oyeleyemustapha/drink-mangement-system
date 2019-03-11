$(document).ready(function(){

	 var base_url=location.protocol+"//"+location.host+"/drinks/";
 
	 $('.date').datepicker({
	 	format:'MM dd, yyyy',
	 	autoclose: true
	 });

	 $('.month').datepicker({
	 	format:'MM yyyy',
	 	autoclose: true
	 });




  //=========================
  //=========================
  //====STORE SETTINGS
  //=========================
  //=========================
  
  //UPDATE STORE SETTINGS
  $('#updateStoreSettings').submit(function(){
    $.post( 
      base_url+"update-store-setting", 
      $(this).serialize(), 
        function(data){
          $('#myModal').modal('hide');
            $.notify({
              message: data
            },{         
              type: "success",
              onClose:function(){
                location.reload();
              }        
            }); 
        }
    );
      $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
      $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
      return false;          
  });


  //=======================
  //=======================
  //LOGIN LOGS
  //=======================
  //=======================

    STAFF_LOGS();
    function STAFF_LOGS(){
      //STAFF LOGS
      $('.logDiv').load(base_url+'fetchLogs', function(){
        $('.log').DataTable();
      });
    }

    //PURGE LOGS
    $('.deleteRecord').click(function(){
      swal({
        title: 'Are you sure of this ?',
        text: "You can't be reverted!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D62C1A',
        cancelButtonColor: '#2C3E50',
        confirmButtonText: 'Yes, delete it!'
      }).then(function () {

            $.post( 
                  base_url+"purge-staff-logs", 
                  {action:'purge'}, 
                  function(data){
                      
                       $.notify({
                          message: data
                      },{
                          
                          type: "success",
                         
                      }); 
                       STAFF_LOGS();
                  }
              );
               $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
               $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
               return false;
      });                  
    });


   

  //=======================
  //=======================
  //STAFF
  //=======================
  //=======================

   function staff(){
      //STAFF
      var staff_cb=function(){
         $('.staffList').DataTable({
              "drawCallback": function( settings ) {


                  //DELETE STAFF
                  $('.deleteStaff').click(function(){
                      var staff_id=$(this).attr('id');

                          swal({
                              title: 'Are you sure of this ?',
                              text: "You can revert this later!",
                              type: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#D62C1A',
                              cancelButtonColor: '#2C3E50',
                              confirmButtonText: 'Yes, delete it!'
                          }).then(function () {
                              $.post( 
                                  base_url+"delete-staff", 
                                  {staff_id:staff_id}, 
                                  function(data){

                                    if(data=="Staff's  Record has been deleted"){
                                      swal({
                                        title: 'Deleted!',
                                        text: data,
                                        type: 'success',
                                        timer:3000,
                                        showConfirmButton:false,
                                        onClose:function(){
                                            staff();
                                        }
                                      });
                                    }
                                    else{
                                      swal({
                                        title: 'Error!',
                                        text: data,
                                        type: 'warning',
                                        timer:3000,
                                        showConfirmButton:false
                                      });
                                    }
                                }
                              );
                            $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                           $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
                             
                          }); 
                  });


                  //EDIT STAFF
                  $('.editStaff').click(function(){
                        $.post( 
                            base_url+"fetch-staff", 
                            {staff_id:$(this).attr('id')}, 
                            function(data){
                              $('#staffInfoModal').modal('show');
                              $('#staffInfoModal .modal-body').html(data);

                                
                              //UPDATE STAFF
                              $('#updateStaffForm').submit(function(){
                                        $.post( 
                                            base_url+"update-staff", 
                                            $(this).serialize(), 
                                            function(data){
                                                $('#staffInfoModal').modal('hide');
                                                 $.notify({
                                                    message: data
                                                },{
                                                    
                                                    type: "success",
                                                   
                                                }); 

                                                 staff();
                                            }
                                        );
                                         $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                                         $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
                                         return false;          
                                }); 
                            }
                        );
                    $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                    $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});       
                  });
             }

        });
      }
      $('.staffListDiv').load(base_url+'staff-list', staff_cb);
   }

    staff();
  	//ADD STAFF
  	$('#addStaffForm').submit(function(){
              $.post( 
                  base_url+"add-staff", 
                  $(this).serialize(), 
                  function(data){
                      $('#myModal').modal('hide');
                        $.notify({
                          message: data
                        },{
                            
                            type: "success",
                           
                        }); 
                        staff();
                  }
              );
               $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
               $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
               return false;          
    });

  

  //=========================
  //=========================
  //====DRINKS STOCK
  //=========================
  //=========================

  

  $('.stockToggle').click(function(){

     $('.stock').load(base_url+'drinks-to-stock', function(){
        
        //ADD DRINKS TO STOCK
        $('#addStockForm').submit(function(){
          $.post( 
            base_url+"add-drink-stock", 
            $(this).serialize(), 
            function(data){
              $.notify({
                message: data
              },{
                type: "success",          
              }); 
              $('#addStockForm')[0].reset();
              drinkStock();
              drinksToallocate();
            }
          );
          $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
          $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
          return false;          
        });
     });

  });

  
  function drinkStock(){
    $('.Drinkstock').load(base_url+'fetch-drinks-in-stock');
  }
  drinkStock();

  drinksToallocate();
  function drinksToallocate(){
    $('.allocateDrink').load(base_url+'fetch-drinks-to-allocate', function(){

      //ALLOCATE DRINK TO STAFF
        $('#allocateDrinks').submit(function(){
          $.post( 
            base_url+"allocate-drinks", 
            $(this).serialize(), 
            function(data){
              $.notify({
                message: data
              },{
                type: "success",          
              }); 
              $('#allocateDrinks')[0].reset();
              drinkStock();
              drinksToallocate();
            }
          );
          $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
          $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
          return false;          
        });

    });
  }

   $('.stockDiv').load(base_url+'drink-stock-log', function(){
    $('.stocklog').DataTable();
   });

  


  //=========================
  //=========================
  //====DRINKS
  //=========================
  //=========================

  //ADD DRINKS
  $('#addDrinkForm').submit(function(){
    $.post( 
      base_url+"add-drink", 
      $(this).serialize(), 
      function(data){
        $.notify({
          message: data
        },{
          type: "success",          
        }); 
        $('#addDrinkForm')[0].reset();
        drinks();
      }
    );
    $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
    $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
    return false;          
  });


  drinks();
  function drinks(){
    var drink_cb=function(){
    $('.drinkList').DataTable({
        
         "drawCallback": function( settings ) {

              //EDIT DRINK
              $('.editDrink').click(function(){
                    $.post( 
                        base_url+"fetch-drink", 
                        {product_id:$(this).attr('id')}, 
                        function(data){
                          $('#productInfoModal').modal('show');
                          $('#productInfoModal .modal-body').html(data);

                            
                          //UPDATE DRINK
                          $('#updateDrinkForm').submit(function(){
                                    $.post( 
                                        base_url+"update-drink", 
                                        $(this).serialize(), 
                                        function(data){
                                            $('#productInfoModal').modal('hide');
                                             $.notify({
                                                message: data
                                            },{
                                                
                                                type: "success",
                                               
                                            }); 

                                            drinks();
                                        }
                                    );
                                     $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                                     $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
                                     return false;          
                            }); 
                        }
                    );
                $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});       
              });
        }

    });
  }
    $('.drinkListDiv').load(base_url+'fetch-drinks', drink_cb);
  }

	//=========================
	//=========================
	//====PRODUCTS
	//=========================
	//=========================

  products();
  function products(){
    var product_cb=function(){
    $('.productList').DataTable({
        
         "drawCallback": function( settings ) {

              //EDIT PRODUCT INFO
              $('.editProduct').click(function(){
                    $.post( 
                        base_url+"fetchProductInfo", 
                        {product_id:$(this).attr('id')}, 
                        function(data){
                          $('#productInfoModal').modal('show');
                          $('#productInfoModal .modal-body').html(data);

                            
                          //UPDATE PRODUCT INFOMATION
                          $('#updateproductForm').submit(function(){
                                    $.post( 
                                        base_url+"updateProductInfo", 
                                        $(this).serialize(), 
                                        function(data){
                                            $('#productInfoModal').modal('hide');
                                             $.notify({
                                                message: data
                                            },{
                                                
                                                type: "success",
                                               
                                            }); 

                                            products();
                                        }
                                    );
                                     $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                                     $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
                                     return false;          
                            }); 
                        }
                    );
                $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});       
              });
        }

    });
  }
  $('.productListDiv').load(base_url+'fetchProductList', product_cb);
  }
	
	//ADD PRODUCT
	$('#addProductForm').submit(function(){
            $.post( 
                base_url+"addProduct", 
                $(this).serialize(), 
                function(data){
                    $('#myModal').modal('hide');
                     $.notify({
                        message: data
                    },{
                        
                        type: "success",
                       
                    }); 


                    $('#addProductForm')[0].reset();
                    products();
                }
            );
             $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
             $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
             return false;          
  });


	  //FETCH PRODUCT LIST TO BE USED FOR SELECT2 PLUGIN
    $("#productsSelect").select2({
        placeholder: "Type Product Name",
        allowClear: true, 
        theme: "classic",
        width: '100%',
        //FETCH SUBJECT FROM THE DATABASE
        ajax: {
                url: base_url+"productListSelect",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
        },
        minimumInputLength: 3
    });

  //=========================
  //=========================
  //====SALES PRODUCTS
  //=========================
  //=========================

    //ADD SALES PRODUCTS
	$('#addsalesProductForm').submit(function(){
            $.post( 
                base_url+"addSalesProducts", 
                $(this).serialize(), 
                function(data){
                    $('#myModal').modal('hide');
                     $.notify({
                        message: data
                    },{
                        
                        type: "success",
                       
                    }); 


                    $('#addsalesProductForm')[0].reset();
                    $("#productsSelect").empty().trigger('change')
                    $('.salesproductListDiv').load(base_url+"fetchSalesProductsCurrent", salesProductList_cb);
                }
            );
             $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
             $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
             return false;          
    });


  //GENERATE SALES PRODUCTS LIST FOR A PARTICULAR DATE
	$('#generateSalesproducts').submit(function(){
            $.post( 
                base_url+"fetchSalesProducts", 
                $(this).serialize(), 
                function(data){
                    $('#myModal2').modal('hide');
                    $('.salesproductListDiv').html(data);
                }
            );
             $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
             $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
             return false;          
    });



	var salesProductList_cb=function(){

		
			//EDIT PRODUCT INFO
              $('.editSalesProduct').click(function(){
                    $.post( 
                        base_url+"salesProductInfo", 
                        {id:$(this).attr('id')}, 
                        function(data){
                        	$('#productInfoModal').modal('show');
                        	$('#productInfoModal .modal-body').html(data);

                        	  
                        	//UPDATE SALES PRODUCT INFOMATION
							$('#updateSalesproductForm').submit(function(){
						            $.post( 
						                base_url+"updateSalesProduct", 
						                $(this).serialize(), 
						                function(data){
						                    $('#productInfoModal').modal('hide');
						                     $.notify({
						                        message: data
						                    },{
						                        
						                        type: "success",
						                       
						                    }); 

						                    $('.salesproductListDiv').load(base_url+"fetchSalesProductsCurrent", salesProductList_cb);
						                }
						            );
						             $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
						             $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
						             return false;          
						    });	
                        }
                    );
                $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});       
              });
    };
    $('.salesproductListDiv').load(base_url+"fetchSalesProductsCurrent", salesProductList_cb);


  



  $('.reports').load(base_url+"dailySalesReport",function(){});


    //SALES
     $("#staff-List").select2({
        placeholder: "Type Staff Name",
        allowClear: true, 
        theme: "classic",
        width: '100%',
        minimumInputLength: 3
    });


     $('.SearchSalesRecord').keyup(function(){
  
     	if($('.SearchSalesRecord').val().length==6){


			            $.post( 
			                base_url+"search-sales", 
			                {search:$('.SearchSalesRecord').val()}, 
			                function(data){
			                    $('#myModal3').modal('hide');
			                    $('.reports').html(data);

                          //CANCEL SPECIFIC PRODUCT ORDER
                          $('.cancel-single-order').click(function(){
                              var sales_id=$(this).attr('id');

                                swal({
                                    title: 'Are you sure of this ?',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#D62C1A',
                                    cancelButtonColor: '#2C3E50',
                                    confirmButtonText: 'Cancel!'
                                }).then(function () {
                                      $.post( 
                                        base_url+"cancel-product-order", 
                                        {sales_id:sales_id}, 
                                        function(data){
                                            swal({
                                              title: 'Order Cancelled',
                                              text: data,
                                              type: 'success',
                                              timer:3000,
                                              showConfirmButton:false
                                            });  
                                        });
                                      });
                                  $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                                  $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});   
                          });

								        //CANCEL ALL ORDER
					              $('.CancelOrderall').click(function(){
					                  var order_no=$(this).attr('id');

					                      swal({
					                          title: 'Are you sure of this ?',
					                          text: "You can revert this later!",
					                          type: 'warning',
					                          showCancelButton: true,
					                          confirmButtonColor: '#D62C1A',
					                          cancelButtonColor: '#2C3E50',
					                          confirmButtonText: 'Cancel!'
					                      }).then(function () {
					                          $.post( 
					                              base_url+"cancel-all-orders", 
					                              {order_no:order_no}, 
					                              function(data){

					                  
					                              		swal({
					                                    title: 'Order Cancelled',
					                                    text: data,
					                                    type: 'success',
					                                    timer:3000,
					                                    showConfirmButton:false,
					                                    onClose:function(){
					                                       
					                                    }
					                                  });
					                              	
					                            }
					                          );
					                        $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
					                       $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
					                         
					                      }); 
					              });
			                }
			            );
			             $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
			             $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
			             return false;          
     	}
     });




    


 
   


});

