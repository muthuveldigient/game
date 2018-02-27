<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 	Search transaction model Management class created by kumar.
*	Purpose  : Control transaction.
*	Date of create : Dec 20 2017
**/
class PlayerPoints_model extends CI_Model
{
	function __construct(){
        parent::__construct();
		$this->load->database();
		$this->load->model("Datatable_model");
		$this->load->helper('date');
		$this->load->model("Dberr_model");
    }
	
	public function get_player_point_details($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_setting');
		if( !$query )
		{
			$this->Dberr_model->index();
		}
		return $query->row_array();
	}

	public function update_player_points($post) {
		foreach( $post as $key => $value ) {
			$data[$key] = $this->db->escape_str($value);
	    }

		$this->db->where('user_id', $data['user_id']);
		if( !$this->db->update('user_setting', $data) )
		{
			$this->Dberr_model->index();
		}
	}
	
}
?>
