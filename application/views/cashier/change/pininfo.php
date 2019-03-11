<?php

if($pin){

	
		
				echo'
				<h1 class="text-center">'.$pin->PIN.'</h1>
				
				<ul class="list-group">
					<li class="list-group-item"><i class="fa fa-male fa-fw"></i>
					<span> Name : </span> '.$pin->NAME.'</li>
					<li class="list-group-item"><i class="fa fa-mobile fa-fw"></i><span> Phone : </span>'.$pin->PHONE.'</li>
					<li class="list-group-item"><i class="fa fa-money fa-fw"></i><span> Amount : </span>&#8358; '.$pin->AMOUNT.'</li>
					<li class="list-group-item"><i class="fa fa-calendar fa-fw"></i><span> Date Created : </span>'.date("F j, Y g:i A",strtotime($pin->DATE_CREATED)).'</li>
					<li class="list-group-item"><i class="fa fa-user fa-fw"></i><span> Created By : </span>'.$pin->STAFF_CREATED.'</li>
					
					';
						if(!is_null($pin->DATE_CLEARED)){
							echo'<li class="list-group-item"><i class="fa fa-calendar-o fa-fw"></i><span> Date Cleared : </span>'.
							date("F j, Y g:i A",strtotime($pin->DATE_CLEARED)).'</li>';
							echo'<li class="list-group-item"><i class="fa fa-user fa-fw"></i><span> Cleared By : </span>'.
							$this->cashier_model->staff_name($pin->CLEARED_BY)->NAME.'</li>';
						}
					
				echo'</ul>';

}
else{
	echo "<div class='alert alert-danger'><h3 class='text-center'>No Record found</h3></div>";
}

?>