<?php

if($drinks){
    echo'

    <h3 class="text-center mb-3 mt-2">Drinks for sale on '.date("F d, Y").'</h3>
<br>
        <table class="table table-bordered table-condensed table-hover stockList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>STAFF</th>
                                            <th>PRODUCT</th>
                                            <th>INITIAL STOCK</th>
                                            <th>ADDED STOCK</th>
                                            <th>QUANTITY AVAILABLE</th>
                                            <th>COST PRICE</th>
                                            <th>SALES PRICE</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($drinks as $drink) {
                                        $quantity_available=($drink->QUANTITY+$drink->ADDED_STOCK)-$drink->QUANTITY_SOLD;
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$drink->NAME</td>
                                                <td>$drink->PRODUCT_NAME</td>
                                                <td>$drink->QUANTITY</td>
                                                <td>$drink->ADDED_STOCK</td>
                                                <td>$quantity_available</td>
                                                <td>&#8358; $drink->COST_PRICE</td>
                                                <td>&#8358; $drink->SALES_PRICE</td>
                                
                                            </tr>
                                        ";
                                        $counter++;
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>



    ';
}
else{
    echo'<div class="alert alert-info text-center"><h3>No Record Found</h3></div>';
}



?>