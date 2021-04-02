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

//FODLER PATHS
define('PRODUCT_ATTATCHMENTS_PATH', 'assets/product/');
define('CATEGORY_ATTACHMENT_PATH', 'assets/category/');
define('BRAND_ATTATCHMENTS_PATH', 'assets/brand/');
define('SELLER_ATTATCHMENTS_PATH', 'assets/seller/');
define('PROFILE_PIC_PATH', 'assets/profile_pics/');
define('OFFER_ATTATCHMENTS_PATH', 'assets/offer/');
define('HTML_FILES_PATH', 'assets/html_files/');
define('DB_BACKUP_PATH', 'assets/db_backup/');
define('TEMP_FOLDER_PATH', 'assets/temp/');

//ERROR CODES
define('CODE_SUCCESS', 1000);
define('CODE_ERROR_PARAM_MISSING', 1001);
define('CODE_ERROR_AUTHENTICATION_FAILED', 1002);
define('CODE_ERROR_UNKNOWN', 1003);
define('CODE_ERROR_IN_QUERY', 1004);
define('CODE_ERROR_FOLDER', 1005);
define('CODE_ERROR_INCORRECT_FORMAT', 1006);
define('CODE_ERROR_ALREADY_EXIST', 1007);
define('CODE_ERROR_LOGIN_EXPIRED', 1008);
define('CODE_ERROR_WRONG_PAGE', 1009);
define('CODE_ERROR_DB', 1010);
define('CODE_ERROR_PHP_NOTICE', 1011);
//define('CODE_ERROR_DB', 1012);
//define('CODE_ERROR_DB', 1013);

//EMAIL CONFIGURATION DETAIL
define('EMAIL_ID', 'roposhop@roposhop.com');
define('EMAIL_NAME', 'ROPOSHOP');
define('EMAIL_USERNAME', 'roposhop@roposhop.com');
define('EMAIL_PASSWORD', 'roposhop123');
define('EMAIL_PROTOCOL', 'smtp');
define('EMAIL_HOST', 'ssl://mail.roposhop.com');
define('EMAIL_PORT', 465);

//DATABASE CONFIGURATION DETAIL
// define('DB_HOST', '162.241.252.212:3306');
// define('DB_USERNAME', 'oobgktmy_4ds');
// define('DB_PASSWORD', '4dsofttech');
// define('DB_DATABASE', 'oobgktmy_roposhop_testing');
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'roposhop');

//DISTANCE UNIT
define('MILES', 'M');
define('KILOMETERS', 'K');
define('NAUTICAL_MILES', 'N');

//MAIL CODES
define('MAIL_CODE_RESET_PASSWORD', 101);
define('MAIL_CODE_CLAIM_BUSINESS', 102);
define('MAIL_CODE_SELLER_SIGNUP', 103);
define('MAIL_CODE_HELP_AND_SUPPORT', 104);
define('MAIL_CODE_CLAIM_BUSINESS_APPROVED', 105);
define('ROPO_SHOP_BRAND_NAME', "ROPOshop");

//DEFAULT VALUES
define('DEFAULT_PASSWORD', '123456');
define('DEFAULT_META_TAG', 'Research Online Purchase Offline, Search and compare products online at home with same convenience as with Online Shopping, once decided on what you want to buy and from which seller visit the shop and buy.');
define('GOOGLE_MAP_API_KEY', 'AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI');
