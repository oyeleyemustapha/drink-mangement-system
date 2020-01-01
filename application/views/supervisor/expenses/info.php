<?php

if($expense){
    echo'
 <form method="post" autocomplete="off" id="UpdateExpensesForm">
 <input type="hidden" name="expense_id" value="'.$expense->EXPENSE_ID.'" required>
                                                          <div class="form-group">
                                                            <label>Title</label>
                                                              <input type="text" name="title" class="form-control form-control-lg" required="" autocomplete="off" value="'.$expense->TITLE.'">
                                                          </div>

                                                          <div class="form-group">
                                                            <label>Amount</label>
                                                              <input type="number" name="amount" class="form-control form-control-lg" required="" autocomplete="off" value="'.$expense->AMOUNT.'">
                                                          </div>

                                                          <div class="form-group">
                                                            <label>Staff</label>
                                                            <select name="staff" class="form-control form-control-lg" required="">
                                                            <option value="'.$expense->STAFF_ID.'" selected>'.$expense->NAME.'</option>
                                                              '.$staffList.'
                                                              </select>
                                                          </div>

                                                          <div class="form-group">
                                                            <label>Date</label>
                                                              <input type="date" name="date" class="form-control form-control-lg" required="" autocomplete="off" value="'.$expense->DATE.'">
                                                          </div>

                                                          <div class="form-group">
                                                            <label>Description</label>
                                                              <textarea name="description" class="form-control" autocomplete="off">'.$expense->DESCRIPTION.'</textarea>
                                                          </div>

                                                          <button class="btn btn-primary">Update</button>


                                                      </form>




    ';

}


?>

    