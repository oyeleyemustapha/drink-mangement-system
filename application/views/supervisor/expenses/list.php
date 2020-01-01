<?php

if($expenses){
    echo'
<table class="table table-hover table-bordered expensesTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>AMOUNT</th>
            <th>STAFF</th>
            <th>DATE</th>
            <th></th>
        </tr>
    </thead>
 <tbody>
    ';

    $counter=1;
    foreach ($expenses as $expense) {
       
        echo"

        <tr>
            <td>$counter</td>
            <td>$expense->TITLE</td>
            <td>".number_format($expense->AMOUNT)."</td>
            <td>$expense->NAME</td>
            <td>".date('F d, Y', strtotime($expense->DATE))."</td>
            <td>

<button class='btn btn-primary editExpenses' id='$expense->EXPENSE_ID'>Edit</button>
<button class='btn btn-danger deleteExpenses' id='$expense->EXPENSE_ID'>Delete</button>

            </td>
        </tr>


        ";

        $counter++;
    }



    echo'

</tbody>
</table>


    ';
}
else{
    echo"

<div class='alert alert-info'><h3 class='text-center'>No Record Found</h3></div>

    ";
}


?>

    