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
}


?>