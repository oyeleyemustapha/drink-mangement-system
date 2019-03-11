<?php

if($drinks){
    echo'
<br>
<form method="post" id="allocateDrinks">

<div class="form-group">
<select name="staff" class="form-control" required>
'.$staffList.'
</select>

</div>
        <table class="table table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PRODUCT</th>
                                            <th>QUANTITY AVAILABLE</th>
                                            <th>QUANTITY TO ALLOCATE</th>
                                            
                                           
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
                                                <td>
                                                 <input type='hidden' class='form-control' name='product[]' value='$drink->DRINK_ID'>
                                                <input type='text' class='form-control' name='quantity[]'>

                                                </td>
                                                
                                
                                            </tr>
                                        ";
                                        $counter++;
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>
                                <button class="btn btn-info">Add</button>
                                </form>



    ';
}
else{
    echo'<div class="alert alert-info text-center"><h3>No Record Found</h3></div>';
}



?>