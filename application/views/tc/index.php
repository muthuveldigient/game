
<html>
    <head>
        <title>Raja Rani</title>
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

        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css" type="text/css">
        <!--<link href="<?php echo base_url(); ?>/assets/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />-->
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery-2.1.4.min.js"></script>
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
            color:red;
        }
        .login_sec {
            width: 300px;
        }
        .reg_logo img {
            width: 220px;
        }
        .form_input_sec {
            margin: 10px;
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function () {

            /**  inspect and right click not working */
            /* document.addEventListener('contextmenu', event => event.preventDefault());
             $(document).keydown(function(event){
             var keycode = (event.keyCode ? event.keyCode : event.which);
             //$("#keydownCode").val(keycode);
             //alert(keycode);
             if(keycode==32 || (keycode>=112 && keycode<=123)) {
             event.preventDefault();
             }
         
             if(keycode==123) { //F12 Result
             return false;
             }		
             }); */


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
                    $.post("<?php echo base_url() . RAJARANI_LOGIN_FORM_URL; ?>", $("#frmLogin").serialize(), function (response) {
                        if (response == 1) {
                            window.location.href = "<?php echo base_url() . RAJARANI_HOME_URL; ?>";
                        } else if (response == 2) {
                            $("#log_msg").show().html('Invalid Login.Please try again.');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        } else if (response == 3) {
                            $("#log_msg").show().html('UnAuthenticated User.Please try again.');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        } else if (response == 4) {
                            $("#log_msg").show().html('Invalid Captcha Please try again.');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        } else {
                            $("#log_msg").show().html('Username or Password invalid');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        }
                        //$(".imgcaptcha").attr("src","captcha.php?_="+((new Date()).getTime()));
                        setTimeout(function () {
                            $("#log_msg").hide();
                        }, 4000);

                    },'jsonp');
                    return false;
                    // form.submit();
                }
            });
            clear_form();
        });
        function clear_form() {
            $("#username").val('');
            $("#password").val('');
            $('#username').attr("autocomplete", "off");
            $('#Password').attr("autocomplete", "off");

        }

        /* function onshow(){
         document.name.username.focus();
         } */

        function txtBlur(id) {
            document.getElementById(id).innerHTML = '';
        }

    </script>
    <style>
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
    <div id="loginParentId" class="loginParent">
        <!--<div class="pageLoader1" id="pageLoader2" style="display:none;"></div>-->
        <div class="reg_cont">
            <div>
                <div class="reg_logo text-center"><img src="<?php echo base_url(); ?>/assets/images/logo.png"></div>
                <div class="login_sec">
                    <div class='notification alert alert-danger' style="display: none" id="log_msg"></div>
                    <form name="frmLogin" id="frmLogin">
                        <div class="form_input_sec">
                            <label class="input_head_login">USERNAME</label>
                            <fieldset>
                                  <!--<input type="text" class="formTxtfield" name="password" style="">-->
                                <input name="username" type="text" class="formTxtfield"  id="username" size="60"  maxlength="30" autofocus tabindex="1" /> <br />
                            </fieldset>
                        </div>
                        <div class="form_input_sec">
                            <label class="input_head_login">PASSWORD</label>
                            <fieldset>
                                <input name="password" type="password" class="formTxtfield" id="password" size="60" maxlength="30" tabindex="2"/><br />
                                      <!--<input type="password" class="formTxtfield" name="password" style="">-->
                            </fieldset>
                        </div>

                        <div class="form_input_sec">
                            <fieldset>
                                <!--<button name="submit" class="form_btn log_btn_1" type="submit">LOGIN</button>-->
                                <input name="submit" class="form_btn log_btn_1" type="submit" id="submit_btn" value="LOGIN" />
                                <!--<img style="display: none; text-align: center; height: 26px; margin: 0 auto;" id="log_loader" src="images/loader.gif" />-->
                                <div class="" style="width: 100%;text-align: center;"><img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="log_loader" src="<?php echo base_url(); ?>assets/images/loader.gif"></div>
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
    $("#username").focus();
    clear_form();
</script>