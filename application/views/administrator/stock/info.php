<?php

if($product){
    echo'
    <form method="post" id="updateDrinkForm">
      <input type="hidden" name="product_id" value="'.$product->DRINK_ID.'">
      <div class="form-group">
       <label>Product Name</label>
                                                               <input type="text" name="product" class="form-control" placeholder="Product Name" required="" value="'.$product->NAME.'">
                                                           </div>

                                                          

                                                           <div class="form-group">
                                                           <label>Cost Price</label>
                                                               <input type="text" name="costPrice" class="form-control" placeholder="Cost Price" required="" value="'.$product->COST_PRICE.'">
                                                           </div>

                                                           <div class="form-group">
                                                            <label>Selling Price</label>
                                                               <input type="text" name="salesPrice" class="form-control" placeholder="Sales Price" required="" value="'.$product->SELLING_PRICE.'">
                                                           </div>

                                                            

                                                           <button class="btn btn-danger">Update</button>                                                  
    </form>
       
    ';
}



?>