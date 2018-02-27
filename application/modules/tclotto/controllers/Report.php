<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()	{
		$this->load->view('tc/index');
	}
        
          public function loginprocess() {
        try {
            /** to protect the controller to be accessed only by registered users */
            if(($this->session->userdata('adminuserid')) != ''){
                redirect('dashboard', 'refresh');
            }
            
            if (!empty($_POST)) {

                // set validation rules
                // $this->form_validation->set_rules('word', 'captcha', 'trim|required|xss_clean|callback_check_captcha');
                $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_admin');


                if ($this->form_validation->run() == true) {

                    $result = $this->Login_model->index();
                    $this->redirection();
                }
            }

            $data['image'] = $this->create_captcha();
            $this->load->view('login', $data);
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
