<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Game_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getFutureDrawsList($gameID) {
        $this->db2->where('DRAW_GAME_ID', $gameID);
        $this->db2->where('DRAW_STARTTIME > NOW()');
        $this->db2->where("DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE()");
        $this->db2->where('DRAW_STATUS', 1);
        $this->db2->order_by('DRAW_ID', 'ASC');
        $query = $this->db2->get('lotto_draw');
        $resultData = $query->result();

        return $resultData;
    }

    function getNextDayDrawsList($gameID) {
        $this->db2->where('DRAW_GAME_ID', $gameID);
        $this->db2->where("DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE() + INTERVAL 1 DAY");
        $this->db2->where('DRAW_STATUS', 1);
        $this->db2->order_by('DRAW_ID', 'ASC');
        $query = $this->db2->get('lotto_draw');
        $resultData = $query->result();

        return $resultData;
    }

    function getPreviousDrawData($drawID, $gameID) {
        if(!empty($gameID)){
            $this->db2->where('DRAW_GAME_ID', $gameID);
        }
        if ($drawID != '') { //previous draw
             $this->db2->where('DRAW_ID <', $drawID);
        } else {
            $this->db2->where('DRAW_STARTTIME < NOW()');
        }

        $this->db2->where('DRAW_STATUS', 1);
        $this->db2->order_by('DRAW_STARTTIME', 'desc');
        $this->db2->limit(1);
        $rsResult = $this->db2->get('lotto_draw');
        return $rsResult->result();
    }

    function getUpcomingDrawData($drawID, $drawType, $gameID) {
        if(!empty($gameID)){
            $this->db2->where('DRAW_GAME_ID',$gameID);
        }

        if ($drawType == "NEXTDRAW" && $drawID != '') {
            $this->db2->where('DRAW_ID > ',$drawID);
        } elseif ($drawType == "FUTUREDRAW" && $drawID != '') {
            $this->db2->where('DRAW_ID >= ',$drawID);
        }
        
        $this->db2->where('DRAW_STARTTIME > NOW()');
        $this->db2->where('DRAW_STATUS',1);
        $this->db2->where('IS_ACTIVE',1);
        $this->db2->order_by('DRAW_STARTTIME','ASC');
        $this->db2->limit(2);
        //echo $browseSQL;exit;
        $rsResult = $this->db2->get('lotto_draw');
        return $rsResult->result();
    }

    function getExtDrawResults($gameID, $nextDrawID = 0) {
        if(!empty($gameID)){
            $this->db2->where('DRAW_GAME_ID',$gameID);
        }
        if (!empty($nextDrawID)) {
            $this->db2->where('DRAW_ID <',$nextDrawID);
        } else {
            $this->db2->where('DRAW_STARTTIME < NOW()');
        }
        
        $this->db2->where('DRAW_STATUS >=',3);
        $this->db2->order_by('DRAW_ID','DESC');
        $this->db2->limit(10);
        $rsResult = $this->db2->get('lotto_draw');
        return $rsResult->result();
    }

    function getTerminalBalance($terminalID) {
        $this->db2->select('*')
                    ->join('user as u', 'u.USER_ID=up.USER_ID');
        if(!empty($terminalID)){
            $this->db2->where('up.USER_ID',$terminalID);
        }
        
        $rsResult = $this->db2->get('user_points as up');
        return $rsResult->result();
    }

    function getDrawResultsToday($gameID) {
        $this->db2->where("DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE()");
        $this->db2->where("DRAW_STATUS >= ",3);
        if(!empty($gameID)){
            $this->db2->where('DRAW_GAME_ID',$gameID);
        }
        
        $this->db2->order_by('DRAW_ID','DESC');
        $rsResult = $this->db2->get('lotto_draw');
        return $rsResult->result();
    }

    function getDrawNumberByID($drawID) {
        $this->db2->where('DRAW_ID',$drawID);
        $rsResult = $this->db2->get('lotto_draw');
        return $rsResult->result();
    }

    function chkDrawStatus($drawID) {
        $this->db2->where('DRAW_ID',$drawID);
        $this->db2->where('DRAW_STATUS',1);
        $rsResult = $this->db2->get('lotto_draw');
        return $rsResult->result();
    }

    function chkTerminalBalance($ticketAmount) {
        $this->db2->where('USER_ID',$ticketAmount["TERMINAL_ID"]);
        $rsResult = $this->db2->get('user_points');
        return $rsResult->result();
    }

    /**
     * Here insert bulk sql records in luckky7_lotto_tickets
     * max 21 records will be insert into db.
     * @param string $browseSQL
     * @return number|unknown
     */
    function createLucy7LottoTickets($data) {
        $rsResult = $this->db->insert_batch('lucky7_lotto_tickets', $data); 
        return $rsResult;
    }

    function ticketCreationLucky7($data, $ticketArray) {
        $this->db->query("SET AUTOCOMMIT=0");
        $this->db->trans_begin();
        $browseSQL = "SELECT * FROM user_points WHERE USER_ID=" . $ticketArray["TERMINAL_ID"] . " FOR UPDATE";
        $rsResult = $this->db2->query($browseSQL);

        $createTicket = $this->createLucy7LottoTickets($data);
        $updateMaster = $this->updateTicketTransaction($ticketArray);

        if ($createTicket != '' && $updateMaster != '') {
            $this->db->trans_commit();
            return 1;
        } else {
            $this->db->trans_rollback();
            return 0;
        }
    }

    function updateTicketTransaction($arrUpdateTicket) {
        $lottoUserID = $arrUpdateTicket["TERMINAL_ID"];
        $balanceamount = $arrUpdateTicket["TOTAL_BET"];
        $drawId = $arrUpdateTicket["DRAW_ID"];
        $playGroupId = $arrUpdateTicket["PLAY_GROUP_ID"];
        $ireference = $arrUpdateTicket["INTERNAL_REFERENCE_NO"];

        $transactionStatusId = "101";
        $transactionTypeId = "11";
        $partnerID = $arrUpdateTicket["PARTNER_ID"];
        $userID = $lottoUserID;

        $pedningDebit = 0;
        $promostatus = 0;
        $depositstatus = 0;
        $winstatus = 0;
        
        $date = date('Y-m-d H:i:s');
        
        $rsResult = $this->getTerminalBalance($userID);
        if ($rsResult[0]->USER_PROMO_BALANCE >= $balanceamount) { // DEBIT ONLY FROM PROMO
            $userTotBalance = $rsResult[0]->USER_TOT_BALANCE;
            $userCloBalance = $rsResult[0]->USER_TOT_BALANCE - ($balanceamount);
            /*
            $browseSQL1="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
						   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,`CURRENT_TOT_BALANCE`,`CLOSING_TOT_BALANCE`,".
						   "`PARTNER_ID`) ".
						   "VALUES('','".$userID."',2,101,11,".$balanceamount.",NOW(),'".$ireference."',".
						   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";					   			
				$rsResult1 =$this->lotto_pdoObj->exec($browseSQL1);
                                */
            $data1= array( 
                            'USER_ID'=>$userID,
                            'BALANCE_TYPE_ID'=>2,
                            'TRANSACTION_STATUS_ID'=>101,
                            'TRANSACTION_TYPE_ID'=>11,
                            'TRANSACTION_AMOUNT'=>$balanceamount,
                            'TRANSACTION_DATE'=>$date,
                            'INTERNAL_REFERENCE_NO'=>$ireference,
                            'CURRENT_TOT_BALANCE'=>$userTotBalance,
                            'CLOSING_TOT_BALANCE'=>$userCloBalance,
                            'PARTNER_ID'=>$partnerID
                
                         );
            
            $rsResult1 = $this->db->insert('master_transaction_history', $data1); 
            $masTransID = $this->db->insert_id();
            $userNewPromoBal = $rsResult[0]->USER_PROMO_BALANCE - $balanceamount;
            $userNewDepotBal = $rsResult[0]->USER_DEPOSIT_BALANCE;
            $userNewWinBal = $rsResult[0]->USER_WIN_BALANCE;
            $userNewTotalBal = $userNewPromoBal + $userNewDepotBal + $userNewWinBal;
            if ($rsResult1 != '') {
                $promostatus = 1;
                $depositstatus = 1;
                $winstatus = 1;
            }
        } else { // DEBIT FROM PROMO AND DEPOSIT
            if ($rsResult[0]->USER_PROMO_BALANCE > 0) {
                $pedningDebit = $balanceamount - $rsResult[0]->USER_PROMO_BALANCE;
                $userTotBalance = $rsResult[0]->USER_TOT_BALANCE;
                $userCloBalance = $rsResult[0]->USER_TOT_BALANCE - $rsResult[0]->USER_PROMO_BALANCE;
                /*
                $browseSQL2="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
							   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,`CURRENT_TOT_BALANCE`,".
							   "`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
							   "VALUES('','".$userID."',2,101,11,".$rsResult[0]->USER_PROMO_BALANCE.",NOW(),'".$ireference."',".
							   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";	*/
                
                $data2= array( 
                            'USER_ID'=>$userID,
                            'BALANCE_TYPE_ID'=>2,
                            'TRANSACTION_STATUS_ID'=>101,
                            'TRANSACTION_TYPE_ID'=>11,
                            'TRANSACTION_AMOUNT'=>$rsResult[0]->USER_PROMO_BALANCE,
                            'TRANSACTION_DATE'=>$date,
                            'INTERNAL_REFERENCE_NO'=>$ireference,
                            'CURRENT_TOT_BALANCE'=>$userTotBalance,
                            'CLOSING_TOT_BALANCE'=>$userCloBalance,
                            'PARTNER_ID'=>$partnerID
                
                         );
            
                $rsResult2 = $this->db->insert('master_transaction_history', $data2); 
                $masTransID = $this->db->insert_id();

                if ($rsResult2 != '') {
                    $promostatus = 1;
                }
                $userNewPromoBal = 0;
            } else {
                $userCloBalance = $rsResult[0]->USER_TOT_BALANCE;
                $pedningDebit = $balanceamount;
                $promostatus = 1;
                $userNewPromoBal = 0;
            }
            if ($pedningDebit > 0 && $rsResult[0]->USER_DEPOSIT_BALANCE >= $pedningDebit) {
                $userTotBalance = $userCloBalance;
                $userCloBalance = $userTotBalance - $pedningDebit;
               /* $browseSQL3="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
							   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,`CURRENT_TOT_BALANCE`,".
							   "`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
							   "VALUES('','".$userID."',1,101,11,".$pedningDebit.",NOW(),'".$ireference."',".
							   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";*/
                $data3= array( 
                            'USER_ID'=>$userID,
                            'BALANCE_TYPE_ID'=>1,
                            'TRANSACTION_STATUS_ID'=>101,
                            'TRANSACTION_TYPE_ID'=>11,
                            'TRANSACTION_AMOUNT'=>$pedningDebit,
                            'TRANSACTION_DATE'=>$date,
                            'INTERNAL_REFERENCE_NO'=>$ireference,
                            'CURRENT_TOT_BALANCE'=>$userTotBalance,
                            'CLOSING_TOT_BALANCE'=>$userCloBalance,
                            'PARTNER_ID'=>$partnerID
                
                         );
            
                $rsResult3 = $this->db->insert('master_transaction_history', $data3); 
                $masTransID = $this->db->insert_id();
                
                $userNewDepotBal = $rsResult[0]->USER_DEPOSIT_BALANCE - $pedningDebit;
                $userNewWinBal = $rsResult[0]->USER_WIN_BALANCE;
                $userNewTotalBal = $userNewPromoBal + $userNewDepotBal + $userNewWinBal;
                if ($rsResult3 !== '') {
                    $depositstatus = 1;
                    $winstatus = 1;
                    $pedningDebit = 0;
                }
            } else { // DEBIT FROM PROMO AND DEPOSIT AND WIN
                if ($rsResult[0]->USER_DEPOSIT_BALANCE > 0) {
                    $pedningDebit = $pedningDebit - $rsResult[0]->USER_DEPOSIT_BALANCE;
                    $userTotBalance = $userCloBalance;
                    $userCloBalance = $userTotBalance - $rsResult[0]->USER_DEPOSIT_BALANCE;
                    /*
                    $browseSQL4="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
								   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,".
								   "`CURRENT_TOT_BALANCE`,`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
								   "VALUES('','".$userID."',1,101,11,".$rsResult[0]->USER_DEPOSIT_BALANCE.",NOW(),'".$ireference."',".
								   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";*/
                    
                    $data4= array( 
                            'USER_ID'=>$userID,
                            'BALANCE_TYPE_ID'=>1,
                            'TRANSACTION_STATUS_ID'=>101,
                            'TRANSACTION_TYPE_ID'=>11,
                            'TRANSACTION_AMOUNT'=>$rsResult[0]->USER_DEPOSIT_BALANCE,
                            'TRANSACTION_DATE'=>$date,
                            'INTERNAL_REFERENCE_NO'=>$ireference,
                            'CURRENT_TOT_BALANCE'=>$userTotBalance,
                            'CLOSING_TOT_BALANCE'=>$userCloBalance,
                            'PARTNER_ID'=>$partnerID
                
                         );
            
                    $rsResult4 = $this->db->insert('master_transaction_history', $data4); 
                    $masTransID = $this->db->insert_id();

                    if ($rsResult4 != '') {
                        $depositstatus = 1;
                    }
                    $userNewDepotBal = 0;
                } else {
                    $userCloBalance = $userCloBalance;
                    $depositstatus = 1;
                    $userNewDepotBal = 0;
                }
                if ($pedningDebit > 0 && $rsResult[0]->USER_WIN_BALANCE >= $pedningDebit) {
                    $userTotBalance = $userCloBalance;
                    $userCloBalance = $userTotBalance - $pedningDebit;
                   /* $browseSQL5="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
							       "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,".
								   "`CURRENT_TOT_BALANCE`,`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
								   "VALUES('','".$userID."',3,101,11,".$pedningDebit.",NOW(),'".$ireference."',".
								   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";*/
                    $data5= array( 
                            'USER_ID'=>$userID,
                            'BALANCE_TYPE_ID'=>3,
                            'TRANSACTION_STATUS_ID'=>101,
                            'TRANSACTION_TYPE_ID'=>11,
                            'TRANSACTION_AMOUNT'=>$pedningDebit,
                            'TRANSACTION_DATE'=>$date,
                            'INTERNAL_REFERENCE_NO'=>$ireference,
                            'CURRENT_TOT_BALANCE'=>$userTotBalance,
                            'CLOSING_TOT_BALANCE'=>$userCloBalance,
                            'PARTNER_ID'=>$partnerID
                
                         );
            
                    $rsResult5 = $this->db->insert('master_transaction_history', $data5); 
                    $masTransID = $this->db->insert_id();
                    
                    $userNewWinBal = $rsResult[0]->USER_WIN_BALANCE - $pedningDebit;
                    $userNewTotalBal = $userNewPromoBal + $userNewDepotBal + $userNewWinBal;
                    if ($rsResult5 != '') {
                        $winstatus = 1;
                        $pedningDebit = 0;
                    }
                } else {
                    $pedningDebit = 1;
                }
            }
        }
        
        /** user point added remain balance **/
        /*$browseSQL6 = "UPDATE ".$this->user_points." SET USER_PROMO_BALANCE=".$userNewPromoBal.",".
						  "USER_DEPOSIT_BALANCE=".$userNewDepotBal.",".
						  "USER_WIN_BALANCE=".$userNewWinBal.",".
						  "USER_TOT_BALANCE=".$userNewTotalBal." WHERE USER_ID=".$userID." AND COIN_TYPE_ID=1";	*/
        
        $data6= array( 
                        'USER_PROMO_BALANCE'=>$userNewPromoBal,
                        'USER_DEPOSIT_BALANCE'=>$userNewDepotBal,
                        'USER_WIN_BALANCE'=>$userNewWinBal,
                        'USER_TOT_BALANCE'=>$userNewTotalBal
                    );
                      $this->db->where('USER_ID',$userID); 
                      $this->db->where('COIN_TYPE_ID',1); 
        $rsResult6 = $this->db->update('user_points', $data6); 
          
        /** lotto_draw added DRAW_TOTALBET **/
        /*$query_pt3=$this->lotto_pdoObj->exec("UPDATE ".$this->lotto_draw." SET DRAW_TOTALBET=DRAW_TOTALBET+'".$balanceamount."' ".
				"WHERE DRAW_ID=".$drawId."");*/
                    $this->db->set('DRAW_TOTALBET', "DRAW_TOTALBET+'" . $balanceamount . "'", FALSE);
                    $this->db->where('DRAW_ID', $drawId);
        $rsResult7 = $this->db->update('lotto_draw'); 

        /** lotto_tickets added pending status 0 **/
        /*$query_pt4=$this->lotto_pdoObj->exec("UPDATE $this->lotto_tickets SET IS_PENDING_STATUS = 0 WHERE TERMINAL_ID='".$lottoUserID."' AND PLAY_GROUP_ID='".$playGroupId."'");*/
        $data8= array( 
                        'IS_PENDING_STATUS'=>0
                    );
                      $this->db->where('TERMINAL_ID',$lottoUserID); 
                      $this->db->where('PLAY_GROUP_ID',$playGroupId); 
        $rsResult8 = $this->db->update('lotto_tickets', $data8); 
        
        if ($pedningDebit == "0" && $promostatus == 1 && $depositstatus == 1 && $winstatus == 1 && $rsResult6 == 1 && $rsResult7 != '' && $rsResult8 != '') {
            //$this->lotto_pdoObj->commit();
            return 1;
        } else {
            //	$this->lotto_pdoObj->rollBack();
            return 0;
        }
    }

    function checkInputs($formData) {
        if (empty($formData)) {
            return 0;
        }
        $result = array();
        //echo'<pre>';print_r($formData);exit;
        foreach ($formData as $key => $val) {
            /**
             * validate double value is empty or not
             */
            if ($key == 'san') {
                if (!empty($val) && array_sum($val) != 0) {

                    $result ['double'] ['1'] = $this->remove_empty($val);
                }
            }
            if ($key == 'che') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['2'] = $this->remove_empty($val);
                }
            }
            if ($key == 'sup') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['3'] = $this->remove_empty($val);
                }
            }
            if ($key == 'del') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['4'] = $this->remove_empty($val);
                }
            }

            if ($key == 'bha') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['5'] = $this->remove_empty($val);
                }
            }
            if ($key == 'dia') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['6'] = $this->remove_empty($val);
                }
            }
            if ($key == 'luk') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['7'] = $this->remove_empty($val);
                }
            }

            if ($key == 'new1') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['8'] = $this->remove_empty($val);
                }
            }
            if ($key == 'new2') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['9'] = $this->remove_empty($val);
                }
            }
            if ($key == 'new3') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['double'] ['10'] = $this->remove_empty($val);
                }
            }


            /**
             * validate single value is empty or not
             */
            if ($key == 'bahar_san') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['1'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_che') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['2'] =$this->remove_empty($val);
                }
            }

            if ($key == 'bahar_sup') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['3'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_del') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['4'] = $this->remove_empty($val);
                }
            }

            if ($key == 'bahar_bha') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['5'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_dia') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['6'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_luk') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['7'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_new1') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['8'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_new2') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['9'] = $this->remove_empty($val);
                }
            }
            if ($key == 'bahar_new3') {
                if (!empty($val) && array_sum($val) != 0) {
                    $result ['single'] ['10'] = $this->remove_empty($val);
                }
            }
        }
        //echo '<pre>';print_r($result);exit;
        return $result;
    }
    
    function remove_empty($linksArray) {
	return array_filter($linksArray, create_function('$value', 'return $value !== "";'));
    }
    
    
    

}

?>
