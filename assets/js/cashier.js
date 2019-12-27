$(document).ready(function(){

	 var base_url=location.protocol+"//"+location.host+"/drinks/cashier/";
 
	 $('.date').datepicker({
	 	format:'MM dd, yyyy',
	 	autoclose: true
	 });

	 $('.month').datepicker({
	 	format:'MM yyyy',
	 	autoclose: true
	 });


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

	//=========================
	//=========================
	//====PRODUCTS
	//=========================
	//=========================

  products();
  function products(){
    var product_cb=function(){
    $('.productList').DataTable();
  }
  $('.productListDiv').load(base_url+'fetch_product_list', product_cb);
  }
	
  //=========================
  //=========================
  //====DRINKS STOCK
  //=========================
  //=========================

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
  $('.salesTable').DataTable();

  $('.allocatedProducts').load(base_url+'fetch_allocated_stock',function(){
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
  });

    //POST SALES FOR THE DAY
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
           $(document).ajaxSend(function(event, xhr, settings) {$("#preloader").fadeIn(); disbleBtn('.PostSales');});
          $(document).ajaxComplete(function(event, xhr, settings) {$("#preloader").fadeOut(); enableBtn('.PostSales');});
      });
                              
        $(document).ajaxSend(function(event, xhr, settings) {$("#preloader").fadeIn(); disbleBtn('.PostSales');});
          $(document).ajaxComplete(function(event, xhr, settings) {$("#preloader").fadeOut(); enableBtn('.PostSales');});
        return false;          
    });



    //=========================
  //=========================
  //====EXPENSES
  //=========================
  //=========================

  //ADD EXPENSES
  $('#expensesForm').submit(function(){
          $.post( 
            base_url+"add_expenses", 
            $(this).serialize(), 
            function(data){
              $.notify({
                message: data
              },{
                type: "success", 
                z_index:9999         
              }); 
              $('#expensesForm')[0].reset();
               expenses();
            }
          );
          $(document).ajaxSend(function(event, xhr, settings) {$("#preloader").fadeIn();});
          $(document).ajaxComplete(function(event, xhr, settings) {$("#preloader").fadeOut();});
          return false;          
        });


  expenses();
  function expenses(){
    $('.expensesDiv').load(base_url+'fetch_expenses', function(){
      $('.expensesTable').DataTable({
         "drawCallback": function( settings ) {


          //DELETE EXPENSE
          $('.deleteExpenses').click(function(){
            var expense_id=$(this).attr('id');
            swal({
              title: 'Are you sure of this ?',
              text: "This can't be reverted!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#D62C1A',
              cancelButtonColor: '#2C3E50',
              confirmButtonText: 'Yes, delete it!'
            }).then(function () {

              $.post( 
                  base_url+"delete_expense", 
                  {expense_id:expense_id}, 
                  function(data){
                      $.notify({
                          message: data
                      },{
                        type: "success" 
                      }); 
                      expenses();
                  }
              );
              $(document).ajaxSend(function(event, xhr, settings) {$("#preloader").fadeIn();});
              $(document).ajaxComplete(function(event, xhr, settings) {$("#preloader").fadeOut();});    
            });   
          });

          //EDIT EXPENSES
          $('.editExpenses').click(function(){
                    $.post( 
                        base_url+"fetch_expense", 
                        {expense_id:$(this).attr('id')}, 
                        function(data){
                          $('#modal-id2').modal('show');
                          $('#modal-id2 .modal-body').html(data);

                            
                          //UPDATE EXPENSE
                          $('#UpdateExpensesForm').submit(function(){
                                    $.post( 
                                        base_url+"update_expense", 
                                        $(this).serialize(), 
                                        function(data){
                                           $('#modal-id2').modal('hide');
                                             $.notify({
                                                message: data
                                            },{
                                                
                                                type: "success",
                                               
                                            }); 

                                            expenses();
                                        }
                                    );
                                     $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
                                     $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
                                     return false;          
                            }); 
                        }
                    );
                $(document).ajaxSend(function(event, xhr, settings) {$("#preloader").fadeIn();});
                $(document).ajaxComplete(function(event, xhr, settings) {$("#preloader").fadeOut();});       
              });

        }
      });
    });
  }


 
   


});

