<?php

if($drinks){
    echo'
    <form method="post" id="addStockForm" autocomplete="off">

        <select name="staff" required class="form-control form-control-lg">
            '.$staffList.'

        </select>
        <br>
        <table class="table table-bordered table-condensed table-hover drinkList">
        
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PRODUCT</th>
                                            <th>QUANTITY</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($drinks as $drink) {
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$drink->PRODUCT_NAME</td>
                                              
                                                <td>
                                                <input type='number' name='quantity[]' class='form-control form-control-lg' autocomplete='off'>

<input type='hidden' name='product[]' value='$drink->PRODUCT_ID' class='form-control form-control-lg'>
                                                </td>
                                               
                                            </tr>
                                        ";
                                        $counter++;
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>
                                <button class="btn btn-info btn-lg addBtn">Add</button>

                                </form>



    ';
}
else{
    echo'<div class="alert alert-info text-center"><h3>No Record Found</h3></div>';
}



?>