<?php

if($wallet){
    echo'
    <form method="post" id="updateWalletForm">
    <input type="hidden" name="wallet_no" value="'.$wallet->WALLET_NUMBER.'">
        <div class="form-group">
                                                               <input type="text" name="name" class="form-control" placeholder="Wallet Holder Name" required="" autocomplete="off" value="'.$wallet->NAME.'">
                                                           </div>

                                                           

                                                           <div class="form-group">
                                                               <input type="text" name="phone" class="form-control" placeholder="Phone Number" required="" autocomplete="off" value="'.$wallet->PHONE.'">
                                                           </div>

                                                           <div class="form-group">
                                                               <input type="text" name="amount" class="form-control" placeholder="Amount" required="" autocomplete="off" value="'.number_format($wallet->AMOUNT).'">
                                                           </div>
                                                   

       <button class="btn btn-danger">Update</button>
    </form>
       
    ';
}



?>