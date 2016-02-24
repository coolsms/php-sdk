<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to create sms group through CoolSMS Rest API PHP v1.0
 * for more info, visit
 * www.coolsms.co.kr
 */

use CS;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$apikey = '#ENTER_YOUR_OWN#';
$apisecret = '#ENTER_YOUR_OWN#';

// initiate rest api sdk object
$rest = new CS\Coolsms($apikey, $apisecret);

// Optional parameters for your own needs
// $options->charset = 'utf8'; 				// utf8, euckr default value is utf8
// $options->srk = '';						// Solution key
// $options->mode = 'test';					// If 'test' value. refund cash to point
// $options->delay = 10;					// '0~20' delay messages
// $options->force_sms = true;				// 'true or false' always send sms 
// $options->os_platform = '';				// Client OS
// $options->dev_lang = '';					// Development language 
// $options->sdk_version = '';				// SDK version ex) PHP SDK 1.2
// $options->app_version = '';				// App version

$result = $rest->newGroup($options);			
print_r($result);
