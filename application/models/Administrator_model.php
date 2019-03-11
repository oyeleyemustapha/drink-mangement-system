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



	


 	//GET STAFF NAME
 	function staff_name($id){
 		$this->db->select('NAME');
 		$this->db->from('staff');
 		$this->db->where('STAFF_ID', $id);
 		$query=$this->db->get();
 		return $query->row();
 	}


 	//CLEAR CHANGE
 	function pay_change($change){
 		$amt=$change['AMOUNT'];
 		$this->db->set('DATE_CLEARED', $change['DATE_CLEARED']);
 		$this->db->set('CLEARED_BY', $change['CLEARED_BY']);
 		$this->db->set('STATUS', $change['STATUS']);
 		$this->db->set('AMOUNT', "AMOUNT-$amt", FALSE);
 		$this->db->where('PIN', $change['PIN']);
 		if($this->db->update('pin')){
 			return true;
 		}
 		else{
 			return false;
 		}
 	}



 	//CHANGES NOT PAID BY STAFF FOR THE CURRENT DATE
 	function change_not_paid_by_staff_day($staff_id){
 		$this->db->select('SUM(AMOUNT) AMOUNT');
 		$this->db->from('pin');
 		$this->db->where('CREATED_BY', $staff_id);
 		$this->db->where('STATUS', 'NOT PAID');
 		$this->db->where('DATE(DATE_CREATED)', date('Y-m-d'));
 		$query=$this->db->get();
 		if($query->row()->AMOUNT){
 			return $query->row()->AMOUNT;
 		}
 		else{
 			return 0;
 		}
 		
 	}

 
 	//CHANGES NOT PAID BY STAFF FOR THE CURRENT MONTH
 	function change_not_paid_by_staff_month($staff_id){
 		$this->db->select('SUM(AMOUNT) AMOUNT');
 		$this->db->from('pin');
 		$this->db->where('CREATED_BY', $staff_id);
 		$this->db->where('STATUS', 'NOT PAID');
 		$this->db->where('MONTH(DATE_CREATED)', date('m'));
 		$query=$this->db->get();
 		if($query->row()->AMOUNT){
 			return $query->row()->AMOUNT;
 		}
 		else{
 			return 0;
 		}
 	}


 	//GET LIST OF UNPAID CHANGE PIN
 	function get_list_of_unpaid_change(){
 		$this->db->select('pin.ID, pin.NAME, pin.STATUS,  pin.PIN, pin.AMOUNT, pin.DATE_CREATED, staff.NAME STAFF');
 		$this->db->from('pin');
 		$this->db->join('staff', 'pin.CREATED_BY=staff.STAFF_ID', 'left');
 		$this->db->order_by('DATE_CREATED', 'DESC');
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