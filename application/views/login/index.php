<?php $vTime = strtotime(date('Y-m-d H:i:s')); ?>
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <meta charset="utf-8">
        <meta name="description" content="game-name">
        <meta name="keywords" content=" "/>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width,  minimal-ui"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="expires" content="0">
        <meta name="msapplication-tap-highlight" content="no" />
        <meta name="theme-color" content="#59a84f" />
        <noscript>
        <meta http-equiv="refresh" content="1;url=jsdisabled.html">
        </noscript>
        <meta name="format-detection" content="telephone=no" />
        <link rel="apple-touch-startup-image" href="images/ios_startup.png">
        <link rel="apple-touch-startup-image" href="images/ios_startup@2x.png" sizes="640x920">
        <link rel="apple-touch-startup-image" href="images/ios_startup-large@2x.png" sizes="640x1096">
        <link rel="apple-touch-startup-image" href="images/ios_startup-6@2x.png" sizes="750x1294">
        <link rel="apple-touch-startup-image" href="images/ios_startup-6-plus@3x.png" sizes="1242x2148">

        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets//css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets//css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets//css/style_login.css?v=<?php echo $vTime ;?>" type="text/css">
        <!--<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />-->
        <script src="<?php echo base_url(); ?>/assets/js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>/assets/js/bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/jquery.validate.min.js"></script>
    </head>
    <style>
        .loginParent{
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            top: 0;
            bottom: 0;
            z-index:1111; 

        }

        .input_head_login {
            color: #fff;
            margin: 0;
        }
        .reg_cont {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .log_btn_1 {
            margin-top: 10px;
            font-weight: bold;
            font-size: 22px;
            padding: 5px;
        }
        .error{
            color: #FF9494;
            font-weight: normal;
            font-size: 12px;
            margin: 0;
        }
        .login_sec {
            width: 343px;
            height: 200px;
            padding-top: 27px;
        }
        .reg_logo img {
            width: 220px;
        }
        .form_input_sec {
            margin: 5px;
        }
        .form_input_sec {
            margin: 15px 5px;
            position: relative;
        }
        label.error {
            position: absolute;
            bottom: -15px;
            width: 100%;
            left: 0;
        }

        .pageLoader1 {
            position: absolute;
            bottom: 2%;
            left: 0%;		
            width:100%;
            height:100%;
            z-index:999999 !important;   
            background:url(<?php echo base_url(); ?>/assets/images/pageloader_login.gif)center center no-repeat;
        }
    </style>
</head>
<body class="login_reg_sec">
    <h1 id="disclaimer" style="
        position: absolute;
        display: flex;
        justify-content: left;
        align-items: center;
        bottom: 0;
        color: #fff;
        font-size: 15px;
        ">Note : Please enable flash player for this website</h1>
    <div id="loginParentId" class="loginParent">
        <!--<div class="pageLoader1" id="pageLoader2" style="display:none;"></div>-->
        <div class="reg_cont">
            <div class="logo_bg">
                <div class="reg_logo text-center"></div>
                <div class="login_sec">
                    <?php if ($this->session->flashdata('message')) { ?>
                        <div class='notification alert alert-danger' style="display: block" id="log_msg"><?php echo $this->session->flashdata('message'); ?></div>
                    <?php } ?>
                    <form name="frmLogin" id="frmLogin" action="<?php echo base_url() . LOGIN_FORM_URL; ?>" method="post">
                        <div class="form_input_sec">
                            <!--<label class="input_head_login">USERNAME</label>-->
                            <fieldset>
                                  <!--<input type="text" class="formTxtfield" name="password" style="">-->
                                <input name="username" type="text" class="formTxtfield" placeholder="username" id="username" size="60"  maxlength="30" autofocus tabindex="1" /> <br />
                            </fieldset>
                        </div>
                        <div class="form_input_sec">
                            <!--<label class="input_head_login">PASSWORD</label>-->
                            <fieldset>
                                <input name="password" type="password" class="formTxtfield" placeholder="password" id="password" size="60" maxlength="30" tabindex="2" autocomplete='new-password'/><br />
                                      <!--<input type="password" class="formTxtfield" name="password" style="">-->
                            </fieldset>
                        </div>

                        <div class="form_input_sec">
                            <fieldset>
                                <!--<button name="submit" class="form_btn log_btn_1" type="submit">LOGIN</button>-->
                                <input name="submit" class="form_btn log_btn_1" type="submit" id="submit_btn" value="LOGIN" />
                                <!--<img style="display: none; text-align: center; height: 26px; margin: 0 auto;" id="log_loader" src="images/loader.gif" />-->
                                <div class="" style="width: 100%;text-align: center;"><img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="log_loader" src="<?php echo base_url();?>assets/images/loader.gif"></div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    
    $(document).ready(function () {
        $("#username").focus();
        /**  inspect and right click not working */
//        document.addEventListener('contextmenu', event => event.preventDefault());
//        $(document).keydown(function (event) {
//            var keycode = (event.keyCode ? event.keyCode : event.which);
//            if (keycode == 32 || (keycode >= 112 && keycode <= 123)) {
//                event.preventDefault();
//            }
//            if (keycode == 123) { //F12 Result
//                return false;
//            }
//        });
            /* function onshow(){
             document.name.username.focus();
             } */
            $('#frmLogin').validate({
                rules: {
                username: {
                required: true,
                },
                        password: {
                        required: true,
                        }
                },
                messages: {
                username: {
                required: "Please enter your username",
                },
                        password: {
                        required: "Please enter your password"
                                //minlength : "Your password must be at least 7 characters long"
                        }
                },
                submitHandler: function (form) {
                $("#log_msg").html('');
                        $("#submit_btn").hide();
                        $("#log_loader").show();
                        $('#submit_btn').attr('disabled', 'disabled');
                        return true;
                }
            });
            clear_form();
            
            function txtBlur(id) {
             document.getElementById(id).innerHTML = '';
            }

            $("#username").focus();
                        clear_form();
            var isMobile = {
                    Android: function () {
                    return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function () {
                    return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function () {
                    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function () {
                    return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function () {
                    return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
                    },
                    any: function () {
                    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
            };
            var hasFlash = false;
            try {
                hasFlash = Boolean(new ActiveXObject('ShockwaveFlash.ShockwaveFlash'));
            } catch (exception) {
                hasFlash = ('undefined' != typeof navigator.mimeTypes['application/x-shockwave-flash']);
            }

            if (!hasFlash && !isMobile.any()) {
            $('#disclaimer').show();
            } else {
            $('#disclaimer').hide();
            }
            
    });
   
    function clear_form() {
    $("#username").val('');
            $("#password").val('');
            $('#username').attr("autocomplete", "off");
            $('#Password').attr("autocomplete", "off");
    }

 

</script>