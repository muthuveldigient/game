<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->database();
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
        $this->load->library('session');
        $this->load->model("Game_model");
        $this->load->model("report_model");
        $this->load->model("common/common_model");

        $sql = "select * from lucky7_games where STATUS=1";
        $rsResult = $this->db2->query($sql);
        $result = $rsResult->result();
        $i = 1;
        foreach ($result as $row) {
            define("GAME_" . $i, $row->GAMES_NAME);
            define("GAME_DESCRIPTION_" . $i, $row->DESCRIPTION);
            $i++;
        }

        if (($this->session->userdata(SESSION_USERID)) == '') {
            redirect('index', 'refresh');
        }
        $data['homeURL'] = base_url() . 'rajarani/web/';
        $data['headerLogoURL'] = base_url().'assets/web/';
        $this->load->view('common/report_header', $data);
    }

    public function gamehistory() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        $data['start'] = '';
        $data['end'] = '';
        
        if (!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
            $data['start']  = $_POST['startdate'];
            $data['end']    = $_POST['enddate'];
        }
        $data ['GAME_ID']      = RR_GAME_ID;
        $data['TERMINAL_ID']   = $SESSION_USERID ;
                    
        $data['viewTickets'] = $this->report_model->viewTickets($data);
              
        $this->load->view('common/gamehistory', $data);
    }

    public function ledger() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        $data['start'] = '';
        $data['end'] = '';
        
        if (!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
            $data['start']  = $_POST['startdate'];
            $data['end']    = $_POST['enddate'];
        }
        $data['user_id']   = $SESSION_USERID ;
                    
        $data['transaction'] = $this->report_model->getUserTransactionHistroy($data);
        $this->load->view('common/ledger', $data);
    }

    public function userprofile() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $data['USER_ID']=$SESSION_USERID;
        $data['getTerminalBal'] = $this->report_model->getUserDetails( $data );
        $this->load->view('common/userprofile', $data);
    }

    public function drawhistory() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        $data['start'] = '';
        $data['end'] = '';
        
        if (!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
            $data['start']  = $_POST['startdate'];
            $data['end']    = $_POST['enddate'];
        }
        $data ['GAME_ID']      = RR_GAME_ID;
        //$data['TERMINAL_ID']   = $SESSION_USERID ;
        
        $data['result'] = $this->report_model->getDrawResults($data);
      //  echo '<pre>';print_r($data['result']);exit;
        $this->load->view('common/drawhistory', $data);
    }

    public function changepassword() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        $msgText ='';
	if(isset($_POST["old_password"]) && isset($_POST["password_confirm"])) {
		$msgText="Please enter valid new and old password";
		if(!empty($_POST["old_password"]) && !empty($_POST["password_confirm"])) {
			$arrChangePassword["PASSWORD"]    =md5($_POST["old_password"]);
			$arrChangePassword["USER_ID"]     =$SESSION_USERID;
			$chkOldPassword=$this->report_model->chkUserOldPassword($arrChangePassword);	
			if($chkOldPassword->PASSWORD == $arrChangePassword["PASSWORD"] ) {
                            $update['PASSWORD']=md5($_POST["new_password"]);
                            $changePassword=$this->report_model->updatePassword($update,$SESSION_USERID);
                            $msgText="Failed to update password";
                            if($changePassword){
                                $msgText="success";
                            }
			} else {
                            $msgText="Invalid old password";	
			}
		} 
	}
        $data['msgText']=$msgText;
        $this->load->view('common/changepassword', $data);
    }

}
