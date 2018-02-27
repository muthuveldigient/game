<?php
$userType = (!empty($_SESSION[USER_TYPE])?$_SESSION[USER_TYPE]:'');
$detect = new Mobile_Detect;
$vTime = strtotime(date('Y-m-d H:i:s'));
$rajaRaniImg = base_url().'assets/images/rajarani.png?v='.$vTime;
$livetcImg = base_url().'assets/images/livetc.png?v='.$vTime;

?>
<html>
    <head>
        <title>Home</title>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<script language="javascript" src="<?php echo base_url(); ?>/assets/js/jquery-2.1.4.min.js"></script>
    </head>
	<body>
	
<style>
body{
	margin:0;
	font-family: sans-serif;
	}
	.main{
    background-image: url(<?php echo base_url(); ?>/assets/images/bg_v2.jpg);
    background-size: cover;
    background-position: center;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
	text-align: center;
	}
	.main_cont img {
    width: 460px;
	webkit-filter: drop-shadow(3px 20px 8px #000);
    filter: drop-shadow(3px 20px 8px #000);
	cursor: pointer;
}
a{
	text-decoration: none;
}
.game_1,.game_2 {
    display: inline-block;
}
.game_title {
    text-align: center;
    font-weight: bold;
    color: #fff;
    text-transform: uppercase;
    font-size: 30px;
    text-shadow: 5px 5px 9px #000;
	cursor: pointer;
}
.game_title a{
	color: #fff;
	text-decoration:none;
}
.logout {
    position: absolute;
    right: 4%;
    top: 4%;
    text-transform: uppercase;
    font-weight: bold;
    padding: 5px;
    background-color: #d1d025;
    background: -webkit-linear-gradient(#d1d025,#f39b00);
    background: -o-linear-gradient(#d1d025,#f39b00);
    background: -moz-linear-gradient(#d1d025,#f39b00);
    background: linear-gradient(#d1d025,#f39b00);
    font-size: 15px;
    color: #000;
    border-radius: 7px;
    border: 2px solid #9e0000;
    text-shadow: 1px 1px #e9bd67;
    cursor: pointer;
    line-height: 22px
}
.logout a {
    text-decoration: none;
    color: #000;
}
@media (max-width:767px){
.main_cont img {
    width: 300px;
	}	
}
</style>

	<div class="main">
	<div class="logout"><a href="<?php echo base_url(); ?>logout">Logout</a></div>
	<div class="main_cont">
	<?php if( $detect->isAndroidOS() ){
				if($userType==1){ ?>
						<div class="game_1">
							<a href="<?php echo base_url().RAJARANI_MOBILE_HOME_URL; ?>"><img src="<?php echo $rajaRaniImg; ?>">
								<!--<div class="game_title"><span>Triple Chance</span></div>-->
							</a>
						</div>
			<?php }else{ ?>
				<div class="game_title"><span>No Games Available</span></div>
			<?php }
		}else if( $detect->isiOS() ){
				if($userType==1){ ?>
					<div class="game_1">
						<a href="<?php echo base_url().RAJARANI_MOBILE_HOME_URL; ?>"><img src="<?php echo $rajaRaniImg; ?>">
							<!--<div class="game_title"><span>Triple Chance</span></div>-->
						</a>
					</div>
			<?php }else{ ?>
				<div class="game_title"><span>No Games Available</span></div>
			<?php }
		}else{
				if($userType==1){
		?>
					<div class="game_1">
						<a href="<?php echo base_url().RAJARANI_WEB_HOME_URL; ?>"><img src="<?php echo $rajaRaniImg; ?>">
							<!--<div class="game_title"><span>Triple Chance</span></div>-->
						</a>
					</div>
					<div class="game_2">
						<a href="<?php echo base_url().TC_HOME_URL; ?>"><img src="<?php echo $livetcImg; ?>">
							<!--<div class="game_title"><span>Triple Chance Live</span></div>-->
						</a>
					</div>
			<?php }elseif($userType==2){ ?>
					<div class="game_2">
						<a href="<?php echo base_url().TC_HOME_URL; ?>"><img src="<?php echo $livetcImg; ?>">
							<!--<div class="game_title"><span>Triple Chance Live</span></div>-->
						</a>
					</div>
			<?php }else{ ?>
				<div class="game_title"><span>No Games Available</span></div>
			<?php } 
		}?>
	</div>
	</div>
	<script>

$('a[data-href]').on('click', function(e) {
    e.preventDefault();
    window.location.href = $(this).data('href');
});
</script>
	</body>
	</html>