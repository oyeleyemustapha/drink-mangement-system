<?php

if($logs){
    echo'
        
        <table class="table table-bordered table-condensed table-hover log">
                                    <thead>
                                        <tr>
                                           
                                            <th>NAME</th>
                                            <th>ROLE</th>
                                            <th>DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    
                                    foreach ($logs as $log) {
                                        echo"
                                            <tr>
                                                <td>$log->NAME</td>
                                                <td>$log->ROLE</td>
                                                <td>".date('F d Y h:i:s', strtotime($log->TIME_LOGGED))."</td>
                                                
                                            </tr>
                                        ";
                                     
                                    }

                                    
                                        
                                    echo'</tbody>
                                </table>



    ';
}
else{

    echo'<div class="alert alert-info text-center"><h3>No Record Found</h3></div>';
}




?>