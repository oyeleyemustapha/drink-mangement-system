<?php

if($order){
    echo'


<!doctype html>
<html class="no-js " lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Meal Ticket</title>
<link rel="stylesheet" href="'.base_url().'assets/plugins/bootstrap/css/bootstrap.min.css">
  <link href="'.base_url().'assets/css/style.css" rel="stylesheet" type="text/css" />


  <style>
  body{
  	font-family:arial;
    margin:0px;
    padding:0px;


  }

  .table {

    margin: 0 auto;

}

 



  </style>
</head>
<body class="ticketBody">
<div id="ticketPOS">
    <div class="col-lg-12 salesTicket2">
    <div class="headerTicket">
    <h2 class="text-center">'.$cafeteria->NAME.'</h2>
    <p>'.$cafeteria->ADDRESS.'</p>
    <p>'.$cafeteria->PHONE.', '.$cafeteria->EMAIL.'</p>
    </div>
    <h3><span>ORDER NO : </span>'.$order[0]->ORDER_NO.'</h3>
    <h3><span>CASHIER : </span>'.$order[0]->NAME.'</h3>
    <h3><span>DATE : </span>'.date('F d, Y', strtotime($order[0]->SALES_DATE)).'</h3>
        <table class="table table-bordered table-responsive">
    <thead>
        <tr>
           <th>Qty</th>
            <th style="width:100px;"">Product</th>
            
            <th>Amount</th>
        </tr>
    </thead> <tbody>
    ';
  
    $total_amount=0;
    foreach ($order as $orders) {
        $total_amount+=$orders->AMOUNT;

        echo"

            <tr>
              <td>$orders->QUANTITY_SOLD</td>
                <td>".ucwords($orders->PRODUCT)."</td>
                
                <td>$orders->AMOUNT</td>
                
            </tr>
        ";

       
    }


    echo'
    <tr style="padding:3px;">
    	<td colspan="2"><p class="text-right amt">Amount</p></td>
    	<td>&#8358;'.number_format($total_amount).'</td>
    	<td></td>

    </tr> 


    </tbody></table>



<div id="legalcopy">
						<p class="legal text-center"><strong>Thank you for your patronage!</strong> <br><span>Ticket can only used the same day of purchase.</span> 
						</p>
					</div>


    </div>
    </div>
    <body>



      <script src="'.base_url().'assets/js/jquery.min.js"></script>
        <script src="'.base_url().'assets/js/popper.min.js"></script>

        <script type="text/javascript">

        $(document).ready(function(){
           window.print();
            });
        </script>
    </html>';
}


  
       
   

?>