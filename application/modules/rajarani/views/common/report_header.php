<html>
  <head>
    <title>RajaRani</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/report_style.css" type="text/css">
	<link href="<?php echo base_url();?>assets/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url();?>assets/css/bootstrap-datepicker.css" rel="stylesheet" />
        
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
	

<style>
.error{
	color:red;
}
</style>

  </head>
  <body>
    <div class="myacc_section">
	
	<div class="myacc_sec_header"> 
	<div class="myacc_logo"><img src="<?php echo $headerLogoURL;?>/images/logo.png" class=""></div>
	<div class="myacc_logout">
	<div class="logout_sec"><a href="<?php echo $homeURL; ?>"><div class="back_myacc">Back to game</div></a></div>
	<div class="logout_sec"><a href="<?php echo base_url().'logout'; ?>"><div class="logout_myacc">Logout</div></a></div>
	</div>
	
	</div>
	
      <div class="tab">
        <div class="tablinks active"  id="game">
         <a href="<?php echo base_url().'rajarani/report/gamehistory'; ?>"> <div class="myacc_sec_head">Game History</div></a>
        </div>
        <div class="tablinks" id="ledger">
		<a href="<?php echo base_url().'rajarani/report/ledger'; ?>"><div class="myacc_sec_head">Ledger</div></a>
        </div>
        <div class="tablinks" id="user" >
          <a href="<?php echo base_url().'rajarani/report/userprofile'; ?>"><div class="myacc_sec_head">User Profile</div></a>
        </div>
        <div class="tablinks" id="draw">
          <a href="<?php echo base_url().'rajarani/report/drawhistory'; ?>"><div class="myacc_sec_head">Draw History</div></a>
        </div>
        <div class="tablinks"  id="pwd">
		 <a href="<?php echo base_url().'rajarani/report/changepassword'; ?>"><div class="myacc_sec_head">Change Password</div></a>
        </div>
      </div>