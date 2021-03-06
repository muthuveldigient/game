<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
        $this->load->library('session');
        $this->load->model("Login_model");
    }

    public function index() {
        $this->load->view('tclotto/index');
    }

    public function loginprocess() {
        try {
            /** to protect the controller to be accessed only by registered users */
//            if (($this->session->userdata(SESSION_USERID)) != '') {
//                redirect('home', 'refresh');
//            }

            if (!empty($_POST['username']) && !empty($_POST['password'])) {
               $result = $this->Login_model->validate_login($_POST);
            }else{
                $result = '5';
            }
           if($result==1){
               redirect('tclotto/home');
           }else{
               $this->session->set_flashdata('message', 'Invalid login please try again');
                redirect('tclotto/login');
           }
        } catch (Exception $err) {
            log_message("error", $err->getMessage());
            //return show_error($err->getMessage());
        }
    }

    public function check_captcha($string) {
        if ($string == $this->session->userdata('captchaword')) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_captcha', 'Please enter correct code');
            return FALSE;
        }
    }

    // validate admin login details with database.
    public function check_admin() {
        $result = $this->Login_model->validate_login();
        if (!$result) {
            $this->form_validation->set_message('check_admin', 'Invalid Login.Please try again.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // redirection based on role.
    public function redirection() {
        //check if the partner type is affiliate or not
        $partner_type_id = $this->session->userdata('partnertypeid');
        if ($partner_type_id == 2) {
            //redirect('reports/affiliateturnover/index?rid=93');
            redirect('dashboard');
        } else if ($partner_type_id == 5) {
            //redirect('reports/affiliate/index?rid=88');
            redirect('dashboard');
        } else {
            //redirect('user/account/search?rid=10&start=1');
            redirect('dashboard');
        }
    }

    // Captcha configuration.
    private function create_captcha() {
        try {
            $this->load->helper('captcha');
            // we will set all the variables needed to create the captcha image
            $options = array(
                'font_path' => FCPATH . 'captcha/font/texb.ttf',
                'img_path' => FCPATH . 'assets/captcha/',
                'img_url' => site_url() . 'assets/captcha/',
                'img_width' => '60',
                'img_height' => 35,
                'word_length' => 3,
                'expiration' => 7200,
                'colors' => array(
                    'background' => array(255, 255, 255),
                    'border' => array(60, 141, 188),
                    'text' => array(0, 0, 0),
                    'grid' => array(255, 255, 255)
                )
            );
            //now we will create the captcha by using the helper function create_captcha()
            $cap = create_captcha($options);
            // we will store the image html code in a variable
            $image = $cap['image'];
            // ...and store the captcha word in a session
            $this->session->unset_userdata('captchaword');
            $this->session->set_userdata('captchaword', $cap['word']);
            // we will return the image html code
            return $image;
        } catch (Exception $err) {
            log_message("error", $err->getMessage());
            //return show_error($err->getMessage());
        }
    }

    // ajax captcha reload function.
    public function refresh() {

        $image = $this->create_captcha();
        // Display captcha image
        echo $image;
    }

}
