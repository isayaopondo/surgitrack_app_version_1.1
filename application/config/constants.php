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


/*
  |--------------------------------------------------------------------------
  | Google Messaging  process
  |
 */
defined('GCM_URL') OR define('GCM_URL', 'https://android.googleapis.com/gcm/send');
defined('GCM_KEY') OR define('GCM_KEY', 'AIzaSyAhdVCAkyaQNR3XoFBbv4uV9kfOcxy74Vc');

/*
  |--------------------------------------------------------------------------
  | System Messaging  users
  |
 */
defined('SENDER_PEAR') or define('SENDER_PEAR', 'pr');
defined('SENDER_ADMIN') or define('SENDER_ADMIN', 'ad');
defined('SENDER_ACCOUNT_MANAGER') or define('SENDER_ACCOUNT_MANAGER', 'am');
defined('SENDER_SYSTEM_NOTIFICATION') or define('SENDER_SYSTEM_NOTIFICATION', 'sn');
/*
  |--------------------------------------------------------------------------
  | System Loggign  users
  |
 */
defined('LOG_GCM_MESSAGE') or define('LOG_GCM_MESSAGE', 'gcm');
defined('LOG_MAIL_MESSAGE') or define('LOG_MAIL_MESSAGE', 'mail');
defined('LOG_PAYMENT_MESSAGE') or define('LOG_PAYMENT_MESSAGE', 'pay');
defined('LOG_ACCOUNT_CREATION') or define('LOG_ACCOUNT_CREATION', 'signup');
defined('LOG_ACCOUNT_PROFILE') or define('LOG_ACCOUNT_PROFILE', 'profile');
defined('LOG_TICKET_MESSAGE') or define('LOG_TICKET_MESSAGE', 'ticket');

defined('NEWSLETTER_EMAIL_FROM') or define('NEWSLETTER_EMAIL_FROM','info@locumer.co.ke');
defined('NEWSLETTER_SENDER') or define('NEWSLETTER_SENDER','LOCUMER');
defined('NEWSLETTER_SUBJECT') or define('NEWSLETTER_SUBJECT','LOCUMER WEEKLY');



/*
  |--------------------------------------------------------------------------
  | KPMB Messaging  constants
  |
 */
defined('API_CALL') or define('API_CALL', 'http://api.infobip.com/api/v3/sendsms/json');
defined('SMS_HOST') or define('SMS_HOST', 'api.infobip.com');
defined('SENDER') or define('SENDER', 'SYNERGYINFO');
defined('INFOBIP_USERNAME') or define('INFOBIP_USERNAME', 'SynergyKE');
defined('INFOBIP_PASSWORD') or define('INFOBIP_PASSWORD', 'Isah20102299');
/*
  |--------------------------------------------------------------------------
  | System Messaging  users
  |
 */
defined('SENDER_PEAR') or define('SENDER_PEAR', 'pr');
defined('SENDER_ADMIN') or define('SENDER_ADMIN', 'ad');
defined('SENDER_ACCOUNT_MANAGER') or define('SENDER_ACCOUNT_MANAGER', 'am');
defined('SENDER_SYSTEM_NOTIFICATION') or define('SENDER_SYSTEM_NOTIFICATION', 'sn');

defined('CONTACT_EMAIL') or define('CONTACT_EMAIL', 'admin@surgitrack.co.za');

defined('DEFAULT_CLIENT') or define('DEFAULT_CLIENT','TYGERBERG HOSPITAL');
defined('DEFAULT_DEPARTMENT') or define('DEFAULT_DEPARTMENT','DEPARTMENT OF UROLOGY ');


defined('EAPI_URL')or define('EAPI_URL','http://bulksms.2way.co.za/eapi/submission/send_sms/2/2.0');
defined('BULK_SMS_USER')or define('BULK_SMS_USER','isaya_opondo');
defined('BULK_SMS_PASS')or define('BULK_SMS_PASS','Isah20102299');


defined('OPNOTES_REPOSITORY')or define('OPNOTES_REPOSITORY',FCPATH.'folder/opnotes/');
defined('OPCODING_REPOSITORY')or define('OPCODING_REPOSITORY',FCPATH.'folder/opcoding/');

defined('DROPBOX_API') or define('DROPBOX_API','https://api.dropboxapi.com/2/');
defined('DROPBOX_CONTENT') or define('DROPBOX_CONTENT','https://content.dropboxapi.com/2/');
defined('DROPBOX_API_ACCESS_TOKEN') or define('DROPBOX_API_ACCESS_TOKEN','ExSgZAq2tAAAAAAAAAAAFz3cwa8gJE11WsG6XDn7K3GIOlAe6NGgv8qhrq4w5RCL');


defined('GOOGLE_DISTANCE_API_URL')or define('GOOGLE_DISTANCE_API_URL','https://maps.googleapis.com/maps/api/distancematrix/json?'); //pass variables 1.origins, 2.destinations,3. mode,4. key
defined('GOOGLE_DISTANCE_API_KEY')or define('GOOGLE_DISTANCE_API_KEY','AIzaSyAzw4gkXOo78OuLKJROgGSul8fPAQwfRl0');

defined('TYGERBERG_GEOCODES') or define('TYGERBERG_GEOCODES','-33.910212,18.6092194');


defined('SYSTEM_NAME') or define('SYSTEM_NAME', 'SurgiTrack ');

defined('NOREPLY') or define('NOREPLY', 'noreply@surgitrack.co.za');

defined('APP_URL')or define('APP_URL', 'https://app.surgitrack.co.za');