<?php

if($product_list){
    echo'

        <table class="table table-bordered table-condensed table-hover productList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PRODUCT</th>
                                            
                                            <th>COST PRICE</th>
                                            <th>SALES PRICE</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($product_list as $product) {
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td><a href='#' class='editProduct' id='$product->PRODUCT_ID'>$product->PRODUCT_NAME</a></td>
                                                <td>&#8358; ".number_format($product->COST_PRICE)."</td>
                                                <td>&#8358; ".number_format($product->SALES_PRICE)."</td>
                                
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