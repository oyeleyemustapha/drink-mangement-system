<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Administrator_model extends CI_Model{


 	//VERIFY ADMINISTRATOR
 	function verify_user($username, $password){
 		$this->db->select('*');
 		$this->db->from('staff');
 		$this->db->where('USERNAME', $username);
 		$this->db->where('PASSWORD', $password);
 		$this->db->where('ROLE', 'Administrator');
 		$query= $this->db->get();
 		if ($query->num_rows()==1) {
 			return true;
 		}
 		else{
 			return false;
 		}
 	}


 	//=====================
 	//=====================
 	//STORE SETTING
 	//=====================
 	//=====================


 	//FETCH STORE settings
 	function fetch_store(){
 		$this->db->select('*');
 		$this->db->from('settings');
 		$query= $this->db->get();
 		if ($query->num_rows()==1) {
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}

 	//UPDATE STORE SETTINGS
 	function update_store_settings($store){
		if($this->db->update('settings', $store)){
			return true;
		}
		else{
			return false;
		}
 	}


 	//=====================
 	//=====================
 	//STAFF LOGS
 	//=====================
 	//=====================

 	//FETCH STAFF LOGS
 	function fetch_staff_logs(){
 		$this->db->select('STAFF.NAME, STAFF.ROLE, staff_logs.TIME_LOGGED');
 		$this->db->from('staff_logs');
 		$this->db->join('staff', 'staff.STAFF_ID=staff_logs.STAFF_ID', 'left');
 		$this->db->order_by('staff_logs.TIME_LOGGED', 'DESC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}

 	//CLEAR LOGS
 	function clear_staff_logs(){
 		$this->db->where('LOG_ID >', 0);
 		if($this->db->delete('staff_logs')){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}


 	//=========================
 	//==========================
 	//STAFF
 	//=========================
 	//=========================
 

 	//ADD STAFF
 	function add_staff($staff_info){
 		if($this->db->insert('staff', $staff_info)){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}

 	//FETCH STAFF LIST
 	function fetch_staff_list(){
 		$this->db->select('*');
 		$this->db->from('staff');
 		$this->db->order_by('STAFF_ID', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//DELETE STAFF
 	function delete_staff($staff_id){
 		$this->db->where('STAFF_ID', $staff_id);
 		if($this->db->delete('staff')){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}

 	//FETCH STAFF INFO
 	function fetch_staff_info($staff_id){
 		$this->db->select('*');
 		$this->db->from('staff');
 		$this->db->where('STAFF_ID', $staff_id);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}

 	//UPDATE STAFF ACCOUNT
 	function update_staff($staff){
 		$this->db->where('STAFF_ID', $staff['STAFF_ID']);
		if($this->db->update('staff', $staff)){
			return true;
		}
		else{
			return false;
		}
 	}



 	//===================
 	//===================
 	//PRODUCTS
 	//===================
 	//===================

 	//ADD PRODUCT
 	function add_product($product){
 		if($this->db->insert('products', $product)){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}

 	//FETCH PRODUCTS LIST
 	function fetch_product_list(){
 		$this->db->select('*');
 		$this->db->from('products');
 		$this->db->order_by('PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH PRODUCT INFO
 	function fetch_product_info($product_id){
 		$this->db->select('*');
 		$this->db->from('products');
 		$this->db->where('PRODUCT_ID', $product_id);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}

 	//UPDATE PRODUCT INFOMATION
 	function update_product($product){
 		$this->db->where('PRODUCT_ID', $product['PRODUCT_ID']);
		if($this->db->update('products', $product)){
			return true;
		}
		else{
			return false;
		}
 	}


 	//FETCH PRODUCT LIST TO BE USED IN SELECT2 PLUGIN
 	function fetch_product_list_select($search){
 		$this->db->select('PRODUCT_ID, PRODUCT');
 		$this->db->from('products');
 		$this->db->where('PRODUCT REGEXP', $search);
 		$query=$this->db->get();
 		return $query->result_array();
 	}



 	//================
 	//================
 	//STOCK
 	//================
 	//=================

 	//FETCH DRINK LIST
 	function fetch_drink_list(){
 		$this->db->select('*');
 		$this->db->from('products');
 		$this->db->order_by('PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}



 	//ADD DRINKS TO STOCK
 	function add_drink_stock($product){
 		$this->db->select('*');
 		$this->db->from('stock');
 		$this->db->where('PRODUCT_ID', $product['PRODUCT_ID']);
 		$this->db->where('STAFF_ID', $product['STAFF_ID']);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			$quantity=$product['QUANTITY'];
	 		$this->db->set('QUANTITY', "QUANTITY+$quantity", FALSE);
	 		$this->db->where('PRODUCT_ID', $product['PRODUCT_ID']);
	 		$this->db->where('STAFF_ID', $product['STAFF_ID']);
			$this->db->update('stock');	
 		}      
 		else{
 			if($this->db->insert('stock', $product)){
	 			return true;
	 		}
	 		else{
	 			return false;
	 		}
 		}
 	}

 	//FETCH LIST OF DRINKS IN STOCK
 	function fetch_drinks_in_stock(){
 		$this->db->select('products.PRODUCT_NAME, stock.QUANTITY, products.COST_PRICE, products.SALES_PRICE, stock.QUANTITY_SOLD, staff.NAME');
 		$this->db->from('stock');
 		$this->db->join('products', 'stock.PRODUCT_ID=products.PRODUCT_ID', 'left');
 		$this->db->join('staff', 'staff.STAFF_ID=stock.STAFF_ID', 'left');
 		$this->db->where('stock.DATE_ADDED', date('Y-m-d'));
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}



 	//===================
 	//==================
 	//SALES
 	//=================
 	//=================

 	//FETCH ALLOCATED STOCK FOR A PARTICULAR USER
 	function fetch_allocated_stock($staff){
 		//CHECK IF SALES HAS BEEN POSTED BEFORE
 		$this->db->select('*');
 		$this->db->from('sales');
 		$this->db->where('STAFF_ID', $staff);
 		$this->db->where('DATE', date('Y-m-d'));
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return 1;
 		}
 		else{
 			$this->db->select('products.PRODUCT_NAME, stock.QUANTITY, products.SALES_PRICE, products.COST_PRICE, stock.PRODUCT_ID');
	 		$this->db->from('stock');
	 		$this->db->join('products', 'stock.PRODUCT_ID=products.PRODUCT_ID', 'left');
	 		$this->db->where('stock.STAFF_ID', $staff);
	 		$this->db->where('stock.DATE_ADDED', date('Y-m-d'));
	 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
	 		$query=$this->db->get();
	 		if($query->num_rows()>0){
	 			return $query->result();
	 		}
	 		else{
	 			return 2;
	 		}
 		}	
 	}


 	//POST SALES
 	function post_sales($sales){
 			$quantity_sold=$sales['QUANTITY_SOLD'];
	 		$this->db->set('QUANTITY_SOLD', $quantity_sold);
	 		$this->db->where('PRODUCT_ID', $sales['PRODUCT_ID']);
	 		$this->db->where('STAFF_ID', $sales['STAFF_ID']);
	 		$this->db->where('DATE_ADDED', $sales['DATE_ADDED']);
			if($this->db->update('stock')){


				//ADD LEFTOVER TO THE NEXT DAY STOCK
				$stock_for_next_day=array(
					'PRODUCT_ID'=>$sales['PRODUCT_ID'],
					'STAFF_ID'=>$sales['STAFF_ID'],
					'QUANTITY'=>$sales['LEFTOVER'],
					'QUANTITY_SOLD'=>0,
					'DATE_ADDED'=>date('Y-m-d', strtotime('+1 day'))
				);
				$this->db->insert('stock', $stock_for_next_day);


				//LOG SALES IN SALES TABLE
				$sales_record=array(
					'PRODUCT_ID'=>$sales['PRODUCT_ID'],
					'QUANTITY'=>$sales['QUANTITY_SOLD'],
					'STAFF_ID'=>$sales['STAFF_ID'],
					'DATE'=>$sales['DATE_ADDED'],
					'COST_PRICE'=>$sales['COST_PRICE'],
					'SALES_PRICE'=>$sales['SALES_PRICE']
				);
				if($this->db->insert('sales', $sales_record));
				return true;
			}
			else{
				return false;
			}
 		
 	}


 	
 	
 	


















	//UPDATE PASSWORD
	public function update_password($password){
		$this->db->set('PASSWORD', $password);
 		$this->db->where('STAFF_ID', $_SESSION['staff_id']);
		if($this->db->update('staff')){
			return true;
		}
		else{
			return false;
		}
	}


	//================
 	//================
 	//SALES REPORT
 	//================
 	//=================



	//FETCH DAILY SALES FOR THE CURRENT DAY
 	function fetch_daily_sales_report(){
 		$this->db->select('products.PRODUCT_NAME, SUM(sales.QUANTITY) SALES, sales.COST_PRICE, sales.SALES_PRICE, sales.DATE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('sales.DATE', date('Y-m-d'));
 		$this->db->group_by(array('sales.PRODUCT_ID', 'sales.COST_PRICE', 'sales.SALES_PRICE'));
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH DAILY SALES FOR THE CURRENT DAY
 	function sales_report_day($date){
 		$this->db->select('products.PRODUCT_NAME, SUM(sales.QUANTITY) SALES, products.COST_PRICE, products.SALES_PRICE, sales.DATE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('sales.DATE', $date);
 		$this->db->group_by(array('sales.PRODUCT_ID', 'sales.COST_PRICE', 'sales.SALES_PRICE'));
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH MONTHLY SALES FOR A PARTICULAR MONTH AND YEAR
 	function sales_report_month($month){
 		$this->db->select('products.PRODUCT_NAME, SUM(sales.QUANTITY) SALES, products.COST_PRICE, products.SALES_PRICE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('MONTH(sales.DATE)', $month['MONTH']);
 		$this->db->where('YEAR(sales.DATE)', $month['YEAR']);
 		$this->db->group_by(array('sales.PRODUCT_ID', 'sales.COST_PRICE', 'sales.SALES_PRICE'));
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH ANNUAL REPORTS FOR A PARTICULAR YEAR
 	function sales_report_annual($year){
 		$this->db->select('products.PRODUCT_NAME, SUM(sales.QUANTITY) SALES, products.COST_PRICE, products.SALES_PRICE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('YEAR(sales.DATE)', $year);
 		$this->db->group_by(array('sales.PRODUCT_ID', 'sales.COST_PRICE', 'sales.SALES_PRICE'));
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}



 	//FETCH DAILY SALES FOR THE CURRENT DAY FOR A PARTICULAR STAFF USUALLY A CASHIER
 	function sales_report_day_staff($report){
 		$this->db->select('products.PRODUCT_NAME, products.COST_PRICE, products.SALES_PRICE, sales.QUANTITY SALES, sales.DATE,  staff.NAME');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->join('staff', 'sales.STAFF_ID=staff.STAFF_ID', 'left');
 		$this->db->where('sales.DATE', $report['DATE']);
 		$this->db->where('sales.STAFF_ID', $report['STAFF_ID']);
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}

 	//FETCH GENERAL DAILY SALES FOR THE CURRENT DAY
 	function sales_report_day_general($report){
 		$this->db->select('products.PRODUCT, products.COST_PRICE, products.SALES_PRICE, sales.SALES_DATE, sales.ORDER_NO, sales.QUANTITY_SOLD, staff.NAME, sales.STATUS');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->join('staff', 'sales.STAFF_ID=staff.STAFF_ID', 'left');

 		if($report['SALES_DATE']=="" and isset($report['MONTH'])){
 			$this->db->where('MONTH(sales.SALES_DATE)', $report['MONTH']);
 			$this->db->where('YEAR(sales.SALES_DATE)', date('Y'));
 		}
 		elseif(isset($report['SALES_DATE']) and $report['MONTH']==""){
 			$this->db->where('sales.SALES_DATE', $report['SALES_DATE']);
 		}
 		
 		$this->db->order_by('sales.STAFF_ID', 'DESC');
 		$this->db->order_by('staff.NAME', 'DESC');
 		$this->db->where('sales.STATUS', 'Confirmed');
 		$this->db->order_by('products.LABEL_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//SALES SHEET
 	function sales_sheet($report){

 		
 		$this->db->select('products.PRODUCT_NAME, sum(stock.QUANTITY) QUANTITY, sum(stock.QUANTITY_SOLD) QUANTITY_SOLD, products.COST_PRICE, products.SALES_PRICE');
 		$this->db->from('stock');
 		$this->db->join('products', 'products.PRODUCT_ID=stock.PRODUCT_ID', 'left');
 		$this->db->where('stock.DATE_ADDED', $report['DATE']);
 		$this->db->group_by(array('stock.PRODUCT_ID', 'products.COST_PRICE', 'products.SALES_PRICE'));
 		$this->db->order_by('products.PRODUCT_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}



 




 	

 	



 	
	
	
	


 	
 	
 	




}


?>