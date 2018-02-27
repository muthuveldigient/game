<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player_Search extends CI_Controller {

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		// to protect the controller to be accessed only by registered users
		if(($this->session->userdata('adminuserid')) == ''){
			redirect('login', 'refresh');
		}
		
		define("Title", "Search Player");
		$this->load->library('form_validation');
		$this->load->model("PlayerSearch_model");
		$this->load->helper("security");
	} 
	public function index()
	{
		try
		{
			$data = array();
			$this->load->view('search/player_search',$data);
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			// return show_error($err->getMessage());
		}
		
	}
	
	public function search()
	{
		try
		{
			$data = $this->PlayerSearch_model->index();
			echo $data; die;
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			// return show_error($err->getMessage());
		}
		
	}
	
	public function update_status(){
		
		try
		{
			$post = $this->input->post();
			$data = $this->PlayerSearch_model->update_status($post);
			echo $data; die;
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			// return show_error($err->getMessage());
		}
	}
}

