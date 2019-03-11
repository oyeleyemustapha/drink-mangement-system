<?php

if($pins){
    echo'

        <table class="table table-bordered table-condensed table-hover changeList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>PIN</th>
                                            <th>AMOUNT</th>
                                            <th>STATUS</th>
                                            <th>DATE CREATED</th>
                                            <th>CASHIER</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($pins as $pin) {

                                        if($pin->STATUS=="PAID"){
                                            $status="<span class='badge badge-info'>PAID</span>";
                                        }
                                        else{
                                            $status="<span class='badge badge-danger'>NOT PAID</span>";
                                        }
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$pin->NAME</td>
                                                <td>$pin->PIN</td>
                                                <td>&#8358; ".number_format($pin->AMOUNT)."</td>
                                                <td>$status</td>
                                                <td>".date('F d, Y h:i:s', strtotime($pin->DATE_CREATED))."</td>
                                                <td>$pin->STAFF</td>
                                                <td>";

                                                if($pin->STATUS=="PAID"){
                                                     echo "<button class='btn btn-primary btn-sm payChange' id='$pin->PIN' disabled>Pay</button>";
                                                }
                                                else{
                                                    echo "<button class='btn btn-primary btn-sm payChange' id='$pin->PIN'>Pay</button>";
                                                }


                                              
                                            echo" </td></tr>
                                        ";
                                        $counter++;
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>

    ';
}
else{
    echo"<div class='alert alert-info'><h2 class='text-center'><i class='fa fa-info-circle fa-2x'></i><br>No Unpaid Change</h2></div>";
}

?>