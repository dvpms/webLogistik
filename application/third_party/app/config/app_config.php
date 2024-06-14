<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*   @author     Faiz Muhammad Syam, S.Kom
*   @project    E - Office 2023
*   @e-mail     faizmsyam@gmail.com - cafeweb.id@gmail.com
**/
/*
| -------------------------------------------------------------------------
| Base Site URL
| -------------------------------------------------------------------------
|
*/

$url = $_SERVER['SCRIPT_NAME'];
$url = substr($url,0,strpos($url,".php"));
$url = substr($url,0,(strlen($url) - strpos(strrev($url),"/")));
$url = ((isset($_SERVER['HTTPS']) OR @$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https' : 'http')."://".$_SERVER['HTTP_HOST'].$url;

defined('BASE_URL') OR define('BASE_URL', $url);
$config['base_url'] = $url;

/*
| -------------------------------------------------------------------------
| Index File
| -------------------------------------------------------------------------
|
*/
$config['index_page'] = '';

/*
| -------------------------------------------------------------------------
| Timezone
| -------------------------------------------------------------------------
|
*/
// $config['timezone'] = 'Europe/Paris';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| 0 = Disables logging, Error logging TURNED OFF
| 1 = Error Messages (including PHP errors)
| 2 = Debug Messages
| 3 = Informational Messages
| 4 = All Messages
|
*/
if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing') {
	// $config['log_threshold'] = array(1, 2);
	$config['log_threshold'] = 0;
} else {
	// $config['log_threshold'] = 1;
}