<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
//        $this->load->model("Dberr_model");
    }

    // Admin login validate.
    public function validate_login() {

        $username = $this->db2->escape_str($this->input->post('username'));
        $password = md5($this->db2->escape_str($this->input->post('password')));

        $this->db2->where('USERNAME', $username);
        $this->db2->where('ACCOUNT_STATUS', 1);
        $this->db2->where('USER_TYPE', 1);
        $query = $this->db2->get('user');

//        if (!$query) {
//            // Prevent from database error.
//            $this->Dberr_model->index();
//        }
        $row = $query->row();
 
        if (empty($row)) {

            $loginStatus = 4; // Login failed.
            //Admin login tracking.
            $this->admin_tracking($loginStatus, $username);
            //Function to get admin login failed tracking count.
            //$rowcount = $this->admin_login_failed_count($username);
            //if ((int) $rowcount > 3) {
            // Alert admin by mail or sms if login failed more then 3 times.
            //   $this->alert_admin();
            // }
            $res = 2;
        } else {

            $password_h = $row->PASSWORD;
            if ( $password === $password_h ) {
                $this->set_session($row);
                $res = 1;
            } else {
                $res = 2;
            }
        }
        return $res;
    }

    //Admin login tracking function .
    public function admin_tracking($loginStatus, $username) {

        //tracking admin login
        $action = 'Web Login';
        $date_time = date("Y-m-d H:m:s");
        $systemIP = $_SERVER['REMOTE_ADDR'];
        $reference = '';
        $USER_ID = '10001';
        $systemMac = '';
        $status = 1;
        $TRACKING_DATA = 1;
        $loginStatus = $loginStatus; // 3 = login Success.
        $updateDate = date("Y-m-d H:m:s");

        $data = array(
            "TRACKING_DATA" => $TRACKING_DATA,
            "USER_ID" => $USER_ID,
            "USERNAME" => $username,
            "ACTION_NAME" => $action,
            "DATE_TIME" => $date_time,
            "SYSTEM_IP" => $systemIP,
            "REFERRENCE_NO" => $reference,
            "SYSTEM_MAC" => $systemMac,
            "STATUS" => $status,
            "LOGIN_STATUS" => $loginStatus,
            "UPDATED_DATE" => $updateDate
        );

        $this->db2->insert('admin_tracking', $data);
       // if (!$this->db2->insert('admin_tracking', $data)) {
            // Prevent from database error.
           // $this->Dberr_model->index();
      //  }
    }

    //Setting session to admin login user and update session id into admin_user table.

    public function set_session($row) {
        /** set session key in user table */
        $keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789" . $row->USERNAME;
        $sessionID = substr(str_shuffle($keyString), 0, 13);

        $data = array('SESSION_ID' => $sessionID, 'LOGIN_STATUS' => 1);
        $this->db2->where('ADMIN_USER_ID', $row->USER_ID);
        $this->db2->update('user', $data);

        $userdata = array(
            SESSION_USERID => $row->USER_ID,
            SESSION_USERNAME => $row->USERNAME,
            SESSION_USEREMAIL => $row->EMAIL_ID,
            SESSION_USERCONTACT => $row->CONTACT,
            SESSION_PARTNERID => $row->PARTNER_ID,
            SESSIONID => $sessionID
        );

        $this->session->set_userdata($userdata);
    }

}

?>
