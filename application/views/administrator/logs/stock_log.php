<?php

if($logs){
    echo'
        
        <table class="table table-bordered table-condensed table-hover stocklog">
                                    <thead>
                                        <tr>
                                           <th>ID</th>
                                            
                                            <th>DRINK</th>
                                            <th>QUANTITY</th>
                                            <th>DATE ADDED</th>
                                            <th>STAFF</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    
                                    foreach ($logs as $log) {
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$log->DRINK</td>
                                                <th>$log->QUANTITY</th>
                                                <td>".date('F d, Y', strtotime($log->DATE))."</td>
                                                <td>$log->STAFFNAME</td>
                                                
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