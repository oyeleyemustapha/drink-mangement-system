<?php

if($wallet){
    echo'
    <form method="post" id="creditWalletForm">
    <input type="hidden" name="wallet_no" value="'.$wallet->WALLET_NUMBER.'">
        <div class="form-group">
                                                               <input type="text" name="name" class="form-control" placeholder="Wallet Holder Name" required="" autocomplete="off" value="'.$wallet->NAME.'" disabled>
                                                           </div>

                                                           

                                                           <div class="form-group">
                                                               <input type="text" name="phone" class="form-control" placeholder="Phone Number" required="" autocomplete="off" value="'.$wallet->PHONE.'" disabled>
                                                           </div>

                                                           <div class="form-group">
                                                           <label>Wallet Balance</label>
                                                            <div class="form-group">
                                                               <input type="text" name="" class="form-control"  required="" autocomplete="off" value="'.number_format($wallet->AMOUNT).'" disabled>
                                                           </div>
                                                           </div>

                                                           <div class="form-group">
                                                               <input type="text" name="amount" class="form-control" placeholder="Fund Amount" required="" autocomplete="off">
                                                           </div>
                                                   

       <button class="btn btn-danger">Fund Wallet</button>
    </form>
       
    ';
}



?>