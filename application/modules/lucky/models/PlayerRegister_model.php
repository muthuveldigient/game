<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 	Search transaction model Management class created by kumar.
*	Purpose  : Control transaction.
*	Date of create : Dec 20 2017
**/
class PlayerRegister_model extends CI_Model
{
	function __construct(){
        parent::__construct();
		$this->load->database();
		$this->load->model("Dberr_model");
    }
	
	public function register_player($post){
		
		$post['login_type'] = 1;
		$post['status'] 	= 1;
		$post['datetime'] 	= date('Y-m-d H:i:s');
		foreach( $post as $key => $value ) {
			if( $key == 'password' ) {
				$data['password'] = password_hash( $this->db->escape_str($value), PASSWORD_DEFAULT );
			} else {
				$data[$key] = $this->db->escape_str($value);
			}
	    }

		if( !$this->db->insert('users', $data) ) {
			$this->Dberr_model->index();
		}
		
	}

	public function get_player_details($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('users');
		if( !$query )
		{
			$this->Dberr_model->index();
		}
		return $query->row_array();
	}

	public function update_player_details($post){
		
		$post['login_type'] = 1;
		$post['datetime'] 	= date('Y-m-d H:i:s');
		foreach( $post as $key => $value ) {
			if( $key == 'password' ) {
				$data['password'] = password_hash( $this->db->escape_str($value), PASSWORD_DEFAULT );
			} else {
				$data[$key] = $this->db->escape_str($value);
			}
	    }

		$this->db->where('user_id', $data['user_id']);
		if( !$this->db->update('users', $data) )
		{
			$this->Dberr_model->index();
		}
		
	}
	
}
?>
