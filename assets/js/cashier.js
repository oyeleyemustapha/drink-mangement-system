$(document).ready(function(){

	 var base_url=location.protocol+"//"+location.host+"/cafeteria/cashier/";
	 

myOrder="";
    
	var sales_product_cb=function(){
		   
        $('.resetOrder').click(function(){
          location.reload();
        });
      $('.Selectproduct').click(function(){
        $('.resetOrder, .submitOrder').show();

        var quantity=$(this).attr('data-quantity')-1; //REDUCE THE QUANTITY



        $(this).attr("data-quantity", quantity);
        $(this).children('span').text(quantity);
         var sales_order=parseInt($(this).attr('data-order'))+1;
         $(this).attr("data-order", sales_order);
         var sales_price=parseInt($(this).attr('data-price'));
         var amount= sales_order * sales_price;
         var product=$(this).attr('data-product-id');
         var customer_orders=$('.orders').attr('data-customerOrders');
         customer_orders="<tr class='label customerOrders'><td class='productName customerProduct' data-product-id='"+product+"'>"+$(this).attr('data-label')+"</td>";
         customer_orders+="<td class='customerQty'>"+sales_order+"</td>";
         customer_orders+="<td class='total_amt'>"+amount+"</td></tr>";
         
        

         $('.orders').attr("data-customerOrders", customer_orders);

          if($("tr.label:contains('"+$(this).attr('data-label')+"')" ).length>0){
            $("tr.label:contains('"+$(this).attr('data-label')+"')" )[$("tr.label:contains('"+$(this).attr('data-label')+"')" ).length-1].remove();
          }

          
         $('.orders tbody').append($('.orders').attr("data-customerOrders"));


         var total_amt=parseInt($('.total').attr('data-totalAMount'));
         total_amt+=sales_price;
         $('.total').attr('data-totalAMount', total_amt);
         $('.total').text($('.total').attr('data-totalAMount'));

         if(quantity==0){
          $(this).attr('disabled', true);
        }


     });
	}
	$('.salesProduct').load(base_url+'fetch_sales_product_list', sales_product_cb);


  $('.paymentType').click(function(){
    if($(this).val()=="Wallet"){  
      let form='<div class="form-group"><select name="walletNumber" class="form-control walletSelect" required><option value="">Type Wallet Number</option></select></div>';
      $('.addForm').html(form);
      walletSelect();
    }
    else{
      $('.addForm').html('');
    }
  });

    walletSelect();
    function walletSelect(){
      //FETCH WALLET LIST TO BE USED FOR SELECT2 PLUGIN
      $(".walletSelect").select2({
          placeholder: "Type Wallet Number",
          allowClear: true, 
          theme: "classic",
          width: '100%',
          ajax: {
                  url: base_url+"get_wallet_list_plugin",
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
    }
    

	 //SUBMITY CUSTOMER ORDERS
    $('.submitOrder').click(function(){

      let paymentType=$('.paymentType').val();


      let wallet=$('.walletSelect').val();
      swal({
            title: 'Are you sure this ?',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#D62C1A',
            cancelButtonColor: '#2C3E50',
            confirmButtonText: 'Confirm Order'
          }).then(function () {
              order_array=[];
        $( "tr.customerOrders" ).each(function( index ) {
          var product_ordered=$(this).children('.customerProduct').attr('data-product-id');
          var quantity_ordered=$(this).children('.customerQty').text();
          var amount=$(this).children('.total_amt').text();
          order_array[index]={
                "product":product_ordered,
                "quantity":quantity_ordered,
                "amount":amount,
                "paymentType": paymentType,
                "wallet": wallet
              } 
          Orders={
            "customerOrders":order_array
          }
          Orders=JSON.stringify(Orders);
          Orders=JSON.parse(Orders);
        });

        console.log(Orders);
          
        $.post( 
          base_url+"submitOrders", 
          Orders, 
          function(data){


            if(data=="You don't  have enough your wallet for this transaction"){
              alert(data);
            }
            else{
              var link=base_url+"get_order_info/"+data;
              var options="menubar=yes, location=no width=360, height=200, resizable=no, status=no";
              window.open(link, 'Meal Ticket', options);
              $('.total').attr('data-totalAMount', 0);
              $('.total').text($('.total').attr('data-totalAMount'));
              cashierSales();
              orders_made_by_cashier();
              $( "tbody tr" ).detach();
              $('.salesProduct').load(base_url+'fetch_sales_product_list', sales_product_cb);

              
              $('.addForm').empty();
            }
            
          });  
        });
        
    });


    //QUERY SALES RECORD
    $('.query').keyup(function(){
        if($(this).val().length=='6'){
             $.post( 
                base_url+"query_sales_record", 
                {query: $(this).val()}, 
                function(data){
                  $('.query').val('');
                  $('.queryResult').html(data);
            });
              $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
              $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
        }
    });


    //FETCH CAHSIER CURRENT SALES 
    cashierSales();
    function cashierSales(){
      $('.currentSales').load(base_url+"cashier_current_sales");
    }
    orders_made_by_cashier();
    function orders_made_by_cashier(){
      $('.currentOrder').load(base_url+"staff_orders_no");
    }
	

    //UPDATE PASSWORD
    $('#updatePassword').submit(function(){
      $.post( 
        base_url+"update_password", 
       $(this).serialize(), 
        function(data){
          $('#updatePassword')[0].reset();
          $('.msg').html('<h3 class="text-center">'+data+'</h3>');
        });
        $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
        $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
        return false;
    });


    //===========================
    //===========================
    //CHANGE
    //===========================
    //===========================

    //GENERATE PIN
    $('#generatePinform').submit(function(){
      $.post( 
        base_url+"generatePin", 
       $(this).serialize(), 
        function(data){
          change_summary();
           unpaidChange();
          $('#myModal1').modal('hide');
          $('#generatePinform')[0].reset();
          $('.pingenerated').html(data);

           var link=base_url+"get_pin/"+data;
            var options="menubar=yes, location=no width=350, height=250, resizable=no, status=no";
            window.open(link, 'Pin', options);
        });
        $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
        $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
        return false;
    });



    //QUERY SALES CHANGE PIN
    $('.SearchPin').keyup(function(){
        if($(this).val().length=='6'){
             $.post( 
                base_url+"get_pin_info", 
                {pin: $(this).val()}, 
                function(data){
                  $('.SearchPin').val('');
                  $('.pinResult').html(data);

                  payChange();
            });
              $(document).ajaxSend(function(event, xhr, settings) {$(".preloader").fadeIn();});
              $(document).ajaxComplete(function(event, xhr, settings) {$(".preloader").fadeOut();});
        }
    });


    

function payChange(){
  $('.payChange').click(function(){
    var pin_id=$(this).attr('id');
    $.post( 
      base_url+"pay_change", 
      {pin_id:pin_id}, 
      function(data){

        $('#payChangeModal').modal();
        $('#payChangeModal .modal-body').html(data);

        //PAY UP CHANGE
        $('#PayChangeForm').submit(function(){
          $.post( 
            base_url+"payUp", 
           $(this).serialize(), 
            function(data){
              $('#payChangeModal').modal('hide');
              change_summary();
              unpaidChange();
              swal({
                title: 'Change Paid',
                text: data,
                type: 'success',
                timer:3000,
                showConfirmButton:false
              }); 
            });
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
	
  // FETCH CHANGE SUMMARY
  change_summary();
  function change_summary(){
  $('.summary').load(base_url+'change_summary');
   }

    //FETCH LIST OF UNPAID CHANGE
    function unpaidChange(){
      $('.unpaidChange').load(base_url+'list_upaid_change',change_cb);
    }

  var change_cb=function(){
    $('.changeList').DataTable({
         "drawCallback": function( settings ) {
          payChange();
        }
    });
  }

  unpaidChange();         
  

 





  
    


    
	
   


});