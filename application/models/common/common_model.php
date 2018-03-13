<?php
class Common_model extends CI_Model {
	 function __construct() {
        parent::__construct();
        $this->load->database();
    }
	  
	function getServerTime(){
		$this->db2->select('NOW() as dateTime');
		$browseSQL = $this->db2->get('');
		$res = $browseSQL->row();
		return $res->dateTime;
	}
	
	function userAuthendication() {
		$SESSION_USERID = $this->session->userdata(SESSION_USERID);
		$SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        $SESSIONID = $this->session->userdata(SESSIONID);
		
		$this->db2->select('USER_ID,ACCOUNT_STATUS');
		$this->db2->where('USER_ID',$SESSION_USERID);
		$this->db2->where('SESSION_ID',$SESSIONID);
		$this->db2->where('ACCOUNT_STATUS',1);
		$resultData = $this->db2->get('user');
		$res = $resultData->row();
		if(empty($res)) {
			/** tracking info */
			$arrTraking["DATE_TIME"] 	= date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$SESSION_USERNAME;
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM2"]      =1;
			$arrTraking["ACTION_NAME"]  ="Logout";
			$arrTraking["CUSTOM1"]      =json_encode(array('failure'=>'Auto logout'));
			$this->db2->insert("tracking",$arrTraking);
			/** tracking info end */
			session_destroy();
			return 1;
		}
		return 0;
	}
	
	function sessionStatus(){
		$SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
		
		/** tracking info */
		$arrTraking["DATE_TIME"] 	= date('Y-m-d h:i:s');
		$arrTraking["USERNAME"]     =$SESSION_USERNAME;
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM2"]      =1;
		/** tracking info end */

		//check current user status
		if($SESSION_USERID != ''){
		  //get the current users status
			$loginUserStaus = $this->getLoginUserStatus($SESSION_USERID);
			 if(!empty($loginUserStaus)){//check record exist or not
				$currentStatus = $loginUserStaus->ACCOUNT_STATUS;
				$currentPassword = $loginUserStaus->PASSWORD;
				//check the status: if current status is deactivate then redirect to logout page
				if($currentStatus == 0){
					//insert into log
					$arrTraking["ACTION_NAME"]  ="Logout";
					$arrTraking["CUSTOM1"]      =json_encode(array('failure'=>'Auto logout - Account Deactivated'));
					$this->db->insert("tracking",$arrTraking);
					$this->session->sess_destroy();
					//$this->session->set_flashdata('message', 'Account Deactivated.');
					//redirect('index');
					return 1;
				}//EO: Status check
				/*
				//check password: if current password and session password not same then redirect to logout page
				if($currentPassword != $sessionPartnerPassword){
					//insert into log
					$arrTraking["ACTION_NAME"]  ="Logout";
					$arrTraking["CUSTOM1"]      =json_encode(array('failure'=>'Auto logout - Password Modified'));
					$this->db->insert("tracking",$arrTraking);
					$this->session->sess_destroy();
					$this->session->set_flashdata('message', 'Password Modified Please Login.');
					redirect('index');
				}//EO: Password check
				*/
			}//EO: record count check
		}//EO: Sesison user Id check
	}
	
	public function getLoginUserStatus($SESSION_USERID){
		$this->db->select('*');
		$this->db->where('USER_ID',$SESSION_USERID);
		$resultData = $this->db->get('user');
		return $resultData->row();
	}
	
	
}
