<!DOCTYPE html>
<html>
<head>
    <?php
        echo'
             <title>Sale Sheet for '.date('F d, Y',strtotime($date)).'</title>
            <link href="'.base_url().'assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="'.base_url().'assets/css/style.css" rel="stylesheet" type="text/css" />

        ';


    ?>

    <style type="text/css">
        body, html{
            background: #fff;
        }


        .table>tbody>tr>td,  .table>thead>tr>td {padding: 5px 5px !important;}
        .table-bordered td, .table-bordered th {border: 1px solid #000 !important;}
        .table-bordered thead th {
            border-bottom-width: 2px;
            background: transparent !important;
            color: #000  !important;
            font-weight: 600;
}

.table th {
    padding: 5px !important;}
    </style>
   
</head>
<body>


    <div class="container-fluid">
        <?php


            if($report){
                 echo'
                 <h2 class="text-center">'.strtoupper($cafeteria).'</h2>
                 <hr>

    <h4 class="text-center">Sales Sheet '.date('F d, Y',strtotime($date)).'</h4>

        <table class="table table-bordered table-condensed table-hover productList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PRODUCT</th>
                                            <th>INITIAL STOCK</th>
                                            <th>ADDED STOCK</th>
                                            <th>TOTAL STOCK</th>
                                            <th>QUANTITY SOLD</th>
                                            <th>LEFTOVER</th>
                                            
                                            <th>AMOUNT</th>
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    $total_amt=0;
                                    $total_profit=0;
                                    foreach ($report as $product) {
                                        $leftover=($product->QUANTITY+$product->ADDED_STOCK)-$product->QUANTITY_SOLD;
                                        $total_stock=$product->QUANTITY+$product->ADDED_STOCK;
                                        $cost_price_sum=$product->QUANTITY_SOLD*$product->COST_PRICE;

                                        $amount=$product->QUANTITY_SOLD*$product->SALES_PRICE;

                                        $profit=$amount-$cost_price_sum;
                                        $total_profit+=$profit;
                                        $total_amt+=$amount;
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$product->PRODUCT_NAME</td>
                                                <td>$product->QUANTITY</td>
                                                <td>$product->ADDED_STOCK</td>
                                                <td>$total_stock</td>
                                                <td>$product->QUANTITY_SOLD</td>
                                                <td>$leftover</td>
                                                
                                                <td>&#8358; ".number_format($amount)."</td>
                                               
                                            </tr>
                                        ";
                                        $counter++;
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>

                                <h5>TOTAL AMOUNT : &#8358; '.number_format($total_amt).' </h5>
                       




    ';
            }
            else{
                echo'<br><br><br><div class="alert alert-info">

                <h1 class="text-center">No Record found</h1>   
                </div>';
            }


        ?>
       
                
    </div>

</body>
</html>