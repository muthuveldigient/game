<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

   function viewTickets($searchArray, $limit=50,$offset=0) {
        $startDate = (!empty($req['start'])?date('Y-m-d', strtotime($req['start'])).' 00:00:00':'');
        $endDate = (!empty($req['end'])?date('Y-m-d', strtotime($req['end'])).' 23:59:59':'');
        
       $this->db2->select('d.DRAW_WINNUMBER,t.TICKET_ID,d.DRAW_NUMBER,d.DRAW_STARTTIME,t.BET_TYPE,t.GAME_TYPE_ID,t.INTERNAL_REFERENCE_NO,t.PARTNER_ID,t.BET_VALUE,t.BET_NUMBER,t.BET_AMOUNT_VALUE,t.CREATED_DATE,t.UPDATED_DATE,t.STATUS,t.WIN_NUMBER,t.TOTAL_BET,t.TOTAL_WIN');
       $this->db2->join('lotto_draw as d','t.DRAW_ID=d.DRAW_ID','left');

        if(!empty($searchArray["DRAW_ID"]))
                $this->db2->where("t.DRAW_ID",$searchArray["DRAW_ID"]);
        if(!empty($searchArray["TICKET_NUMBER"]))
                $this->db2->where("t.INTERNAL_REFERENCE_NO",$searchArray["TICKET_NUMBER"]);
        if(!empty($searchArray["GAME_ID"]))
                $this->db2->where("d.DRAW_GAME_ID=",$searchArray["GAME_ID"]);
        if(!empty($searchArray["TERMINAL_ID"]))
                $this->db2->where("t.TERMINAL_ID",$searchArray["TERMINAL_ID"]);
        if (!empty($searchArray['start']) && !empty($searchArray['end'])){
                $this->db2->where("t.CREATED_DATE BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY t.TICKET_ID DESC LIMIT $offset,$limit");
        }else{
                $this->db2->order_by("t.TICKET_ID", 'DESC');
                $this->db2->limit($limit,$offset);
        }

        $rsResult = $this->db2->get('lucky7_lotto_tickets as t');
        return $rsResult->result();
    }
    
    
    function getUserTransactionHistroy($req){
        $cond = array();
        $param = array();
        $histroyInfo = array();

        $userId	= (!empty($req['user_id'])?$req['user_id']:'');
        $limit	= (!empty( $req['limit'])?$req['limit']:LIMIT_COUNT);
        $offset = (!empty( $req['offset'])?$req['offset']:0);

        $this->db2->select('*');
        if(!empty($userId)){
            $this->db2->where_in('h.USER_ID',$userId);
        }

        if (!empty($req['start']) && !empty($req['end'])){
                $this->db2->where("h.TRANSACTION_DATE BETWEEN '".date('Y-m-d', strtotime($req['start']))." 00:00:00' AND '".date('Y-m-d', strtotime($req['end']))." 23:59:59'");
                $this->db2->order_by("h.TRANSACTION_DATE", 'DESC');
        }else{
                $this->db2->order_by("h.TRANSACTION_DATE", 'DESC');
                $this->db2->limit($limit,$offset);
        }
        $rsResult = $this->db2->get('master_transaction_history as h');
      //  echo $this->db2->last_query();exit;
        return $rsResult->result();
    }
    
    function getDrawResults($req) {
        $gameID = (!empty($req['GAME_ID'])?$req['GAME_ID']:'');
        $startDate = (!empty($req['start'])?date('Y-m-d', strtotime($req['start'])).' 00:00:00':'');
        $endDate = (!empty($req['end'])?date('Y-m-d', strtotime($req['end'])).' 23:59:59':'');
        
        $this->db2->where('DRAW_STATUS>=',3);
        if(!empty($gameID)){
            $this->db2->where('DRAW_GAME_ID',$gameID);
        }
        if (!empty($req['start']) && !empty($req['end'])){
               $this->db2->where("DRAW_STARTTIME BETWEEN '".$startDate."' AND '".$endDate."'");
        }else{
            $this->db2->order_by('DRAW_ID','DESC');
            $this->db2->limit(LIMIT_COUNT);
        }
        $rsResult = $this->db2->get('lotto_draw');
        //echo $this->db2->last_query();exit;
        return $rsResult->result();
    }
    
    function chkUserOldPassword($arrChangePassword) {
        $this->db2->select('USER_ID,PASSWORD');
        if(!empty($arrChangePassword["USER_ID"])){
            $this->db2->where("USER_ID",$arrChangePassword["USER_ID"]);
        }
        $rsResult = $this->db2->get('user');
        return $rsResult->row();
    }
    
    function updatePassword($arrChangePassword, $userId ) {
        if( empty($arrChangePassword) || empty($userId)){
            return 0;
        }
        $this->db2->where('USER_ID', $userId);
        $rsResult = $this->db2->update('user',$arrChangePassword);
        return $rsResult;
    }
    
    function getUserDetails($data) {
        $terminalID = (!empty($data["USER_ID"])?$data["USER_ID"]:'');
        $this->db2->select('*')
                    ->join('user as u', 'u.USER_ID=up.USER_ID');
        
        if(!empty($terminalID)){
            $this->db2->where('up.USER_ID',$terminalID);
        }
        
        $rsResult = $this->db2->get('user_points as up');
        return $rsResult->result();
    }
    

}

?>
