<html>
  <head>
    <title>RajaaRani</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" href="<?php echo ASSET_URL_CSS;?>/bootstrap.css" type="text/css">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="<?php echo ASSET_URL_CSS;?>/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSET_URL_CSS;?>/style.css?v=<?php echo $vTime; ?>" type="text/css">
    <link href="<?php echo ASSET_URL_CSS;?>/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="js/jquery.fullscreen.js"></script>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
  </head>
	<script type="text/javascript">
		var WEB_SOCKET_URL = '<?php echo RR_WEB_SOCKET_URL;?>';
	</script>
  <body>
  <div class="home_load">
  <img src="images/home.gif">
  </div>
  
	<div id="confirmation" style="display:none;">
	<div class="confirm_center">
		<div class="confirm_1">
			<div class="" style="color: #fff; margin: 0% 0 5% 0;">Network Disconnected Page Reload at <span id="timer"></span></div>
			<a href="home.php" id="" class="yes_btn">Reload</a>
			<!-- <input type="submit" value="NO" id="" class="yes_btn"> -->
 		</div>
	</div>
	</div>
	
	<div id="idlestate" style="display:none;">
	<div class="confirm_center">
		<div class="confirm_1">
			<div class="" style="color: #fff; margin: 0% 0 5% 0;"> Page is idle state. Problem may be occur please reload</div>
			<a href="home.php" id="" class="yes_btn">Reload</a>
			<!-- <input type="submit" value="NO" id="" class="yes_btn"> -->
 		</div>
	</div>
	</div>
	
	<div class="loading-spinner-wrapper" id="loading-img">
	  <span class="loading-spinner white">
		<i></i>
		<i></i>
		<i></i>
		<i></i>
		<i></i>
		<i></i>
	  </span>
	</div>
	<div class='col-lg-4 notification_success alert alert-danger' style="display: none;" id="msg"></div>
		<div class='col-lg-4 notification_success alert alert-success' style="display: none;" id="success-msg"></div>
    <div class="full_body_1" id="loading">
      <div class="mob_portrait"></div>
      <div class="header">
        <div class="tab_sin_dou">
          <div class="tab mid_head1">
            <div class="tablinks1 single_tab active" onclick="openPlayer(event, 'single_1')">
              <div class="rot_1">SINGLE<span class="hidden-lg hidden-md">(<span class="total_mob_1 single_total">0</span>)</span></div>
            </div>
            <div class="tablinks1 double_tab" onclick="openPlayer(event, 'double_1')">
              <div class="rot_1">DOUBLE<span class="hidden-lg hidden-md">(<span class="total_mob_1 double_total">0</span>)</span></div>
            </div>
          </div>
        </div>
        <div class="hidden-xs hidden-sm logo_1">
          <div class="logo"><img src="images/logo.png"></div>
        </div>
        <!-- before login-->
        <div class="hidden-xs hidden-sm user_2" style="">
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 username_login">
            <div class="userdetails_1">
              <div class="user_1_d">
                <div class="userval">USERNAME</div>
                <div class="userdata"><?= (!empty($_SESSION['lucky_username'])?$_SESSION['lucky_username']:'--');?></div>
              </div>
              <div class="user_1_d">
                <div class="userval">POINT</div>
                <div class="userdata userBalance" id="userBalance"><?php echo (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:000);?></div>
              </div>
            </div>
            <div class="nextdraw_1">
              <div class="userval">NEXT DRAW:<span class="nxtdrawTime"><?= $nxtDrawTime; ?></span>
				
			  </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 ttd_1">
            <div class="timedraw_1">
			<div class="future_date"><?php echo $nDrawDate; ?></div>
			<?php if (!empty($futureDraw ) || !empty($nextDayDraw) ) { ?>
						<div class="future_draw">FUTURE DRAW<select class="time_selection future" onChange="nextdraw(this.value)" id="future">
					<?php 
					if(!empty($futureDraw)){
					$k=0;
					foreach ($futureDraw as $draw){
							$nxtDraw = (!empty($draw->DRAW_STARTTIME)?date('h:i A',strtotime($draw->DRAW_STARTTIME)):'00:00');
							
							$sel = "";
							if ($drawID==$draw->DRAW_ID){
								$sel = "selected='selected'";
							}
								if ( $k==0){
						?>
									<option value="0" <?= $sel; ?>>NOW</option>
							<?php } else { ?>
									<option value="<?= $draw->DRAW_ID; ?>" <?= $sel; ?>><?= $nxtDraw; ?></option>
							<?php } ?>
					<?php $k++;} }
						if(!empty($nextDayDraw)){
									?>
								<option class="futuredraw_day" value=""><b>Next Day</b></option>
								<?php 
								$k1=0;
								foreach ($nextDayDraw as $next){
									//$link1 = 'home.php?fdrawID='.base64_encode($next->DRAW_ID);
									//$drawNumber1 = substr( $next->DRAW_NUMBER,strlen( $next->DRAW_NUMBER)-5,5);
									$nxtDraw1 = (!empty($next->DRAW_STARTTIME)?date('h:i A',strtotime($next->DRAW_STARTTIME)):'00:00');
									
									$sel = "";
									if ($drawID==$next->DRAW_ID){
										$sel = "selected='selected'";
									}?>
										
											<option class="futuredraw_day" value="<?= $next->DRAW_ID; ?>" <?= $sel; ?>><?= $nxtDraw1; ?></option>
									
									
								<?php $k1++;} } ?>
					</select></div>
				<?php } ?>
              <div class="ttd">STARTS IN</div>
              <div class="runtime_1 ndrawLeftTime" id="ndrawLeftTime"><?php echo $drawCountDownTime;?></div>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 logout">
            <div class="log_out">
			  <div class="back"><a href="<?php echo LOGIN_LANDING_URL ?>"><span>Back</span></a></div>
              <div class="logout_1" data-toggle="modal" data-target="#logout_mob"><a title="Logout">logout<i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
            </div>
            <div class="date_time">
              <div class="date_1"><?PHP echo date("d-m-Y"); ?></div>
              <div class="time_1 servertime"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="middle">
		<input type="hidden" id="activeClass" value="game1_cont">
		<input type="hidden" id="sactiveClass" value="sgame1_cont">
		<form method="post" id="ticketForm" class="form" action="ticketprocess.php">
			<input type="hidden" name="drawID" id="drawID" value="<?php echo $upcomingDraw[0]->DRAW_ID;?>" />
			<input type="hidden" name="drawName" id="drawName" value="<?php echo $upcomingDraw[0]->DRAW_NUMBER;?>" />
			<input type="hidden" name="drawPrice" id="drawPrice" value="<?php echo $upcomingDraw[0]->DRAW_PRICE;?>" />
			<input type="hidden" name="drawDateTime" id="drawDateTime" value="<?php echo $upcomingDraw[0]->DRAW_STARTTIME;?>" />
			<input type="hidden" name="ticketSentStatus" id="ticketSentStatus" value="0" />
			<input type="hidden" name="ticketAction" id="ticketAction" value="newtransaction" />
        
		<div class="single_player tabcontent1" id="double_1" style="display:none;">
          <div class="tab_sec" style="" id="doubleInfo">
            <div class="tabmid_cont">
			<!--<a class="left_scroll blink" href="#defaultOpen"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a><a href="#double_bottom" class="right_scroll blink"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>-->
              <div class="tab mid_head">
			  
			<div class="tablinks mid_title game1 empty_game_sec">
                 &nbsp;
                </div>
	
                <div class="tablinks mid_title game1 active" onclick="openCity(event, 'game1_cont')" id="defaultOpen">
                  <div class="mid_head_bg"><?= GAME_1; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val game1_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game1_amt">0</div>
                  </div>
                </div>
                <div class="tablinks mid_title game2 " onclick="openCity(event, 'game2_cont')">
                  <div class="mid_head_bg"><?= GAME_2; ?></div>
                 <div class="mob_qty">
                    Qty:
                    <div class="mob_val game2_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game2_amt">0</div>
                  </div>
                </div>
                <div class="tablinks mid_title game3 " onclick="openCity(event, 'game3_cont')">
                  <div class="mid_head_bg"><?= GAME_3; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game3_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game3_amt">0</div>
                  </div>
                </div>
                <div class="tablinks mid_title game4 " onclick="openCity(event, 'game4_cont')">
                  <div class="mid_head_bg"><?= GAME_4; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val game4_qty">0</div>
                  </div>
                  <div class="mob_bet">
                     Bet:
                    <div class="mob_val game4_amt">0</div>
                  </div>
                </div>
                <div class="tablinks mid_title game5 " onclick="openCity(event, 'game5_cont')">
                  <div class="mid_head_bg"><?= GAME_5; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game5_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game5_amt">0</div>
                  </div>
                </div>
				<div class="tablinks mid_title game6 " onclick="openCity(event, 'game6_cont')">
                  <div class="mid_head_bg"><?= GAME_6; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game6_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game6_amt">0</div>
                  </div>
                </div>
				<div class="tablinks mid_title game7 " onclick="openCity(event, 'game7_cont')">
                  <div class="mid_head_bg"><?= GAME_7; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game7_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game7_amt">0</div>
                  </div>
                </div>
				<div class="tablinks mid_title game8 " onclick="openCity(event, 'game8_cont')">
                  <div class="mid_head_bg"><?= GAME_8; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game8_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game8_amt">0</div>
                  </div>
                </div>
				<div class="tablinks mid_title game9 " onclick="openCity(event, 'game9_cont')">
                  <div class="mid_head_bg"><?= GAME_9; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game9_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game9_amt">0</div>
                  </div>
                </div>
				<div class="tablinks mid_title game10 " onclick="openCity(event, 'game10_cont')" id="double_bottom">
                  <div class="mid_head_bg"><?= GAME_10; ?></div>
                  <div class="mob_qty">
                    Qty:
                    <div class="mob_val  game10_qty">0</div>
                  </div>
                  <div class="mob_bet">
                    Bet:
                    <div class="mob_val game10_amt">0</div>
                  </div>
                </div>
              </div>
              <div id="game1_cont" class="tabcontent middlecontent game1_cont">
                <div class="middlecont_1">
					<?php 
						$count =0;
						$s =0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn">
									<p id="pd_game1_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game1_<?= $i; ?>" name="double_game1[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn">
									<p id="pd_game1_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game1_<?= $i; ?>" name="double_game1[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							
							
							
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
				
                </div>
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
              <div id="game2_cont" class="tabcontent middlecontent game2_cont" style=" display: none;">
                <div class="middlecont_1">
					<?php 
						$count =0;
						$s =0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game2_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game2_<?= $i; ?>" name="double_game2[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game2_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game2_<?= $i; ?>" name="double_game2[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
              <div id="game3_cont" class="tabcontent middlecontent game3_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game3_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game3_<?= $i; ?>" name="double_game3[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game3_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game3_<?= $i; ?>" name="double_game3[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
				<div class="middlecont_1 hide_desk3" >
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
              <div id="game4_cont" class="tabcontent middlecontent game4_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game4_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game4_<?= $i; ?>" name="double_game4[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game4_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game4_<?= $i; ?>" name="double_game4[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
              <div id="game5_cont" class="tabcontent middlecontent game5_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game5_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game5_<?= $i; ?>" name="double_game5[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game5_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game5_<?= $i; ?>" name="double_game5[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
			  <div id="game6_cont" class="tabcontent middlecontent game6_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game6_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game6_<?= $i; ?>" name="double_game6[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game6_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game6_<?= $i; ?>" name="double_game6[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
			  <div id="game7_cont" class="tabcontent middlecontent game7_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game7_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game7_<?= $i; ?>" name="double_game7[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game7_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game7_<?= $i; ?>" name="double_game7[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
			  <div id="game8_cont" class="tabcontent middlecontent game8_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game8_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game8_<?= $i; ?>" name="double_game8[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game8_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game8_<?= $i; ?>" name="double_game8[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
			  <div id="game9_cont" class="tabcontent middlecontent game9_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game9_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game9_<?= $i; ?>" name="double_game9[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game9_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game9_<?= $i; ?>" name="double_game9[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
			  <div id="game10_cont" class="tabcontent middlecontent game10_cont" style=" display: none;">
                <div class="middlecont_1">
                  <?php 
						$count =0;
						$s=0;
						for($i=0; $i<=99; $i++) { $count=$count+1?>
							<div class="table_midcont">
							<?php if ($i>=10) {?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game10_<?= $i; ?>"><?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game10_<?= $i; ?>" name="double_game10[<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }else{ ?>
								<div class="middlecont_btn selection_click">
									<p id="pd_game10_<?= $i; ?>">0<?= $i; ?></p>
									<input type="text" maxlength="3" id="double_game10_<?= $i; ?>" name="double_game10[0<?= $i; ?>]" class="input_selection_value selection_div"  readonly />
								</div>
								<?php }?>
							</div>
							
					<?php
						if($count==10){
							echo '<div class="table_midcont select_row" onclick="randomPickRowNumber('.$s.','.$i.')">
										<div class="select_row_1"><img class="img-responsive" src="images/arrow1.png"></div>
									</div>';
							if($i!=99){
								echo '
							</div><div class="middlecont_1">';
							}
							$s+=$count;
							$count=0;
						}?>
						
					<?php } ?>
                </div>
                
				<div class="middlecont_1 hide_desk">
                  <div class="table_midcont select_row" onclick="randomPickEndedNumber(0)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(1)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(2)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(3)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(4)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(5)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(6)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(7)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(8)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
                   <div class="table_midcont select_row" onclick="randomPickEndedNumber(9)">
                    <div class="select_row_1"><img class="img-responsive" src="images/arrow.png"></div>
                  </div>
				   
                </div>
              </div>
			  
			  
			  
			  
			  
            </div>
          </div>
		  <div class="random_mobile">
		   <div class="random_common">
       </div>
        <div class="sel_tic_mob">
		<div class="tic_val_mob tic_val_mob_1">Ticket Value : <?php echo (!empty($upcomingDraw[0]->DRAW_PRICE)?$upcomingDraw[0]->DRAW_PRICE:0);?></div>
          <div class="sel_tic_mob_1">
            <div class="sel_mob_head">Ticket Quantity</div>
            <div class="dropdown">
              <button class="select_drop" type="button">
                
				<div class="add_minus_btn minus_btn" id="double_min_btn">-</div>
                <div class="input_sel_1" id="double_input_sel_1"><input type="text" maxlength="3" class="key_val" readonly id="tkt_qty"/></div>
                <div class="add_minus_btn plus_btn" id="double_plus_btn">+</div>
              </button>  
            </div>
			<div class="keypad_div" id="double_keypad_div">
                <div class="sel_btn_mob	double_sel_btn_mob">1</div>
                <div class="sel_btn_mob	double_sel_btn_mob">2</div>
                <div class="sel_btn_mob	double_sel_btn_mob">3</div>
                <div class="sel_btn_mob	double_sel_btn_mob">4</div>
                <div class="sel_btn_mob	double_sel_btn_mob">5</div>
                <div class="sel_btn_mob	double_sel_btn_mob">6</div>
                <div class="sel_btn_mob	double_sel_btn_mob">7</div>
                <div class="sel_btn_mob	double_sel_btn_mob">8</div>
                <div class="sel_btn_mob	double_sel_btn_mob">9</div>
                <div class="sel_btn_mob	double_sel_btn_mob">0</div>
				 <div class="sel_btn_mob clear" id="double_clear">C</div>
                <!--<div class="sel_btn_mob sel_btn_ok" onclick="calculateDouble()">OK</div>-->
              </div>
			  <div class="random_sec" id="random_double1" onClick="randomToggleDouble()"><div class="random_btn_mob" onClick="randomPickNumber('all')">ALL</div>
              <div class="random_btn_mob" onClick="randomPickNumber('odd')">ODD</div>
              <div class="random_btn_mob" onClick="randomPickNumber('even')">EVEN</div>
              <div class="random_btn_mob" onClick="randomPick('20')">20</div>
              <div class="random_btn_mob" onClick="randomPick('40')">40</div>
              <div class="random_btn_mob" onClick="randomPick('60')">60</div>
              <div class="random_btn_mob" onClick="randomPick('80')">80</div>
              <div class="random_btn_mob" onClick="randomPick('90')">90</div>
			</div>
          </div>
			
          <div class="random_double" onClick="randomToggleDouble()">Random</div>
        </div>
        <!-- <div class="random_drop_mob">
          <div class="dropdown">
            <button class="dropdown-toggle random_drop" type="button" data-toggle="dropdown">Random
            <span class="caret"></span></button>
            <div class="dropdown-menu">
              <div class="random_btn_mob">ALL</div>
              <div class="random_btn_mob">ODD</div>
              <div class="random_btn_mob">EVEN</div>
              <div class="random_btn_mob">20</div>
              <div class="random_btn_mob">40</div>
              <div class="random_btn_mob">60</div>
              <div class="random_btn_mob">80</div>
              <div class="random_btn_mob">100</div>
            </div>
          </div>
        </div> -->
        <div class="submit_sec_mob">
          <!--<div class="btn_mob mob_double">Double</div>-->
          <div class="btn_mob mob_clear" onclick="clearInput()">Clear</div>
		  <input type="button" value="Submit" class="btn_mob mob_submit_1 clickable" data-toggle="modal" data-target="#submit_mob" >
          <!--<div class="btn_mob mob_submit_1 clickable button_disabled" data-toggle="modal" data-target="#submit_mob">Submit</div>-->
        </div>
      </div>
          <div class="tic_sec hidden-xs hidden-sm" style="padding:0;">
            <div class="selected_1">
               <table class="select_val_1">
				<thead class="select_right_head">
				  <tr>
					<th class="ticket_1">TICKETS</th>
					<th class="qty_1">QTY</th>
					<th class="value_1">POINT</th>
					<th class="res_1">RESULT</th>
				  </tr>
				</thead>
				<tbody class="sel_val2">
				  <tr class="game1_sel">
					<td class="ticket_2"><?= GAME_1; ?></td>
					<td class="qty_2 double_qty_div game1_qty" id="game1_qty">0</td>
					<td class="value_2 double_amt_div game1_amt" id="game1_amt">0</td>
					<td class="res_2" id="rd_1"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}: '--');?></td>
				  </tr>
				  <tr class="game2_sel">
					<td class="ticket_2"><?= GAME_2; ?></td>
					<td class="qty_2 double_qty_div game2_qty" id="game2_qty">0</td>
					<td class="value_2 double_amt_div game2_amt" id="game2_amt">0</td>
					<td class="res_2"id="rd_2"><?= (isset($preDrawWIn->double->{2})? $preDrawWIn->double->{2}: '--');?></td>
				  </tr>
				  <tr class="game3_sel">
					<td class="ticket_2"><?= GAME_3; ?></td>
					<td class="qty_2 double_qty_div game3_qty" id="game3_qty">0</td>
					<td class="value_2 double_amt_div game3_amt" id="game3_amt">0</td>
					<td class="res_2"id="rd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></td>
				  </tr>
				  <tr class="game4_sel">
					<td class="ticket_2"><?= GAME_4; ?></td>
					<td class="qty_2 double_qty_div game4_qty" id="game4_qty">0</td>
					<td class="value_2 double_amt_div game4_amt" id="game4_amt">0</td>
					<td class="res_2"id="rd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></td>
				  </tr>
				  <tr class="game5_sel">
					<td class="ticket_2"><?= GAME_5; ?></td>
					<td class="qty_2 double_qty_div game5_qty" id="game5_qty">0</td>
					<td class="value_2 double_amt_div game5_amt" id="game5_amt">0</td>
					<td class="res_2"id="rd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></td>
				  </tr>
				  <tr class="game6_sel">
					<td class="ticket_2"><?= GAME_6; ?></td>
					<td class="qty_2 double_qty_div game6_qty" id="game6_qty">0</td>
					<td class="value_2 double_amt_div game6_amt" id="game6_amt">0</td>
					<td class="res_2"id="rd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></td>
				  </tr>
				  <tr class="game7_sel">
					<td class="ticket_2"><?= GAME_7; ?></td>
					<td class="qty_2 double_qty_div game7_qty" id="game7_qty">0</td>
					<td class="value_2 double_amt_div game7_amt" id="game7_amt">0</td>
					<td class="res_2"id="rd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></td>
				  </tr>
				  <tr class="game8_sel">
					<td class="ticket_2"><?= GAME_8; ?></td>
					<td class="qty_2 double_qty_div game8_qty" id="game8_qty">0</td>
					<td class="value_2 double_amt_div game8_amt" id="game8_amt">0</td>
					<td class="res_2"id="rd_8"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></td>
				  </tr>
				  <tr class="game9_sel">
					<td class="ticket_2"><?= GAME_9; ?></td>
					<td class="qty_2 double_qty_div game9_qty" id="game9_qty">0</td>
					<td class="value_2 double_amt_div game9_amt" id="game9_amt">0</td>
					<td class="res_2"id="rd_9"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></td>
				  </tr>
				  <tr class="game10_sel">
					<td class="ticket_2"><?= GAME_10; ?></td>
					<td class="qty_2 double_qty_div game10_qty" id="game10_qty">0</td>
					<td class="value_2 double_amt_div game10_amt" id="game10_amt">0</td>
					<td class="res_2"id="rd_10"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></td>
				  </tr>
				  
				  
				  <tr class="total_sel">
					<td class="ticket_2">Total</td>
					<td class="qty_2 double_qty" id="double_qty">0</td>
					<td class="value_2 double_total" id="double_total">0</td>
					<td class="value_3"></td>
				  </tr>
				</tbody>
			  </table>
            </div>
            <div class="randompick">
							<!-- <div class="select_right">
								<p>RANDOM PICK</p>
							</div>
							<div class="random_cont">
								<div class="tic_amt">
									<label>Ticket Qty</label><input type="text" id="tkt_qty" name="tkt_qty" value="" maxlength="3" onchange="ticketQty()" disabled="">
								</div>
								<div class="tic_amt random_num_1">
									<label>Random Number</label><input type="text" id="random_number" value="" maxlength="2" onkeyup="randomPick(this.value)" disabled="">
								</div>
								<div class="random_1">
									<div id="random_no_all" class="random_num random_no_1" onclick="randomPickNumber('all',this)"><p class="series_all">ALL</p></div>
									<div id="random_no_odd" class="random_num random_no_1" onclick="randomPickNumber('odd',this)"><p class="series_all">ODD</p></div>
									<div id="random_no_even" class="random_num random_no_1" onclick="randomPickNumber('even',this)"><p class="series_all">EVEN</p></div>
								</div>

							
								
								<div class="random_1">
									<label>Series</label>
								</div>
								<div class="random_1">
									<div id="random_endno_0" class="random_num random_no_2" onclick="randomPickEndedNumber('0',this)"><p class="series_all">0</p></div>
									<div id="random_endno_1" class="random_num random_no_2" onclick="randomPickEndedNumber('1',this)"><p class="series_all">1</p></div>
									<div id="random_endno_2" class="random_num random_no_2" onclick="randomPickEndedNumber('2',this)"><p class="series_all">2</p></div>
									<div id="random_endno_3" class="random_num random_no_2" onclick="randomPickEndedNumber('3',this)"><p class="series_all">3</p></div>
									<div id="random_endno_4" class="random_num random_no_2" onclick="randomPickEndedNumber('4',this)"><p class="series_all">4</p></div>
									<div id="random_endno_5" class="random_num random_no_2" onclick="randomPickEndedNumber('5',this)"><p class="series_all">5</p></div>
									<div id="random_endno_6" class="random_num random_no_2" onclick="randomPickEndedNumber('6',this)"><p class="series_all">6</p></div>
									<div id="random_endno_7" class="random_num random_no_2" onclick="randomPickEndedNumber('7',this)"><p class="series_all">7</p></div>
									<div id="random_endno_8" class="random_num random_no_2" onclick="randomPickEndedNumber('8',this)"><p class="series_all">8</p></div>
									<div id="random_endno_9" class="random_num random_no_2" onclick="randomPickEndedNumber('9',this)"><p class="series_all">9</p></div>
	
								</div>
							
							</div> -->
						</div>
				  </div>
				</div>
				
		<div class="double_player tabcontent1" id="single_1" >
		  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bahar" id="singleInfo"  style="overflow: auto;-webkit-overflow-scrolling: touch;">	
  <!--<a class="left_scroll blink" href="#ss" id="2"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a><a href="#ss1" id="5" class="right_scroll blink"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>-->

   
			<div class=" cont_left">
			  <div class="cont_left1">
				<div class="contright_head game_title">Tickets</div>
				<!-- <div class="contright_head game_points">Point</div> -->
				<div class="contright_head">0</div>
				<div class="contright_head">1</div>
				<div class="contright_head">2</div>
				<div class="contright_head">3</div>
				<div class="contright_head">4</div>
				<div class="contright_head">5</div>
				<div class="contright_head">6</div>
				<div class="contright_head">7</div>
				<div class="contright_head">8</div>
				<div class="contright_head">9</div>
				<!-- <div class="contright_head game_qty">Qty</div>
				<div class="contright_head game_amt_1">Point</div>
				<div class="contright_head game_lastrst">Result</div> -->
			  </div>
			  <div class="cont_right1 s_active sgame1" onClick="openSingle('sgame1_cont')" id="ss">
				<div class="cont_right_top game1_color">
					<div class="game_sec game1_right game_title">
						<div class="left_head_mob">
							<div class="mid_head_bg"><?= GAME_1; ?></div>
						</div>
							 <div class="mob_qty">
								Qty:
								<div class="mob_val sgame1_qty">0</div>
							</div>
							<div class="mob_bet">
								Bet:
								<div class="mob_val sgame1_amt">0</div>
							</div>
					</div>
				</div>
				<div class="cont_right_bottom game1_color sgame1_cont" id="sgame1_cont" >
				<!-- <div class="game_sec game1_right game_points">0</div> -->
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_0">0</p><input style="display:none;" name="single_game1[0]" id="sgame1_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_1">1</p><input style="display:none;" name="single_game1[1]" id="sgame1_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_2">2</p><input style="display:none;" name="single_game1[2]" id="sgame1_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_3">3</p><input style="display:none;" name="single_game1[3]" id="sgame1_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_4">4</p><input style="display:none;" name="single_game1[4]" id="sgame1_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_5">5</p><input style="display:none;" name="single_game1[5]" id="sgame1_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_6">6</p><input style="display:none;" name="single_game1[6]" id="sgame1_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_7">7</p><input style="display:none;" name="single_game1[7]" id="sgame1_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_8">8</p><input style="display:none;" name="single_game1[8]" id="sgame1_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game1_right"><div class="middlecont_btn"><p id="pd_sgame1_9">9</p><input style="display:none;" name="single_game1[9]" id="sgame1_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game1_right game_qty"><div>0</div></div>
				<div class="game_sec game1_right game_amt_1"><div>0</div></div>
				<div class="game_sec game1_right game_lastrst"><div>0</div></div> -->
				</div>
			  </div>
			  <div class="cont_right1 sgame2" onClick="openSingle('sgame2_cont')">
			  <div class="cont_right_top game2_color active">
				<div class="game_sec game2_right game_title"><div class="left_head_mob">
							<div class="mid_head_bg"><?= GAME_2; ?></div>
						  </div>
						  <div class="mob_qty">
								Qty:
								<div class="mob_val sgame2_qty">0</div>
							</div>
							<div class="mob_bet">
								Bet:
								<div class="mob_val sgame2_amt">0</div>
							</div>
							</div>
						  </div>
				<div class="cont_right_bottom game2_color  sgame2_cont" id="sgame2_cont">
			   <!--  <div class="game_sec game2_right game_points">0</div> -->
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_0">0</p><input style="display:none;" name="single_game2[0]" id="sgame2_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_1">1</p><input style="display:none;" name="single_game2[1]" id="sgame2_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_2">2</p><input style="display:none;" name="single_game2[2]" id="sgame2_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_3">3</p><input style="display:none;" name="single_game2[3]" id="sgame2_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_4">4</p><input style="display:none;" name="single_game2[4]" id="sgame2_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_5">5</p><input style="display:none;" name="single_game2[5]" id="sgame2_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_6">6</p><input style="display:none;" name="single_game2[6]" id="sgame2_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_7">7</p><input style="display:none;" name="single_game2[7]" id="sgame2_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_8">8</p><input style="display:none;" name="single_game2[8]" id="sgame2_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game2_right"><div class="middlecont_btn"><p id="pd_sgame2_9">9</p><input style="display:none;" name="single_game2[9]" id="sgame2_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game2_right game_qty"><div>0</div></div>
				<div class="game_sec game2_right game_amt_1"><div>0</div></div>
				<div class="game_sec game2_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			  <div class="cont_right1 sgame3" onClick="openSingle('sgame3_cont')">
			  <div class="cont_right_top game3_color">
				<div class="game_sec game3_right game_title"><div class="left_head_mob">
							<div class="mid_head_bg"><?= GAME_3; ?></div>
						  </div>
						  <div class="mob_qty">
								Qty:
								<div class="mob_val sgame3_qty">0</div>
							</div>
							<div class="mob_bet">
								Bet:
								<div class="mob_val sgame3_amt">0</div>
							</div></div>
						  </div>
				<div class="cont_right_bottom game3_color sgame3_cont" id="sgame3_cont">
			   <!--  <div class="game_sec game3_right game_points">0</div> -->
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_0">0</p><input style="display:none;" name="single_game3[0]" id="sgame3_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_1">1</p><input style="display:none;" name="single_game3[1]" id="sgame3_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_2">2</p><input style="display:none;" name="single_game3[2]" id="sgame3_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_3">3</p><input style="display:none;" name="single_game3[3]" id="sgame3_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_4">4</p><input style="display:none;" name="single_game3[4]" id="sgame3_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_5">5</p><input style="display:none;" name="single_game3[5]" id="sgame3_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_6">6</p><input style="display:none;" name="single_game3[6]" id="sgame3_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_7">7</p><input style="display:none;" name="single_game3[7]" id="sgame3_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_8">8</p><input style="display:none;" name="single_game3[8]" id="sgame3_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game3_right"><div class="middlecont_btn"><p id="pd_sgame3_9">9</p><input style="display:none;" name="single_game3[9]" id="sgame3_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
			   <!--  <div class="game_sec game3_right game_qty"><div>0</div></div>
				<div class="game_sec game3_right game_amt_1"><div>0</div></div>
				<div class="game_sec game3_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			  <div class="cont_right1 sgame4" onClick="openSingle('sgame4_cont')">
			  <div class="cont_right_top game4_color">
				<div class="game_sec game4_right game_title"><div class="left_head_mob">
							<div class="mid_head_bg"><?= GAME_4; ?></div>
						  </div>
						  <div class="mob_qty">
								Qty:
								<div class="mob_val sgame4_qty">0</div>
							</div>
							<div class="mob_bet">
								Bet:
								<div class="mob_val sgame4_amt">0</div>
							</div></div>
						  </div>
				<div class="cont_right_bottom game4_color sgame4_cont" id="sgame4_cont">
				<!-- <div class="game_sec game4_right game_points">0</div> -->
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_0">0</p><input style="display:none;" name="single_game4[0]" id="sgame4_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_1">1</p><input style="display:none;" name="single_game4[1]" id="sgame4_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_2">2</p><input style="display:none;" name="single_game4[2]" id="sgame4_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_3">3</p><input style="display:none;" name="single_game4[3]" id="sgame4_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_4">4</p><input style="display:none;" name="single_game4[4]" id="sgame4_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_5">5</p><input style="display:none;" name="single_game4[5]" id="sgame4_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_6">6</p><input style="display:none;" name="single_game4[6]" id="sgame4_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_7">7</p><input style="display:none;" name="single_game4[7]" id="sgame4_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_8">8</p><input style="display:none;" name="single_game4[8]" id="sgame4_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game4_right"><div class="middlecont_btn"><p id="pd_sgame4_9">9</p><input style="display:none;" name="single_game4[9]" id="sgame4_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game4_right game_qty"><div>0</div></div>
				<div class="game_sec game4_right game_amt_1"><div>0</div></div>
				<div class="game_sec game4_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			  <div class="cont_right1 sgame5" onClick="openSingle('sgame5_cont')" >
			  <div class="cont_right_top game5_color">
				<div class="game_sec game5_right game_title">
					<div class="left_head_mob">
						<div class="mid_head_bg"><?= GAME_5; ?></div>
					</div>
					<div class="mob_qty">
						Qty:
						<div class="mob_val sgame5_qty">0</div>
					</div>
					<div class="mob_bet">
						Bet:
						<div class="mob_val sgame5_amt">0</div>
					</div></div>
				  </div>
				<div class="cont_right_bottom game5_color sgame5_cont" id="sgame5_cont">
				<!-- <div class="game_sec game5_right game_points">0</div> -->
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_0">0</p><input style="display:none;" name="single_game5[0]" id="sgame5_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_1">1</p><input style="display:none;" name="single_game5[1]" id="sgame5_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_2">2</p><input style="display:none;" name="single_game5[2]" id="sgame5_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_3">3</p><input style="display:none;" name="single_game5[3]" id="sgame5_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_4">4</p><input style="display:none;" name="single_game5[4]" id="sgame5_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_5">5</p><input style="display:none;" name="single_game5[5]" id="sgame5_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_6">6</p><input style="display:none;" name="single_game5[6]" id="sgame5_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_7">7</p><input style="display:none;" name="single_game5[7]" id="sgame5_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_8">8</p><input style="display:none;" name="single_game5[8]" id="sgame5_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game5_right"><div class="middlecont_btn"><p id="pd_sgame5_9">9</p><input style="display:none;" name="single_game5[9]" id="sgame5_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game5_right game_qty"><div>0</div></div>
				<div class="game_sec game5_right game_amt_1"><div>0</div></div>
				<div class="game_sec game5_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			  
			  
			  <div class="cont_right1 sgame6" onClick="openSingle('sgame6_cont')" >
			  <div class="cont_right_top game6_color">
				<div class="game_sec game6_right game_title">
					<div class="left_head_mob">
						<div class="mid_head_bg"><?= GAME_6; ?></div>
					</div>
					<div class="mob_qty">
						Qty:
						<div class="mob_val sgame6_qty">0</div>
					</div>
					<div class="mob_bet">
						Bet:
						<div class="mob_val sgame6_amt">0</div>
					</div></div>
				  </div>
				<div class="cont_right_bottom game6_color sgame6_cont" id="sgame6_cont">
				<!-- <div class="game_sec game6_right game_points">0</div> -->
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_0">0</p><input style="display:none;" name="single_game6[0]" id="sgame6_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_1">1</p><input style="display:none;" name="single_game6[1]" id="sgame6_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_2">2</p><input style="display:none;" name="single_game6[2]" id="sgame6_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_3">3</p><input style="display:none;" name="single_game6[3]" id="sgame6_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_4">4</p><input style="display:none;" name="single_game6[4]" id="sgame6_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_5">5</p><input style="display:none;" name="single_game6[5]" id="sgame6_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_6">6</p><input style="display:none;" name="single_game6[6]" id="sgame6_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_7">7</p><input style="display:none;" name="single_game6[7]" id="sgame6_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_8">8</p><input style="display:none;" name="single_game6[8]" id="sgame6_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game6_right"><div class="middlecont_btn"><p id="pd_sgame6_9">9</p><input style="display:none;" name="single_game6[9]" id="sgame6_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game6_right game_qty"><div>0</div></div>
				<div class="game_sec game6_right game_amt_1"><div>0</div></div>
				<div class="game_sec game6_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			  <div class="cont_right1 sgame7" onClick="openSingle('sgame7_cont')">
			  <div class="cont_right_top game7_color">
				<div class="game_sec game7_right game_title">
					<div class="left_head_mob">
						<div class="mid_head_bg"><?= GAME_7; ?></div>
					</div>
					<div class="mob_qty">
						Qty:
						<div class="mob_val sgame7_qty">0</div>
					</div>
					<div class="mob_bet">
						Bet:
						<div class="mob_val sgame7_amt">0</div>
					</div></div>
				  </div>
				<div class="cont_right_bottom game7_color sgame7_cont" id="sgame7_cont">
				<!-- <div class="game_sec game7_right game_points">0</div> -->
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_0">0</p><input style="display:none;" name="single_game7[0]" id="sgame7_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_1">1</p><input style="display:none;" name="single_game7[1]" id="sgame7_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_2">2</p><input style="display:none;" name="single_game7[2]" id="sgame7_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_3">3</p><input style="display:none;" name="single_game7[3]" id="sgame7_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_4">4</p><input style="display:none;" name="single_game7[4]" id="sgame7_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_5">5</p><input style="display:none;" name="single_game7[5]" id="sgame7_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_6">6</p><input style="display:none;" name="single_game7[6]" id="sgame7_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_7">7</p><input style="display:none;" name="single_game7[7]" id="sgame7_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_8">8</p><input style="display:none;" name="single_game7[8]" id="sgame7_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game7_right"><div class="middlecont_btn"><p id="pd_sgame7_9">9</p><input style="display:none;" name="single_game7[9]" id="sgame7_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game7_right game_qty"><div>0</div></div>
				<div class="game_sec game7_right game_amt_1"><div>0</div></div>
				<div class="game_sec game7_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			   <div class="cont_right1 sgame8" onClick="openSingle('sgame8_cont')">
			  <div class="cont_right_top game8_color">
				<div class="game_sec game8_right game_title">
					<div class="left_head_mob">
						<div class="mid_head_bg"><?= GAME_8; ?></div>
					</div>
					<div class="mob_qty">
						Qty:
						<div class="mob_val sgame8_qty">0</div>
					</div>
					<div class="mob_bet">
						Bet:
						<div class="mob_val sgame8_amt">0</div>
					</div></div>
				  </div>
				<div class="cont_right_bottom game8_color sgame8_cont" id="sgame8_cont">
				<!-- <div class="game_sec game8_right game_points">0</div> -->
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_0">0</p><input style="display:none;" name="single_game8[0]" id="sgame8_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_1">1</p><input style="display:none;" name="single_game8[1]" id="sgame8_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_2">2</p><input style="display:none;" name="single_game8[2]" id="sgame8_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_3">3</p><input style="display:none;" name="single_game8[3]" id="sgame8_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_4">4</p><input style="display:none;" name="single_game8[4]" id="sgame8_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_5">5</p><input style="display:none;" name="single_game8[5]" id="sgame8_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_6">6</p><input style="display:none;" name="single_game8[6]" id="sgame8_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_7">7</p><input style="display:none;" name="single_game8[7]" id="sgame8_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_8">8</p><input style="display:none;" name="single_game8[8]" id="sgame8_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game8_right"><div class="middlecont_btn"><p id="pd_sgame8_9">9</p><input style="display:none;" name="single_game8[9]" id="sgame8_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game8_right game_qty"><div>0</div></div>
				<div class="game_sec game8_right game_amt_1"><div>0</div></div>
				<div class="game_sec game8_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			   <div class="cont_right1 sgame9" onClick="openSingle('sgame9_cont')">
			  <div class="cont_right_top game9_color">
				<div class="game_sec game9_right game_title">
					<div class="left_head_mob">
						<div class="mid_head_bg"><?= GAME_9; ?></div>
					</div>
					<div class="mob_qty">
						Qty:
						<div class="mob_val sgame9_qty">0</div>
					</div>
					<div class="mob_bet">
						Bet:
						<div class="mob_val sgame9_amt">0</div>
					</div></div>
				  </div>
				<div class="cont_right_bottom game9_color sgame9_cont" id="sgame9_cont">
				<!-- <div class="game_sec game9_right game_points">0</div> -->
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_0">0</p><input style="display:none;" name="single_game9[0]" id="sgame9_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_1">1</p><input style="display:none;" name="single_game9[1]" id="sgame9_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_2">2</p><input style="display:none;" name="single_game9[2]" id="sgame9_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_3">3</p><input style="display:none;" name="single_game9[3]" id="sgame9_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_4">4</p><input style="display:none;" name="single_game9[4]" id="sgame9_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_5">5</p><input style="display:none;" name="single_game9[5]" id="sgame9_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_6">6</p><input style="display:none;" name="single_game9[6]" id="sgame9_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_7">7</p><input style="display:none;" name="single_game9[7]" id="sgame9_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_8">8</p><input style="display:none;" name="single_game9[8]" id="sgame9_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game9_right"><div class="middlecont_btn"><p id="pd_sgame9_9">9</p><input style="display:none;" name="single_game9[9]" id="sgame9_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game9_right game_qty"><div>0</div></div>
				<div class="game_sec game9_right game_amt_1"><div>0</div></div>
				<div class="game_sec game9_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			   <div class="cont_right1 sgame10" onClick="openSingle('sgame10_cont')" id="ss1">
			  <div class="cont_right_top game10_color">
				<div class="game_sec game10_right game_title">
					<div class="left_head_mob">
						<div class="mid_head_bg"><?= GAME_10; ?></div>
					</div>
					<div class="mob_qty">
						Qty:
						<div class="mob_val sgame10_qty">0</div>
					</div>
					<div class="mob_bet">
						Bet:
						<div class="mob_val sgame10_amt">0</div>
					</div></div>
				  </div>
				<div class="cont_right_bottom game10_color sgame10_cont" id="sgame10_cont"">
				<!-- <div class="game_sec game10_right game_points">0</div> -->
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_0">0</p><input style="display:none;" name="single_game10[0]" id="sgame10_0" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_1">1</p><input style="display:none;" name="single_game10[1]" id="sgame10_1" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_2">2</p><input style="display:none;" name="single_game10[2]" id="sgame10_2" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_3">3</p><input style="display:none;" name="single_game10[3]" id="sgame10_3" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_4">4</p><input style="display:none;" name="single_game10[4]" id="sgame10_4" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_5">5</p><input style="display:none;" name="single_game10[5]" id="sgame10_5" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_6">6</p><input style="display:none;" name="single_game10[6]" id="sgame10_6" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_7">7</p><input style="display:none;" name="single_game10[7]" id="sgame10_7" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_8">8</p><input style="display:none;" name="single_game10[8]" id="sgame10_8" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<div class="game_sec game10_right"><div class="middlecont_btn"><p id="pd_sgame10_9">9</p><input style="display:none;" name="single_game10[9]" id="sgame10_9" type="text" readonly value="" class="input_selection_value selection_div" /></div></div>
				<!-- <div class="game_sec game10_right game_qty"><div>0</div></div>
				<div class="game_sec game10_right game_amt_1"><div>0</div></div>
				<div class="game_sec game10_right game_lastrst"><div>0</div></div> -->
			  </div>
			  </div>
			</div>
			
		   <!--  <div class="total_resinput">
			  <div class="cont_right1total">
			   Total
			  </div>
			  <div class="empty_div">
			  
			  </div>
			  <div class="cont_right1 right_qty inputtotal">
				<div class="" id="single_qty">
				  0
				</div>
			  </div>
			  <div class="cont_right1 right_amt inputtotal">
				<div class="" id="single_total">
				  0
				</div>
			  </div>
			  <div class="cont_right1 lastres_1 inputtotal">
				<div class="">
				</div>
			  </div>
			</div> -->
		  </div>
		<div class="random_mobile">
		   <div class="random_common">
		   </div>
			<div class="sel_tic_mob">
			<div class="tic_val_mob tic_val_mob_1">Ticket Value : <?php echo (!empty($upcomingDraw[0]->DRAW_PRICE)?$upcomingDraw[0]->DRAW_PRICE:0);?></div>
			  <div class="sel_tic_mob_1">
				<div class="sel_mob_head">Ticket Quantity</div>
				<div class="dropdown">
				  <button class="select_drop" type="button">
					<div class="add_minus_btn minus_btn" id="single_min_btn">-</div>
					<div class="input_sel_1" id="single_input_sel_1"><input type="text" maxlength="3" class="key_val" readonly id="stkt_qty"/></div>
					<div class="add_minus_btn plus_btn" id="single_plus_btn">+</div>
				  </button>
				  
				</div>
				<div class="keypad_div" id="single_keypad_div">
					<div class="sel_btn_mob single_sel_btn_mob">1</div>
					<div class="sel_btn_mob single_sel_btn_mob">2</div>
					<div class="sel_btn_mob single_sel_btn_mob">3</div>
					<div class="sel_btn_mob single_sel_btn_mob">4</div>
					<div class="sel_btn_mob single_sel_btn_mob">5</div>
					<div class="sel_btn_mob single_sel_btn_mob">6</div>
					<div class="sel_btn_mob single_sel_btn_mob">7</div>
					<div class="sel_btn_mob single_sel_btn_mob">8</div>
					<div class="sel_btn_mob single_sel_btn_mob">9</div>
					<div class="sel_btn_mob single_sel_btn_mob">0</div>
					 <div class="sel_btn_mob clear" id="single_clear">C</div>
				   <!-- <div class="sel_btn_mob sel_btn_ok">OK</div>-->
				  </div>
				  <div class="random_sec" id="random_single" onClick="randomToggleSingle()"><div class="random_btn_mob" onClick="randomPickNumberSingle('all')">ALL</div>
				  <div class="random_btn_mob" onClick="randomPickNumberSingle('odd')">ODD</div>
				  <div class="random_btn_mob" onClick="randomPickNumberSingle('even')">EVEN</div>
				  <div class="random_btn_mob" onClick="randomPickSingle('2')">2</div>
				  <div class="random_btn_mob" onClick="randomPickSingle('4')">4</div>
				  <div class="random_btn_mob" onClick="randomPickSingle('6')">6</div>
				  <div class="random_btn_mob" onClick="randomPickSingle('8')">8</div>
				  <div class="random_btn_mob" onClick="randomPickSingle('9')">9</div>
				</div>
			  </div>
				
			  <div class="random_single" onClick="randomToggleSingle()">Random</div>
			</div>
			<!-- <div class="random_drop_mob">
			  <div class="dropdown">
				<button class="dropdown-toggle random_drop" type="button" data-toggle="dropdown">Random
				<span class="caret"></span></button>
				<div class="dropdown-menu">
				  <div class="random_btn_mob">ALL</div>
				  <div class="random_btn_mob">ODD</div>
				  <div class="random_btn_mob">EVEN</div>
				  <div class="random_btn_mob">20</div>
				  <div class="random_btn_mob">40</div>
				  <div class="random_btn_mob">60</div>
				  <div class="random_btn_mob">80</div>
				  <div class="random_btn_mob">100</div>
				</div>
			  </div>
			</div> -->
			<div class="submit_sec_mob">
			  <!--<div class="btn_mob mob_double">Double</div>-->
			  <div class="btn_mob mob_clear" onclick="clearInput()">Clear</div>
			  <!--<div class="btn_mob mob_submit_1 clickable button_disabled" data-toggle="modal" data-target="#submit_mob">Submit</div>-->
			  <input type="button" value="Submit" class="btn_mob mob_submit_1 clickable" data-toggle="modal" data-target="#submit_mob" >
			</div>
      </div>
		  <div class="tic_sec hidden-xs hidden-sm" style="padding:0;">
					<div class="selected_1">
					  
					  <table class="select_val_1">
						<thead class="select_right_head">
						  <tr>
							<th class="ticket_1">STICKETS</th>
							<th class="qty_1">QTY</th>
							<th class="value_1">POINT</th>
							<th class="res_1">RESULT</th>
						  </tr>
						</thead>
						<tbody class="sel_val2">
						  <tr class="game1_sel">
							<td class="ticket_2"><?= GAME_1; ?></td>
							<td class="qty_2 single_qty_div sgame1_qty" id="sgame1_qty">0</td>
							<td class="value_2 single_amt_div sgame1_amt" id="sgame1_amt">0</td>
							<td class="res_2" id="rd_1"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}: '--');?></td>
						  </tr>
						  <tr class="game2_sel">
							<td class="ticket_2"><?= GAME_2; ?></td>
							<td class="qty_2 single_qty_div sgame2_qty" id="sgame2_qty">0</td>
							<td class="value_2 single_amt_div sgame2_amt" id="sgame2_amt">0</td>
							<td class="res_2"id="rd_2"><?= (isset($preDrawWIn->double->{2})? $preDrawWIn->double->{2}: '--');?></td>
						  </tr>
						  <tr class="game3_sel">
							<td class="ticket_2"><?= GAME_3; ?></td>
							<td class="qty_2 single_qty_div sgame3_qty" id="sgame3_qty">0</td>
							<td class="value_2 single_amt_div sgame3_amt" id="sgame3_amt">0</td>
							<td class="res_2"id="rd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></td>
						  </tr>
						  <tr class="game4_sel">
							<td class="ticket_2"><?= GAME_4; ?></td>
							<td class="qty_2 single_qty_div sgame4_qty" id="sgame4_qty">0</td>
							<td class="value_2 single_amt_div sgame4_amt" id="sgame4_amt">0</td>
							<td class="res_2"id="rd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></td>
						  </tr>
						  <tr class="game5_sel">
							<td class="ticket_2"><?= GAME_5; ?></td>
							<td class="qty_2 single_qty_div sgame5_qty" id="sgame5_qty">0</td>
							<td class="value_2 single_amt_div sgame5_amt" id="sgame5_amt">0</td>
							<td class="res_2"id="rd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></td>
						  </tr>
						  <tr class="game6_sel">
							<td class="ticket_2"><?= GAME_6; ?></td>
							<td class="qty_2 single_qty_div sgame6_qty" id="sgame6_qty">0</td>
							<td class="value_2 single_amt_div sgame6_amt" id="sgame6_amt">0</td>
							<td class="res_2"id="rd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></td>
						  </tr>
						  <tr class="game7_sel">
							<td class="ticket_2"><?= GAME_7; ?></td>
							<td class="qty_2 single_qty_div sgame7_qty" id="sgame7_qty">0</td>
							<td class="value_2 single_amt_div sgame7_amt" id="sgame7_amt">0</td>
							<td class="res_2"id="rd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></td>
						  </tr>
						  <tr class="game8_sel">
							<td class="ticket_2"><?= GAME_8; ?></td>
							<td class="qty_2 single_qty_div sgame8_qty" id="sgame8_qty">0</td>
							<td class="value_2 single_amt_div sgame8_amt" id="sgame8_amt">0</td>
							<td class="res_2"id="rd_8"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></td>
						  </tr>
						  <tr class="game9_sel">
							<td class="ticket_2"><?= GAME_9; ?></td>
							<td class="qty_2 single_qty_div sgame9_qty" id="sgame9_qty">0</td>
							<td class="value_2 single_amt_div sgame9_amt" id="sgame9_amt">0</td>
							<td class="res_2"id="rd_9"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></td>
						  </tr>
						  <tr class="game10_sel">
							<td class="ticket_2"><?= GAME_10; ?></td>
							<td class="qty_2 single_qty_div sgame10_qty" id="sgame10_qty">0</td>
							<td class="value_2 single_amt_div sgame10_amt" id="sgame10_amt">0</td>
							<td class="res_2"id="rd_10"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></td>
						  </tr>
						  
						  <tr class="total_sel">
							<td class="ticket_2">Total</td>
							<td class="qty_2 single_qty" id="single_qty">0</td>
							<td class="value_2 single_total" id="single_total">0</td>
							<td class="value_3"></td>
						  </tr>
						</tbody>
					  </table>
					</div>
					<div class="randompick">
						<!-- <div class="select_right">
							<p>RANDOM PICK</p>
						</div>
						<div class="random_cont">
							<div class="tic_amt">
								<label>Ticket Qty</label><input type="text" id="tkt_qty" name="tkt_qty" value="" maxlength="3" onchange="ticketQty()" disabled="">
							</div>
							<div class="tic_amt random_num_1">
								<label>Random Number</label><input type="text" id="random_number" value="" maxlength="2" onkeyup="randomPick(this.value)" disabled="">
							</div>
							<div class="random_1">
								<div id="random_no_all" class="random_num random_no_1" onclick="randomPickNumber('all',this)"><p class="series_all">ALL</p></div>
								<div id="random_no_odd" class="random_num random_no_1" onclick="randomPickNumber('odd',this)"><p class="series_all">ODD</p></div>
								<div id="random_no_even" class="random_num random_no_1" onclick="randomPickNumber('even',this)"><p class="series_all">EVEN</p></div>
							</div>

						
							
							<div class="random_1">
								<label>Series</label>
							</div>
							<div class="random_1">
								<div id="random_endno_0" class="random_num random_no_2" onclick="randomPickEndedNumber('0',this)"><p class="series_all">0</p></div>
								<div id="random_endno_1" class="random_num random_no_2" onclick="randomPickEndedNumber('1',this)"><p class="series_all">1</p></div>
								<div id="random_endno_2" class="random_num random_no_2" onclick="randomPickEndedNumber('2',this)"><p class="series_all">2</p></div>
								<div id="random_endno_3" class="random_num random_no_2" onclick="randomPickEndedNumber('3',this)"><p class="series_all">3</p></div>
								<div id="random_endno_4" class="random_num random_no_2" onclick="randomPickEndedNumber('4',this)"><p class="series_all">4</p></div>
								<div id="random_endno_5" class="random_num random_no_2" onclick="randomPickEndedNumber('5',this)"><p class="series_all">5</p></div>
								<div id="random_endno_6" class="random_num random_no_2" onclick="randomPickEndedNumber('6',this)"><p class="series_all">6</p></div>
								<div id="random_endno_7" class="random_num random_no_2" onclick="randomPickEndedNumber('7',this)"><p class="series_all">7</p></div>
								<div id="random_endno_8" class="random_num random_no_2" onclick="randomPickEndedNumber('8',this)"><p class="series_all">8</p></div>
								<div id="random_endno_9" class="random_num random_no_2" onclick="randomPickEndedNumber('9',this)"><p class="series_all">9</p></div>

							</div>
						
						</div> -->
				</div>
			  </div>
			</div>
			</form>
		  </div>
		   <div class="navmob">
          <div class="dropdown">
            <button class="dropdown-toggle nav_drop" type="button" data-toggle="dropdown"><img class="img-responsive" src="images/nav_icon.png">
            </button>
				<div class="dropdown-menu">
				  <div class="nav_cont">
					<a href="gamehistory.php">
					  <div><img class="img-responsive" src="images/my-account.png"></div>
					  <p>MYACCOUNT</p>
					</a>
				  </div>
				  <div class="nav_cont">
					<a href="previousResult.php" class="play-icon popup-with-zoom-anim resultchat">
					  <div><img class="img-responsive" src="images/previous-result.png"></div>
					  <p>RESULT</p>
					</a>
				  </div>
				  <div class="nav_cont"  data-toggle="modal" data-target="#logout_mob" >
					<a><div><img class="img-responsive" src="images/logout.png"></div>
					<p>LOGOUT</p>
					</a>
				  </div>
				  <div class="nav_cont">
					<a href="<?php echo LOGIN_LANDING_URL ?>"><div><i class="fa fa-arrow-circle-o-left" style="font-size: 35px;"></i></div>
					<p>BACK</p>
					</a>
				  </div>
				</div>
          </div>
        </div>
		
		
		
		
		
		<div class="modal fade logout_confirm" id="logout_mob" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header popup_head">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Confirm Logout</h4>
          </div>
          <div class="modal-body">
           
            <div class="">
              <div class="">Are you sure you want to logout?</div>
              <div class="confirm_logout_1"><a href="logout.php">OK</a></div>
              <div class="confirm_logout_1"  data-dismiss="modal">CANCEL</div>
            </div>
          </div>
        </div>
      </div>
    </div>
		
		
		
		
		
		
		
		
		
		
	  <div class="random_common1">
	  
