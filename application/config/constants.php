<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/** URL defined */
define('BASE_URL', 'http://local.games.com/');
define('ASSET_URL', BASE_URL.'assets/'); //Asset url
define('ASSET_URL_CSS', ASSET_URL.'css'); //Asset url css
define('ASSET_URL_JS', ASSET_URL.'js'); //Asset url js
define('ASSET_URL_IMG', ASSET_URL.'images'); //Asset url js

define('RR_ASSET_URL', ASSET_URL.'rajarani/'); //Rajarani Asset url
define('RR_ASSET_URL_CSS', RR_ASSET_URL.'css'); //Rajarani css Asset url
define('RR_ASSET_URL_JS', RR_ASSET_URL.'js'); //Rajarani js Asset url
define('RR_ASSET_URL_IMG', RR_ASSET_URL.'images'); //Rajarani image Asset url

define('RR_WEB_ASSET_URL_CSS', RR_ASSET_URL.'web/css'); //Rajarani web Asset url
define('RR_WEB_ASSET_URL_JS', RR_ASSET_URL.'web/js'); //Rajarani web Asset url
define('RR_WEB_ASSET_URL_IMG', RR_ASSET_URL.'web/images'); //Rajarani web Asset url

define('RR_MOB_ASSET_URL_CSS', RR_ASSET_URL.'mob/css'); //Rajarani Mobile Asset url
define('RR_MOB_ASSET_URL_JS', RR_ASSET_URL.'mob/js'); //Rajarani Mobile Asset url
define('RR_MOB_ASSET_URL_IMG', RR_ASSET_URL.'mob/images'); //Rajarani Mobile Asset url

define('LOGIN_FORM_URL', BASE_URL.'/index/loginprocess');
define('LOGIN_URL', BASE_URL.'login.php');
define('LOGIN_LANDING_URL', BASE_URL.'home.php');
define('TC_SITE_URL', BASE_URL.'/tclotto/');

/** web socket URL */
define('TC_WEB_SOCKET_URL', "ws://54.254.155.69:8899/?encoding=text");
define('RR_WEB_SOCKET_URL', "ws://54.254.155.69:7722/?encoding=text");

define('RR_GAME_ID', '1');
define('TC_GAME_ID', '2');

define('RAJARANI_MOBILE_HOME_URL', BASE_URL.'/rajarani/mobile/index');
define('RAJARANI_WEB_HOME_URL', BASE_URL.'/rajarani/web/index');
define('TC_HOME_URL', BASE_URL.'/tclotto/home/index');
define('BIGBOSS_HOME_URL', BASE_URL.'/bigboss/home/index');

define('SESSION_USERNAME', 'lucky_ter_username');
define('SESSION_USERID', 'lucky_ter_userid');
define('SESSION_PARTNERID', 'lucky_ter_partnerid');
define('SESSION_PARTNERNAME', 'lucky_ter_partnername');
define('SESSIONID', 'lucky_sessionID');
define('SESSION_USEREMAIL', 'lucky_email');
define('SESSION_USERCONTACT', 'lucky_contact');
define('USER_TYPE', 'lucky_user_type');

define('SD_COMM', 90);
define('AG_COMM', 80);
define('LIMIT_COUNT', 50);


//define('BET_TYPE_1', 'Andar');
define('BET_TYPE_1', 'Single');
define('BET_TYPE_2', 'Double');



