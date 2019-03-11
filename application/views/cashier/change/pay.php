<?php

if($pin){


	echo'
		<form method="post" id="PayChangeForm">

			<div class="form-group">
				<label>Customer\'s Name</label>
				<input type="text" value="'.$pin->NAME.'" class="form-control" disabled>
			</div>

			<div class="form-group">
				<label>Change Amount</label>
				<input type="text" value="'.$pin->AMOUNT.'" class="form-control" disabled>
			</div>

			<input type="hidden" name="change" value="'.$pin->AMOUNT.'" class="form-control" required>
			<input type="hidden" name="pin" value="'.$pin->PIN.'" class="form-control" required>

			<div class="form-group">
				<label>Amount to Pay</label>
				<input type="text"  class="form-control" name="amount" autocomplete="off" required>
			</div>

			<button class="btn btn-info btn-lg">Pay</button>




		</form>



	';
	
		
				

}
else{
	echo "<div class='alert alert-danger'><h3 class='text-center'>No Record found</h3></div>";
}

?>