<div class="user_detail_mob"><i class="fa fa-user" aria-hidden="true"></i></div>
<div class="user_detail_mob1" style="display:none;">
<div class="user_logo">
<img src="images/logo.png">
</div>

<div class="user_detail_mob2">
<div class="user_name_mob_1"><?= (!empty($_SESSION['lucky_username'])?$_SESSION['lucky_username']:'--');?></div>
<div class="userBalance"><?php echo (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:000);?></div>
</div>
</div>
<script>
$(document).ready(function(){
    $(".user_detail_mob").click(function(){
        $(".user_detail_mob1").slideToggle();
    });
	 $(".middle").click(function(){
        $(".user_detail_mob1").hide();
    });
	
});
</script>
        <div class="time_mob">
          <div><?PHP echo date("d-m-Y"); ?></div>
          <div class="servertime"></div>
        </div>
       
		 <div class="tic_val_mob">Ticket Value (<?php echo (!empty($upcomingDraw[0]->DRAW_PRICE)?$upcomingDraw[0]->DRAW_PRICE:0);?>)</div>
        <div class="drawtime_sec_mob">
		<div class="nextdraw_mob">
			<div class="next_draw_1">Next Draw: <span class="nxtdrawTime"><?= $nxtDrawTime; ?></span></div>	
		<div class="future_date"><?php echo $nDrawDate; ?></div>
		</div>
		
          <div class="drawtime_mob">
		  <?php if (!empty($futureDraw ) || !empty($nextDayDraw)) { ?>
		  <div class="fut_draw_1">
						<select class="time_selection future" onChange="nextdraw(this.value)">
					<?php 
					if(!empty($futureDraw)){
					$k=0;
					foreach ($futureDraw as $draw){
							$nxtDraw = (!empty($draw->DRAW_STARTTIME)?date('h:i A',strtotime($draw->DRAW_STARTTIME)):'00:00');
							
							$sel = "";
							if ($drawID==$draw->DRAW_ID){
								$sel = "selected='selected'";
							}
								if ( $k==0){
						?>
									<option value="0" <?= $sel; ?>>NOW</option>
							<?php } else { ?>
									<option value="<?= $draw->DRAW_ID; ?>" <?= $sel; ?>><?= $nxtDraw; ?></option>
							<?php } ?>
					<?php $k++;} }
					if(!empty($nextDayDraw)){
									?>
								<option class="futuredraw_day" value=""><b>Next Day</b></option>
								<?php 
								$k1=0;
								foreach ($nextDayDraw as $next){
									//$link1 = 'home.php?fdrawID='.base64_encode($next->DRAW_ID);
									//$drawNumber1 = substr( $next->DRAW_NUMBER,strlen( $next->DRAW_NUMBER)-5,5);
									$nxtDraw1 = (!empty($next->DRAW_STARTTIME)?date('h:i A',strtotime($next->DRAW_STARTTIME)):'00:00');
									
									$sel = "";
									if ($drawID==$next->DRAW_ID){
										$sel = "selected='selected'";
									}?>
										
											<option class="futuredraw_day" value="<?= $next->DRAW_ID; ?>" <?= $sel; ?>><?= $nxtDraw1; ?></option>
									
									
								<?php $k1++;} } ?>
					</select>
					</div>
				<?php } ?>
		  <div class="fut_draw_2">Starts In: <span class="ndrawLeftTime"><?php echo $drawCountDownTime;?></span> </div></div>
          
        </div>
		</div> 
      <div class="hidden-xs hidden-sm footer">
        <div class="footer_1" style="display:none;">
          <!-- <div class="freeacc foot_1">FREE ACCOUNT</div>
            <div class="htp foot_1">HOW TO PLAY</div>
            <div class="abtus foot_1">ABOUT US</div>
            <div class="rescht foot_1">RESULT CHART</div> -->
			
        <!--<a href="#small-dialog" class="play-icon popup-with-zoom-anim"><input type="button" value="FREE ACCOUNT" class="freeacc"></a>
        <a href="#small-dialog1" class="play-icon popup-with-zoom-anim"><input type="button" value="HOW TO PLAY" class="htp"></a>
        <a href="#small-dialog3" class="play-icon popup-with-zoom-anim"><input type="button" value="ABOUT US" class="abtus"></a>
        <a href="#small-dialog3" class="play-icon popup-with-zoom-anim"><input type="button" value="RESULT CHART" class="rescht"> </a>-->
        </div>
        <div class="footer_1" style="display:block;">
          <!--<input type="text" value="READY TO PLAY" class="readytoplay">
          <input type="button" value="SUBMIT" class="submit_1">
          <input type="button" value="CLEAR" class="clear_1">
          <a href="myaccount.html"><input type="button" value="REPORT" class="report_1"></a>
          <a href="#small-dialog3" class="play-icon popup-with-zoom-anim"><input type="button" value="RESULT CHART" class="rescht_1"></a> -->
			<input type="text" value="READY TO PLAY" class="readytoplay" readonly>
			<a href="gamehistory.php">
			<input type="button" value="REPORT" class="report_1" id="report"> 
			</a>
			 <!--<input type="button" value="DOUBLE" class="double_1">-->
			<a href="previousResult.php" class="resultchat" id="resultchat">
			<input type="button" value="RESULT CHART" class="rescht" id="result_chat">
			</a>
			<input type="button" value="CLEAR" class="clear_1" onClick="clearInput()" id="clear">
			<input type="button" value="SUBMIT" id="buy" class="submit_1 mob_submit_1 clickable" data-toggle="modal" data-target="#submit_mob" >
			 

         
		<div id="result_timer">
			<div id="small-dialog2" class="mfp-hide w3ls_small_dialog wthree_pop">
			 <div class="popup_head">
			 <img class="result_logo" src="images/logo.png">
			 </div>
			 <div class="result_popup_1"><div>RESULTS <span  class="preDrawTime"  title="previous result time"><?= $preDrawTimeFull ?></span><span class="timer_1" id="countTimer" style="display:none;">10 <small>sec</small></span></div></div>
			 <div class="results_cont" id="timer">
			   <div class="rescont_1">
				   <div class="game1_result">
					  <p><?= GAME_1?></p>
					  <!--<div class="res_points" id="drd_1"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}: '--');?></div>-->
					   <div class="res_points" id="drd_1">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next"></div>
								<div class="flip flip--top" id="top"></div>
								<div class="flip flip--top flip--back" id="back">0</div>
								<div class="flip flip--bottom" id="bottom"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
								<div class="flip flip--next" id="next1"></div>
								<div class="flip flip--top" id="top1"></div>
								<div class="flip flip--top flip--back" id="back1">0</div>
								<div class="flip flip--bottom" id="bottom1"></div>
							  </div>
						 </div>
					  </div>
				   </div>
				   <div class="game2_result">
					  <p><?= GAME_2?></p>
					 <!-- <div class="res_points" id="drd_2"><?= (isset($preDrawWIn->double->{2})? $preDrawWIn->double->{2}: '--');?></div>-->
					  <div class="res_points" id="drd_2">
						 <div class="seg">
							<div class="flip-wrapper">
								<div class="flip flip--next" id="next2"></div>
								<div class="flip flip--top" id="top2"></div>
								<div class="flip flip--top flip--back" id="back2">0</div>
								<div class="flip flip--bottom" id="bottom2"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next3"></div>
								<div class="flip flip--top" id="top3"></div>
								<div class="flip flip--top flip--back" id="back3">0</div>
								<div class="flip flip--bottom" id="bottom3"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game3_result">
					  <p><?= GAME_3?></p>
					  <!--<div class="res_points" id="drd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></div>-->
					   <div class="res_points" id="drd_3">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next4"></div>
								<div class="flip flip--top" id="top4"></div>
								<div class="flip flip--top flip--back" id="back4">0</div>
								<div class="flip flip--bottom" id="bottom4"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next5"></div>
								<div class="flip flip--top" id="top5"></div>
								<div class="flip flip--top flip--back" id="back5">0</div>
								<div class="flip flip--bottom" id="bottom5"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game4_result">
					  <p><?= GAME_4?></p>
					  <!--<div class="res_points" id="drd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></div>-->
					   <div class="res_points" id="drd_4">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next6"></div>
								<div class="flip flip--top" id="top6"></div>
								<div class="flip flip--top flip--back" id="back6">0</div>
								<div class="flip flip--bottom" id="bottom6"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next7"></div>
								<div class="flip flip--top" id="top7"></div>
								<div class="flip flip--top flip--back" id="back7">0</div>
								<div class="flip flip--bottom" id="bottom7"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game5_result">
					  <p><?= GAME_5?></p>
					  <!--<div class="res_points" id="drd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></div>-->
					   <div class="res_points" id="drd_5">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next8"></div>
								<div class="flip flip--top" id="top8"></div>
								<div class="flip flip--top flip--back" id="back8">0</div>
								<div class="flip flip--bottom" id="bottom8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next9"></div>
								<div class="flip flip--top" id="top9"></div>
								<div class="flip flip--top flip--back" id="back9">0</div>
								<div class="flip flip--bottom" id="bottom9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				    <div class="game6_result">
					  <p><?= GAME_6?></p>
					  <!--<div class="res_points" id="drd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></div>-->
					   <div class="res_points" id="drd_6">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next8"></div>
								<div class="flip flip--top" id="top8"></div>
								<div class="flip flip--top flip--back" id="back8">0</div>
								<div class="flip flip--bottom" id="bottom8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next9"></div>
								<div class="flip flip--top" id="top9"></div>
								<div class="flip flip--top flip--back" id="back9">0</div>
								<div class="flip flip--bottom" id="bottom9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				    <div class="game7_result">
					  <p><?= GAME_7?></p>
					  <!--<div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></div>-->
					   <div class="res_points" id="drd_7">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next8"></div>
								<div class="flip flip--top" id="top8"></div>
								<div class="flip flip--top flip--back" id="back8">0</div>
								<div class="flip flip--bottom" id="bottom8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next9"></div>
								<div class="flip flip--top" id="top9"></div>
								<div class="flip flip--top flip--back" id="back9">0</div>
								<div class="flip flip--bottom" id="bottom9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				    <div class="game8_result">
					  <p><?= GAME_8?></p>
					  <!--<div class="res_points" id="drd_8"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></div>-->
					   <div class="res_points" id="drd_8">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next8"></div>
								<div class="flip flip--top" id="top8"></div>
								<div class="flip flip--top flip--back" id="back8">0</div>
								<div class="flip flip--bottom" id="bottom8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next9"></div>
								<div class="flip flip--top" id="top9"></div>
								<div class="flip flip--top flip--back" id="back9">0</div>
								<div class="flip flip--bottom" id="bottom9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				    <div class="game9_result">
					  <p><?= GAME_9?></p>
					  <!--<div class="res_points" id="drd_9"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></div>-->
					   <div class="res_points" id="drd_9">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next8"></div>
								<div class="flip flip--top" id="top8"></div>
								<div class="flip flip--top flip--back" id="back8">0</div>
								<div class="flip flip--bottom" id="bottom8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next9"></div>
								<div class="flip flip--top" id="top9"></div>
								<div class="flip flip--top flip--back" id="back9">0</div>
								<div class="flip flip--bottom" id="bottom9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				    <div class="game10_result">
					  <p><?= GAME_10?></p>
					  <!--<div class="res_points" id="drd_10"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></div>-->
					   <div class="res_points" id="drd_10">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next8"></div>
								<div class="flip flip--top" id="top8"></div>
								<div class="flip flip--top flip--back" id="back8">0</div>
								<div class="flip flip--bottom" id="bottom8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip flip--next" id="next9"></div>
								<div class="flip flip--top" id="top9"></div>
								<div class="flip flip--top flip--back" id="back9">0</div>
								<div class="flip flip--bottom" id="bottom9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   
				   
				</div>
			 </div>
			 
			 <div class="results_cont" id="timer1" style="display:none">
				<div class="rescont_1">
				   <div class="game1_result">
					  <p><?= GAME_1 ?></p>
					  <!--<div class="res_points" id="rd_1"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_1"></div>
							   <div class="flip1 flip--top1 flip--back1">1</div>
							   <div class="flip1 flip--bottom1 ra_1"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_1"></div>
							   <div class="flip1 flip--top1 flip--back1">2</div>
							   <div class="flip1 flip--bottom1 rb_1"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game2_result">
					  <p><?= GAME_2 ?></p>
					  <!--<div class="res_points" id="rd_2"><?= (isset($preDrawWIn->double->{2})? $preDrawWIn->double->{2}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_2"></div>
							   <div class="flip1 flip--top1 flip--back1">5</div>
							   <div class="flip1 flip--bottom1 ra_2"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_2"></div>
							   <div class="flip1 flip--top1 flip--back1">7</div>
							   <div class="flip1 flip--bottom1 rb_2"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game3_result">
					  <p><?= GAME_3 ?></p>
					  <!--<div class="res_points" id="rd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_3"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_3"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_3"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_3"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game4_result">
					  <p><?= GAME_4 ?></p>
					  <!--<div class="res_points" id="rd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_4"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_4"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_4"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_4"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game5_result">
					  <p><?= GAME_5 ?></p>
					  <!--<div class="res_points" id="rd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_5"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_5"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_5"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_5"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game6_result">
					  <p><?= GAME_6 ?></p>
					  <!--<div class="res_points" id="rd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_6"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_6"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_6"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_6"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game7_result">
					  <p><?= GAME_7 ?></p>
					  <!--<div class="res_points" id="rd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_7"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_7"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_7"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_7"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game8_result">
					  <p><?= GAME_8 ?></p>
					  <!--<div class="res_points" id="rd_8"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_8"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_8"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_8"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_8"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game9_result">
					  <p><?= GAME_9 ?></p>
					  <!--<div class="res_points" id="rd_9"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_9"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_9"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_9"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_9"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   <div class="game10_result">
					  <p><?= GAME_10 ?></p>
					  <!--<div class="res_points" id="rd_10"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></div>-->
						 <div class="res_points">
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 ra_10"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 ra_10"></div>
							</div>
						 </div>
						 <div class="seg">
							<div class="flip-wrapper">
							   <div class="flip1 flip--next1"></div>
							   <div class="flip1 flip--top1 rb_10"></div>
							   <div class="flip1 flip--top1 flip--back1">0</div>
							   <div class="flip1 flip--bottom1 rb_10"></div>
							</div>
						 </div>
					  </div>
				   </div>
				   
				   
				   
				  </div>
			 </div>
		  </div>
          <!--<div id="small-dialog3" class="mfp-hide w3ls_small_dialog wthree_pop">
            <div class="popup_head">Previous Result</div>
            <div class="chart_1">
              <div class="chart_head_1">
                <div class="chart_head draw_1">DRAW TIME</div>
                <div class="chart_head game1"><?= GAME_1; ?></div>
                <div class="chart_head game2"><?= GAME_2; ?></div>
                <div class="chart_head game3"><?= GAME_3; ?></div>
                <div class="chart_head game4"><?= GAME_4; ?></div>
                <div class="chart_head game5"><?= GAME_5; ?></div>
              </div>
              <div class="chart_scroll">
                <div class="chart_cont_1">
                  <div class="chart_cont_2">09:00 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">09:15 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">09:30 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">09:45 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">10:00 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">10:15 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">10:30 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">10:45 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">11:00 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">11:15 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">11:30 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">11:45 AM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
                <div class="chart_cont_1">
                  <div class="chart_cont_2">12:00 PM</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">49</div>
                  <div class="chart_cont_2">20</div>
                  <div class="chart_cont_2">08</div>
                  <div class="chart_cont_2">34</div>
                </div>
              </div>
            </div>
          </div>-->
        </div>
      </div>
     </div>
    <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
    <!-- Modal -->
    <div class="modal fade submit_confirm" id="submit_mob" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header popup_head">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Summary</h4>
          </div>
          <div class="modal-body">
            <div class="mob_table">
              <div class="popup_tab_mob">
                <div class="table_sec_mob">
                  <div class="sum_head" style="width:19.5%;background-color: transparent;"></div>
                  <div class="sum_head table_space_mob">Single</div>
                  <div class="sum_head table_space_mob">Double</div>
                </div>
                <div class="table_sec_mob">
                  <div class="sub_tab_1 sum_head_1">Name</div>
                  <div class="sub_tab_1 sum_head_1 table_space_mob">Qty</div>
                  <div class="sub_tab_1 sum_head_1">Point</div>
                  <div class="sub_tab_1 sum_head_1 table_space_mob">Qty</div>
                  <div class="sub_tab_1 sum_head_1">Point</div>
                </div>
                <div class="table_sec_mob">
                  <div class="sub_tab_1 game1_sub"><?= GAME_1; ?></div>
                  <div class="sub_tab_1 game1_sub_1 table_space_mob sgame1_qty">0</div>
                  <div class="sub_tab_1 game1_sub_1 sgame1_amt">0</div>
                  <div class="sub_tab_1 game1_sub_1 table_space_mob  game1_qty">0</div>
                  <div class="sub_tab_1 game1_sub_1  game1_amt">0</div>
                </div>
                <div class="table_sec_mob">
                  <div class="sub_tab_1 game2_sub"><?= GAME_2; ?></div>
                  <div class="sub_tab_1 game2_sub_1 table_space_mob sgame2_qty">0</div>
                  <div class="sub_tab_1 game2_sub_1 sgame2_amt">0</div>
                  <div class="sub_tab_1 game2_sub_1 table_space_mob  game2_qty">0</div>
                  <div class="sub_tab_1 game2_sub_1  game2_amt">0</div>
                </div>
                <div class="table_sec_mob">
                  <div class="sub_tab_1 game3_sub"><?= GAME_3; ?></div>
                  <div class="sub_tab_1 game3_sub_1 table_space_mob sgame3_qty">0</div>
                  <div class="sub_tab_1 game3_sub_1 sgame3_amt">0</div>
                  <div class="sub_tab_1 game3_sub_1 table_space_mob  game3_qty">0</div>
                  <div class="sub_tab_1 game3_sub_1  game3_amt">0</div>
                </div>
                <div class="table_sec_mob">
                  <div class="sub_tab_1 game4_sub"><?= GAME_4; ?></div>
                  <div class="sub_tab_1 game4_sub_1 table_space_mob sgame4_qty">0</div>
                  <div class="sub_tab_1 game4_sub_1 sgame4_amt">0</div>
                  <div class="sub_tab_1 game4_sub_1 table_space_mob  game4_qty">0</div>
                  <div class="sub_tab_1 game4_sub_1  game4_amt">0</div>
                </div>
                <div class="table_sec_mob">
                  <div class="sub_tab_1 game5_sub"><?= GAME_5; ?></div>
                  <div class="sub_tab_1 game5_sub_1 table_space_mob sgame5_qty">0</div>
                  <div class="sub_tab_1 game5_sub_1 sgame5_amt">0</div>
                  <div class="sub_tab_1 game5_sub_1 table_space_mob  game5_qty">0</div>
                  <div class="sub_tab_1 game5_sub_1  game5_amt">0</div>
                </div>
				<div class="table_sec_mob">
                  <div class="sub_tab_1 game6_sub"><?= GAME_6; ?></div>
                  <div class="sub_tab_1 game6_sub_1 table_space_mob sgame6_qty">0</div>
                  <div class="sub_tab_1 game6_sub_1 sgame6_amt">0</div>
                  <div class="sub_tab_1 game6_sub_1 table_space_mob  game6_qty">0</div>
                  <div class="sub_tab_1 game6_sub_1  game6_amt">0</div>
                </div>
				<div class="table_sec_mob">
                  <div class="sub_tab_1 game7_sub"><?= GAME_7; ?></div>
                  <div class="sub_tab_1 game7_sub_1 table_space_mob sgame7_qty">0</div>
                  <div class="sub_tab_1 game7_sub_1 sgame7_amt">0</div>
                  <div class="sub_tab_1 game7_sub_1 table_space_mob  game7_qty">0</div>
                  <div class="sub_tab_1 game7_sub_1  game7_amt">0</div>
                </div>
				<div class="table_sec_mob">
                  <div class="sub_tab_1 game8_sub"><?= GAME_8; ?></div>
                  <div class="sub_tab_1 game8_sub_1 table_space_mob sgame8_qty">0</div>
                  <div class="sub_tab_1 game8_sub_1 sgame8_amt">0</div>
                  <div class="sub_tab_1 game8_sub_1 table_space_mob  game8_qty">0</div>
                  <div class="sub_tab_1 game8_sub_1  game8_amt">0</div>
                </div>
				<div class="table_sec_mob">
                  <div class="sub_tab_1 game9_sub"><?= GAME_9; ?></div>
                  <div class="sub_tab_1 game9_sub_1 table_space_mob sgame9_qty">0</div>
                  <div class="sub_tab_1 game9_sub_1 sgame9_amt">0</div>
                  <div class="sub_tab_1 game9_sub_1 table_space_mob  game9_qty">0</div>
                  <div class="sub_tab_1 game9_sub_1  game9_amt">0</div>
                </div>
				<div class="table_sec_mob">
                  <div class="sub_tab_1 game10_sub"><?= GAME_10; ?></div>
                  <div class="sub_tab_1 game10_sub_1 table_space_mob sgame10_qty">0</div>
                  <div class="sub_tab_1 game10_sub_1 sgame10_amt">0</div>
                  <div class="sub_tab_1 game10_sub_1 table_space_mob  game10_qty">0</div>
                  <div class="sub_tab_1 game10_sub_1  game10_amt">0</div>
                </div>
				
				
				
                <div class="table_sec_mob">
                  <div class="sub_tab_1 sub_tot">Total</div>
                  <div class="sub_tab_1 sub_tot table_space_mob single_qty">0</div>
                  <div class="sub_tab_1 sub_tot single_total">0</div>
                  <div class="sub_tab_1 sub_tot table_space_mob double_qty">0</div>
                  <div class="sub_tab_1 sub_tot double_total">0</div>
                </div>
              </div>
            </div>
            <div class="confirm_mob_1">
               <div class="confirm_tic">Ticket Value: <span><?php echo (!empty($upcomingDraw[0]->DRAW_PRICE)?$upcomingDraw[0]->DRAW_PRICE:0);?></span></div>
              <!-- <div class="confirm_tic_val"><?php echo (!empty($upcomingDraw[0]->DRAW_PRICE)?$upcomingDraw[0]->DRAW_PRICE:0);?></div> -->
              <div class="confirm_back" data-dismiss="modal">BACK</div>
              <div class="confirm_but" onclick="submitData()">CONFIRM</div>
            </div>
          </div>
        </div>
      </div>
    </div>
<input type="hidden" id="sTime" value="<? echo date("F d, Y h:i:s", time())?>">
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.countdown.js"></script>
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<script src="js/home.js?v=<?php echo $vTime; ?>" type="text/javascript"></script>
<script src="js/bootstrap.js"></script>	

<script>
 /*** date and time display start */
 var intval ='';
 var currenttime = '<? print $dbTime; ?>';//$("#sTime").val();
//var currenttime1 = '<?=  date("Y-m-d H:i:s")?>'
//var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime);

function padlength(what){
	var output=(what.toString().length==1)? "0"+what : what
	return output
}
	
function displaytime(){
	var hours = serverdate.getHours();
	var ampm = hours >= 12 ? 'PM' : 'AM';
	hours = hours % 12;
	hours = hours ? hours : 12; // the hour '0' should be '12'
	
	serverdate.setSeconds(serverdate.getSeconds()+1)
	var timestring=hours+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
	// document.getElementById("servertime").innerHTML=timestring;
	// document.getElementById("servertime1").innerHTML=timestring;
	$('.servertime').html(timestring+' '+ampm);
}

 window.onload=function(){
	intval = setInterval("displaytime()", 1000);
}   



 /*** date and time display end** countdown timer start  */ 


 $(document).ready(function(){
	$('.user_detail_mob').click(function(event){
		 $('.navmob').children().closest('.dropdown ').removeClass('open');
		 $('.dropdown-menu').hide();
		event.stopPropagation();
	});

	$(window).click(function() {
		$('.user_detail_mob1').hide();
	});
	$('.dropdown').click(function() {
		$('.user_detail_mob1').hide();
	});
	$(function () {
			$('.ndrawLeftTime').html('00:00:00');
				var timeLeft = '';
				<?php if(!empty( $drawCountDownTime) ){ ?>
					timeLeft = new Date(<?php echo $drawCountDownTime;?>); //2016,0,06,11,56,01
					//$('#ndrawLeftTime').countdown({until: timeLeft,serverSync: serverTime, format: 'HMS', padZeroes: true, compact: true,onExpiry: liftOff});
					$('.ndrawLeftTime').countdown({
						until: timeLeft,
						serverSync: serverTime, 
						format: 'HMS', 
						padZeroes: true, 
						compact: true,
						onExpiry: liftOff,
						onTick: function(periods) {
										var secs = $.countdown.periodsToSeconds(periods);
										if (secs < 60) { 
											$('.ndrawLeftTime span').addClass('text_blink');
										}
									 } 
						});
				<?php }?>
		});	

	
	
/*  if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
       || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4)))
{ 
	
		
	
}*/
	
}); 

$('body').click(function(){ 
	var width =  screen.width;
	 if(width<=991) {
		var i=0;
		if(i==0){
			$(document).fullScreen(true);
			i=1;
		}
	 }
});

$(function(){
 //animateInfo();
	
 });

function liftOff() {
	var curDrawIDNext = $('#drawID').val();
	$('.ndrawLeftTime span').removeClass('text_blink');
	$.ajax({
		type:"POST",
		url:"nextdrawtime_ajax.php?cDrawID="+curDrawIDNext,
		dataType: "json",
		success:function(response) {
			if(response.status =="available") {
				$('#drawID').val(response.DRAW_ID);
				$('#drawName').val(response.DRAW_NUMBER);
				$('#drawPrice').val(response.DRAW_PRICE);
				$('#drawDateTime').val(response.DRAW_STARTTIME);
				$('#drawNumber').html(response.GAME_NO);
				$('.userBalance').html(response.USER_BAL);
//				$('#preDrawNumb').html(response.PREV_DRAW_NO);
//				$('#preDrawTime').html(response.PREV_DRAW_TIME);
				//$('.future1').removeClass('text-success');
				if(response.NXT_SEL==''){
					$('.future').html('').hide();
				}else{
					$('.future').html(response.NXT_SEL);
				}
//				$('#sDrawName,#dDrawName,#tDrawName').html(drawTimeRes[5]);
//				$('#sDrawPrice,#dDrawPrice,#tDrawPrice').html(drawTimeRes[3]);
//				$('#nxtdrawDate').html(response.NXT_DRAW_DATE);
				$('.nxtdrawTime').html(response.NXT_DRAW_TIME);
				var drawCountDownTime=response.COUNT_DOWN.split(",");
				var shortly = new Date();
				shortly = new Date(drawCountDownTime[0],drawCountDownTime[1],drawCountDownTime[2],drawCountDownTime[3],drawCountDownTime[4],drawCountDownTime[5]);
				$('.ndrawLeftTime').countdown('option', {until: shortly,serverSync: serverTime, format: 'HMS', padZeroes: true, compact: true,onExpiry: liftOff});
			} else {
				if(response.NXT_SEL==''){
					$('.future').html('').hide();
				}else{
					$('.future').html(response.NXT_SEL);
				}
				$('.nxtdrawTime').html("--:--");
//				alert(response.status);
				$('#msg').html(response.status).fadeIn();
				setTimeout( function() {
					$("#msg").fadeOut();
				}, 4000 );
			}
		},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.readyState == 4) {
                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            	//$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
            }
            else if (XMLHttpRequest.readyState == 0) {
                // Network error (i.e. connection refused, access denied due to CORS, etc.)
            	 $("#loading").addClass('overlay');
            	$("#msg").show().html('Please connect network').removeClass('alert-success').addClass('alert-danger');
            	location.reload();
            }
        }
	});
	return false;
} 

function serverTime() {
	var time = null;
	$.ajax({url: 'serverTime.php',
		async: false, dataType: 'text',
		success: function(text) {
			//time = new Date(text);
			// create Date object for current location India
			offset = '+5.5';
			d = new Date(text);
			// convert to msec
			// add local time zone offset 
			// get UTC time in msec
			utc = d.getTime() + (d.getTimezoneOffset() * 60000);
			// create new Date object for different city
			// using supplied offset
			time = new Date(utc + (3600000*offset));
			console.log(time);
		}, error: function(http, message, exc) {
			time = new Date();
		}
	});
	return time;
}

/* page going to idle above 3 min then reload the page */
var idleTime = 0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 5) { // 5 minutes
        $('#idlestate').show();
    }
}

function nextdraw(id){
	if(id!=0){
		window.location.href = "home.php?fdrawID="+btoa(id);
	}else{
		window.location.href = "home.php";
	}
	return false;
}

 </script>
 <script src="js/socket.js?v=<?php echo $vTime; ?>"></script>
  </body>
<script>
  	 $('.home_load').hide();
</script>
</html>