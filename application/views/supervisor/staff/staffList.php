<?php

if($staff_list){
    echo'

        <table class="table table-bordered table-condensed table-hover staffList">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>USERNAME</th>
                                            <th>ROLE</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $counter=1;
                                    foreach ($staff_list as $staff) {

                                        if($staff->ROLE!="Cashier"){
                                            continue;
                                        }
                                        echo"
                                            <tr>
                                                <td>$counter</td>
                                                <td>$staff->NAME</td>
                                                <td>$staff->USERNAME</td>
                                                <td>$staff->ROLE</td>
                                                <td>
                                                    <button class='btn btn-info btn-sm editStaff' id='$staff->STAFF_ID'>Edit</button>
                            
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

    echo'<div class="alert alert-info text-center"><h3>NO Record Found</h3></div>';
}



?>