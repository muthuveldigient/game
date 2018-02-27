<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player_Register extends CI_Controller {

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		// to protect the controller to be accessed only by registered users
		if(($this->session->userdata('adminuserid')) == ''){
			redirect('login', 'refresh');
		}
		
		define("Title", "Register");
		$this->load->library('form_validation');
		$this->load->model("PlayerRegister_model");
		$this->load->helper("security");
		$this->load->view("header");
		$this->load->view("end_header");
	} 
	public function index()
	{
		try
		{
			if( !empty( $_POST ) ) {
				
				// set validation rules
				$validation_list = array("fullname", "password", "gender", "age", "country");

			    foreach( $validation_list as $value ) {
			    	$this->form_validation->set_rules($value, $value, 'trim|required|xss_clean');
			    }
				$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean|is_unique[users.username]');
   				$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|is_unique[users.email]');
				
				if ( $this->form_validation->run() == true ) {
					$post   = $this->input->post();
					$result = $this->PlayerRegister_model->register_player($post);
					$this->session->set_flashdata('msg_success','Player registered successfully.');
					redirect('player/player_search', 'refresh');
				}
			}

			$this->load->view('register/register_player');
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			//return show_error($err->getMessage());
		}
		
	}
	
	public function get_player_details()
	{
		try
		{
			// http://localhost/cricket_mom/player/player_register/get_player_details?user_id=14
			if( !empty($_POST) ) {
				
				// set validation rules
				$this->form_validation->set_rules('playerId', 'playerId', 'trim|required|xss_clean');
				
				if ( $this->form_validation->run() == true ) {
					$user_id = $this->input->post('playerId');
					$data['player'] = $this->PlayerRegister_model->get_player_details($user_id);
					// echo '<pre>'; print_r($data); exit;
					$this->load->view('register/edit_register_player', $data);
				}
			} else {
				$this->session->set_flashdata('msg_error','Something went wrong. Please try again.');
				redirect('player/player_search', 'refresh');
			}
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			//return show_error($err->getMessage());
		}
		
	}

	public function update_player_details()
	{
		try
		{
			if( !empty( $_POST ) ) {
				
				// set validation rules
				$validation_list = array("user_id", "fullname", 'username', 'email', "password", "gender", "age", "country");

			    foreach( $validation_list as $value ) {
			    	$this->form_validation->set_rules($value, $value, 'trim|required|xss_clean');
			    }
				
				if ( $this->form_validation->run() == true ) {
					$post = $this->input->post();
					$this->PlayerRegister_model->update_player_details($post);
					$this->session->set_flashdata('msg_success','Player details updated successfully.');
					redirect('player/player_search', 'refresh');
				}
				
			} else {
				$this->session->set_flashdata('msg_error','Something went wrong. Please try again.');
				redirect('player/player_search', 'refresh');
			}
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			//return show_error($err->getMessage());
		}
		
	}
	
}

