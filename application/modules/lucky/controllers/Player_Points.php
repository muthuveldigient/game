<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player_Points extends CI_Controller {

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		// to protect the controller to be accessed only by registered users
		if(($this->session->userdata('adminuserid')) == ''){
			redirect('login', 'refresh');
		}
		
		define("Title", "Adjust Points");
		$this->load->library('form_validation');
		$this->load->model("PlayerPoints_model");
		$this->load->helper("security");
		$this->load->view("header");
		$this->load->view("end_header");
	}

	public function get_player_points()
	{
		try
		{
			if( !empty($_POST) ) {
				
				// set validation rules
				$this->form_validation->set_rules('playerId', 'playerId', 'trim|required|xss_clean');
				
				if ( $this->form_validation->run() == true ) {
					$user_id = $this->input->post('playerId');
					$data['default_result'] = $this->PlayerPoints_model->get_player_point_details($user_id);
					// echo '<pre>'; print_r($data); exit;
					$this->load->view('points/points_view_edit', $data);
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

	public function player_points_update()
	{
		try
		{
			if( !empty( $_POST ) ) {
				
				// set validation rules
				$validation_list = array("user_id", "current_xps", 'current_coins', 'current_gems');

			    foreach( $validation_list as $value ) {
			    	$this->form_validation->set_rules($value, $value, 'trim|required|xss_clean');
			    }
				
				if ( $this->form_validation->run() == true ) {
					$post = $this->input->post();
					$this->PlayerPoints_model->update_player_points($post);
					$this->session->set_flashdata('msg_success','Player points updated successfully.');
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

