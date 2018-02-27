<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		// to protect the controller to be accessed only by registered users
		if(($this->session->userdata('adminuserid')) == ''){
			redirect('login', 'refresh');
		}
		
		define("Title","Search Transaction");
		$this->load->library('form_validation');
		$this->load->model("Searchtransaction_model");
		$this->load->model("Partners_model");
		$this->load->helper("security");
	} 
	public function index()
	{
		try
		{
			$data['partner_type'] = $this->Partners_model->partner_type();
			$this->load->view('search_transaction',$data);
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			//return show_error($err->getMessage());
		}
		
	}
	
	public function search()
	{
		try
		{
			$data = $this->Searchtransaction_model->index();
			echo $data; die;
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			//return show_error($err->getMessage());
		}
		
	}
	
	public function update_status(){
		
		try
		{
			$data = $this->Searchtransaction_model->update_status();
			echo $data; die;
		}
		catch(Exception $err)
		{
			log_message("error", $err->getMessage());
			//return show_error($err->getMessage());
		}
	}
}

