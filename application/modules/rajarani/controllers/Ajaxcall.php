<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxcall extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->database();
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
        $this->load->library('session');
        $this->load->model("Game_model");
		//$this->common_model->userAuthendication();
    }

    public function getdbtime() {
        $dbTime = $this->common_model->getServerTime();
        echo date("M j, Y H:i:s O", strtotime($dbTime)) . "\n";
        exit;
    }

    public function nextdrawtime($cDrawID) {
		$session = $this->common_model->userAuthendication();
		if($session){
			$status= array(	'status' => 'expired' );
			echo json_encode($status);exit;
		}
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        if (!empty($cDrawID)) {
            $gameID = RR_GAME_ID;
            $drawType = "NEXTDRAW";
            $getNextDrawTime = $this->Game_model->getUpcomingDrawData($cDrawID, $drawType, $gameID);
            $preDrawInfo = $this->Game_model->getPreviousDrawData($cDrawID, $gameID);

            $getTerminalBal = $this->Game_model->getTerminalBalance($SESSION_USERID);

            $preDrawTime = '';
            $preDrawNo = '';
            if (!empty($preDrawInfo)) {
                $preDrawTime = date('h:i A', strtotime($preDrawInfo[0]->DRAW_STARTTIME));
                $preDrawNo = substr($preDrawInfo[0]->DRAW_NUMBER, strlen($preDrawInfo[0]->DRAW_NUMBER) - 5, 5);
            }

            $futureDraw = $this->Game_model->getFutureDrawsList($gameID); //today
            $nextDayDraw = $this->Game_model->getNextDayDrawsList($gameID); //Tommorrow
            $draws = '';

            if (!empty($futureDraw)) {
                $k = 0;
                foreach ($futureDraw as $draw) {
                    $nxtDraw = (!empty($draw->DRAW_STARTTIME) ? date('h:i A', strtotime($draw->DRAW_STARTTIME)) : '00:00');
                    if ($k == 0) {
                        $draws .= '<option value="0">NOW</option>';
                    } else {
                        $draws .= '<option value="' . $draw->DRAW_ID . '">' . $nxtDraw . '</option>';
                    }
                    $k++;
                }

                if (!empty($nextDayDraw)) {
                    $draws .= '<option class="futuredraw_day" value=""><b>Next Day</b></option>';
                    $k1 = 0;
                    foreach ($nextDayDraw as $next) {
                        $nxtDraw1 = (!empty($next->DRAW_STARTTIME) ? date('h:i A', strtotime($next->DRAW_STARTTIME)) : '00:00');
                        $draws .= '<option class="futuredraw_day" value="' . $next->DRAW_ID . '">' . $nxtDraw1 . '</option>';
                        $k1++;
                    }
                }
            }

            if (!empty($getNextDrawTime)) {

                $nxtDrawDate = (!empty($getNextDrawTime[1]->DRAW_STARTTIME) ? date('d/m/Y', strtotime($getNextDrawTime[1]->DRAW_STARTTIME)) : '');
                $nxtDrawTime = (!empty($getNextDrawTime[1]->DRAW_STARTTIME) ? date('h:i A', strtotime($getNextDrawTime[1]->DRAW_STARTTIME)) : '');

                $expDDate1 = date('d-m-Y', strtotime(substr($getNextDrawTime[0]->DRAW_STARTTIME, 0, 10)));
                $expDTime1 = date('H:i:s', strtotime($getNextDrawTime[0]->DRAW_STARTTIME));
                $expDDate = explode('-', $expDDate1);
                $expDTime = explode(':', $expDTime1);
                $drawCountDownTime = $expDDate[2] . ',' . ($expDDate[1] - 1) . ',' . $expDDate[0] . ',' . $expDTime[0] . ',' . $expDTime[1] . ',' . $expDTime[2]; //'Y,m,d,h,m,s'	
                //$price =	(!empty($getNextDrawTime[0]->GAME_TYPE_DRAW_PRICE)?explode(",",$getNextDrawTime[0]->GAME_TYPE_DRAW_PRICE):0);
                $price = (!empty($getNextDrawTime[0]->DRAW_PRICE) ? $getNextDrawTime[0]->DRAW_PRICE : 0);
                $status = array('status' => 'available',
                    'DRAW_ID' => $getNextDrawTime[0]->DRAW_ID,
                    'DRAW_NUMBER' => $getNextDrawTime[0]->DRAW_NUMBER,
                    'GAME_NO' => substr($getNextDrawTime[0]->DRAW_NUMBER, strlen($getNextDrawTime[0]->DRAW_NUMBER) - 5, 5),
                    'DRAW_PRICE' => (!empty($price) ? $price : '000'),
                    'DRAW_STARTTIME' => $getNextDrawTime[0]->DRAW_STARTTIME,
                    'COUNT_DOWN' => $drawCountDownTime,
                    'NXT_DRAW_DATE' => $nxtDrawDate,
                    'NXT_DRAW_TIME' => $nxtDrawTime,
                    'PREV_DRAW_NO' => $preDrawNo,
                    'PREV_DRAW_TIME' => $preDrawTime,
                    'USER_BAL' => (!empty($getTerminalBal[0]->USER_TOT_BALANCE) ? $getTerminalBal[0]->USER_TOT_BALANCE : 000),
                    'NXT_SEL' => $draws
                );
                echo json_encode($status);
                exit;
            } else {
                $status = array('status' => 'Next draw not available', 'NXT_SEL' => $draws);
                echo json_encode($status);
                exit;
            }
        } else {
            $status = array('status' => 'Invalid draw');
            echo json_encode($status);
            exit;
        }
    }

    public function previousResult() {
        $today = $this->Game_model->getDrawResultsToday(RR_GAME_ID);
        $data = '	<div id="small-dialog3"	 class="w3ls_small_dialog wthree_pop">
                            <div class="popup_head">Previous Result</div>';
        if (!empty($today)) {
            $data .= '<div class="chart_1">
                    <div class="chart_head_1">
                            <div class="chart_head draw_1">DrawTime</div>
                            <div class="chart_head san_1">' . GAME_1 . '</div>
                            <div class="chart_head che_1">' . GAME_2 . '</div>
                            <div class="chart_head super_1">' . GAME_3 . '</div>
                            <div class="chart_head del_1">' . GAME_4 . '</div>
                            <div class="chart_head bhag_1">' . GAME_5 . '</div>
                            <div class="chart_head dia_1">' . GAME_6 . '</div>
                            <div class="chart_head luc_1">' . GAME_7 . '</div>
                            <div class="chart_head new_1">' . GAME_8 . '</div>
                            <div class="chart_head new_2">' . GAME_9 . '</div>
                            <div class="chart_head new_3">' . GAME_10 . '</div>

                    </div>
                    <div class="chart_scroll">';
            foreach ($today as $day) {
                $winNumb1 = '';
                $numb1 = array();
                $win1 = '';
                $time = (!empty($day->DRAW_STARTTIME) ? date('h:i A', strtotime($day->DRAW_STARTTIME)) : '');
                if (!empty($day->DRAW_WINNUMBER)) {
                    $win1 = json_decode($day->DRAW_WINNUMBER, true);
                }


                $data .= '<div class="chart_cont_1">
                                            <div class="chart_cont_2">' . $time . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][1]) ? $win1['double'][1] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][2]) ? $win1['double'][2] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][3]) ? $win1['double'][3] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][4]) ? $win1['double'][4] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][5]) ? $win1['double'][5] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][6]) ? $win1['double'][6] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][7]) ? $win1['double'][7] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][8]) ? $win1['double'][8] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][9]) ? $win1['double'][9] : '') . '</div>
                                            <div class="chart_cont_2">' . (isset($win1['double'][10]) ? $win1['double'][10] : '') . '</div>
                                    </div>';
            }
            $data .= '</div>
            </div>';
        } else {
            $data .= '<div class="chart_1"><div class="chart_head_1"><h2>Result not found</h2></div></div>';
        }
        $data .= '<div>';
        echo $data;
        exit;
    }

    public function ticketprocess() {
        $SESSION_USERID = $this->session->userdata(SESSION_USERID);
        $SESSION_USERNAME = $this->session->userdata(SESSION_USERNAME);
        $SESSION_PARTNERID = $this->session->userdata(SESSION_PARTNERID);
        
		$session = $this->common_model->userAuthendication();
		if($session){
			$status= array(	'msg' => 'expired' );
			echo json_encode($status);exit;
		}
		
        $drawName = $_POST["drawName"];
        $drawPrice = $_POST["drawPrice"];
        $drawDateT = date('d/m/Y H:i', strtotime($_POST["drawDateTime"]));
        $ticketArray["TERMINAL_ID"] = $SESSION_USERID;

        $ticketAction = $_POST["ticketAction"];
        if ($ticketAction == "newtransaction") {
            if (!empty($drawName)) {
                $ticketArray["DRAW_ID"] = $_POST["drawID"];
                $ticketArray["PARTNER_ID"] = $SESSION_PARTNERID; //agent id
                $ticketArray["TERMINAL_ID"] = $SESSION_USERID;  //userid
                $ticketArray["PLAY_GROUP_ID"] = $SESSION_USERID . date('dm') . time();
                $ticketArray["INTERNAL_REFERENCE_NO"] = RR_GAME_ID . $SESSION_USERID . date('dm') . time();
                $ticketArray["CREATED_DATE"] = date('Y-m-d H:i:s');
                $ticketArray["UPDATED_DATE"] = date('Y-m-d H:i:s');
                $ticketArray["DRAW_PRICE"] = $_POST["drawPrice"];
                $ticketArray["STATUS"] = 1;

                $data = "";
                $betAmt = $betQty = array();

                /** get ticket price value */
                /** get ticket price value */
                $drawpriceInfo = $this->Game_model->getDrawNumberByID($ticketArray["DRAW_ID"]);
                $price = (!empty($drawpriceInfo[0]->DRAW_PRICE) ? $drawpriceInfo[0]->DRAW_PRICE : 0);
                if (!empty($price)) {
                    /** validate inputs and set value in bet type based */
                    $insertTickets = array();
                    $result = $this->Game_model->checkInputs($_POST);
                    
                    /** Here set insertion format for lotto_tickets table */
                    if (!empty($result)) {
                        foreach ($result as $key => $val) {
                            foreach ($val as $key1 => $val1) {
                                if ($key == 'single') {
                                    $input1 = $val[$key1];
                                    $BET_VALUE1 = json_encode(array_reverse($input1, true));
                                    $BET_NUMBER1 = implode(',', array_keys($input1));
                                    $BET_AMOUNT_VALUE1 = implode(',', array_values($input1));
                                    $TOTAL_BET1 = array_sum($input1) * $price;
                                    $betAmt[] = $TOTAL_BET1;
                                    $betQty[] = $BET_AMOUNT_VALUE1;
                                    $insertTickets[] = array(   'DRAW_ID'=> $ticketArray["DRAW_ID"],
                                                                'BET_TYPE'=>1 ,
                                                                'GAME_TYPE_ID'=>$key1 ,
                                                                'INTERNAL_REFERENCE_NO'=>$ticketArray["INTERNAL_REFERENCE_NO"] ,
                                                                'PARTNER_ID'=>$ticketArray["PARTNER_ID"] ,
                                                                'TERMINAL_ID'=>$ticketArray["TERMINAL_ID"] ,
                                                                'BET_VALUE'=>$BET_VALUE1 ,
                                                                'BET_NUMBER'=>$BET_NUMBER1 ,
                                                                'BET_AMOUNT_VALUE'=>$BET_AMOUNT_VALUE1 ,
                                                                'DRAW_PRICE'=>$price ,
                                                                'CREATED_DATE'=>$ticketArray["CREATED_DATE"] ,
                                                                'UPDATED_DATE'=>$ticketArray["UPDATED_DATE"] ,
                                                                'STATUS'=>$ticketArray["STATUS"] ,
                                                                'WIN_NUMBER'=>'' ,
                                                                'TOTAL_BET'=>$TOTAL_BET1 ,
                                                                'TOTAL_WIN'=>'' ,
                                                                'PLAY_GROUP_ID'=>$ticketArray["PLAY_GROUP_ID"] ,
                                                                'IS_PENDING_STATUS'=>1 
                                                            );
                                }

                                if ($key == 'double') {
                                    $input2 = $val[$key1];
                                    $BET_VALUE2 = json_encode($input2);
                                    $BET_NUMBER2 = implode(',', array_keys($input2));
                                    $BET_AMOUNT_VALUE2 = implode(',', array_values($input2));
                                    $TOTAL_BET2 = array_sum($input2) * $price;
                                    $betAmt[] = $TOTAL_BET2;
                                    $betQty[] = $BET_AMOUNT_VALUE2;
                                    $insertTickets[] = array(   'DRAW_ID'=> $ticketArray["DRAW_ID"],
                                                                'BET_TYPE'=>2 ,
                                                                'GAME_TYPE_ID'=>$key1 ,
                                                                'INTERNAL_REFERENCE_NO'=>$ticketArray["INTERNAL_REFERENCE_NO"] ,
                                                                'PARTNER_ID'=>$ticketArray["PARTNER_ID"] ,
                                                                'TERMINAL_ID'=>$ticketArray["TERMINAL_ID"] ,
                                                                'BET_VALUE'=>$BET_VALUE2 ,
                                                                'BET_NUMBER'=>$BET_NUMBER2 ,
                                                                'BET_AMOUNT_VALUE'=>$BET_AMOUNT_VALUE2 ,
                                                                'DRAW_PRICE'=>$price ,
                                                                'CREATED_DATE'=>$ticketArray["CREATED_DATE"] ,
                                                                'UPDATED_DATE'=>$ticketArray["UPDATED_DATE"] ,
                                                                'STATUS'=>$ticketArray["STATUS"] ,
                                                                'WIN_NUMBER'=>'' ,
                                                                'TOTAL_BET'=>$TOTAL_BET2 ,
                                                                'TOTAL_WIN'=>'' ,
                                                                'PLAY_GROUP_ID'=>$ticketArray["PLAY_GROUP_ID"] ,
                                                                'IS_PENDING_STATUS'=>1 
                                                            );
                                }
                            }
                        }
                    }
                } else {
                    $res = array('msg' => 'please contact administrator');
                    echo json_encode($res);
                    exit;
                }
                $ticketArray["TOTAL_BET"] = (!empty($betAmt) ? array_sum($betAmt) : '');

                /**
                 *  if user not bet any game then send error message 
                 *  validate total bet value 
                 * */
                if (!empty($ticketArray["TOTAL_BET"])) {
                    $getDrawData = $this->Game_model->chkDrawStatus($ticketArray["DRAW_ID"]); //This is to check draw is not completed already and the draw time is passed already
                    if (!empty($getDrawData) ) {
                        if ($getDrawData[0]->IS_ACTIVE == 1) {
                            $insufficientBal = $this->Game_model->chkTerminalBalance($ticketArray);
                            if ($insufficientBal[0]->USER_TOT_BALANCE >= $ticketArray["TOTAL_BET"]) {
                                /** insert the record (master,lotto_draw,lucky7_lotto_tickets,user_points)**/
                                $createTicket = $this->Game_model->ticketCreationLucky7($insertTickets, $ticketArray);
                                if (!empty($createTicket)) {
                                    $userBal = $this->Game_model->chkTerminalBalance($ticketArray);
                                    $bal = (!empty($userBal[0]->USER_TOT_BALANCE) ? $userBal[0]->USER_TOT_BALANCE : 0);
                                    $res = array('msg' => 'success', 'bal' => $bal);
                                } else {
                                    $res = array('msg' => 'Ticket could not be created'); //Ticket could not be created
                                }
                            } else {
                                $res = array('msg' => 'You have insufficient points'); //user does not have sufficient balance
                            }
                        } else {
                            $res = array('msg' => 'The draw is deactivated'); //The draw is deactivated
                        }
                    } else {
                        $res = array('msg' => 'The draw is finished already'); //Can not create ticket for the completed draws, or the draw, which is about to start
                    }
                } else {
                    $res = array('msg' => 'please select the tickets'); // total bet empty then
                }
            } else {
                $res = array('msg' => 'Invaild draw'); //missing
            }
        } else {
            $res = array('msg' => 'Invaild'); //name not correct
        }
        echo json_encode($res);
        exit;
    }
	
	public function userbalanceupdate($drawID){
		if (!$this->input->is_ajax_request()) {
			echo 'No direct script is allowed';
			die;
		}
		
		$session = $this->common_model->userAuthendication();
		if($session){
			$status= array(	'SESSION' => $session );
			echo json_encode($status);exit;
		}
		
		
		$SESSION_USERID = $this->session->userdata(SESSION_USERID);
		$nxtDrawInfo= $this->Game_model->getUpcomingDrawData('','',RR_GAME_ID);
		$nxtDrawTime =  "--:--";
		if (!empty( $nxtDrawInfo[1]->DRAW_STARTTIME )){
			$nxtDrawTime = date('h:i A',strtotime($nxtDrawInfo[1]->DRAW_STARTTIME));
		}
		
		$futureDraw = $this->Game_model->getFutureDrawsList(RR_GAME_ID);//today
		$nextDayDraw = $this->Game_model->getNextDayDrawsList(RR_GAME_ID);//Tommorrow
		$draws ='';
		if (!empty($futureDraw ) ) {
			$k=0;
			foreach ($futureDraw as $draw){
				$sel = "";
				if ($drawID==$draw->DRAW_ID){
					$sel = "selected='selected'";
				}
				
				$nxtDraw = (!empty($draw->DRAW_STARTTIME)?date('h:i A',strtotime($draw->DRAW_STARTTIME)):'00:00');
				if ( $k==0){
					$draws.='<option value="0" '.$sel.'>NOW</option>';
				} else {
					$draws.='<option value="'.$draw->DRAW_ID.'" '.$sel.'>'.$nxtDraw.'</option>';
				}
			$k++;
			}
			if(!empty($nextDayDraw)){
				$draws.='<option class="futuredraw_day" value=""><b>Next Day</b></option>';
				$k1=0;
				foreach ($nextDayDraw as $next){
					$sel1 = "";
					if ($drawID==$next->DRAW_ID){
						$sel1 = "selected='selected'";
					}
					$nxtDraw1 = (!empty($next->DRAW_STARTTIME)?date('h:i A',strtotime($next->DRAW_STARTTIME)):'00:00');
					$draws.='<option class="futuredraw_day" value="'.$next->DRAW_ID.'" '.$sel1.'>'.$nxtDraw1.'</option>';
				$k1++;}
			}
		}
		
		$getTerminalBal=$this->Game_model->getTerminalBalance($SESSION_USERID);
		$status= array(	'USER_BAL' 		=> (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:000),
						'nxtDrawTime'	=>$nxtDrawTime,
						'NXT_SEL'		=> $draws
					);
		echo json_encode($status);exit;
	}

}
