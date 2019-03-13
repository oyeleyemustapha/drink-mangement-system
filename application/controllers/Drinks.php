<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drinks extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('drinks_model');  
    }

    
	//HOME PAGE
	public function index(){
		$data['store_name']=$this->drinks_model->fetch_store()->STORE_NAME;
		$this->load->view('login' , $data);
	}

	//PROCESS LOGIN
	public function login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run()){
			$username=strtoupper(trim($this->input->post('username')));
			$password=md5(strtolower(trim($this->input->post('password'))));
			if($this->drinks_model->process_login($username, $password)){
				$staff=$this->drinks_model->process_login($username, $password);
					$staff_id=$staff->STAFF_ID;
					$username=$staff->USERNAME;
					$password=$staff->PASSWORD;
					$name=$staff->NAME;
					$role=$staff->ROLE;
					$session_data=array(
						'username' => $username, 
						'password' => $password, 
						'staff_id'=>$staff_id, 
						'name'=>$name,
						'role'=>$role
					);

					$log=array(
						'STAFF_ID'=>$staff_id,
						'TIME_LOGGED'=>date('Y-m-d h:i:s')
					);

				$this->drinks_model->log_staff($log);
				$this->session->set_userdata($session_data);

				switch ($role) {
					case 'Administrator':
						redirect(base_url()."administrator");	
						break;
					case 'Supervisor':
						redirect(base_url()."supervisor");	
						break;
					case 'Cashier':
						redirect(base_url()."cashier");	
						break;
				}	
			}
			else{
				$this->session->set_flashdata('error', 'Invalid Username or password');
				redirect(base_url());
			}	
		}
		else{
			$this->index();
		}
	}

	//LOGOUT
	public function logout(){
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('staff_id');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('role');
		redirect(base_url());
	}

	
}
