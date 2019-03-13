<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('drinks_model');  
        $this->load->model('administrator_model');  
    }	

	//VERIFY USER FOR SECURITY PURPOSES
    public function verify(){
    	if(is_null($this->session->userdata('username')) && is_null($this->session->userdata('password'))){
			redirect(base_url());
		}
		else{
			if($this->administrator_model->verify_user($this->session->userdata('username'),$this->session->userdata('password'))==false){
				redirect(base_url());
			}
		}
    }

    //DASHBOARD
	public function index(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Dashboard";
		//$data['dailyReport']=$this->daily_sales_reports_dashboard();
		//$data['monthReport']=$this->monthly_sales_reports_dashboard();
		//$data['dailyOrders']=$this->administrator_model->fetch_no_order();
		$this->load->view('administrator/parts/head', $data);
		$this->load->view('administrator/dashboard', $data);
		$this->load->view('administrator/parts/bottom', $data);
	}


	//==============================
    //==============================
    //LOGIN LOGS
    //==============================
    //==============================

	public function logs(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Staff Login Logs";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/logs/logs',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//LOGIN LOGS
	public function fetch_logs(){
		$data['logs']=$this->administrator_model->fetch_staff_logs();
		$this->load->view('administrator/logs/staff_log', $data);
	}

	//CLEAR LOGIN LOGS
	public function clear_staff_logs(){
		$this->verify();
		if($this->administrator_model->clear_staff_logs()){
			echo "Logs has been cleared";
		}
	}


	//==============================
    //==============================
    //STORE SETTINGS
    //==============================
    //==============================

	public function settings(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Settings";
		$data['store']=$this->administrator_model->fetch_store();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/settings',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//EXPORT RECORDS IN CSV
	public function export_records(){
		$this->verify();
		$prefs = array(
		        'tables'        => array(),   
		        'ignore'        => array(),                     
		        'format'        => 'zip',                   
		        'filename'      => 'Record-'.date("F-d-Y").'.sql',
		        'add_drop'      => TRUE,                        
		        'add_insert'    => TRUE,                        
		        'newline'       => "\n"                        
		);
		$this->load->dbutil();
		$backup = $this->dbutil->backup($prefs);
		$this->load->helper('file');
		write_file('backup/'.$tables.'-'.date("F-d-Y").'.zip', $backup);
		$this->load->helper('download');
		delete_files('backup/');
		force_download('backup/'.$tables.'-'.date("F-d-Y").'.zip', $backup);
	}

	//UPDATE STORE SETTINGS
	public function update_store_settings(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Cafeteria Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'valid_email');
		if($this->form_validation->run()){
			$store=array(
				'STORE_NAME'=>trim($this->input->post('name')),
				'PHONE'=>trim($this->input->post('phone')),
				'ADDRESS'=>trim($this->input->post('address')),
				'EMAIL'=>trim($this->input->post('email'))
			);
			if($this->administrator_model->update_store_settings($store)){
				echo "Store Settings has been updated";
			}
		}
		else{

			$error="";
			if(form_error('name')){
				$error.=form_error('name');
			}
			if(form_error('phone')){
				$error.=form_error('phone');
			}
			if(form_error('address')){
				$error.=form_error('address');
			}
			if(form_error('email')){
				$error.=form_error('email');
			}
			echo $error;
		}
	}	

	//==============================
    //==============================
    //STAFF
    //==============================
    //==============================

	public function staff(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Staff";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/staff/staff',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}


	//FETCH THE LIST OF STAFF
	public function fetch_staff_list(){
		$data['staff_list']=$this->administrator_model->fetch_staff_list();
		$this->load->view('administrator/staff/staffList', $data);
	}

	
		
	//ADD STAFF
	public function add_staff(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[staff.USERNAME]', array('is_unique' => 'Username has been taken'));
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('cpassword', 'Password', 'required|matches[password]');
		$this->form_validation->set_rules('role', 'Role', 'required');
		if($this->form_validation->run()){
			$staff_info=array(
				'NAME'=>trim($this->input->post('name')),
				'USERNAME'=>strtolower(trim($this->input->post('username'))),
				'PASSWORD'=>md5(strtolower(trim($this->input->post('password')))),
				'ROLE'=>$this->input->post('role')
			);
			if($this->administrator_model->add_staff($staff_info)){
				echo "Staff has been added";
			}
		}
		else{

			$error="";

			if(form_error('name')){
				$error.=form_error('name');
			}

			if(form_error('role')){
				$error.=form_error('role');
			}

			if(form_error('username')){
				$error.=form_error('username');
			}

			if(form_error('password')){
				$error.=form_error('password');
			}

			if(form_error('cpassword')){
				$error.=form_error('cpassword');
			}
			echo $error;
		}
	}

	//UPDATE STAFF
	public function update_staff(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('staff_id', 'Staff ID', 'required|numeric');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Password', 'required|matches[password]');
		if($this->form_validation->run()){
			$staff=array(
				'NAME'=>trim($this->input->post('name')),
				'USERNAME'=>strtolower(trim($this->input->post('username'))),
				'PASSWORD'=>md5(strtolower(trim($this->input->post('password')))),
				'STAFF_ID'=>$this->input->post('staff_id'),
				'ROLE'=>$this->input->post('role')
			);

			if($this->administrator_model->update_staff($staff)){
				if($_SESSION['staff_id']==$this->input->post('staff_id')){
					$session_data=array('role' => $staff['ROLE'], 'username' => $staff['USERNAME'], 'password' => $staff['PASSWORD'], 'name'=> $staff['NAME']);
					$this->session->set_userdata($session_data);
				}
				echo "Staff's Record has been updated";
			}
		}
		else{
			$error="";
			if(form_error('username')){
				$error.=form_error('username');
			}
			if(form_error('password')){
				$error.=form_error('password');
			}
			if(form_error('cpassword')){
				$error.=form_error('cpassword');
			}
			if(form_error('staff_id')){
				$error.=form_error('staff_id');
			}
			if(form_error('role')){
				$error.=form_error('role');
			}
		}
	}

	//DELETE STAFF
	public function delete_staff(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff_id', 'Staff ID', 'required|numeric');
		if($this->form_validation->run()){
			if($_SESSION['staff_id']==$this->input->post('staff_id')){
				echo "You can't delete your account while logged in";
			}
			else{
				if($this->administrator_model->delete_staff($this->input->post('staff_id'))){
					echo "Staff's  Record has been deleted";
				}
			}
		}
	}

	//FETCH STAFF INFO
	public function fetch_staff_info(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff_id', 'Staff ID', 'required|numeric');
		if($this->form_validation->run()){
			$data['staff']= $this->administrator_model->fetch_staff_info($this->input->post('staff_id'));
			$this->load->view('administrator/staff/staffInfo', $data);
		}
	}


	
	//==============================
    //==============================
    //DRINK STOCK LOGS
    //==============================
    //==============================

	public function drinkstocklogs(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->NAME." :: Drinks Stock Logs";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/logs/drinkStocklogs',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//FETCH DRINK STOCK LOGS
	public function fetch_drink_stock_logs(){
		$data['logs']=$this->administrator_model->fetch_drinkstock_logs();
		$this->load->view('administrator/logs/stock_log', $data);
	}

	

	
	//==============================
    //==============================
    //STOCK DRINKS
    //==============================
    //==============================

	public function stock(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Stock";
		$data['staffList']=$this->staff_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/stock/stock',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}
	public function staff_list(){
		$staff=$this->administrator_model->fetch_staff_list();
		$staffList='<option value="">Select Staff</option>';
		foreach ($staff as $person) {
			$staffList.="<option value='$person->STAFF_ID'>$person->NAME</option>";
		}
		return $staffList;
	}

	//FETCH LIST OF DRINKS TO ADD TO STOCK
	public function fetchDrinktoStock(){
		$data['staffList']=$this->staff_list();
		$data['drinks']=$this->administrator_model->fetch_drink_list();
		$this->load->view('administrator/stock/drinksToStock', $data);
	}

	//FETCH LIST OF DRINKS IN STOCK
	public function fetchDrinksStock(){
		$data['drinks']=$this->administrator_model->fetch_drinks_in_stock();
		$this->load->view('administrator/stock/stockedDrinks', $data);
	}

	
	
	//ADD DRINKS TO STOCK
	public function add_drinks_stock(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff', 'Staff', 'numeric');
		$this->form_validation->set_rules('product[]', 'Product', 'numeric');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'numeric');
		if($this->form_validation->run()){
			for ($i=0; $i <count($this->input->post('product')) ; $i++) { 
				$product=$_POST['product'][$i];
				$quantity=$_POST['quantity'][$i];
				if(	$quantity==''){
					continue;
				}
				else{
					$product=array(
						'STAFF_ID'=>$this->input->post('staff'),
						'PRODUCT_ID'=>$product,
						'QUANTITY'=>$quantity,
						'DATE_ADDED'=>date('Y-m-d')
					);					
					$this->administrator_model->add_drink_stock($product);
				}
			}
			echo "Products has been added to stock";
		}
		else{

			$error="";

			if(form_error('product[]')){
				$error.=form_error('product[]');
			}

			if(form_error('staff')){
				$error.=form_error('staff');
			}

			if(form_error('quantity[]')){
				$error.=form_error('quantity[]');
			}
			echo $error;
		}
	}


	//==============================
    //==============================
    //PRODUCTS (DRINKS)
    //==============================
    //==============================

	public function products(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME."| Products";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/products/products',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}


	//ADD PRODUCT
	public function add_product(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product', 'Product', 'required|is_unique[products.PRODUCT_NAME]', array('is_unique' => 'Product has been added before.'));
		$this->form_validation->set_rules('costPrice', 'Cost Price', 'required');
		$this->form_validation->set_rules('salesPrice', 'Sales Price', 'required');
		if($this->form_validation->run()){
			$product=array(
				'PRODUCT_NAME'=>ucwords(trim($this->input->post('product'))),
				'COST_PRICE'=>str_replace(',', '', trim($this->input->post('costPrice'))),
				'SALES_PRICE'=>str_replace(',', '', trim($this->input->post('salesPrice')))
			);
			if($this->administrator_model->add_product($product)){
				echo "Product has been added";
			}
		}
		else{

			$error="";

			if(form_error('product')){
				$error.=form_error('product');
			}

			if(form_error('costPrice')){
				$error.=form_error('costPrice');
			}

			if(form_error('salesPrice')){
				$error.=form_error('salesPrice');
			}

			

			echo $error;
		}
	}


	//FETCH PRODUCTS LIST
	public function fetch_product_list(){
		$data['product_list']=$this->administrator_model->fetch_product_list();
		$this->load->view('administrator/products/productList', $data);
	}


	//FETCH PRODUCT INFO
	public function fetch_product_info(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product ID', 'required|numeric');
		if($this->form_validation->run()){
			$data['product']= $this->administrator_model->fetch_product_info($this->input->post('product_id'));
			$this->load->view('administrator/products/productInfo', $data);
		}
	}


	//UPDATE PRODUCT INFO
	public function update_product_info(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product', 'required|numeric');
		$this->form_validation->set_rules('product', 'Product', 'required');
		$this->form_validation->set_rules('costPrice', 'Cost Price', 'required');
		$this->form_validation->set_rules('salesPrice', 'Sales Price', 'required');
		if($this->form_validation->run()){
			$product=array(
				'PRODUCT_ID'=>$this->input->post('product_id'),
				'PRODUCT_NAME'=>ucwords(trim($this->input->post('product'))),
				'COST_PRICE'=>str_replace(',', '', trim($this->input->post('costPrice'))),
				'SALES_PRICE'=>str_replace(',', '', trim($this->input->post('salesPrice')))
			);


			if($this->administrator_model->update_product($product)){
				echo "Product Information has been updated";
			}
		}
		else{

			$error="";

			if(form_error('product')){
				$error.=form_error('product');
			}

			if(form_error('product_id')){
				$error.=form_error('product_id');
			}

			
			if(form_error('costPrice')){
				$error.=form_error('costPrice');
			}

			if(form_error('salesPrice')){
				$error.=form_error('salesPrice');
			}

			echo $error;
		}
	}
	
	//==============================
    //==============================
    //SALES
    //==============================
    //==============================

	public function sales(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Sales";
		$data['year']=$this->list_year();
		$data['month']=$this->list_month();
		$data['staffList']=$this->staff_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/sales/sales',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}


	//FETCH PRODUCTS ALLOCATED TO CASHIER
	public function fetch_allocated_stock(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff', 'Staff', 'required|numeric');
		if($this->form_validation->run()){
			$data['products']=$this->administrator_model->fetch_allocated_stock($this->input->post('staff'));
			
			if($data['products']==1){

				echo "<div class='alert alert-info'><h3 class='text-center'>Sales has been posted before for this staff</h3></div>";
			}
			elseif ($data['products']==2) {
				echo "<div class='alert alert-info'><h3 class='text-center'>No products was allocated to this staff today</h3></div>";
			}
			else{
				$this->load->view('administrator/sales/allocated', $data);

			}


			
		}
		else{

		}
	}


	//POST SALES RECORD
	public function post_sales(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff', 'Staff', 'numeric');
		$this->form_validation->set_rules('product[]', 'Product', 'numeric');
		$this->form_validation->set_rules('leftover[]', 'Leftover', 'numeric');
		if($this->form_validation->run()){
			for ($i=0; $i <count($this->input->post('product')) ; $i++) { 
				$product=$_POST['product'][$i];
				$leftover=$_POST['leftover'][$i];
				$initial_stock=$_POST['initial_stock'][$i];
				$sales_price=$_POST['sales_price'][$i];
				$cost_price=$_POST['cost_price'][$i];
				if(	$leftover==''){
					continue;
				}
				else{

					$quantity_sold=$initial_stock-$leftover;
					$sales=array(
						'STAFF_ID'=>$this->input->post('staff'),
						'PRODUCT_ID'=>$product,
						'QUANTITY_SOLD'=>$quantity_sold,
						'DATE_ADDED'=>date('Y-m-d'),
						'SALES_PRICE'=>$sales_price,
						'COST_PRICE'=>$cost_price,
						'LEFTOVER'=>$leftover
					);					
					$this->administrator_model->post_sales($sales);
				}
			}
			echo "Sales has been posted";
		}
		else{

			$error="";

			if(form_error('product[]')){
				$error.=form_error('product[]');
			}

			if(form_error('staff')){
				$error.=form_error('staff');
			}

			if(form_error('leftover[]')){
				$error.=form_error('leftover[]');
			}
			echo $error;
		}
	}
	




	//==============================
    //==============================
    //REPORTS
    //==============================
    //==============================

	public function reports(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_store()->STORE_NAME." :: Financial Reports";
		$data['daily_report']=$this->administrator_model->fetch_daily_sales_report();
		$data['year']=$this->list_year();
		$data['month']=$this->list_month();
		$data['staffList']=$this->staff_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/reports/reports',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	

	//GENERATE SALES RECORDS BASED ON SALES DATE
	public function sales_reports_day(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Sales date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_store()->STORE_NAME;
			$date=date('Y-m-d', strtotime($this->input->post('date')));
			$data['date']=$date;
			$data['report']=$this->administrator_model->sales_report_day($date);
			
			$this->load->view('administrator/reports/generalDailysales',$data);
		}
	}


	//GENERATE SALES REPORTS BASED ON MONTH AND YEAR
	public function sales_reports_month(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('month', 'Sales Month', 'required');
		$this->form_validation->set_rules('year', 'Sales Year', 'required');
		if($this->form_validation->run()){
			$month_report=array(
				'MONTH'=>date('m',strtotime($this->input->post('month'))),
				'YEAR'=>$this->input->post('year')
			);
			$data['cafeteria']=$this->administrator_model->fetch_store()->STORE_NAME;
			$data['date']=$this->input->post('month')." ".$this->input->post('year');
			$data['report']=$this->administrator_model->sales_report_month($month_report);
			$this->load->view('administrator/reports/generalMonthsales',$data);
		}
	}

	//GENERATE ANNUAL SALES REPORT
	public function sales_reports_annual(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('year', 'Sales Year', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_store()->STORE_NAME;
			$data['date']=$this->input->post('year');
			$data['report']=$this->administrator_model->sales_report_annual($this->input->post('year'));
			$this->load->view('administrator/reports/generalYearsales',$data);
		}
	}

	public function list_year(){
		$year="";
		$date=date('Y');
	    $count=1;
	    while($count<=10){
	    	$year.="<option value='$date'>$date</option>\n";
	        $date++;
	        $count++;
	    }
	    return $year;
	}


	public function list_month(){
		$month_list="<option value='' selected>Select Month</option>";
		for ($m=1; $m<=12; $m++) {
	     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
	     $month_list.="<option value='$month'>$month</option>";
	    }
	    return $month_list;		
	}

	//GENERATE SALES RECORDS BASED ON SALES DATE FOR A PARTICULAR STAFFs
	public function sales_reports_day_staff(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff', 'Staff', 'required|numeric');
		$this->form_validation->set_rules('date', 'Sales Date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_store()->STORE_NAME;
			$report=array(
				'DATE'=> $this->input->post('date'),
				'STAFF_ID'=>$this->input->post('staff')
			);
			$data['report']=$this->administrator_model->sales_report_day_staff($report);
			$this->load->view('administrator/reports/staffDailySales',$data);
		}
	}


	//GENERATE SALES SHEET
	public function sales_sheet(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Sales Date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_store()->STORE_NAME;
			$report=array(
				'DATE'=> $this->input->post('date'),
				'STAFF_ID'=>$this->input->post('staff')
			);
			$data['date']=$this->input->post('date');
			$data['report']=$this->administrator_model->sales_sheet($report);
			$this->load->view('administrator/reports/saleSheet',$data);
		}
	}



	


	


	

	
	
	
	

    






	
	


}
