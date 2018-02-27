<?php
   session_start();
   if ( isset( $_SESSION['lucky_userid'])){
   	header('Location: home.php');
   }
   
   include_once("include/DbConnect.php");
   include_once("include/clsLotto.php");
   
   $objLotto =  new clsLotto();
   $sesion = $objLotto->userAuthendication();
   
   $preDrawInfo = $objLotto->getPreviousDrawData('',$arrGameIDs[0]);
   $upcomingDraw= $objLotto->getUpcomingDrawData($drawID,$drawType,$arrGameIDs[0]);
   
   $drawPrice=	(!empty($upcomingDraw[0]->GAME_TYPE_DRAW_PRICE)?explode(",",$upcomingDraw[0]->GAME_TYPE_DRAW_PRICE):0);
   
   $preDrawTime = '';
   $preDrawNo = '';
   $preDrawWIn = '';
   $preDrawTimeFull ='';
   if (!empty($preDrawInfo )){
   	$preDrawTime = date('H:i',strtotime($preDrawInfo[0]->DRAW_STARTTIME));
   	$preDrawTimeFull = date('h:i A',strtotime($preDrawInfo[0]->DRAW_STARTTIME));
   	$preDrawNo = substr($preDrawInfo[0]->DRAW_NUMBER,strlen($preDrawInfo[0]->DRAW_NUMBER)-5,5);
   	$preDrawWIn = (!empty($preDrawInfo[0]->DRAW_WINNUMBER)?json_decode($preDrawInfo[0]->DRAW_WINNUMBER):'');
   }
   ?>
