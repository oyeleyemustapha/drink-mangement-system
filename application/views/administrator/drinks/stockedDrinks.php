<?php

if($drinks){
    echo'
<br>
        <table class="table table-bordered table-condensed table-hover drinkList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PRODUCT</th>
                                            <th>QUANTITY AVAILABLE</th>
                                            <th>COST PRICE</th>
                                            <th>SALES PRICE</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($drinks as $drink) {
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$drink->NAME</td>
                                                <td>$drink->QUANTITY</td>
                                                <td>&#8358; $drink->COST_PRICE</td>
                                                <td>&#8358; $drink->SELLING_PRICE</td>
                                
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