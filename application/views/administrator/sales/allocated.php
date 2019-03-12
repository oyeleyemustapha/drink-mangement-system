<?php

if($products){
    echo'
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>PRODUCT</th>
            <th>INITIAL STOCK</th>
            <th>LEFT OVER</th>
        </tr>
    </thead>
 <tbody>
    ';

    $counter=1;
    foreach ($products as $product) {
        echo"

        <tr>
            <td>$counter</td>
            <td>$product->PRODUCT_NAME</td>
            <td>$product->QUANTITY</td>
            <td>
            <input type='hidden' name='product[]' value='$product->PRODUCT_ID'>
            <input type='hidden' name='sales_price[]' value='$product->SALES_PRICE'>
            <input type='hidden' name='cost_price[]' value='$product->COST_PRICE'>
            <input type='hidden' name='initial_stock[]' value='$product->QUANTITY'>
             <input type='number' class='form-control form-control-lg leftOverform' name='leftover[]' data-initial-stock='$product->QUANTITY'>



            </td>
        </tr>


        ";

        $counter++;
    }



    echo'

</tbody>
</table>

    ';
}


?>

    