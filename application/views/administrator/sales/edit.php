<?php

if($products){
    echo'
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>PRODUCT</th>
            <th>STOCK</th>
            <th>LEFT OVER</th>
        </tr>
    </thead>
 <tbody>
    ';

    $counter=1;
    foreach ($sales as $product) {
        $stock=$product->QUANTITY+$product->ADDED_STOCK;
        $quantityRemain=$stock-$product->QUANTITY_SOLD;
        echo"

        <tr>
            <td>$counter</td>
            <td>$product->PRODUCT_NAME</td>
            <td>$stock</td>
            <td>
            <input type='hidden' name='product[]' value='$product->PRODUCT_ID'>
            <input type='hidden' name='sales_price[]' value='$product->SALES_PRICE'>
            <input type='hidden' name='cost_price[]' value='$product->COST_PRICE'>
            <input type='hidden' name='initial_stock[]' value='$stock'>
            <input type='number' class='form-control form-control-lg leftOverform' name='leftOver[]' data-initial-stock='$stock' value='$quantityRemain' required>



            </td>
        </tr>


        ";

        $counter++;
    }



    echo'

</tbody>
</table>
<button class="btn btn-danger PostSales">Update</button>

    ';
}


?>

    