$(document).ready(function(){

	 var base_url=location.protocol+"//"+location.host+"/drinks/supervisor/";
 
	 $('.date').datepicker({
	 	format:'MM dd, yyyy',
	 	autoclose: true
	 });

	 $('.month').datepicker({
	 	format:'MM yyyy',
	 	autoclose: true
	 });

$('.reportTable').DataTable();
  function disbleBtn(Selector){
      $(Selector).prop('disabled', true);
  }

  function enableBtn(Selector){
      $(Selector).prop('disabled', false);
  }



  //UPDATE PROFILE
  $('#updateProfile').submit(function(){
    $.post( 
      base_url+"update_profile", 
      $(this).serialize(), 
        function(data){
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
  //STAFF
  //=======================
  //=======================

   function staff(){
      //STAFF
      var staff_cb=function(){
         $('.staffList').DataTable({
              "drawCallback": function( settings ) {

                  //EDIT STAFF
                  $('.editStaff').click(function(){
                        $.post( 
                            base_url+"fetch_staff_info", 
                            {staff_id:$(this).attr('id')}, 
                            function(data){
                              $('#staffInfoModal').modal('show');
                              $('#staffInfoModal .modal-body').html(data);

                                
                              //UPDATE STAFF
                              $('#updateStaffForm').submit(function(){
                                        $.post( 
                                            base_url+"update_staff", 
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
      $('.staffListDiv').load(base_url+'fetch_staff_list', staff_cb);
   }

    staff();
  	//ADD STAFF
  	$('#addStaffForm').submit(function(){
              $.post( 
                  base_url+"add_staff", 
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
                        base_url+"fetch_product_info", 
                        {product_id:$(this).attr('id')}, 
                        function(data){
                          $('#productInfoModal').modal('show');
                          $('#productInfoModal .modal-body').html(data);

                            
                          //UPDATE PRODUCT INFOMATION
                          $('#updateproductForm').submit(function(){
                                    $.post( 
                                        base_url+"update_product_info", 
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
  $('.productListDiv').load(base_url+'fetch_product_list', product_cb);
  }
	
	//ADD PRODUCT
	$('#addProductForm').submit(function(){
            $.post( 
                base_url+"add_product", 
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
             $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn(); disbleBtn('.addProductBtn');});
             $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut(); enableBtn('.addProductBtn')});
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
  //====DRINKS STOCK
  //=========================
  //=========================

  $('.stockToggle').click(function(){
     $('.stock').load(base_url+'fetchDrinktoStock', function(){
        //ADD DRINKS TO STOCK
        $('#addStockForm').submit(function(){
          $.post( 
            base_url+"add_drinks_stock", 
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
          $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn(); disbleBtn('.addStockBtn')});
          $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut(); enableBtn('.addStockBtn')});
          return false;          
        });
     });

  });

  
  function drinkStock(){
    $('.Drinkstock').load(base_url+'fetchDrinksStock', function(){
      $('.stockList').DataTable();
    });
  }
  drinkStock();

  //=========================
  //=========================
  //====SALES
  //=========================
  //=========================

    $('#staff-List1').change(function(){
      $.post( 
          base_url+"fetch_allocated_stock", 
          {staff:$(this).val()}, 
          function(data){
             $('.allocatedProducts').html(data); 

             //CHECK IF LEFTOVER IS NOT MORE THAN THE INITIAL STOCK
             $('.leftOverform').keyup(function(){

              if($(this).val().length>=2){

                let leftover=Number($(this).val());
                let initial_stock=$(this).attr('data-initial-stock');

                if(leftover>initial_stock){
                     $.notify({
                          message: "Inputted leftover can't be more than the Initial stock"
                      },{
                          
                          type: "success"
                      });  

                       $(this).val('');     
                }
              }
             })                         
          }
      );
        $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
        $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
        return false;          
    });



    $('#PostSales').submit(function(){
        let salesdata= $(this).serialize();

      swal({
        title: 'Are you sure of this?',
        text: "Cross Check Sales before posting it !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D62C1A',
        cancelButtonColor: '#2C3E50',
        confirmButtonText: 'Post it'
      }).then(function () {

        $.post( 
          base_url+"post_sales", 
          salesdata, 
            function(data){
                 $.notify({
                          message: data
                      },{
                          
                          type: "success",
                          onClose: function(){
                            $('.allocatedProducts').html('');
                          }
                         
                      });            
            }
        );
          $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn(); disbleBtn('.PostSales')});
          $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut(); enableBtn('.PostSales')});
      });
                              
         $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn(); disbleBtn('.PostSales')});
          $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut(); enableBtn('.PostSales')});
        return false;          
    });



    


 
   


});

