<?php
class this{
    public function __construct() {
        $this->load();
    }

    /**
     * Load the databases and ignore the old ordinary CI loader which only allows one
     */
    public function load() {
            $CI =& get_instance();
            $this->db = $CI->load->database('default', TRUE);
            $this->db2 = $CI->load->database('db2', TRUE);
            $this->db3 = $CI->load->database('db3', TRUE);
			return $this;
    }
 }
 
 ?>