<html>
   <head>
      <title>Lucky10</title>
      <meta name="viewport"  content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
      <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
      <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
      <script src="js/bootstrap.js"></script>
      <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> -->
      <script src="js/jquery.validate.min.js"></script>
      <script src="js/dashboard.js"></script>
      <script src="js/login.js"></script>
      <link rel="stylesheet" href="css/style.css" type="text/css">
      <link href="css/popuo-box.css" rel="stylesheet" type="text/css"
         media="all" />
   </head>
   <style>
      .error{
      color:whitesmoke;
      }
   </style>
   <body>
		<!-- <div id="confirmation" >
			<div class="confirm_1">
				<div class="" style="color: #fff; margin: 0% 0 5% 0;">Network Disconnected Page Reload at <span id="timer"></span></div>
				<a href="index.php" id="" class="yes_btn">Reload</a>
				<input type="submit" value="NO" id="" class="yes_btn">
	 		</div>
		</div>-->		
      <div class="full_body" id="loading">
		<div id="loading-img"><img alt="Loding..." src="images/loader_img.gif"></div>
         <div class='notification alert alert-danger' style="display: none" id="log_msg"></div>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
               <div class="logo">
                  <img src="images/logo.png">
               </div>
            </div>
            <!-- before login-->
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 user_1" style="">
               <div class='notification alert alert-danger' style="display: none" id="msg"></div>
               <form action="#" method="post" id="login">
                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 username">
                     <div class="">
                        <input type="text" autocomplete="off" placeholder="UserName" id="username" name="username" required tabindex="1" maxlength="15"> 
                        <!--<p><input type="checkbox" class="remchk"> REMEMBER ME</p>-->
                     </div>
                  </div>
                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 password">
                     <input type="password" placeholder="Password" id="password" name="password" required tabindex="2" maxlength="15">
                     <p> <a href="#fp-dialog" class="play-icon popup-with-zoom-anim" style="color: #fff;">
                	 		FORGOT PASSWORD
                 		 </a>
                     </p>
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 login">
                     <input type="submit"id="submit_btn" value="login" tabindex="3"/>
                     <img style="display: none; text-align: center; height: 26px" id="log_loader" src="images/loader.gif" />
                     <p>
                        </br>
                     </p>
                  </div>
               </form>
            </div>
            <!--After login -->
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 user_2"
               style="display: none;">
               <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 username_login">
                  <div class="userdetails_1">
                     <div class="user_1_d">
                        <div class="userval">USERNAME</div>
                        <div class="userdata">Testuser123</div>
                     </div>
                     <div class="user_1_d">
                        <div class="userval">BALANCE</div>
                        <div class="userdata">10000000</div>
                     </div>
                  </div>
                  <div class="nextdraw_1">
                     <div class="userval">
                        NEXT DRAW:<span>00:00:00</span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 ttd_1">
                  <div class="timedraw_1">
                     <div class="ttd">TIME TO DRAW</div>
                     <div class="runtime_1">00:00:00</div>
                  </div>
               </div>
               <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 logout">
                  <div class="log_out">
                     <div class="logout_1">
                        <img src="images/logout.png">
                     </div>
                  </div>
                  <div class="date_time">
                     <div class="date_1">23/03/2017</div>
                     <div class="time_1">12:00:00</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 middle">
            <div class="tab mid_head1">
               <div class="tablinks1 single_tab active" onClick="openPlayer(event, 'single_1')" id="defaultOpen">ONE</div>
               <div class="tablinks1 double_tab" onClick="openPlayer(event, 'double_1')">TWO</div>
            </div>
            <input type="hidden" id="activeClass" value="sangam_cont">
            <form method="post" id="ticketForm" class="form">
            <input type="hidden" name="drawID" id="drawID" value="<?php echo $upcomingDraw[0]->DRAW_ID;?>" />
	            <input type="hidden" name="drawName" id="drawName" value="<?php echo $upcomingDraw[0]->DRAW_NUMBER;?>" />
	            <input type="hidden" name="drawPrice_1" id="drawPrice_1" value="<?php echo (!empty($drawPrice[0])?$drawPrice[0]:0);?>" />
	            <input type="hidden" name="drawPrice_2" id="drawPrice_2" value="<?php echo (!empty($drawPrice[1])?$drawPrice[1]:0);?>" />
	            <input type="hidden" name="drawPrice_3" id="drawPrice_3" value="<?php echo (!empty($drawPrice[2])?$drawPrice[2]:0);?>" />
	            <input type="hidden" name="drawPrice_4" id="drawPrice_4" value="<?php echo (!empty($drawPrice[3])?$drawPrice[3]:0);?>" />
	            <input type="hidden" name="drawPrice_5" id="drawPrice_5" value="<?php echo (!empty($drawPrice[4])?$drawPrice[4]:0);?>" />
	            <input type="hidden" name="drawPrice_6" id="drawPrice_6" value="<?php echo (!empty($drawPrice[5])?$drawPrice[5]:0);?>" />
	            <input type="hidden" name="drawPrice_7" id="drawPrice_7" value="<?php echo (!empty($drawPrice[6])?$drawPrice[6]:0);?>" />
	            <input type="hidden" name="8" id="drawPrice_8" value="<?php echo (!empty($drawPrice[7])?$drawPrice[7]:0);?>" />
	            <input type="hidden" name="drawPrice_9" id="drawPrice_9" value="<?php echo (!empty($drawPrice[8])?$drawPrice[8]:0);?>" />
	            <input type="hidden" name="drawPrice_10" id="drawPrice_10" value="<?php echo (!empty($drawPrice[9])?$drawPrice[9]:0);?>" />
	            <input type="hidden" name="drawDateTime" id="drawDateTime" value="<?php echo $upcomingDraw[0]->DRAW_STARTTIME;?>" />
              
               <div class="single_player tabcontent1" id="double_1" style="display: none;">
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"
						style="padding-left: 0;width:70%;">
						<div class="tabmid_cont" id="double_default">
							<div class="tab mid_head">
								<div class="tablinks mid_title san_1 active" onClick="openCity(event, 'sangam_cont')" id="defaultOpen"><?= GAME_1; ?><br>(<?php echo (!empty($drawPrice[0])?$drawPrice[0]:0);?>)</div>
								<div class="tablinks mid_title che_1" onClick="openCity(event, 'chetak_cont')"><?= GAME_2; ?><br>(<?php echo (!empty($drawPrice[1])?$drawPrice[1]:0);?>)</div>
								<div class="tablinks mid_title super_1" onClick="openCity(event, 'super_cont')"><?= GAME_3; ?><br>(<?php echo (!empty($drawPrice[2])?$drawPrice[2]:0);?>)</div>
								<div class="tablinks mid_title del_1" onClick="openCity(event, 'deluxe_cont')"><?= GAME_4; ?><br>(<?php echo (!empty($drawPrice[3])?$drawPrice[3]:0);?>)</div>
								<div class="tablinks mid_title bhag_1" onClick="openCity(event, 'bhagya_cont')"><?= GAME_5; ?><br>(<?php echo (!empty($drawPrice[4])?$drawPrice[4]:0);?>)</div>
								<div class="tablinks mid_title dia_1" onClick="openCity(event, 'diamond_cont')"><?= GAME_6; ?><br>(<?php echo (!empty($drawPrice[5])?$drawPrice[5]:0);?>)</div>
								<div class="tablinks mid_title luc_1"onclick="openCity(event, 'lucky_cont')"><?= GAME_7; ?><br>(<?php echo (!empty($drawPrice[6])?$drawPrice[6]:0);?>)</div>
								<div class="tablinks mid_title new_1" onClick="openCity(event, 'new1_cont')"><?= GAME_8; ?><br>(<?php echo (!empty($drawPrice[7])?$drawPrice[7]:0);?>)</div>
								<div class="tablinks mid_title new_2" onClick="openCity(event, 'new2_cont')"><?= GAME_9; ?><br>(<?php echo (!empty($drawPrice[8])?$drawPrice[8]:0);?>)</div>
								<div class="tablinks mid_title new_3"onclick="openCity(event, 'new3_cont')" style="border-right: none;"><?= GAME_10; ?><br>(<?php echo (!empty($drawPrice[9])?$drawPrice[9]:0);?>)</div>
							</div>
							<div id="sangam_cont" class="tabcontent middlecontent">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($i=0; $i<=99; $i++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($i>=10) {?>
													<p><?= $i; ?></p>
													<input type="text" maxlength="3" id="sangam_<?= $i; ?>" name="san[<?= $i; ?>]" class="sangam">
												<?php }else{ ?>
													<p>0<?= $i; ?></p>
													<input type="text" maxlength="3" id="sangam_<?= $i; ?>" name="san[0<?= $i; ?>]" class="sangam">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($i!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								
							</div>
							</div>
	
							<div id="chetak_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($j=0; $j<=99; $j++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($j>=10) {?>
												<p><?= $j; ?></p>
												<input type="text" maxlength="3" id="chetak_<?= $j; ?>" name="che[<?= $j; ?>]" class="chetak">
												<?php }else{ ?>
													<p>0<?= $j; ?></p>
													<input type="text" maxlength="3" id="chetak_<?= $j; ?>" name="che[0<?= $j; ?>]" class="chetak">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($j!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
										
								</div>
							</div>
	
							<div id="super_cont" class="tabcontent middlecontent"
								style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($k=0; $k<=99; $k++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($k>=10) {?>
												<p><?= $k; ?></p>
													<input type="text" maxlength="3" id="super_<?= $k; ?>" name="sup[<?= $k; ?>]" class="super">
												<?php }else{ ?>
													<p>0<?= $k; ?></p>
													<input type="text" maxlength="3" id="super_<?= $k; ?>" name="sup[0<?= $k; ?>]" class="super">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($k!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
	
							<div id="deluxe_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($l=0; $l<=99; $l++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($l>=10) {?>
												<p><?= $l; ?></p>
												<input type="text" maxlength="3" id="deluxe_<?= $l; ?>" name="del[<?= $l; ?>]" class="deluxe">
												<?php }else{ ?>
													<p>0<?= $l; ?></p>
													<input type="text" maxlength="3" id="deluxe_<?= $l; ?>" name="del[0<?= $l; ?>]" class="deluxe">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($l!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
	
							<div id="bhagya_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($m=0; $m<=99; $m++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($m>=10) {?>
												<p><?= $m; ?></p>
												<input type="text" maxlength="3" id="bhagya_<?= $m; ?>" name="bha[<?= $m; ?>]" class="bhagya">
												<?php }else{ ?>
													<p>0<?= $m; ?></p>
													<input type="text" maxlength="3" id="bhagya_<?= $m; ?>" name="bha[0<?= $m; ?>]" class="bhagya">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($i!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
	
							<div id="diamond_cont" class="tabcontent middlecontent"	style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($n=0; $n<=99; $n++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($n>=10) {?>
												<p><?= $n; ?></p>
												<input type="text" maxlength="3" id="diamond_<?= $n; ?>" name="dia[<?= $n; ?>]" class="diamond">
												<?php }else{ ?>
													<p>0<?= $n; ?></p>
													<input type="text" maxlength="3" id="diamond_<?= $n; ?>" name="dia[0<?= $n; ?>]" class="diamond">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($n!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
	
							<div id="lucky_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($p=0; $p<=99; $p++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($p>=10) {?>
												<p><?= $p; ?></p>
												<input type="text" maxlength="3" id="lucky_<?= $p; ?>" name="luk[<?= $p; ?>]" class="lucky">
												<?php }else{ ?>
													<p>0<?= $p; ?></p>
													<input type="text" maxlength="3" id="lucky_<?= $p; ?>" name="luk[0<?= $p; ?>]" class="lucky">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($p!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
							
							<div id="new1_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($q=0; $q<=99; $q++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($q>=10) {?>
												<p><?= $q; ?></p>
												<input type="text" maxlength="3" id="new1_<?= $q; ?>" name="new1[<?= $q; ?>]" class="new1">
												<?php }else{ ?>
													<p>0<?= $q; ?></p>
													<input type="text" maxlength="3" id="new1_<?= $q; ?>" name="new1[0<?= $q; ?>]" class="new1">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($q!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
							
							<div id="new2_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($r=0; $r<=99; $r++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($r>=10) {?>
												<p><?= $r; ?></p>
												<input type="text" maxlength="3" id="new2_<?= $r; ?>" name="new2[<?= $r; ?>]" class="new2">
												<?php }else{ ?>
													<p>0<?= $r; ?></p>
													<input type="text" maxlength="3" id="new2_<?= $r; ?>" name="new2[0<?= $r; ?>]" class="new2">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($r!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
							
							<div id="new3_cont" class="tabcontent middlecontent" style="display: none;">
								<div class="middlecont_1">
									<?php 
										$count =0;
										for($s=0; $s<=99; $s++) { $count=$count+1?>
											<div class="table_midcont">
											<?php if ($s>=10) {?>
												<p><?= $s; ?></p>
												<input type="text" maxlength="3" id="new3_<?= $s; ?>" name="new3[<?= $s; ?>]" class="new3">
												<?php }else{ ?>
													<p>0<?= $s; ?></p>
													<input type="text" maxlength="3" id="new3_<?= $s; ?>" name="new3[0<?= $s; ?>]" class="new3">
												<?php }?>
											</div>
									<?php
										if($count==10){
											$count=0;
											if($s!=99){
												echo '</div><div class="middlecont_1">';
											}
										}
									} ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding: 0;width:30%;">
						<div class="selected_1">
							
	
							<table class="select_val_1">
								<thead  class="select_right">
									<tr>
										<th class="ticket_1">TICKETS</th>
										<th class="qty_1">QTY</th>
										<th class="value_1">POINT</th>
										<th class="value_3" id="">RESULT</th>
									</tr>
								</thead>
								<tbody class="sel_val2" id="double_qty_amt">
									<tr class="san_sel">
										<td class="ticket_2"><?= GAME_1; ?></td>
										<td class="qty_2 double_qty_div" id="sangam_qty">0</td>
										<td class="value_2 double_amt_div" id="sangam_amt">0</td>
										<td class="value_3" id="rd_1"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}: '--');?></td>
									</tr>
									<tr class="che_sel">
										<td class="ticket_2"><?= GAME_2; ?></td>
										<td class="qty_2 double_qty_div" id="chetak_qty">0</td>
										<td class="value_2 double_amt_div" id="chetak_amt">0</td>
										<td class="value_3" id="rd_2"><?= (isset($preDrawWIn->double->{2})? $preDrawWIn->double->{2}: '--');?></td>
									</tr>
									<tr class="super_sel">
										<td class="ticket_2"><?= GAME_3; ?></td>
										<td class="qty_2 double_qty_div" id="super_qty">0</td>
										<td class="value_2 double_amt_div" id="super_amt">0</td>
										<td class="value_3" id="rd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></td>
									</tr>
									<tr class="deluxe_sel">
										<td class="ticket_2"><?= GAME_4; ?></td>
										<td class="qty_2 double_qty_div" id="deluxe_qty">0</td>
										<td class="value_2 double_amt_div" id="deluxe_amt">0</td>
										<td class="value_3" id="rd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></td>
									</tr>
									<tr class="bhag_sel">
										<td class="ticket_2"><?= GAME_5; ?></td>
										<td class="qty_2 double_qty_div" id="bhagya_qty">0</td>
										<td class="value_2 double_amt_div" id="bhagya_amt">0</td>
										<td class="value_3" id="rd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></td>
									</tr>
									<tr class="dia_sel">
										<td class="ticket_2"><?= GAME_6; ?></td>
										<td class="qty_2 double_qty_div" id="diamond_qty">0</td>
										<td class="value_2 double_amt_div" id="diamond_amt">0</td>
										<td class="value_3" id="rd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></td>
									</tr>
									<tr class="luc_sel">
										<td class="ticket_2"><?= GAME_7; ?></td>
										<td class="qty_2 double_qty_div" id="lucky_qty">0</td>
										<td class="value_2 double_amt_div" id="lucky_amt">0</td>
										<td class="value_3" id="rd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></td>
									</tr>
								
									<tr class="new1_sel">
										<td class="ticket_2"><?= GAME_8; ?></td>
										<td class="qty_2 double_qty_div" id="new1_qty">0</td>
										<td class="value_2 double_amt_div" id="new1_amt">0</td>
										<td class="value_3" id="rd_8"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></td>
									</tr>
									<tr class="new2_sel">
										<td class="ticket_2"><?= GAME_9; ?></td>
										<td class="qty_2 double_qty_div" id="new2_qty">0</td>
										<td class="value_2 double_amt_div" id="new2_amt">0</td>
										<td class="value_3" id="rd_9"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></td>
									</tr>
									<tr class="new3_sel">
										<td class="ticket_2"><?= GAME_10; ?></td>
										<td class="qty_2 double_qty_div" id="new3_qty">0</td>
										<td class="value_2 double_amt_div" id="new3_amt">0</td>
										<td class="value_3" id="rd_10"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></td>
									</tr> 
									<tr class="total_sel">
										<td class="ticket_2">Total</td>
										<td class="qty_2" id="double_qty">0</td>
										<td class="value_2" id="double_total">0</td>
										<td class="value_3" ></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="randompick">
							<div class="select_right">
								<p>RANDOM PICK</p>
							</div>
							<div class="random_cont">
								<div class="tic_amt">
									<label>Ticket Qty</label><input type="text" id="tkt_qty" name="tkt_qty" value="" maxlength="3" onchange="ticketQty()">
								</div>
								<div class="tic_amt random_num_1">
									<label>Random Number</label><input type="text" id="random_number" value="" maxlength="2" onkeyup ="randomPick(this.value)">
								</div>
								<div class="random_1">
									<div id="random_no_all" class="random_num random_no_1" onClick="randomPickNumber('all',this)">ALL</div>
									<div id="random_no_odd" class="random_num random_no_1" onClick="randomPickNumber('odd',this)">ODD</div>
									<div id="random_no_even" class="random_num random_no_1" onClick="randomPickNumber('even',this)">EVEN</div>
								</div>

								<!--<div class="random_1">
									<div class="random_num" onClick="randomPick('10')">10</div>
									<div class="random_num" onClick="randomPick('20')">20</div>
									<div class="random_num" onClick="randomPick('30')">30</div>
									<div class="random_num" onClick="randomPick('40')">40</div>
									<div class="random_num" onClick="randomPick('50')">50</div>
									<div class="random_num" onClick="randomPick('60')">60</div>
									<div class="random_num" onClick="randomPick('70')">70</div>
	
								</div>-->
								
								<div class="random_1">
									<label>Series</label>
								</div>
								<div class="random_1">
									<div id="random_endno_0" class="random_num random_no_2" onClick="randomPickEndedNumber('0',this)">0</div>
									<div id="random_endno_1" class="random_num random_no_2" onClick="randomPickEndedNumber('1',this)">1</div>
									<div id="random_endno_2" class="random_num random_no_2" onClick="randomPickEndedNumber('2',this)">2</div>
									<div id="random_endno_3" class="random_num random_no_2" onClick="randomPickEndedNumber('3',this)">3</div>
									<div id="random_endno_4" class="random_num random_no_2" onClick="randomPickEndedNumber('4',this)">4</div>
									<div id="random_endno_5" class="random_num random_no_2" onClick="randomPickEndedNumber('5',this)">5</div>
									<div id="random_endno_6" class="random_num random_no_2" onClick="randomPickEndedNumber('6',this)">6</div>
									<div id="random_endno_7" class="random_num random_no_2" onClick="randomPickEndedNumber('7',this)">7</div>
									<div id="random_endno_8" class="random_num random_no_2" onClick="randomPickEndedNumber('8',this)">8</div>
									<div id="random_endno_9" class="random_num random_no_2" onClick="randomPickEndedNumber('9',this)">9</div>
	
								</div>
								<!-- <div class="random_1">
									<div id="random_no_5" class="random_num random_no_3" onClick="randomPick('5',this)" >5</div>
									<div id="random_no_10" class="random_num random_no_3" onClick="randomPick('10',this)">10</div>
									<div id="random_no_15" class="random_num random_no_3" onClick="randomPick('15',this)">15</div>
									<div id="random_no_20" class="random_num random_no_3" onClick="randomPick('20',this)">20</div>
									<div id="random_no_25" class="random_num random_no_3" onClick="randomPick('25',this)">25</div>
									<div id="random_no_50" class="random_num random_no_3" onClick="randomPick('50',this)">50</div>
									<div id="random_no_75" class="random_num random_no_3" onClick="randomPick('75',this)">75</div>
									<div id="random_no_17" class="random_num random_no_3 random_no_input"><input type="text" value="" maxlength="3" ></div>
	
								</div> -->

							</div>
						</div>
					</div>
				</div>
               <div class="double_player tabcontent1" id="single_1">
				<?php /*
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 andar">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 cont_left">
						<div class="cont_left1">
							<div class="contleft_head">ANDAR</div>
							<div class="san_left"><?= GAME_1; ?></div>
							<div class="che_left"><?= GAME_2; ?></div>
							<div class="super_left"><?= GAME_3; ?></div>
							<div class="deluxe_left"><?= GAME_4; ?></div>
							<div class="bhagya_left"><?= GAME_5; ?></div>
							<div class="dia_left"><?= GAME_6; ?></div>
							<div class="lucky_left"><?= GAME_7; ?></div>
						</div>
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"
						style="padding-right: 0;">
						<div class="cont_right" id="single_andar">
							<div class="cont_right1">
								<div class="contright_head">0</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">1</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che1" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup1" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del1" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha1" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia1" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk1" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">2</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san2" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che2" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup2" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del2" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha2" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia2" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk2" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">3</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san3" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che3" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup3" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del3" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha3" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia3" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk3" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">4</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san4" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che4" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup4" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del4" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha4" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia4" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk4" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">5</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san5" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che5" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup5" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del5" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha5" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia5" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk5" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">6</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san6" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che6" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup6" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del6" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha6" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia6" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk6" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">7</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san7" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che7" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup7" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_de7l" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha7" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right andar_dia">
									<input type="text" maxlength="3" id="andar_dia7" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right andar_luk">
									<input type="text" maxlength="3" id="andar_luk7" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">8</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san8" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che8" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup8" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del8" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha8" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right andar_dia">
									<input type="text" maxlength="3" id="andar_dia8" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right andar_luk">
									<input type="text" maxlength="3" id="andar_luk8" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">9</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="andar_san9" name="andar_san[]" class="andar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="andar_che9" name="andar_che[]" class="andar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="andar_sup9" name="andar_sup[]" class="andar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="andar_del9" name="andar_del[]" class="andar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="andar_bha9" name="andar_bha[]" class="andar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="andar_dia9" name="andar_dia[]" class="andar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="andar_luk9" name="andar_luk[]" class="andar_luk">
								</div>
							</div>
							<div class="cont_right1 right_qty" id="andhar_qty_div">
								<div class="contright_head">Qty</div>
								<div class="san_right single_qty_div" id="andar_san_qty">0</div>
								<div class="che_right single_qty_div" id="andar_che_qty">0</div>
								<div class="super_right single_qty_div" id="andar_sup_qty">0</div>
								<div class="deluxe_right single_qty_div" id="andar_del_qty">0</div>
								<div class="bhagya_right single_qty_div" id="andar_bha_qty">0</div>
								<div class="dia_right single_qty_div" id="andar_dia_qty">0</div>
								<div class="lucky_right single_qty_div" id="andar_luk_qty">0</div>
							</div>
							<div class="cont_right1 right_amt">
								<div class="contright_head">Point</div>
								<div class="san_right single_amt_div" id="andar_san_amt">0</div>
								<div class="che_right single_amt_div" id="andar_che_amt">0</div>
								<div class="super_right single_amt_div" id="andar_sup_amt">0</div>
								<div class="deluxe_right single_amt_div" id="andar_del_amt">0</div>
								<div class="bhagya_right single_amt_div" id="andar_bha_amt" >0</div>
								<div class="dia_right single_amt_div" id="andar_dia_amt">0</div>
								<div class="lucky_right single_amt_div" id="andar_luk_amt">0</div>
							</div>
							
							<div class="cont_right1 lastres_1">
								<div class="contright_head preDrawTime" id="preDrawTime" title="previous result time"><?= $preDrawTimeFull ?></div>
								<div id="ra_1" class="san_right"><?= (isset($preDrawWIn->andar->{1})? $preDrawWIn->andar->{1}:  '--');?></div>
								<div id="ra_2" class="che_right"><?= (isset($preDrawWIn->andar->{2})?$preDrawWIn->andar->{2}: '--');?></div>
								<div id="ra_3" class="super_right"><?= (isset($preDrawWIn->andar->{3})? $preDrawWIn->andar->{3}: '--');?></div>
								<div id="ra_4" class="deluxe_right"><?= (isset($preDrawWIn->andar->{4})? $preDrawWIn->andar->{4}: '--');?></div>
								<div id="ra_5" class="bhagya_right"><?= (isset($preDrawWIn->andar->{5})? $preDrawWIn->andar->{5}: '--');?></div>
								<div id="ra_6" class="dia_right"><?= (isset($preDrawWIn->andar->{6})? $preDrawWIn->andar->{6}: '--');?></div>
								<div id="ra_7" class="lucky_right"><?= (isset($preDrawWIn->andar->{7})? $preDrawWIn->andar->{7}: '--');?></div>
							</div>
							
						</div>
					</div>
				</div>
				*/
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bahar">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 cont_left">
						<div class="cont_left1">
							<div class="contleft_head">TICKETS</div>
							<div class="san_left1" title="<?= GAME_DESCRIPTION_1; ?>"><?= GAME_1; ?></div>
							<div class="che_left1" title="<?= GAME_DESCRIPTION_2; ?>"><?= GAME_2; ?></div>
							<div class="super_left1" title="<?= GAME_DESCRIPTION_3; ?>"><?= GAME_3; ?></div>
							<div class="deluxe_left1" title="<?= GAME_DESCRIPTION_4; ?>"><?= GAME_4; ?></div>
							<div class="bhagya_left1" title="<?= GAME_DESCRIPTION_5; ?>"><?= GAME_5; ?></div>
							<div class="dia_left1" title="<?= GAME_DESCRIPTION_6; ?>"><?= GAME_6; ?></div>
							<div class="lucky_left1" title="<?= GAME_DESCRIPTION_7; ?>"><?= GAME_7; ?></div>
							<div class="new1_left1" title="<?= GAME_DESCRIPTION_8; ?>"><?= GAME_8; ?></div>
							<div class="new2_left1" title="<?= GAME_DESCRIPTION_9; ?>"><?= GAME_9; ?></div>
							<div class="new3_left1" title="<?= GAME_DESCRIPTION_10; ?>"><?= GAME_10; ?></div>
							
						</div>
						<div class="cont_left2">
							<div class="contleft_head">Point</div>
							<div class="san_left1"><?php echo (!empty($drawPrice[0])?$drawPrice[0]:0);?></div>
							<div class="che_left1"><?php echo (!empty($drawPrice[1])?$drawPrice[1]:0);?></div>
							<div class="super_left1"><?php echo (!empty($drawPrice[2])?$drawPrice[2]:0);?></div>
							<div class="deluxe_left1"><?php echo (!empty($drawPrice[3])?$drawPrice[3]:0);?></div>
							<div class="bhagya_left1"><?php echo (!empty($drawPrice[4])?$drawPrice[4]:0);?></div>
							<div class="dia_left1"><?php echo (!empty($drawPrice[5])?$drawPrice[5]:0);?></div>
							<div class="lucky_left1"><?php echo (!empty($drawPrice[6])?$drawPrice[6]:0);?></div>
							<div class="new1_left1"><?php echo (!empty($drawPrice[7])?$drawPrice[7]:0);?></div>
							<div class="new2_left1"><?php echo (!empty($drawPrice[8])?$drawPrice[8]:0);?></div>
							<div class="new3_left1"><?php echo (!empty($drawPrice[9])?$drawPrice[9]:0);?></div>
						</div>
						<div class="total_res">Total</div>
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="padding-right: 0;" >
						<div class="cont_rightheight" id="single_bhahar">
							<div class="cont_right1">
								<div class="contright_head">0</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">1</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san1" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che1" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup1" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del1" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha1" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia1" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk1" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_1" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_1" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_1" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">2</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san2" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che2" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup2" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del2" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha2" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia2" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk2" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_2" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_2" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_2" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">3</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san3" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che3" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup3" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del3" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha3" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia3" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk3" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_3" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_3" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_3" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">4</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san4" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che4" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup4" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del4" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha4" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia4" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk4" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_4" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_4" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_4" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">5</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san5" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che5" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup5" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del5" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha5" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia5" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk5" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_5" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_5" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_5" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">6</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san6" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che6" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup6" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del6" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha6" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia6" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk6" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_6" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_6" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_6" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">7</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san7" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che7" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup7" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_de7l" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha7" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right bahar_dia">
									<input type="text" maxlength="3" id="bahar_dia7" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right bahar_luk">
									<input type="text" maxlength="3" id="bahar_luk7" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_7" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_7" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_7" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">8</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san8" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che8" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup8" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del8" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha8" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right bahar_dia">
									<input type="text" maxlength="3" id="bahar_dia8" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right bahar_luk">
									<input type="text" maxlength="3" id="bahar_luk8" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_8" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_8" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_8" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1">
								<div class="contright_head">9</div>
								<div class="san_right">
									<input type="text" maxlength="3" id="bahar_san9" name="bahar_san[]" class="bahar_san">
								</div>
								<div class="che_right">
									<input type="text" maxlength="3" id="bahar_che9" name="bahar_che[]" class="bahar_che">
								</div>
								<div class="super_right">
									<input type="text" maxlength="3" id="bahar_sup9" name="bahar_sup[]" class="bahar_sup">
								</div>
								<div class="deluxe_right">
									<input type="text" maxlength="3" id="bahar_del9" name="bahar_del[]" class="bahar_del">
								</div>
								<div class="bhagya_right">
									<input type="text" maxlength="3" id="bahar_bha9" name="bahar_bha[]" class="bahar_bha">
								</div>
								<div class="dia_right">
									<input type="text" maxlength="3" id="bahar_dia9" name="bahar_dia[]" class="bahar_dia">
								</div>
								<div class="lucky_right">
									<input type="text" maxlength="3" id="bahar_luk9" name="bahar_luk[]" class="bahar_luk">
								</div>
								<div class="new1_right">
									<input type="text" maxlength="3" id="bahar_new1_9" name="bahar_new1[]" class="bahar_new1">
								</div>
								<div class="new2_right">
									<input type="text" maxlength="3" id="bahar_new2_9" name="bahar_new2[]" class="bahar_new2">
								</div>
								<div class="new3_right">
									<input type="text" maxlength="3" id="bahar_new3_9" name="bahar_new3[]" class="bahar_new3">
								</div>
							</div>
							<div class="cont_right1 right_qty" id="bahar_qty_div">
								<div class="contright_head">Qty</div>
								<div class="san_right single_qty_div" id="bahar_san_qty">0</div>
								<div class="che_right single_qty_div" id="bahar_che_qty">0</div>
								<div class="super_right single_qty_div" id="bahar_sup_qty">0</div>
								<div class="deluxe_right single_qty_div" id="bahar_del_qty">0</div>
								<div class="bhagya_right single_qty_div" id="bahar_bha_qty">0</div>
								<div class="dia_right single_qty_div" id="bahar_dia_qty">0</div>
								<div class="lucky_right single_qty_div" id="bahar_luk_qty">0</div>	
								<div class="new1_right single_qty_div" id="bahar_new1_qty">0</div>
								<div class="new2_right single_qty_div" id="bahar_new2_qty">0</div>
								<div class="new3_right single_qty_div" id="bahar_new3_qty">0</div>
							</div>
							<div class="cont_right1 right_amt" id="bahar_amt_div">
								<div class="contright_head">Point</div>
								<div class="san_right single_amt_div" id="bahar_san_amt">0</div>
								<div class="che_right single_amt_div" id="bahar_che_amt">0</div>
								<div class="super_right single_amt_div" id="bahar_sup_amt">0</div>
								<div class="deluxe_right single_amt_div" id="bahar_del_amt">0</div>
								<div class="bhagya_right single_amt_div" id="bahar_bha_amt" >0</div>
								<div class="dia_right single_amt_div" id="bahar_dia_amt">0</div>
								<div class="lucky_right single_amt_div" id="bahar_luk_amt">0</div>
								<div class="new1_right single_amt_div" id="bahar_new1_amt" >0</div>
								<div class="new2_right single_amt_div" id="bahar_new2_amt">0</div>
								<div class="new3_right single_amt_div" id="bahar_new3_amt">0</div> 
								
							</div>
							<div class="cont_right1 lastres_1">
								<div class="contright_head" id="" >Result</div>
								<div id="rb_1" class="san_right san_res_col"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}:  '--');?></div>
								<div id="rb_2" class="che_right che_res_col"><?= (isset($preDrawWIn->double->{2})?$preDrawWIn->double->{2}: '--');?></div>
								<div id="rb_3" class="super_right super_res_col"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></div>
								<div id="rb_4" class="deluxe_right deluxe_res_col"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></div>
								<div id="rb_5" class="bhagya_right bhagya_res_col"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></div>
								<div id="rb_6" class="dia_right dia_res_col"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></div>
								<div id="rb_7" class="lucky_right lucky_res_col"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></div>
								<div id="rb_8" class="new1_right new1_res_col"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></div>
								<div id="rb_9" class="new2_right new2_res_col"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></div>
								<div id="rb_10" class="new3_right new3_res_col"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></div>
							</div>
							
						</div>
							<div class="total_resinput">
							<div class="cont_right1total">
							&nbsp;
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
							</div>
						</div>
					</div>
				</div>
            </form>
         </div>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer">
               <div class="footer_1" style="display: block;">
                  <a href="#small-dialog" class="play-icon popup-with-zoom-anim" onClick="resetValidation()"><input type="button" value="FREE ACCOUNT" class="freeacc" id="freeacc"></a>
                  <input type="button" value="CLEAR" class="clear_1" onClick="clearInput()">  
                  <a href="#small-dialog1" class="play-icon popup-with-zoom-anim"><input type="button" value="HOW TO PLAY" class="htp" id="htp"></a> 
<!--                   <input type="button" value="ABOUT US" class="abtus" id="abtus"> -->
                  <a href="previousResult.php" class="play-icon" id="resultchat" ><input type="button" value="RESULT CHART" class="rescht" id="result_chat"> </a>
               </div>
               <div class="footer_1" style="display: none;">
                  <input type="text" value="READY TO PLAY" class="readytoplay"> 
                  <input type="button" value="REPORT" class="report_1">
                  <a href="#small-dialog3" class="">
                  <input type="button" value="RESULT CHART" class="rescht_1"></a>
                  <div id="small-dialog"
                     class="mfp-hide w3ls_small_dialog wthree_pop">
                     <div class="popup_head">CREATE A FREE ACCOUNT</div>
                     <div class='notification alert alert-danger' style="display: none" id="msg"></div>
                     <div class="create_form">
                        <form action="#" method="post" id="userRegistration">
                           <div style="position: relative;">
                              <input type="text" name="reg_username" id="reg_username" placeholder="Username(4-15 characters)" maxlength="15" required onKeyPress="return spaceKey(event)" tabindex="4" onChange="javascript:checkUsernameExists(this.value);">
                              <img style="display: none; position: absolute;right: 7%;top: 8px;"id="user_loader" src="images/spinner.gif" />
                              <div>
                                 <label id="reg_username-error" class="error" for="reg_username"></label>
                              </div>
                           </div>
                           <div> 
                              <input type="password" name="reg_password" id="reg_password"  placeholder="Password(4-15 characters)" required maxlength="15" autocomplete="off" onKeyPress="return spaceKey(event)" tabindex="5">
                              <label id="reg_password-error" class="error" for="reg_password"></label>
                           </div>
                           <div style="position: relative;">
                              <input type="email"	name="reg_email" id="reg_email" placeholder="Email" required onKeyPress="return spaceKey(event)" tabindex="6" onChange="javascript:checkEmailExists(this.value);">
                              <img style="display: none; position: absolute;right: 7%;top: 8px;"id="email_loader" src="images/spinner.gif" />
                              <div>
                                 <label id="reg_email-error" class="error" for="reg_email"></label>
                              </div>
                           </div>
                           <div>
                              <div id="contact" style="display:block;position: relative;">
                                 <input type="digit" class="mob" name="reg_mobile" id="reg_mobile" tabindex="7" placeholder="Mobile" required maxlength="10" autocomplete="off" onChange="javascript:checkMobileExists(this.value);" onKeyUp="javascript:regmobile(this.value);">
                                 <img style="display: none; position: absolute;right: 7%;top: 8px;"id="mobile_loader" src="images/spinner.gif" />
                                <!--   style="width: 45%;" <input name="getotp" id="getotp" value="GET OTP" onclick="getotpno()" disabled="disabled" style="width: 20%;margin-left: 66%;margin-top: -72px;" type="button" aria-invalid="false">-->
                                 <div>
                                    <label id="reg_mobile-error" class="error" for="reg_mobile"></label>
                                 </div>
                              </div>
                            <!--  <div id="otp" style="display:none;position: relative;">
                                 <input placeholder="Enter OTP" tabindex="7"  style="width: 40%;" name="regotp" id="regotp" maxlength="6" autocomplete="off" type="text">
                                 <img style="display: none; position: absolute;right: 7%;top: 8px;"id="regotp_loader" src="images/spinner.gif" />
                                 <input name="resendotp" id="resendotp" value="RESEND OTP" onclick="getotpno()" type="button" style="width: 26%;margin-left: 60%;margin-top: -72px;">
                                 <div>
                                    <label id="regotp-error" class="error" for="regotp" style="display: none"></label>
                                 </div>
                              </div>-->
                           </div>
                           <div>
                              <input type="submit" value="CREATE ACCOUNT" id="reg_btn" class="createacc">
                              <img style="display: none; text-align: center; height: 26px"id="loader" src="images/loader.gif" />
                           </div>
                        </form>
                     </div>
                  </div>
                  
             
                  
                  
                  
                  
                  <div id="fp-dialog"
                     class="mfp-hide w3ls_small_dialog wthree_pop">
                     <div class="popup_head">FORGET PASSWORD</div>
                     <div class='notification alert alert-danger' style="display: none" id="msg"></div>
                     <div class="create_form">
                        <form action="#" method="post" id="fgt_pwd">
                           <div style="position: relative;">
                              <input type="email"	name="fgt_email" id="fgt_email" placeholder="Email" required onKeyPress="return spaceKey(event)" tabindex="6">
                              <img style="display: none; position: absolute;right: 7%;top: 8px;"id="email_loader" src="images/spinner.gif" />
                              <div>
                                 <label id="fgt_email-error" class="error" for="fgt_email"></label>
                              </div>
                           </div>
                           
                           <div>
                              <input type="submit" value="SUBMIT" id="fgt_btn" class="createacc">
                              <img style="display: none; text-align: center; height: 26px"id="loader" src="images/loader.gif" />
                           </div>
                        </form>
                     </div>
                  </div>
                  
                  
                  <div id="small-dialog1"
                     class="mfp-hide w3ls_small_dialog wthree_pop">
                     <div class="popup_head">HOW TO PLAY</div>
                     <div class="htp_cont">
                        <p>	1. Create your  account from ‘Free Account” page</p>
                        <p>	2. Login with your username and password</p>
                        <p>	3. Two types of game tab on the main page  “SINGLE” and “DOUBLE”   </p>
						<p class="htp_head">	4. To play SINGLE:-</p>
                        <p class="htp_cont_sub">	4.1 The page has TEN different names of tickets with a different price.</p>
						<p class="htp_cont_sub">	4.2 0-9 numbers in a row on each ticket, place a quantity of ticket (max 999 quantity  for each number on each ticket).</p>
						<p class="htp_cont_sub">	4.3 The amount for the ticket display in “Amount” column based on the Qty of numbers what you have entered in the 0-9 numbers.</p>
						<p class="htp_cont_sub">	4.4 After entering the quantity Click “BUY” button to buy tickets.</p>
						<p class="htp_cont_sub">	4.5 Buy tickets on any number of times after every buys the page automatically set clear. Success message shows for the confirmation.</p>
						<p class="htp_cont_sub">	4.6 User ‘Clear” button to remove the selected quantity of tickets.</p>
                        <p class="htp_head">	5.  To play DOUBLE:-</p>
						<p class="htp_cont_sub"> 5.1  The page has TEN different names of tickets with a different price.</p>
						<p class="htp_cont_sub"> 5.2  “00-99” numbers distributed in 10 rows.</p>
						<p class="htp_cont_sub"> 5.3  Each row has 10 numbers for ex (Row 1 : 00-09, Row 2: 10-19, Row 3: 20-29, Row 10: 90-99).</p>
						<p class="htp_cont_sub"> 5.4  Place a quantity of ticket on your favorite double number.</p>
						<p class="htp_cont_sub"> 5.5  The amount for the ticket display in “Amount” column based on the Qty of numbers what you have entered in the 00-99 numbers.</p>
						<p class="htp_cont_sub"> 5.6  After entering the quantity click “BUY” button to buy tickets.</p>
                       
						<p> 6. Draw conduct on every 15 min. Current and Feature Draw time display in the drop down 	on“Next Draw” area, select any draw time and buy tickets in any quantity. Default next draw has denoted as “Now”.</p>
						<p> 
						<p> 7. “Time To Draw” section shows remaining time for the draw to start.

						<p> 8. When the time reaches zero, the game starts with Result page , the two digit number rolling on each ticket and stops randomly on any numbers between 00-99. Win /Loss on tickets update in report page on the particular draw.</p>


						<p> 9. Use ‘Report” page to view your tickets details, profile ,draw history and ledger report.</p> 

						<p> 10. View all the previous tickets results from “Previous Result” page.</p>

						<p> 11. Single, matching with the second number of results. It gives 1:9 win.</p>

						<p> 12. Double, matching with the two number of results. It gives 1:90 win.</p>
                     </div>
                  </div>
                  <div id="result_timer">
					<div id="small-dialog2" class="mfp-hide w3ls_small_dialog wthree_pop">
                     <div class="popup_head">RESULTS <span  class="preDrawTime"  title="previous result time"><?= $preDrawTimeFull ?></span><span class="timer_1" id="countTimer" style="display:none;">10 <small>sec</small></span></div>
                     <div class="results_cont" id="timer">
                       <div class="rescont_1">
                           <div class="san_result">
                              <p><?= GAME_1?></p>
                              <!--<div class="res_points" id="drd_1"><?= (isset($preDrawWIn->double->{1})? $preDrawWIn->double->{1}: '--');?></div>-->
							   <div class="res_points" id="drd_1">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next"></div>
									    <div class="flip flip--top" id="top"></div>
									    <div class="flip flip--top flip--back" id="back">00</div>
									    <div class="flip flip--bottom" id="bottom"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
									    <div class="flip flip--next" id="next1"></div>
									    <div class="flip flip--top" id="top1"></div>
									    <div class="flip flip--top flip--back" id="back1">00</div>
									    <div class="flip flip--bottom" id="bottom1"></div>
									  </div>
                                 </div>
                              </div>
                           </div>
                           <div class="che_result">
                              <p><?= GAME_2?></p>
                             <!-- <div class="res_points" id="drd_2"><?= (isset($preDrawWIn->double->{2})? $preDrawWIn->double->{2}: '--');?></div>-->
							  <div class="res_points" id="drd_2">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                        <div class="flip flip--next" id="next2"></div>
									    <div class="flip flip--top" id="top2"></div>
									    <div class="flip flip--top flip--back" id="back2">00</div>
									    <div class="flip flip--bottom" id="bottom2"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next3"></div>
									    <div class="flip flip--top" id="top3"></div>
									    <div class="flip flip--top flip--back" id="back3">00</div>
									    <div class="flip flip--bottom" id="bottom3"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="super_result">
                              <p><?= GAME_3?></p>
                              <!--<div class="res_points" id="drd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></div>-->
							   <div class="res_points" id="drd_3">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next4"></div>
									    <div class="flip flip--top" id="top4"></div>
									    <div class="flip flip--top flip--back" id="back4">00</div>
									    <div class="flip flip--bottom" id="bottom4"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next5"></div>
									    <div class="flip flip--top" id="top5"></div>
									    <div class="flip flip--top flip--back" id="back5">00</div>
									    <div class="flip flip--bottom" id="bottom5"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="deluxe_result">
                              <p><?= GAME_4?></p>
                              <!--<div class="res_points" id="drd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></div>-->
							   <div class="res_points" id="drd_4">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next6"></div>
									    <div class="flip flip--top" id="top6"></div>
									    <div class="flip flip--top flip--back" id="back6">00</div>
									    <div class="flip flip--bottom" id="bottom6"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next7"></div>
									    <div class="flip flip--top" id="top7"></div>
									    <div class="flip flip--top flip--back" id="back7">00</div>
									    <div class="flip flip--bottom" id="bottom7"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						   <div class="bhagya_result">
                              <p><?= GAME_5?></p>
                              <!--<div class="res_points" id="drd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></div>-->
							   <div class="res_points" id="drd_5">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next8"></div>
									    <div class="flip flip--top" id="top8"></div>
									    <div class="flip flip--top flip--back" id="back8">00</div>
									    <div class="flip flip--bottom" id="bottom8"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next9"></div>
									    <div class="flip flip--top" id="top9"></div>
									    <div class="flip flip--top flip--back" id="back9">00</div>
									    <div class="flip flip--bottom" id="bottom9"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="rescont_2">
                           
                           <div class="dia_result">
                              <p><?= GAME_6?></p>
                              <!--<div class="res_points" id="drd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></div>-->
							   <div class="res_points" id="drd_6">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next10"></div>
									    <div class="flip flip--top" id="top10"></div>
									    <div class="flip flip--top flip--back" id="back10">00</div>
									    <div class="flip flip--bottom" id="bottom10"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next11"></div>
									    <div class="flip flip--top" id="top11"></div>
									    <div class="flip flip--top flip--back" id="back11">00</div>
									    <div class="flip flip--bottom" id="bottom11"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="lucky_result">
                              <p><?= GAME_7?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></div>-->
							  <div class="res_points" id="drd_7">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next12"></div>
									    <div class="flip flip--top" id="top12"></div>
									    <div class="flip flip--top flip--back" id="back12">00</div>
									    <div class="flip flip--bottom" id="bottom12"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next13"></div>
									    <div class="flip flip--top" id="top13"></div>
									    <div class="flip flip--top flip--back" id="back13">00</div>
									    <div class="flip flip--bottom" id="bottom13"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						   <div class="new1_result">
                              <p><?= GAME_8?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></div>-->
							  <div class="res_points" id="drd_8">
                                  <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next14"></div>
									    <div class="flip flip--top" id="top14"></div>
									    <div class="flip flip--top flip--back" id="back14">00</div>
									    <div class="flip flip--bottom" id="bottom14"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next15"></div>
									    <div class="flip flip--top" id="top15"></div>
									    <div class="flip flip--top flip--back" id="back15">00</div>
									    <div class="flip flip--bottom" id="bottom15"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						   <div class="new2_result">
                              <p><?= GAME_9?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></div>-->
							  <div class="res_points" id="drd_9">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next16"></div>
									    <div class="flip flip--top" id="top16"></div>
									    <div class="flip flip--top flip--back" id="back16">00</div>
									    <div class="flip flip--bottom" id="bottom16"></div>
                                    </div>
                                 </div>
								 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next17"></div>
									    <div class="flip flip--top" id="top17"></div>
									    <div class="flip flip--top flip--back" id="back17">00</div>
									    <div class="flip flip--bottom" id="bottom17"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						   <div class="new3_result">
                              <p><?= GAME_10?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></div>-->
							  <div class="res_points" id="drd_10">
                                 
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next18"></div>
									    <div class="flip flip--top" id="top18"></div>
									    <div class="flip flip--top flip--back" id="back18">00</div>
									    <div class="flip flip--bottom" id="bottom18"></div>
                                    </div>
                                 </div>
								 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip flip--next" id="next19"></div>
									    <div class="flip flip--top" id="top19"></div>
									    <div class="flip flip--top flip--back" id="back19">00</div>
									    <div class="flip flip--bottom" id="bottom19"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="results_cont" id="timer1" style="display:none">
                        <div class="rescont_1">
                           <div class="san_result">
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
                           <div class="che_result">
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
                           <div class="super_result">
                              <p><?= GAME_3 ?></p>
                              <!--<div class="res_points" id="rd_3"><?= (isset($preDrawWIn->double->{3})? $preDrawWIn->double->{3}: '--');?></div>-->
							     <div class="res_points">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 ra_3"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 ra_3"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 rb_3"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 rb_3"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="deluxe_result">
                              <p><?= GAME_4 ?></p>
                              <!--<div class="res_points" id="rd_4"><?= (isset($preDrawWIn->double->{4})? $preDrawWIn->double->{4}: '--');?></div>-->
							     <div class="res_points">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 ra_4"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 ra_4"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 rb_4"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 rb_4"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="bhagya_result">
                              <p><?= GAME_5 ?></p>
                              <!--<div class="res_points" id="rd_5"><?= (isset($preDrawWIn->double->{5})? $preDrawWIn->double->{5}: '--');?></div>-->
							     <div class="res_points">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 ra_5"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 ra_5"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 rb_5"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 rb_5"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						  </div>
						   <div class="rescont_2">
                           <div class="dia_result">
                              <p><?= GAME_6 ?></p>
                              <!--<div class="res_points" id="rd_6"><?= (isset($preDrawWIn->double->{6})? $preDrawWIn->double->{6}: '--');?></div>-->
							     <div class="res_points">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 ra_6"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 ra_6"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 rb_6"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 rb_6"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="lucky_result">
                              <p><?= GAME_7 ?></p>
                              <!--<div class="res_points" id="rd_7"><?= (isset($preDrawWIn->double->{7})? $preDrawWIn->double->{7}: '--');?></div>-->
                              <div class="res_points">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 ra_7"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 ra_7"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
                                       <div class="flip1 flip--top1 rb_7"></div>
                                       <div class="flip1 flip--top1 flip--back1">00</div>
                                       <div class="flip1 flip--bottom1 rb_7"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						   <div class="new1_result">
                              <p><?= GAME_8?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{8})? $preDrawWIn->double->{8}: '--');?></div>-->
							  <div class="res_points">
                                  <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
									    <div class="flip1 flip--top1 ra_8"></div>
									    <div class="flip1 flip--top1 flip--back1">00</div>
									    <div class="flip1 flip--bottom1 ra_8"></div>
                                    </div>
                                 </div>
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
									    <div class="flip1 flip--top1 rb_8"></div>
									    <div class="flip1 flip--top1 flip--back1">00</div>
									    <div class="flip1 flip--bottom1 rb_8"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						   <div class="new2_result">
                              <p><?= GAME_9?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{9})? $preDrawWIn->double->{9}: '--');?></div>-->
							  <div class="res_points">
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
									    <div class="flip1 flip--top1 ra_9"></div>
									    <div class="flip1 flip--top1 flip--back1">00</div>
									    <div class="flip1 flip--bottom1 ra_9"></div>
                                    </div>
                                 </div>
								 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
									    <div class="flip1 flip--top1 rb_9"></div>
									    <div class="flip1 flip--top1 flip--back1">00</div>
									    <div class="flip1 flip--bottom1 rb_9"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
						    <div class="new3_result">
                              <p><?= GAME_10?></p>
                             <!-- <div class="res_points" id="drd_7"><?= (isset($preDrawWIn->double->{10})? $preDrawWIn->double->{10}: '--');?></div>-->
							  <div class="res_points">
                                 
                                 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
									    <div class="flip1 flip--top1 ra_10"></div>
									    <div class="flip1 flip--top1 flip--back1">00</div>
									    <div class="flip1 flip--bottom1 ra_10"></div>
                                    </div>
                                 </div>
								 <div class="seg">
                                    <div class="flip-wrapper">
                                       <div class="flip1 flip--next1"></div>
									    <div class="flip1 flip--top1 rb_10"></div>
									    <div class="flip1 flip--top1 flip--back1">00</div>
									    <div class="flip1 flip--bottom1 rb_10"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  </div>
                  <?php /*
                     $today = $objLotto->getDrawResultsToday($arrGameIDs[0]);
                     $yesterday = $objLotto->getDrawResultsYesterday($arrGameIDs[0]);
                     ?>
                  <div id="small-dialog3"
                     class="mfp-hide w3ls_small_dialog wthree_pop">
                     <div class="popup_head">Previous Result</div>
                     <?php  if (!empty( $today )) { ?>
                     <div class="chart_1">
                        <div class="chart_head_1">
                           <div class="chart_head draw_1">DRAW TIME</div>
                           <div class="chart_head san_1">SANGAM</div>
                           <div class="chart_head che_1">CHETAK</div>
                           <div class="chart_head super_1">SUPER</div>
                           <div class="chart_head del_1">MP DELUXE</div>
                           <div class="chart_head bhag_1">BHAGYA</div>
                           <div class="chart_head dia_1">DIAMOND</div>
                           <div class="chart_head luc_1">LUCKY7</div>
                        </div>
                        <div class="chart_scroll">
                           <?php 	
                              foreach ( $today as $day ){ 
                              	$winNumb1 = '';
                              	$numb1 = array();
                              	$time = (!empty($day->DRAW_STARTTIME)?date('H:i A',strtotime($day->DRAW_STARTTIME)):'');
                              	if(!empty($day->DRAW_WINNUMBER)){
                              		$win1 ='';
                              		$win1 = json_decode($day->DRAW_WINNUMBER, true);
                              	}
                              ?>
                           <div class="chart_cont_1">
                              <div class="chart_cont_2"><?= $time; ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[1])?$win1[1]:''); ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[2])?$win1[2]:''); ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[3])?$win1[3]:''); ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[4])?$win1[4]:''); ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[5])?$win1[5]:''); ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[6])?$win1[6]:''); ?></div>
                              <div class="chart_cont_2"><?= (!empty($win1[7])?$win1[7]:''); ?></div>
                           </div>
                           <?php }	?>
                        </div>
                     </div>
                     <?php } else{ echo "Result not found"; } ?>
                  </div>
                  <?php */ ?>
               </div>
            </div>
         </div>
      </div>
      <script src="js/reg.js"></script>
      <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
      <script>
         $(document).ready(function() {
         	var magnificPopup= $('.popup-with-zoom-anim').magnificPopup({
         		type: 'inline',
         		fixedContentPos: false,
         		fixedBgPos: true,
         		overflowY: 'auto',
         		closeBtnInside: true,
         		preloader: false,
         		midClick: true,
         		removalDelay: 300,
         		mainClass: 'my-mfp-zoom-in'
         	});
         
         	$('#resultchat').magnificPopup({
                    type: 'ajax'
                });
         });
         
         $(function(){
        	 animateInfo();
         })
   </script>

      <script src="js/socket.js"></script>
   </body>
</html>