<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

	function __construct() {
        parent::__construct();
        //$this->load->database();
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
        $this->load->library('session');
        $this->load->model("Game_model");
		$session = $this->common_model->userAuthendication();
		if($session){
			redirect('index');
		}
    }

    public function index() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);

        $data['USERNAME'] = $SESSION_USERNAME;
        $data['futureDraw'] = $this->Game_model->getFutureDrawsList(RR_GAME_ID);
        $data['nextDayDraw'] = $this->Game_model->getNextDayDrawsList(RR_GAME_ID);

        $drawID = "";
        $drawType = ""; //NextDraw | Future Draw
        if (isset($_REQUEST["drawID"])) {
            $drawID = base64_decode($_REQUEST["drawID"]);
            $drawType = "NEXTDRAW";
        }
        if (isset($_REQUEST["fdrawID"])) {
            $drawID = base64_decode($_REQUEST["fdrawID"]);
            $drawType = "FUTUREDRAW";
        }

        $preDrawInfo = $this->Game_model->getPreviousDrawData('', RR_GAME_ID);
        $data['preDrawTime'] = (!empty($preDrawInfo[0]->DRAW_STARTTIME) ? date('H:i', strtotime($preDrawInfo[0]->DRAW_STARTTIME)) : '');
        $data['preDrawTimeFull'] = (!empty($preDrawInfo[0]->DRAW_STARTTIME) ? date('h:i A', strtotime($preDrawInfo[0]->DRAW_STARTTIME)) : '00:00');
        $data['preDrawNo'] = (!empty($preDrawInfo[0]->DRAW_NUMBER) ? substr($preDrawInfo[0]->DRAW_NUMBER, strlen($preDrawInfo[0]->DRAW_NUMBER) - 5, 5) : '');
        $data['preDrawWIn'] = (!empty($preDrawInfo[0]->DRAW_WINNUMBER) ? json_decode($preDrawInfo[0]->DRAW_WINNUMBER) : '');

        $upcomingDraw = $this->Game_model->getUpcomingDrawData($drawID, $drawType, RR_GAME_ID);
        if (!empty($upcomingDraw)) {
            $drawPrice = (!empty($upcomingDraw[0]->GAME_TYPE_DRAW_PRICE) ? explode(",", $upcomingDraw[0]->GAME_TYPE_DRAW_PRICE) : 0);

            $nDrawDate = date('d/m/Y', strtotime(substr($upcomingDraw[0]->DRAW_STARTTIME, 0, 10)));
            $nDrawTime = date('H:i', strtotime($upcomingDraw[0]->DRAW_STARTTIME));

            $nxtDrawInfo = $this->Game_model->getUpcomingDrawData('', '', RR_GAME_ID);
            $nxtDrawDate = "00/00/0000";
            $nxtDrawTime = "--:--";
            if (!empty($nxtDrawInfo[1]->DRAW_STARTTIME)) {
                $nxtDrawDate = date('d/m/Y', strtotime(substr($nxtDrawInfo[1]->DRAW_STARTTIME, 0, 10)));
                $nxtDrawTime = date('h:i A', strtotime($nxtDrawInfo[1]->DRAW_STARTTIME));
            }

            $expDDate1 = date('d-m-Y', strtotime(substr($upcomingDraw[0]->DRAW_STARTTIME, 0, 10)));
            $expDTime1 = date('H:i:s', strtotime($upcomingDraw[0]->DRAW_STARTTIME));

            $expDDate = explode('-', $expDDate1);
            $expDTime = explode(':', $expDTime1);
            $drawCountDownTime = $expDDate[2] . ',' . ($expDDate[1] - 1) . ',' . $expDDate[0] . ',' . $expDTime[0] . ',' . $expDTime[1] . ',' . $expDTime[2];
            $nDrawTimeL = "";
            $getExtDrawResults = $this->Game_model->getExtDrawResults(RR_GAME_ID, $upcomingDraw[0]->DRAW_ID); //the parameter is the next draw id
        } else {
            $drawPrice = '';
            $nDrawDate = "00/00/0000";
            $nxtDrawTime = "--:--";
            $nxtDrawDate = "00/00/0000";
            $nxtDrawTime = "00:00";
            $drawCountDownTime = "";
            $nDrawTimeL = "00:00:00";
            $getExtDrawResults = $this->Game_model->getExtDrawResults(RR_GAME_ID);
        }
        $getTerminalBal = $this->Game_model->getTerminalBalance($SESSION_USERID);
        $data['upcomingDraw'] = (!empty($upcomingDraw) ? $upcomingDraw : '');
        $data['drawPrice'] = $drawPrice;
        $data['nDrawDate'] = $nDrawDate;
        $data['nxtDrawTime'] = $nxtDrawTime;
        $data['nxtDrawDate'] = $nxtDrawDate;
        $data['drawCountDownTime'] = $drawCountDownTime;
        $data['nDrawTimeL'] = $nDrawTimeL;
        $data['getExtDrawResults'] = $getExtDrawResults;
        $data['getTerminalBal'] = $getTerminalBal;

        $data['drawID'] =$drawID;
        $data['vTime'] = strtotime(date('Y-m-d H:i:s'));
        $rsResult = $this->db2->query("SELECT NOW() as time");
        $row = $rsResult->row();
        $data['dbTime'] = (!empty($row->time) ? date("F d, Y H:i:s", strtotime($row->time)) : date("F d, Y H:i:s", time()));
        $this->load->view('mob/home', $data);
    }
        
          

}
