<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('drinks_model');  
        $this->load->model('cashier_model');  
    }	

	//VERIFY USER FOR SECURITY PURPOSES
    public function verify(){
    	if(is_null($this->session->userdata('username')) && is_null($this->session->userdata('password'))){
			redirect(base_url());
		}
		else{
			if($this->cashier_model->verify_user($this->session->userdata('username'),$this->session->userdata('password'))==false){
				redirect(base_url());
			}
		}
    }

    //DASHBOARD
	public function index(){
		$this->verify();
		$data['title']=$this->cashier_model->fetch_store()->STORE_NAME." :: Dashboard";
		$data['dailyReport']=$this->daily_sales_reports_dashboard();
		$data['monthReport']=$this->monthly_sales_reports_dashboard();
		$this->load->view('cashier/parts/head', $data);
		$this->load->view('cashier/dashboard', $data);
		$this->load->view('cashier/parts/bottom', $data);
	}

	//==============================
    //==============================
    //PROFILE
    //==============================
    //==============================

	public function profile(){
		$this->verify();
		$data['title']=$this->cashier_model->fetch_store()->STORE_NAME." :: My Profile";
		$data['profile']=$this->cashier_model->fetch_staff_info($_SESSION['staff_id']);
		$this->load->view('cashier/parts/head',$data);
		$this->load->view('cashier/profile',$data);
		$this->load->view('cashier/parts/bottom',$data);
	}

	//UPDATE PROFILE
	public function update_profile(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Password', 'required|matches[password]');
		if($this->form_validation->run()){
			$staff=array(
				'NAME'=>trim($this->input->post('name')),
				'USERNAME'=>strtolower(trim($this->input->post('username'))),
				'PASSWORD'=>md5(strtolower(trim($this->input->post('password')))),
				'STAFF_ID'=>$_SESSION['staff_id']
			);

			if($this->cashier_model->update_profile($staff)){
				
					$session_data=array(
						'username' => $staff['USERNAME'], 
						'password' => $staff['PASSWORD'], 
						'name'=> $staff['NAME']
					);
					$this->session->set_userdata($session_data);
				echo "Your profile has been updated";
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
			echo $error;
		}
	}
	
	//==============================
    //==============================
    //STOCK DRINKS
    //==============================
    //==============================

	public function stock(){
		$this->verify();
		$data['title']=$this->cashier_model->fetch_store()->STORE_NAME." :: Stock";
		$this->load->view('cashier/parts/head',$data);
		$this->load->view('cashier/stock/stock',$data);
		$this->load->view('cashier/parts/bottom',$data);
	}
	
	//FETCH LIST OF DRINKS IN STOCK
	public function fetchDrinksStock(){
		$data['drinks']=$this->cashier_model->fetch_drinks_in_stock();
		$this->load->view('cashier/stock/stockedDrinks', $data);
	}

	//==============================
    //==============================
    //PRODUCTS
    //==============================
    //==============================

	public function products(){
		$this->verify();
		$data['title']=$this->cashier_model->fetch_store()->STORE_NAME."| Products";
		$this->load->view('cashier/parts/head',$data);
		$this->load->view('cashier/products/products',$data);
		$this->load->view('cashier/parts/bottom',$data);
	}


	//FETCH PRODUCTS LIST
	public function fetch_product_list(){
		$data['product_list']=$this->cashier_model->fetch_product_list();
		$this->load->view('cashier/products/productList', $data);
	}

	
	
	//==============================
    //==============================
    //SALES
    //==============================
    //==============================

	public function sales(){
		$this->verify();
		$data['title']=$this->cashier_model->fetch_store()->STORE_NAME." :: Sales";
		
		$this->load->view('cashier/parts/head',$data);
		$this->load->view('cashier/sales/sales',$data);
		$this->load->view('cashier/parts/bottom',$data);
	}


	//FETCH PRODUCTS ALLOCATED TO CASHIER
	public function fetch_allocated_stock(){
		$this->verify();
			$data['products']=$this->cashier_model->fetch_allocated_stock($_SESSION['staff_id']);
			if($data['products']==1){
				echo "<div class='alert alert-info'><h3 class='text-center'>Sales has been posted before for this staff</h3></div>";
			}
			elseif ($data['products']==2) {
				echo "<div class='alert alert-info'><h3 class='text-center'>No products was allocated to this staff today</h3></div>";
			}
			else{
				$this->load->view('cashier/sales/allocated', $data);
			}
	}


	//POST SALES RECORD
	public function post_sales(){
		$this->verify();
		$this->load->library('form_validation');
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
						'STAFF_ID'=>$_SESSION['staff_id'],
						'PRODUCT_ID'=>$product,
						'QUANTITY_SOLD'=>$quantity_sold,
						'DATE_ADDED'=>date('Y-m-d'),
						'SALES_PRICE'=>$sales_price,
						'COST_PRICE'=>$cost_price,
						'LEFTOVER'=>$leftover
					);					
					$this->cashier_model->post_sales($sales);
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
		$data['title']=$this->cashier_model->fetch_store()->STORE_NAME." :: Financial Reports";
		$data['daily_report']=$this->cashier_model->fetch_daily_sales_report();
		$this->load->view('cashier/parts/head',$data);
		$this->load->view('cashier/reports/reports',$data);
		$this->load->view('cashier/parts/bottom',$data);
	}

	

	//GENERATE SALES RECORDS BASED ON SALES DATE
	public function sales_reports_day(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Sales date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->cashier_model->fetch_store()->STORE_NAME;
			$date=date('Y-m-d', strtotime($this->input->post('date')));
			$data['date']=$date;
			$data['report']=$this->cashier_model->sales_report_day($date);
			
			$this->load->view('cashier/reports/generalDailysales',$data);
		}
	}

	//GENERATE SALES SHEET
	public function sales_sheet(){
		$this->verify();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Sales Date', 'required');
		if($this->form_validation->run()){
			$data['cafeteria']=$this->cashier_model->fetch_store()->STORE_NAME;
			$report=array(
				'DATE'=> $this->input->post('date'),
				'STAFF_ID'=>$_SESSION['staff_id']
			);
			$data['date']=$this->input->post('date');
			$data['report']=$this->cashier_model->sales_sheet($report);
			$this->load->view('cashier/reports/saleSheet',$data);
		}
	}


	//REPORTS ON DASHBOARD
	public function daily_sales_reports_dashboard(){
		$report=$this->cashier_model->sales_report_day(date('Y-m-d'));
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
		$report=$this->cashier_model->sales_report_month($month);

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

	


	


	

	
	
	
	

    






	
	


}