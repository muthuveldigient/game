<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 	Search transaction model Management class created by kumar.
*	Purpose  : Control transaction.
*	Date of create : Dec 20 2017
**/
class PlayerSearch_model extends CI_Model
{
	function __construct(){
        parent::__construct();
		$this->load->database();
		$this->load->model("Datatable_model");
		$this->load->helper('date');
		$this->load->model("Dberr_model");
    }
	
	// Use to set table name, columns name to sort data, and return result to datatable.
	public function index() {
		// echo '<pre>'; print_r($_POST); exit;
		// DB table to use
		$table = 'users';
		
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		$columns = array(
			array( 'db' => 'fullname', 	'dt' => 0 ),
			array( 'db' => 'username', 	'dt' => 1 ),
			array( 'db' => 'email', 	'dt' => 2 ),
			array( 'db' => 'status', 	'dt' => 3 ),
			array( 'db' => 'datetime', 	'dt' => 4 )
		);
		
		$getData = $this->getData($_POST, $table, $columns);
		return $getData;
	}
	
	// Use to set data based on datatable designed.
	public function getData($request, $table, $columns) {
		$recordsTotal 	 = $this->Datatable_model->recordsTotal($table);
		$recordsFiltered = $this->recordsFiltered($request, $table, $columns);
		$data 			 = $this->data($request, $table, $columns);
		$array 			 = array(
			"draw" 			  => !empty( $request['draw'] ) ? intval( $request['draw'] ) : 0,
			"recordsTotal"	  => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data"			  => $data
		);
		return json_encode($array);
	}

	// Use to get count of filter and search data with user input.
    public function recordsFiltered($request, $table, $columns) {
		
		$this->db->select('count(*) as recordsFiltered');
		
		/* search condition */
		if( !empty($request['username']) ) {
			$this->db->where('username', $request['username']);
		}
		if( !empty($request['email']) ) {
			$this->db->where('email', $request['email']);
		}
		if( !empty($request['status']) ) {
			$request['status'] = $request['status'] == 2 ? 0 : 1;
			$this->db->where('status', $request['status']);
		}
		if( !empty($request['login_type']) ) {
			$this->db->where('login_type', $request['login_type']);
		}
		
		if( !empty($request['selected_datatime']) ) {
			$selected_datatime = explode( "&", $request['selected_datatime'] );
			$start = date("Y-m-d h:m:s", strtotime($selected_datatime[0]));
			$end   = date("Y-m-d h:m:s", strtotime($selected_datatime[1]));
			$where = "DATE_FORMAT(datetime,'%Y-%m-%d %h:%m:%s') BETWEEN '".$start."' AND '".$end."'";
			$this->db->where($where);
		}
		/* search condition */
		
		$query = $this->db->get($table);
		if(!$query)
		{
			$this->Dberr_model->index();
		}
		$result = $query->row_array();
		return $result['recordsFiltered']; 
	}
	
	// Use to filter and search data with user input.
	public function data($request, $table, $columns) {

		$bindings = array();
		$this->db->select('user_id, fullname, username, email, datetime, status');
		
		/* search condition */
		if( !empty($request['username']) ) {
			$this->db->where('username', $request['username']);
		}
		if( !empty($request['email']) ) {
			$this->db->where('email', $request['email']);
		}
		if( !empty($request['status']) ) {
			$request['status'] = $request['status'] == 2 ? 0 : 1;
			$this->db->where('status', $request['status']);
		}
		if( !empty($request['login_type']) ) {
			$this->db->where('login_type',$request['login_type']);
		}
		
		if( !empty($request['selected_datatime']) ) {
			$selected_datatime = explode("&",$request['selected_datatime']);
			$start = date("Y-m-d h:m:s", strtotime($selected_datatime[0]));
			$end   = date("Y-m-d h:m:s", strtotime($selected_datatime[1]));
			$where = "DATE_FORMAT(datetime,'%Y-%m-%d %h:%m:%s') BETWEEN '".$start."' AND '".$end."'";
			$this->db->where($where);
		}
		/* search condition */
		
		/* order by */
		$order = $this->Datatable_model->order($request, $columns);
		$order = explode(',', $order);
		$this->db->order_by($order[0], $order[1]);
		/* order by */
		
		/* limit */
		if ( isset($request['start']) && isset($request['length']) &&  $request['start'] != 0 ) {
			$this->db->limit($request['length'], $request['start']);
		} else {
			if( !empty($request['length']) ) {
				$this->db->limit($request['length']);
			} else {
				$this->db->limit(10);
			}
		}
		/* limit */

		$query = $this->db->get($table);
		if( !$query )
		{
			$this->Dberr_model->index();
		}
		$result 	  = $query->result_array();
		// echo $this->db->last_query(); die;
		// echo '<pre>'; print_r($result); exit;
		$binding_data = $this->binding_data($result);
		return $binding_data;
	}

	// Use to bind data based on datatable.
	public function binding_data($result) {
		$binding_data = array();
		foreach( $result as $key => $val ) {
			$binding_data[] = array($val['fullname'], $val['username'], $val['email'], $val['datetime'], $val['status'], $val['user_id']);
			
		}
		return $binding_data; 
	}
	
	public function update_status($post) {
		
		$data =  array(
			'status' => $this->db->escape_str($post['status'])
		);
		$this->db->where('user_id', $this->db->escape_str( $post['player_id'] ));
		if(!$this->db->update('users', $data))
		{
			$this->Dberr_model->index();
		}
		return $this->db->affected_rows();
	}
	
}
?>
