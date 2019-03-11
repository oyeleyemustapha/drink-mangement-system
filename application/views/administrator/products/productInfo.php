<?php

if($product){
    echo'
    <form method="post" id="updateproductForm">
      <input type="hidden" name="product_id" value="'.$product->PRODUCT_ID.'">
      <div class="form-group">
                                                               <input type="text" name="product" class="form-control" placeholder="Product Name" required="" value="'.$product->PRODUCT_NAME.'">
                                                           </div>

                                                          

                                                           <div class="form-group">
                                                               <input type="text" name="costPrice" class="form-control" placeholder="Cost Price" required="" value="'.number_format($product->COST_PRICE).'">
                                                           </div>

                                                           <div class="form-group">
                                                               <input type="text" name="salesPrice" class="form-control" placeholder="Sales Price" required="" value="'.number_format($product->SALES_PRICE).'">
                                                           </div>

                                                            

                                                           <button class="btn btn-danger">Update</button>                                                  
    </form>
       
    ';
}



?>