<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 	Search transaction model Management class created by kumar.
*	Purpose  : Control transaction.
*	Date of create : Dec 20 2017
**/
class Searchtransaction_model extends CI_Model
{
	function __construct(){
        parent::__construct();
		$this->load->database();
		$this->load->model("Datatable_model");
		$this->load->helper('date');
		$this->load->model("Dberr_model");
    }
	
	// Use to set table name, columns name to sort data, and return result to datatable.
	public function index(){
		
		if(isset($_POST)) {
			$formDoor = $_POST;
			// check if the formDoor field is actually an array
			if(is_array($formDoor)) {
				// combine the array values into a string
				$data = json_encode($formDoor);
			}
		}
		// DB table to use
		$table = 'partner as p';

		// Table's primary key
		$primaryKey = 'PARTNER_NAME';
		
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		$columns = array(
			array( 'db' => 'PARTNER_NAME', 'dt' => 0 ),
			array( 'db' => 'PARTNER_USERNAME', 'dt' => 1 ),
			array( 'db' => 'PARTNER_TYPE', 'dt' => 2 ),
			array( 'db' => 'PARTNER_EMAIL', 'dt' => 3 ),
			array( 'db' => 'PARTNER_PHONE', 'dt' => 4 ),
			array( 'db' => 'CREATED_ON', 'dt' => 5 )
		);
		
		
		
		$getData = $this->getData($_POST, $table, $primaryKey, $columns);
		return $getData;
	}
	
	// Use to set data based on datatable designed.
	public function getData($request, $table, $primaryKey, $columns){
		
		$recordsTotal = $this->Datatable_model->recordsTotal($table);
		$recordsFiltered = $this->recordsFiltered($request,$table,$columns);
		$data = $this->data($request,$table,$columns);
		$array = array("draw"=>intval($request['draw']),"recordsTotal"=>intval($recordsTotal),
			"recordsFiltered"=>intval($recordsFiltered),"data"=>$data
		);
		return json_encode($array);
		
	}
	
	// Use to bind data based on datatable.
	public function binding_data($result){
		
		$binding_data = array();
		
		foreach($result as $key=>$val){
		
			$binding_data[] = array($val['PARTNER_NAME'],$val['PARTNER_USERNAME'],$val['PARTNER_TYPE'],$val['PARTNER_EMAIL'],$val['PARTNER_PHONE'],$val['CREATED_ON'],$val['PARTNER_ID'],$val['PARTNER_STATUS']);
			
		}
		return $binding_data; 
	}
	
	// Use to filter and search data with user input.
	public function data($request,$table,$columns){
		
		$bindings = array();
		$this->db2->select('p.PARTNER_NAME,p.PARTNER_USERNAME,p.PARTNER_EMAIL,p.PARTNER_PHONE,p.CREATED_ON,p.PARTNER_ID,p.PARTNER_STATUS,pt.PARTNER_TYPE');
		$this->db2->join('partners_type pt', 'p.PARTNER_TYPE_ID = pt.PARTNER_TYPE_ID', 'left');
		
		/* search condition */
		if($request['username'] != ''){
			$this->db2->where('p.PARTNER_USERNAME',$request['username']);
		}
		if($request['name'] != ''){
			$this->db2->where('p.PARTNER_NAME',$request['name']);
		}
		if($request['email'] != ''){
			$this->db2->where('p.PARTNER_EMAIL',$request['email']);
		}
		if($request['contact_number'] != ''){
			$this->db2->where('p.PARTNER_PHONE',$request['contact_number']);
		}
		if($request['partner_type'] != ''){
			$this->db2->where('p.PARTNER_TYPE_ID',$request['partner_type']);
		}
		
		if($request['selected_datatime'] != ''){
			$selected_datatime = explode("&",$request['selected_datatime']);
			$start = date("Y-m-d h:m:s", strtotime($selected_datatime[0]));
			$end = date("Y-m-d h:m:s", strtotime($selected_datatime[1]));
			$where = "DATE_FORMAT(p.CREATED_ON,'%Y-%m-%d %h:%m:%s') BETWEEN '".$start."' AND '".$end."'";
			$this->db2->where($where);
		}
		/* search condition */
		
		/* order by */
		$order = $this->Datatable_model->order($request, $columns);
		$order = explode(',',$order);
		$this->db2->order_by($order[0], $order[1]);
		/* order by */
		
		/* limit */
		if ( isset($request['start']) && isset($request['length']) &&  $request['start'] != 0) {
			$this->db2->limit($request['length'],$request['start']);
		}else{
			
			if($request['length'] != ''){
				$this->db2->limit($request['length']);
			}else{
				$this->db2->limit(10);
			}
			
		}
		/* limit */
		$query = $this->db2->get($table);
		if(!$query)
		{
			$this->Dberr_model->index();
		}
		//echo $this->db2->last_query(); die;
		$result = $query->result_array();
		$binding_data = $this->binding_data($result);
		return $binding_data;
		
	}
	
	// Use to get count of filter and search data with user input.
    public function recordsFiltered($request,$table,$columns){
		
		$this->db2->select('count(*) as recordsFiltered');
		$this->db2->join('partners_type pt', 'p.PARTNER_TYPE_ID = pt.PARTNER_TYPE_ID', 'left');
		
		/* search condition */
		if($request['username'] != ''){
			$this->db2->where('p.PARTNER_USERNAME',$request['username']);
		}
		if($request['name'] != ''){
			$this->db2->where('p.PARTNER_NAME',$request['name']);
		}
		if($request['email'] != ''){
			$this->db2->where('p.PARTNER_EMAIL',$request['email']);
		}
		if($request['contact_number'] != ''){
			$this->db2->where('p.PARTNER_PHONE',$request['contact_number']);
		}
		if($request['partner_type'] != ''){
			$this->db2->where('p.PARTNER_TYPE_ID',$request['partner_type']);
		}
		
		if($request['selected_datatime'] != ''){
			$selected_datatime = explode("&",$request['selected_datatime']);
			$start = date("Y-m-d h:m:s", strtotime($selected_datatime[0]));
			$end = date("Y-m-d h:m:s", strtotime($selected_datatime[1]));
			$where = "DATE_FORMAT(p.CREATED_ON,'%Y-%m-%d %h:%m:%s') BETWEEN '".$start."' AND '".$end."'";
			$this->db2->where($where);
		}
		/* search condition */
		
		$query = $this->db2->get($table);
		if(!$query)
		{
			$this->Dberr_model->index();
		}
		$result = $query->result_array();
		return $result[0]['recordsFiltered']; 
	}
	
	public function update_status(){
		
		$data =  array(
			'PARTNER_STATUS' => $this->db->escape_str($this->input->post('status'))
		);
		$this->db2->where('PARTNER_ID',$this->db->escape_str($this->input->post('partner_id')));
		if(!$this->db2->update('partner',$data))
		{
			$this->Dberr_model->index();
		}
		return $this->db2->affected_rows();
	}
	
	
}
?>
