<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Drinks_model extends CI_Model{


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

 	//LOG STAFF LOG IN
 	function log_staff($log){
 		if($this->db->insert('staff_logs', $log)){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}


 	//PROCESS LOGIN
 	function process_login($username, $password){
 		$this->db->select('*');
 		$this->db->from('staff');
 		$this->db->where('USERNAME', $username);
 		$this->db->where('PASSWORD', $password);
 		$query= $this->db->get();
 		if ($query->num_rows()==1) {
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}

 	

 	//==========================
 	//==========================
 	//WALLET
 	//==========================
 	//===========================


 	//FETCH WALLET LIST TO BE USED IN SELECT2 PLUGIN
 	function fetch_wallet_list_select($search){
 		$this->db->select('WALLET_NUMBER');
 		$this->db->from('wallet');
 		$this->db->where('WALLET_NUMBER REGEXP', $search);
 		$this->db->where('AMOUNT > ', 0);
 		$query=$this->db->get();
 		return $query->result_array();
 	}

 	function check_wallet_no($wallet_no){
 		$this->db->select('WALLET_NUMBER');
 		$this->db->from('wallet');
 		$this->db->where('WALLET_NUMBER', $wallet_no);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}


 	//CREATE WALLET ACCOUNT
 	function create_wallet($wallet){
 		if($this->db->insert('wallet', $wallet)){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}

 	//LOG WALLET TRANSACTION
 	function log_wallet_transaction($log){
 		$this->db->insert('wallet_log', $log);
 	}


 	//FETCH WALLETS
 	function fetch_wallets(){
 		$this->db->select('*');
 		$this->db->from('wallet');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH WALLET INFO
 	function fetch_wallet($wallet_no){
 		$this->db->select('*');
 		$this->db->from('wallet');
 		$this->db->where('WALLET_NUMBER', $wallet_no);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH WALLET LOG
 	function fetch_wallet_log($wallet_no){
 		$this->db->select('*');
 		$this->db->from('wallet_log');
 		$this->db->where('WALLET_NUMBER', $wallet_no);
 		$this->db->order_by('DATE', 'DESC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//DELETE WALLET
 	function delete_wallet($wallet_no){
 		//CHECK IF THE WALLET HAS CREDIT
 		$this->db->select('*');
 		$this->db->from('wallet');
 		$this->db->where('WALLET_NUMBER', $wallet_no);
 		$this->db->where('AMOUNT >', 0);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return false;
 		}
 		else{
 			$this->db->where('WALLET_NUMBER', $wallet_no);
	 		if($this->db->delete('wallet')){
	 			return true;
	 		}
 		}
 	}

 	//UPDATE WALLET
 	function update_wallet($wallet){
 		$this->db->where('WALLET_NUMBER', $wallet['WALLET_NUMBER']);
		if($this->db->update('wallet', $wallet)){
			return true;
		}
		else{
			return false;
		}
 	}

 	function fund_wallet($wallet){
 		$amount=$wallet['AMOUNT'];
 		$this->db->set('AMOUNT', "AMOUNT+$amount", FALSE);
 		$this->db->where('WALLET_NUMBER', $wallet['WALLET_NUMBER']);
		if($this->db->update('wallet')){
			return true;
		}
		else{
			return false;
		}
 	}




 	
 	//FETCH DRINK STOCK LOGS
 	function fetch_drinkstock_logs(){
 		$this->db->select('drinks.NAME DRINK, staff.NAME STAFFNAME, drinkstocklog.DATE, drinkstocklog.QUANTITY');
 		$this->db->from('drinkstocklog');
 		$this->db->join('staff', 'staff.STAFF_ID=drinkstocklog.STAFF', 'left');
 		$this->db->join('drinks', 'drinks.DRINK_ID=drinkstocklog.DRINK', 'left');
 		$this->db->order_by('drinkstocklog.DATE', 'DESC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}

 	//=========================
 	//==========================
 	//STOCK DRINKS
 	//=========================
 	//=========================

 	//ADD DRINKS TO STOCK
 	function add_drink_stock($product){
 		$log=array(
				'DRINK'=>$product['DRINK'],
				'QUANTITY'=>$product['QUANTITY'],
				'DATE'=>date('Y-m-d'),
				'STAFF'=>$_SESSION['staff_id']
			);
 		$this->db->select('*');
 		$this->db->from('drinkstock');
 		$this->db->where('DRINK', $product['DRINK']);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			$quantity=$product['QUANTITY'];
	 		$this->db->set('QUANTITY', "QUANTITY+$quantity", FALSE);
	 		$this->db->where('DRINK', $product['DRINK']);
			$this->db->update('drinkstock');	
			$this->log_stock($log);	
 		}      
 		else{
 			if($this->db->insert('drinkstock', $product)){
 				$this->log_stock($log);	
	 			return true;
	 		}
	 		else{
	 			return false;
	 		}
 		}
 	}

 	//ALLOCATE DRINKS TO STAFF
 	function allocate_drinks($product){
 		$log=array(
				'DRINK'=>$product['DRINK'],
				'QUANTITY'=>$product['QUANTITY'],
				'DATE'=>$product['DATE'],
				'STAFF'=>$product['STAFF']
			);
 		$quantity=$product['QUANTITY'];
 		$drink=$product['DRINK'];
 		$this->db->select('*');
 		$this->db->from('staffstock');
 		$this->db->where('DRINK', $product['DRINK']);
 		$this->db->where('DATE', $product['DATE']);
 		$this->db->where('STAFF', $product['STAFF']);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			
	 		$this->db->set('QUANTITY', "QUANTITY+$quantity", FALSE);
	 		$this->db->where('DRINK', $product['DRINK']);
	 		$this->db->where('DATE', $product['DATE']);
 			$this->db->where('STAFF', $product['STAFF']);
			$this->db->update('staffstock');	
			$this->log_staffstock($log);
			$this->deduct_drinks($quantity, $drink);
 		}      
 		else{
 			if($this->db->insert('staffstock', $product)){
 				$this->log_staffstock($log);
 				$this->deduct_drinks($quantity, $drink);	
	 			return true;
	 		}
	 		else{
	 			return false;
	 		}
 		}

 		

 	}


 	//DEDUCT DRINKS FROM DRINKS STOCK
 	function deduct_drinks($quantity, $drink){
 		//UPDATE THE DRINK STOCK
 		$this->db->set('QUANTITY', "QUANTITY-$quantity", FALSE);
	 	$this->db->where('DRINK', $drink);
		$this->db->update('drinkstock');
 	}

 	//LOG STOCK
 	function log_stock($log){
 		$this->db->insert('drinkstocklog', $log);
 	}

 	//LOG STOCK TO STAFF STOCK
	function log_staffstock($log){
 		$this->db->insert('staffstocklog', $log);
 	}
 	//FETCH LIST OF DRINKS IN STOCK
 	function fetch_drinks_in_stock(){
 		$this->db->select('drinks.NAME, drinkstock.QUANTITY, drinks.COST_PRICE, drinks.SELLING_PRICE');
 		$this->db->from('drinkstock');
 		$this->db->join('drinks', 'drinks.DRINK_ID=drinkstock.DRINK', 'left');
 		$this->db->order_by('drinks.NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH LIST OF DRINKS TO ALLOCATE TO STAFF
 	function fetch_drinks_with_stock(){
 		$this->db->select('drinks.NAME, drinkstock.QUANTITY, drinks.DRINK_ID');
 		$this->db->from('drinkstock');
 		$this->db->join('drinks', 'drinks.DRINK_ID=drinkstock.DRINK', 'left');
 		$this->db->where('drinkstock.QUANTITY >', 0);
 		$this->db->order_by('drinks.NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//=========================
 	//==========================
 	//PRODUCTS (DRINKS)
 	//=========================
 	//=========================

 	
 

 	//ADD DRINKS
 	function add_drink($product){
 		if($this->db->insert('drinks', $product)){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}

 	//FETCH DRINK LIST
 	function fetch_drink_list(){
 		$this->db->select('*');
 		$this->db->from('drinks');
 		$this->db->order_by('NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//FETCH DRINK
 	function fetch_drink($product_id){
 		$this->db->select('*');
 		$this->db->from('drinks');
 		$this->db->where('DRINK_ID', $product_id);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}

 	//UPDATE DRINK
 	function update_drink($product){
 		$this->db->where('DRINK_ID', $product['DRINK_ID']);
		if($this->db->update('drinks', $product)){
			return true;
		}
		else{
			return false;
		}
 	}


 	//=========================
 	//==========================
 	//PRODUCTS (FOODS)
 	//=========================
 	//=========================
 

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
 		$this->db->order_by('LABEL_NAME', 'ASC');
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



 	//=========================
 	//==========================
 	//SALES PRODUCTS
 	//=========================
 	//=========================
 

 	//ADD SALES PRODUCT
 	function add_sales_products($product){
 		$this->db->select('*');
 		$this->db->from('products_to_sell');
 		$this->db->where('PRODUCT_ID', $product['PRODUCT_ID']);
 		$this->db->where('DATE_ADDED', $product['DATE_ADDED']);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			$sales_quantity=$product['QUANTITY'];
	 		$this->db->set('QUANTITY', "QUANTITY+$sales_quantity", FALSE);
	 		$this->db->where('PRODUCT_ID', $product['PRODUCT_ID']);
 			$this->db->where('DATE_ADDED', $product['DATE_ADDED']);
			$this->db->update('products_to_sell');	
 		}      
 		else{
 			if($this->db->insert('products_to_sell', $product)){
	 			return true;
	 		}
	 		else{
	 			return false;
	 		}
 		}
 		
 	}


 	//FETCH SALES PRODUCTS LIST FOR A PARTICULAR DATE
 	function fetch_sales_product_list($date){
 		$this->db->select('products.PRODUCT, products_to_sell.QUANTITY, products_to_sell.ID, products_to_sell.DATE_ADDED');
 		$this->db->from('products_to_sell');
 		$this->db->join('products', 'products_to_sell.PRODUCT_ID=products.PRODUCT_ID', 'left');
 		$this->db->where('products_to_sell.DATE_ADDED', $date);
 		$this->db->order_by('products.LABEL_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}



 	


 	//FETCH PRODUCT INFO
 	function fetch_sales_product_info($id){
 		$this->db->select('products.PRODUCT, products_to_sell.QUANTITY, products_to_sell.ID, products.PRODUCT_ID');
 		$this->db->from('products_to_sell');
 		$this->db->join('products', 'products_to_sell.PRODUCT_ID=products.PRODUCT_ID', 'left');
 		$this->db->where('products_to_sell.ID', $id);
 		$query=$this->db->get();
 		if($query->num_rows()==1){
 			return $query->row();
 		}
 		else{
 			return false;
 		}
 	}


 	//UPDATE SALES PRODUCT INFOMATION
 	function update_sales_product($product){
 		$this->db->where('ID', $product['ID']);
		if($this->db->update('products_to_sell', $product)){
			return true;
		}
		else{
			return false;
		}
 	}


 	



 	//FETCH DAILY SALES FOR THE CURRENT DAY
 	function fetch_daily_sales_report(){
 		$this->db->select('products.PRODUCT, SUM(sales.QUANTITY_SOLD) SALES, products.COST_PRICE, products.SALES_PRICE, sales.SALES_DATE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('sales.SALES_DATE', date('Y-m-d'));
 		$this->db->where('sales.STATUS','Confirmed');
 		$this->db->group_by('sales.PRODUCT_ID');
 		$this->db->order_by('products.LABEL_NAME', 'ASC');
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
 		$this->db->select('products.PRODUCT, SUM(sales.QUANTITY_SOLD) SALES, products.COST_PRICE, products.SALES_PRICE, sales.SALES_DATE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('sales.SALES_DATE', $date);
 		$this->db->where('sales.STATUS', 'Confirmed');
 		$this->db->group_by('sales.PRODUCT_ID');
 		$this->db->order_by('products.LABEL_NAME', 'ASC');
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
 		else{
 			$this->db->where('sales.SALES_DATE', date('Y-m-d'));
 		}
 		$this->db->where('sales.STAFF_ID', $report['STAFF_ID']);
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


 	//FETCH SALES RECORD BASED ON ORDER NUMBER
 	function sales_records_order_no($order_no){
 		$this->db->select('sales.SALES_ID, products.PRODUCT, sales.AMOUNT, sales.SALES_DATE, sales.ORDER_NO,, sales.SALES_ID, sales.QUANTITY_SOLD, staff.NAME, sales.STATUS');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->join('staff', 'sales.STAFF_ID=staff.STAFF_ID', 'left');
 		$this->db->where('sales.ORDER_NO', $order_no);
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
 		$this->db->select('products.PRODUCT, SUM(sales.QUANTITY_SOLD) SALES, products.COST_PRICE, products.SALES_PRICE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('MONTH(sales.SALES_DATE)', $month['MONTH']);
 		$this->db->where('YEAR(sales.SALES_DATE)', $month['YEAR']);
 		$this->db->where('sales.STATUS', 'Confirmed');
 		$this->db->group_by('sales.PRODUCT_ID');
 		$this->db->order_by('products.LABEL_NAME', 'ASC');
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
 		$this->db->select('products.PRODUCT, SUM(sales.QUANTITY_SOLD) SALES, products.COST_PRICE, products.SALES_PRICE');
 		$this->db->from('sales');
 		$this->db->join('products', 'products.PRODUCT_ID=sales.PRODUCT_ID', 'left');
 		$this->db->where('YEAR(sales.SALES_DATE)', $year);
 		$this->db->where('STATUS', 'Confirmed');
 		$this->db->group_by('sales.PRODUCT_ID');
 		$this->db->order_by('products.LABEL_NAME', 'ASC');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->result();
 		}
 		else{
 			return false;
 		}
 	}


 	//CANCEL ALL ORDERS
 	function cancel_orders_all($order_no){
 		$this->db->select('PRODUCT_ID, QUANTITY_SOLD,SALES_DATE');
 		$this->db->from('sales');
 		$this->db->where('ORDER_NO', $order_no);
 		$this->db->where('STATUS', "Confirmed");
 		$query=$this->db->get();
 		if($query->num_rows()>0){

 			$sales=$query->result();

 			foreach ($sales as $sales) {
 				$product=$sales->PRODUCT_ID;
 				$quantity=$sales->QUANTITY_SOLD;
 				$date=$sales->SALES_DATE;

 				$this->db->set('QUANTITY', "QUANTITY+$quantity", FALSE);
 				$this->db->where('PRODUCT_ID', $product);
 				$this->db->where('DATE_ADDED', $date);
 				if($this->db->update('products_to_sell')){

 					$this->db->set('STATUS', "Canceled");
 					$this->db->where('ORDER_NO', $order_no);
 					$this->db->update('sales');		

					return true;
				}
				else{
					return false;
				}
 			}



 		}
 	}


 	//CANCEL SPECIFIC PRODUCT ORDER
 	function cancel_specific_order($sales_id){
 		$this->db->select('PRODUCT_ID, QUANTITY_SOLD,SALES_DATE');
 		$this->db->from('sales');
 		$this->db->where('SALES_ID', $sales_id);
 		$this->db->where('STATUS', "Confirmed");
 		$query=$this->db->get();
 		if($query->num_rows()==1){

 			$sales=$query->row();

 				$product=$sales->PRODUCT_ID;
 				$quantity=$sales->QUANTITY_SOLD;
 				$date=$sales->SALES_DATE;

 				$this->db->set('QUANTITY', "QUANTITY+$quantity", FALSE);
 				$this->db->where('PRODUCT_ID', $product);
 				$this->db->where('DATE_ADDED', $date);
 				if($this->db->update('products_to_sell')){

 					$this->db->set('STATUS', "Canceled");
 					$this->db->where('SALES_ID', $sales_id);
 					$this->db->update('sales');		

					return true;
				}
				else{
					return false;
				}
 		}
 	}

 	//FETCH THE TOTAL NUMBER OF ORDERS FOR A DAY
 	function fetch_no_order(){
 		$this->db->select('SUM(ORDER_NO)');
 		$this->db->from('sales');
 		$this->db->where('SALES_DATE', date('Y-m-d'));
 		$this->db->where('STATUS', 'Confirmed');

 		$this->db->group_by('ORDER_NO');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->num_rows();
 		}
 		else{
 			return 0;
 		}
 	}





 	
	
	//FETCH THE TOTAL NUMBER OF ORDERS FOR A DAY FOR A PARTICULARC STAFF
 	function fetch_no_order_staff(){
 		$this->db->select('SUM(ORDER_NO)');
 		$this->db->from('sales');
 		$this->db->where('SALES_DATE', date('Y-m-d'));
 		$this->db->where('STATUS', 'Confirmed');
 		$this->db->where('STAFF_ID', $_SESSION['staff_id']);
 		$this->db->group_by('ORDER_NO');
 		$query=$this->db->get();
 		if($query->num_rows()>0){
 			return $query->num_rows();
 		}
 		else{
 			return 0;
 		}
 	}




}


?>