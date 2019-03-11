<?php

if($wallets){
    echo'

        <table class="table table-bordered table-condensed table-hover walletList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>PHONE</th>
                                            <th>WALLET NUMBER</th>
                                            <th>WALLET BALANCE</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($wallets as $wallet) {
                                        $walletUrl=base_url()."walletlogs/".$wallet->WALLET_NUMBER;
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$wallet->NAME</td>
                                                <td>$wallet->PHONE</td>
                                                <td>$wallet->WALLET_NUMBER</td>
                                                <td>".number_format($wallet->AMOUNT)."</td>

                                                <td>
                                                   
                                                   <button class='btn btn-info btn-sm fundWallet' data-wallet='$wallet->WALLET_NUMBER'>Credit Wallet</button>

                                                   <button class='btn btn-success btn-sm editWallet' data-wallet='$wallet->WALLET_NUMBER'><i class='fa fa-edit'></i></button>

                                                   <button class='btn btn-danger btn-sm deletewallet' data-wallet='$wallet->WALLET_NUMBER'><i class='fa fa-trash'></i></button>

                                                   <a href='$walletUrl' class='btn btn-danger btn-sm'>View Logs</a>



                                                </td>
                                            </tr>
                                        ";
                                        $counter++;
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>



    ';
}
else{

    echo"<div class='alert alert-info'>
            <h3 class='text-center'>No Wallet Found</h3>

    </div>";
}



?>