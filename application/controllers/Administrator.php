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
		$data['title']=$this->administrator_model->fetch_cafeteria()->STORE_NAME." :: Dashboard";
		//$data['dailyReport']=$this->daily_sales_reports_dashboard();
		//$data['monthReport']=$this->monthly_sales_reports_dashboard();
		//$data['dailyOrders']=$this->administrator_model->fetch_no_order();
		$this->load->view('administrator/parts/head', $data);
		$this->load->view('administrator/dashboard', $data);
		$this->load->view('administrator/parts/bottom', $data);
	}
	

	

	//==============================
    //==============================
    //STAFF
    //==============================
    //==============================

	public function staff(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Staff";
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
    //LOGIN LOGS
    //==============================
    //==============================

	public function logs(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Staff Login Logs";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/logs/logs',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//LOGIN LOGS
	public function fetch_logs(){
		$data['logs']=$this->administrator_model->fetch_logs();
		$this->load->view('administrator/logs/staff_log', $data);
	}

	//CLEAR LOGIN LOGS
	public function clear_logs(){
		$this->verify();
		if($this->administrator_model->clear_logs()){
			echo "Logs has been cleared";
		}
	}

	//==============================
    //==============================
    //DRINK STOCK LOGS
    //==============================
    //==============================

	public function drinkstocklogs(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Drinks Stock Logs";
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
    //SETTINGS
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
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->library('zip');
		$database_tables=['logs', 'products', 'products_to_sell', 'sales', 'setting', 'staff', 'wallet', 'wallet_log', 'pin'];
		foreach ($database_tables as $tables) {
			$query = $this->db->query("SELECT * FROM ".$tables);
			$data=$this->dbutil->csv_from_result($query);
			write_file('backup/'.$tables.'-'.date("F-d-Y").'.csv', $data);
		}
		$this->zip->read_dir('backup', TRUE);
		delete_files('backup/');
		$this->zip->download('Record-'.date("F-d-Y").'.zip');
	}

	//UPDATE CAFETERIA NAME
	public function update_cafeteria_name(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Cafeteria Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'valid_email');
		if($this->form_validation->run()){
			$name=array(
				'NAME'=>trim($this->input->post('name')),
				'PHONE'=>trim($this->input->post('phone')),
				'ADDRESS'=>trim($this->input->post('address')),
				'EMAIL'=>trim($this->input->post('email'))
			);
			if($this->administrator_model->update_cafeteria_name($name)){
				echo "Cafeteria Name has been updated";
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
    //STOCK DRINKS
    //==============================
    //==============================

	public function stockDrinks(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Drinks' Stock";
		$data['staffList']=$this->staff_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/drinks/stock',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}


	//FETCH LIST OF DRINKS TO ADD TO STOCK
	public function fetchDrinktoStock(){
		$data['drinks']=$this->administrator_model->fetch_drink_list();
		$this->load->view('administrator/drinks/drinksToStock', $data);
	}

	//FETCH LIST OF DRINKS IN STOCK
	public function fetchDrinksStock(){
		$data['drinks']=$this->administrator_model->fetch_drinks_in_stock();

		$this->load->view('administrator/drinks/stockedDrinks', $data);
	}

	//FETCH LIST OF DRINKS TO ALLOCATE TO STAFF
	public function fetchDrinkstoAllocate(){
		$data['staffList']=$this->staff_list();
		$data['drinks']=$this->administrator_model->fetch_drinks_with_stock();
		$this->load->view('administrator/drinks/listDrinks', $data);
	}

	//ALLOCATE DRINK TO STAFF
	public function allocate_drink(){
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
						'STAFF'=>$this->input->post('staff'),
						'DRINK'=>$product,
						'QUANTITY'=>$quantity,
						'DATE'=>date('Y-m-d')
					);					
					$this->administrator_model->allocate_drinks($product);
				}
			}
			echo "Products has been added allocated to staff";
		}
		else{

			$error="";

			if(form_error('product[]')){
				$error.=form_error('product[]');
			}

			if(form_error('quantity[]')){
				$error.=form_error('quantity[]');
			}
			echo $error;
		}
	}




	//ADD DRINKS TO STOCK
	public function add_drinks_stock(){
		$this->verify();
		$this->load->library('form_validation');
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
						'DRINK'=>$product,
						'QUANTITY'=>$quantity
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

	public function drinks(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Drinks";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/drinks/drinks',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//ADD DRINKS
	public function add_drink(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product', 'Drink Name', 'required|is_unique[drinks.NAME]', array('is_unique' => 'Drink has been added before.'));
		$this->form_validation->set_rules('costPrice', 'Cost Price', 'required|numeric');
		$this->form_validation->set_rules('salesPrice', 'Sales Price', 'required|numeric');
		if($this->form_validation->run()){
			$product=array(
				'NAME'=>ucwords(trim($this->input->post('product'))),
				'COST_PRICE'=>trim($this->input->post('costPrice')),
				'SELLING_PRICE'=>trim($this->input->post('salesPrice')),
			);
			if($this->administrator_model->add_drink($product)){
				echo "Drink has been added";
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

	//FETCH DRINK LIST
	public function fetch_drink_list(){
		$data['drinks']=$this->administrator_model->fetch_drink_list();
		$this->load->view('administrator/drinks/list', $data);
	}


	//FETCH DRINK
	public function fetch_drink(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product ID', 'required|numeric');
		if($this->form_validation->run()){
			$data['product']= $this->administrator_model->fetch_drink($this->input->post('product_id'));
			$this->load->view('administrator/drinks/info', $data);
		}
	}


	//UPDATE DRINK
	public function update_drink(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product', 'required|numeric');
		$this->form_validation->set_rules('product', 'Product', 'required');
		$this->form_validation->set_rules('costPrice', 'Cost Price', 'required|numeric');
		$this->form_validation->set_rules('salesPrice', 'Sales Price', 'required|numeric');
		if($this->form_validation->run()){
			$product=array(
				'DRINK_ID'=>$this->input->post('product_id'),
				'NAME'=>ucwords(trim($this->input->post('product'))),
				'COST_PRICE'=>trim($this->input->post('costPrice')),
				'SELLING_PRICE'=>trim($this->input->post('salesPrice'))
			);
			if($this->administrator_model->update_drink($product)){
				echo "Drink has been updated";
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
    //PRODUCTS (FOODS)
    //==============================
    //==============================

	public function products(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Foods";
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/products/products',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}


	//ADD PRODUCT
	public function add_product(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product', 'Product', 'required|is_unique[products.PRODUCT]', array('is_unique' => 'Product has been added before.'));
		$this->form_validation->set_rules('labelname', 'Label Name', 'required');
		$this->form_validation->set_rules('costPrice', 'Cost Price', 'required|numeric');
		$this->form_validation->set_rules('salesPrice', 'Sales Price', 'required|numeric');
		if($this->form_validation->run()){
			$product=array(
				'PRODUCT'=>ucwords(trim($this->input->post('product'))),
				'LABEL_NAME'=>ucwords(trim($this->input->post('labelname'))),
				'COST_PRICE'=>trim($this->input->post('costPrice')),
				'SALES_PRICE'=>trim($this->input->post('salesPrice')),
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

			if(form_error('labelname')){
				$error.=form_error('labelname');
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
		$this->form_validation->set_rules('labelname', 'Label Name', 'required');
		$this->form_validation->set_rules('costPrice', 'Cost Price', 'required|numeric');
		$this->form_validation->set_rules('salesPrice', 'Sales Price', 'required|numeric');
		if($this->form_validation->run()){
			$product=array(
				'PRODUCT_ID'=>$this->input->post('product_id'),
				'PRODUCT'=>ucwords(trim($this->input->post('product'))),
				'LABEL_NAME'=>ucwords(trim($this->input->post('labelname'))),
				'COST_PRICE'=>trim($this->input->post('costPrice')),
				'SALES_PRICE'=>trim($this->input->post('salesPrice'))
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

			if(form_error('labelname')){
				$error.=form_error('labelname');
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
    //SALES PRODUCTS
    //==============================
    //==============================

	public function sales_product(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Sales Products";
		$data['products']=$this->administrator_model->fetch_product_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/products/salesProduct',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//FETCH SUBEJCT LIST [TO BE USED IN SELECT2 PLUGIN]
	public function get_product_list_plugin(){
		$this->verify();
		$products=$this->administrator_model->fetch_product_list_select($_GET['search']);
		foreach ($products as $key => $value) {
			$data[] = array('id' => $value['PRODUCT_ID'], 'text' => $value['PRODUCT']);			 	
   		}
		echo json_encode($data);
	}

	//ADD SALES PRODUCTS
	public function add_sales_products(){
		$this->verify();
		$this->load->library('form_validation');
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
						'PRODUCT_ID'=>$product,
						'QUANTITY'=>$quantity,
						'STAFF_ID'=>$_SESSION['staff_id'],
						'DATE_ADDED'=> date('Y-m-d')
					);
					$this->administrator_model->add_sales_products($product);
				}
			}
			echo "Product has been added";
		}
		else{

			$error="";

			if(form_error('product[]')){
				$error.=form_error('product[]');
			}

			if(form_error('quantity[]')){
				$error.=form_error('quantity[]');
			}
			echo $error;
		}
	}

	//FETCH SALES PRODUCTS LIST FOR A PARTICULAR DATE
	public function fetch_sales_product_list(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Date', 'required');
		if($this->form_validation->run()){
			$date=date('Y-m-d', strtotime($this->input->post('date')));
			$data['products']=$this->administrator_model->fetch_sales_product_list($date);
			$this->load->view('administrator/products/salesproductList', $data);
		}
		
	}


	//FETCH SALES PRODUCTS LIST FOR THE CURRENT DATE
	public function fetch_sales_product_list_current(){
		$data['products']=$this->administrator_model->fetch_sales_product_list(date('Y-m-d'));
		$this->load->view('administrator/products/salesproductList', $data);	
	}

	//FETCH SALES PRODUCT INFO
	public function fetch_sales_product_info(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'required|numeric');
		if($this->form_validation->run()){
			$data['product']= $this->administrator_model->fetch_sales_product_info($this->input->post('id'));
			$this->load->view('administrator/products/salesproductInfo', $data);
		}
	}

	//UPDATE SALES PRODUCTS INFO
	public function update_sales_products(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product', 'Product', 'required|numeric');
		$this->form_validation->set_rules('id', 'ID', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
		if($this->form_validation->run()){
			$product=array(
				'PRODUCT_ID'=>$this->input->post('product'),
				'QUANTITY'=>trim($this->input->post('quantity')),
				'ID'=>$this->input->post('id')
			);
			if($this->administrator_model->update_sales_product($product)){
				echo "Product has been updated";
			}
		}
		else{

			$error="";

			if(form_error('product')){
				$error.=form_error('product');
			}

			if(form_error('quantity')){
				$error.=form_error('quantity');
			}

			if(form_error('id')){
				$error.=form_error('id');
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
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Financial Reports";
		$data['year']=$this->list_year();
		$data['month']=$this->list_month();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/reports/reports',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}

	//GENERATE DAILY SALES REPORT
	public function daily_sales_reports(){
		$data['daily_sales']=$this->administrator_model->fetch_daily_sales_report();
		$this->load->view('administrator/reports/dailysales',$data);
	}


	//GENERATE SALES RECORDS BASED ON SALES DATE
	public function sales_reports_day(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Sales date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
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
			$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
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
			$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
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



	//REPORTS ON DASHBOARD

	public function daily_sales_reports_dashboard(){
		$report=$this->administrator_model->sales_report_day(date('Y-m-d'));

		$total_amt=0;
        $total_profit=0;

        if($report){
        	foreach ($report as $product) {
	            $cost_price_sum=$product->SALES*$product->COST_PRICE;
	            $amount=$product->SALES*$product->SALES_PRICE;
	            $profit=$amount-$cost_price_sum;
	            $total_profit+=$profit;
	            $total_amt+=$amount;                        
	        }


	        return $daily_report=array(
	        	'SALES'=>$total_amt,
	        	'PROFIT'=>$total_profit
	        );
        }
        else{
        	return $daily_report=array(
	        	'SALES'=>0,
	        	'PROFIT'=>0
	        );
        }                        
	}


	public function monthly_sales_reports_dashboard(){
		$month=array(
			'MONTH'=>date('m'),
			'YEAR'=> date('Y')
		);
		$report=$this->administrator_model->sales_report_month($month);

		$total_amt=0;
        $total_profit=0;

        if($report){
        	foreach ($report as $product) {
	            $cost_price_sum=$product->SALES*$product->COST_PRICE;
	            $amount=$product->SALES*$product->SALES_PRICE;
	            $profit=$amount-$cost_price_sum;
	            $total_profit+=$profit;
	            $total_amt+=$amount;                        
	        }


	        return $daily_report=array(
	        	'SALES'=>$total_amt,
	        	'PROFIT'=>$total_profit
	        );
        }
        else{
        	return $daily_report=array(
	        	'SALES'=>0,
	        	'PROFIT'=>0
	        );
        }                        
	}


	//==============================
    //==============================
    //SALES
    //==============================
    //==============================

	public function sales(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Sales";
		$data['year']=$this->list_year();
		$data['month']=$this->list_month();
		$data['staffList']=$this->staff_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/sales/sales',$data);
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


	//GENERATE SALES RECORDS BASED ON SALES DATE FOR A PARTICULAR STAFFs
	public function sales_reports_day_staff(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('staff', 'Staff', 'required|numeric');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
			$data['year']=$this->list_year();
			$data['month']=$this->list_month();

			if($this->input->post('month')!=''){
				$month=date('m',strtotime($this->input->post('month')));
			}
			else{
				$month="";
			}


			if($this->input->post('date')!=''){
				$date=date('Y-m-d', strtotime($this->input->post('date')));
			}
			else{
				$date="";
			}
			$report=array(
				'MONTH'=>   $month,
				'SALES_DATE'=> $date,
				'STAFF_ID'=>$this->input->post('staff')
			);
			$data['date']=$date;
			$data['month']=$month;
			$data['report']=$this->administrator_model->sales_report_day_staff($report);
			$this->load->view('administrator/sales/staffDailysales',$data);
		}
	}


	//GENERATE GENERAL SALES RECORDS BASED ON SALES DATE
	public function sales_reports_day_general(){
		$this->verify();
		$this->load->library('form_validation');
			$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
			$data['month']=$this->list_month();

			if($this->input->post('month')!=''){
				$month=date('m',strtotime($this->input->post('month')));
			}
			else{
				$month="";
			}


			if($this->input->post('date')!=''){
				$date=date('Y-m-d', strtotime($this->input->post('date')));
			}
			else{
				$date="";
			}
			$report=array(
				'MONTH'=>   $month,
				'SALES_DATE'=> $date
			);
			$data['date']=$date;
			$data['month']=$month;
			$data['report']=$this->administrator_model->sales_report_day_general($report);
			$this->load->view('administrator/sales/generalDailysales',$data);

			//var_dump($report);
	}


	//GENERATE SALES RECORD BASED ON ORDER NO
	public function sales_records_order_no(){
		$this->verify();
		$this->load->library('form_validation');
			$this->form_validation->set_rules('search', 'Search', 'required|numeric');
		if($this->form_validation->run()){
			$data['sales']=$this->administrator_model->sales_records_order_no(trim($this->input->post('search')));
			$this->load->view('administrator/sales/salesdetails',$data);
		}
			
			
	}


	//CANCEL ALL ORDERS
	public function cancel_all_orders(){
		$this->verify();
		$this->load->library('form_validation');
			$this->form_validation->set_rules('order_no', 'Order NO', 'required|numeric');
		if($this->form_validation->run()){
			if($this->administrator_model->cancel_orders_all($this->input->post('order_no'))){
				echo "Orders has been canceled";
			}
		}		
	}


	//CANCEL SPECIFIC PRODUCT ORDER
	public function cancel_product_order(){
		$this->verify();
		$this->load->library('form_validation');
			$this->form_validation->set_rules('sales_id', 'Sales ID', 'required|numeric');
		if($this->form_validation->run()){
			if($this->administrator_model->cancel_specific_order($this->input->post('sales_id'))){
				echo "Order has been canceled";
			}
		}		
	}


	 //DASHBOARD
	public function order_page(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Take Order";
		$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
		$this->load->view('administrator/parts/head', $data);
		$this->load->view('administrator/order/order', $data);
		$this->load->view('administrator/parts/bottom', $data);
	}
	


	


	


	//FETCH LEFT OVER RECORDS
	public function fetch_leftover(){
		$this->verify();
		$this->load->library('form_validation');
			$this->form_validation->set_rules('date', 'Date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->administrator_model->fetch_cafeteria()->NAME;
			$date=date('Y-m-d', strtotime($this->input->post('date')));
			$data['report']=$this->administrator_model->fetch_sales_product_list($date);
			$this->load->view('administrator/reports/leftover', $data);

			
		}	
	}



	//==============================
    //==============================
    //CHANGE
    //==============================
    //==============================

	public function change(){
		$this->verify();
		$data['title']=$this->administrator_model->fetch_cafeteria()->NAME." :: Change";
		$data['year']=$this->list_year();
		$data['month']=$this->list_month();
		$data['staffList']=$this->staff_list();
		$this->load->view('administrator/parts/head',$data);
		$this->load->view('administrator/change/change',$data);
		$this->load->view('administrator/parts/bottom',$data);
	}


	//FETCH INDIVIDUAL CHANGE REPORT BASED ON CHANGE STATUS
	public function change_report_individual(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('staff', 'Staff', 'required');
		if($this->form_validation->run()){
			$report=array(
				'STATUS'=> $this->input->post('status'),
				'CREATED_BY'=>$this->input->post('staff')
			);

			$data['report']=$this->administrator_model->change_report_individual($report);
			$this->load->view('administrator/change/individualReportStatus', $data);
		}		
	}
	

	


	




	
	
	
	

    






	
	


}
