<?php
class Autoload{
    public function __construct() {
		$CI =& get_instance();
		$this->db = $CI->load->database('default', TRUE);
		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->gamename();
    }
	
	public function gamename(){
		/** define rajrani games name */
		$sql = "select * from lucky7_games where STATUS=1";
		$rsResult = $this->db2->query($sql);
		$result = $rsResult->result();
		$i = 1;
		foreach ($result as $row) {
			define("GAME_" . $i, $row->GAMES_NAME);
			define("GAME_DESCRIPTION_" . $i, $row->DESCRIPTION);
			$i++;
		}
	}
	
	
	
 }
 
 ?>