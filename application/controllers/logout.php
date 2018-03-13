<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends CI_Controller
{
        
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->library('session');
	}
    
	public function index($err = NULL) {
		$SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
		
		$update = array("LOGIN_STATUS" => 0 );
		$this->db2->where("USER_ID",$SESSION_USERID);
		$this->db2->update("user",$update);

		/** tracking info */
		$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
		$arrTraking["USERNAME"]     =SESSION_USERNAME;
		$arrTraking["ACTION_NAME"]  ="Web Logout";
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM1"]      ='Web Logout';
		$arrTraking["CUSTOM2"]      =1;
		$this->db2->insert("tracking",$arrTraking);
		$this->session->sess_destroy();
		
		redirect('index');
	}
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */